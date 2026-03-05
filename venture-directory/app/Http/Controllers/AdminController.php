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

        $stats = [
            'total_videos' => Video::count(),
            'approved_videos' => Video::approved()->count(),
            'pending_videos' => Video::pending()->count(),
        ];

        return view('admin.dashboard', compact('pendingVideos', 'stats'));
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
