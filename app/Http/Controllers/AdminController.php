<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with pending videos.
     */
    public function index(): View
    {
        $pendingVideos = Video::pending()
            ->with(['user', 'category'])
            ->latest()
            ->paginate(15);

        // DAU Chart - last 7 days
        $daus = \App\Models\UserActivity::select('date', \Illuminate\Support\Facades\DB::raw('count(distinct user_id) as count'))
            ->where('date', '>=', now()->subDays(6)->toDateString())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');
            
        $dauChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dauChart[$date] = $daus[$date] ?? 0;
        }

        $stats = [
            'total_videos' => Video::count(),
            'approved_videos' => Video::approved()->count(),
            'pending_videos' => Video::pending()->count(),
            'total_users' => \App\Models\User::count(),
        ];
        
        $maxDAU = max(1, max(empty($dauChart) ? [0] : array_values($dauChart)));

        $mostSearched = \App\Models\SearchHistory::select('query', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit(5)
            ->get();
            
        $mostViewedVideos = Video::orderByDesc('views_count')->limit(5)->get();
        $newestImports = Video::whereNotNull('youtube_video_id')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('pendingVideos', 'stats', 'dauChart', 'maxDAU', 'mostSearched', 'mostViewedVideos', 'newestImports'));
    }

    /**
     * Approve a video.
     */
    public function approve(Video $video): RedirectResponse
    {
        $video->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return back()->with('success', "'{$video->title}' has been approved!");
    }

    /**
     * Reject (delete) a video.
     */
    public function reject(Video $video): RedirectResponse
    {
        $title = $video->title;
        $video->delete();

        return back()->with('success', "'{$title}' has been rejected and removed.");
    }
}
