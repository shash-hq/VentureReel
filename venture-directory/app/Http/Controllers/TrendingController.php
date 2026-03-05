<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\YouTubeService;
use Illuminate\View\View;

class TrendingController extends Controller
{
    public function index(YouTubeService $youtube): View
    {
        // Local trending: top videos by views this week
        $localTrending = Video::approved()
            ->with(['user', 'category'])
            ->withCount('likes')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('views_count')
            ->take(8)
            ->get();

        // If not enough recent videos, supplement with all-time top
        if ($localTrending->count() < 4) {
            $localTrending = Video::approved()
                ->with(['user', 'category'])
                ->withCount('likes')
                ->orderByDesc('views_count')
                ->take(8)
                ->get();
        }

        // YouTube trending (only if API key is configured)
        $youtubeTrending = $youtube->getTrendingStartupVideos(6);

        return view('trending.index', compact('localTrending', 'youtubeTrending'));
    }
}
