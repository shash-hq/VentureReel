<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function show($identifier)
    {
        try {
            $collection = Collection::where('slug', $identifier)->orWhere('id', $identifier)->firstOrFail();
        } catch (\Exception $e) {
            abort(404);
        }

        $videos = $collection->videos()
            ->with(['category', 'user'])
            ->withCount('likes')
            ->latest()
            ->paginate(16);
        return view('collections.show', compact('collection', 'videos'));
    }
}
