<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Category;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Services\YouTubeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VideoController extends Controller
{
    /**
     * Display listing of approved videos (homepage).
     */
    public function index(): View|RedirectResponse
    {
        $search = request('search');
        
        if (request()->has('search')) {
            // Sanitize: strip HTML tags and remove special characters
            $search = trim(strip_tags($search));
            $search = preg_replace('/[^\w\s\-]/', '', $search);
            
            if (empty($search)) {
                return redirect()->back()->withErrors(['search' => 'Please enter a valid search term to find videos.']);
            }
        }

        $categorySlug = request('category');

        if ($search && auth()->check()) {
            $this->recordSearchHistory($search);
        }

        $videos = Video::approved()
            ->with(['user', 'category'])
            ->withCount('likes')
            ->search($search)
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = \Illuminate\Support\Facades\Cache::remember('categories_list', 600, function () {
            return Category::withCount('approvedVideos')->get();
        });

        $recommendedVideos = $this->getRecommendedVideos($search, $categorySlug);

        $featuredCollections = collect();
        if (!$search && !$categorySlug) {
            $featuredCollections = \Illuminate\Support\Facades\Cache::remember('featured_collections', 600, function () {
                return \App\Models\Collection::withCount('videos')->has('videos')->latest()->take(4)->get();
            });
        }

        $youtubeResults = [];
        $youtubeCached = false;
        $youtubeError = false;
        if ($search) {
            try {
                $youtube = app(YouTubeService::class);
                if ($youtube->isConfigured()) {
                    $searchData = $youtube->searchVideos($search, 12);
                    $youtubeCached = $searchData['cached'] ?? false;
                    $youtubeResults = collect($searchData['results'] ?? [])->filter(function ($ytVideo) use ($videos) {
                        // Filter out videos we already have locally to avoid duplicates in the same view
                        return !$videos->contains('youtube_video_id', $ytVideo['video_id']);
                    })->all();
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('YouTube API Search Error: ' . $e->getMessage());
                $youtubeError = true;
            }
        }

        return view('videos.index', compact('videos', 'categories', 'search', 'categorySlug', 'youtubeResults', 'youtubeCached', 'recommendedVideos', 'featuredCollections', 'youtubeError'));
    }

    /**
     * Record search history for the authenticated user.
     */
    protected function recordSearchHistory(string $search): void
    {
        \App\Models\SearchHistory::create([
            'user_id' => auth()->id(),
            'query' => $search
        ]);
    }

    /**
     * Retrieve recommended videos based on past search history.
     */
    protected function getRecommendedVideos(?string $search, ?string $categorySlug)
    {
        if ($search || $categorySlug || !auth()->check()) {
            return collect();
        }

        $latestQueries = \App\Models\SearchHistory::where('user_id', auth()->id())
            ->latest()
            ->pluck('query')
            ->unique()
            ->take(3);

        if ($latestQueries->isEmpty()) {
            return collect();
        }

        return Video::approved()
            ->with(['user', 'category'])
            ->withCount('likes')
            ->where(function ($queryBuilder) use ($latestQueries) {
                foreach ($latestQueries as $q) {
                    $queryBuilder->orWhere('title', 'like', "%{$q}%")
                                 ->orWhere('description', 'like', "%{$q}%");
                }
            })
            ->latest()
            ->take(4)
            ->get();
    }

    /**
     * Import a video directly from YouTube after clicking a search result.
     */
    public function importYouTube(\Illuminate\Http\Request $request, string $youtube_id): RedirectResponse
    {
        $video = $this->findOrImportYouTubeVideo($youtube_id);

        if (!$video) {
            return redirect()->route('home')->with('error', 'Unable to fetch video details from YouTube.');
        }

        return redirect()->route('videos.show', $video)->with('success', 'Video successfully imported to VentureReel!');
    }

    /**
     * Find an existing YouTube video locally, or fetch and create it.
     */
    protected function findOrImportYouTubeVideo(string $youtube_id): ?Video
    {
        $existingVideo = Video::where('youtube_video_id', $youtube_id)->first();
        if ($existingVideo) {
            return $existingVideo;
        }

        $youtube = app(YouTubeService::class);
        $details = $youtube->getVideoDetails($youtube_id);

        if (!$details) {
            return null;
        }

        $userId = auth()->id() ?: (\App\Models\User::first()->id ?? 1);

        return Video::create([
            'user_id' => $userId,
            'category_id' => null,
            'title' => $details['title'] ?? 'YouTube Video',
            'slug' => str($details['title'])->slug() . '-' . time(),
            'description' => $details['description'] ?? 'Imported from YouTube.',
            'youtube_url' => 'https://www.youtube.com/watch?v=' . $youtube_id,
            'youtube_video_id' => $youtube_id,
            'thumbnail_url' => $details['thumbnail_url'] ?? null,
            'channel_name' => $details['channel_title'] ?? null,
            'duration' => $details['duration'] ?? null,
            'entrepreneur_name' => $details['channel_title'] ?? 'Unknown',
            'business_name' => 'YouTube Creator',
            'is_approved' => true,
            'approved_at' => now(),
            'views_count' => rand(10, 100),
        ]);
    }

    /**
     * Show form for creating a new video.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('videos.create', compact('categories'));
    }

    /**
     * Store a newly created video.
     */
    public function store(StoreVideoRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $video = Video::create($data);

        // Enrich with YouTube API data (if key is configured)
        try {
            $youtube = app(YouTubeService::class);
            if ($youtube->isConfigured() && $video->youtube_video_id) {
                $ytData = $youtube->getVideoDetails($video->youtube_video_id);
                if ($ytData) {
                    $video->update([
                        'duration' => $ytData['duration'] ?? null,
                        'thumbnail_url' => $ytData['thumbnail_url'] ?? null,
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silently fail — YouTube enrichment is optional
        }

        return redirect()->route('videos.index')
            ->with('success', 'Your video has been submitted for review! It will appear once approved.');
    }

    /**
     * Display the specified video.
     */
    public function show($identifier): View
    {
        try {
            $video = Video::where('slug', $identifier)->orWhere('id', $identifier)->firstOrFail();
        } catch (\Exception $e) {
            abort(404);
        }

        // Only show if approved OR if the owner is viewing
        if (!$video->is_approved && (!auth()->check() || auth()->id() !== $video->user_id)) {
            abort(404);
        }

        $video->incrementViews();
        $video->load(['user', 'category']);
        $video->loadCount('likes');

        $relatedVideos = Video::approved()
            ->where('id', '!=', $video->id)
            ->where('category_id', $video->category_id)
            ->withCount('likes')
            ->take(4)
            ->get();

        return view('videos.show', compact('video', 'relatedVideos'));
    }

    /**
     * Show form for editing the specified video.
     */
    public function edit(Video $video): View
    {
        // Only the owner can edit
        if (auth()->id() !== $video->user_id) {
            abort(403);
        }

        $categories = Category::all();
        return view('videos.edit', compact('video', 'categories'));
    }

    /**
     * Update the specified video.
     */
    public function update(UpdateVideoRequest $request, Video $video): RedirectResponse
    {
        if (auth()->id() !== $video->user_id) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Reset approval on edit — admin must re-approve
        $data['is_approved'] = false;
        $data['approved_at'] = null;

        $video->update($data);

        return redirect()->route('videos.show', $video)
            ->with('success', 'Video updated successfully. It will be reviewed again.');
    }

    /**
     * Remove the specified video.
     */
    public function destroy(Video $video): RedirectResponse
    {
        if (auth()->id() !== $video->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $video->delete();

        return redirect()->route('videos.index')
            ->with('success', 'Video deleted successfully.');
    }
}
