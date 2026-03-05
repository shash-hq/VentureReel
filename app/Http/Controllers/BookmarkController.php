<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    /**
     * Toggle bookmark on a video.
     */
    public function toggle(Video $video): RedirectResponse
    {
        $user = auth()->user();

        if ($user->hasBookmarked($video)) {
            $user->bookmarkedVideos()->detach($video->id);
            $message = 'Bookmark removed.';
        } else {
            $user->bookmarkedVideos()->attach($video->id);
            $message = 'Video bookmarked!';
        }

        return back()->with('success', $message);
    }

    /**
     * Display user's bookmarked videos.
     */
    public function index(): View
    {
        $videos = auth()->user()
            ->bookmarkedVideos()
            ->approved()
            ->with(['user', 'category'])
            ->withCount('likes')
            ->latest('bookmarks.created_at')
            ->paginate(12);

        return view('bookmarks.index', compact('videos'));
    }
}
