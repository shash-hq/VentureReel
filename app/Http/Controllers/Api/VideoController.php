<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

class VideoController extends Controller
{
    /**
     * Return all approved videos as JSON.
     */
    public function index(): JsonResponse
    {
        $videos = Video::approved()
            ->with(['user:id,name,username', 'category:id,name,slug'])
            ->withCount('likes')
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $videos,
        ]);
    }

    /**
     * Return a single video as JSON.
     */
    public function show(Video $video): JsonResponse
    {
        if (!$video->is_approved) {
            return response()->json([
                'success' => false,
                'message' => 'Video not found.',
            ], 404);
        }

        $video->load(['user:id,name,username', 'category:id,name,slug']);
        $video->loadCount('likes');

        return response()->json([
            'success' => true,
            'data' => $video,
        ]);
    }
}
