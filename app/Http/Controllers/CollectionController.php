<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function show(Collection $collection)
    {
        $videos = $collection->videos()->with(['category'])->latest()->paginate(16);
        return view('collections.show', compact('collection', 'videos'));
    }
}
