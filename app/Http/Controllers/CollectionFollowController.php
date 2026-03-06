<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionFollowController extends Controller
{
    public function toggle(\App\Models\Collection $collection)
    {
        auth()->user()->followedCollections()->toggle($collection->id);
        
        return back()->with('success', 'Collection follow status updated.');
    }
}
