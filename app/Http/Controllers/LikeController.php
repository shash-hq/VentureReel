<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    /**
     * Toggle like on a video.
     */
    public function toggle(Video $video): RedirectResponse
    {
        $user = auth()->user();

        if ($user->hasLiked($video)) {
            $user->likedVideos()->detach($video->id);
            $message = 'Like removed.';
        } else {
            $user->likedVideos()->attach($video->id);
            $message = 'Video liked!';
        }

        return back()->with('success', $message);
    }
}
