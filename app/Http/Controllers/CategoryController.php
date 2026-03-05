<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index(): View
    {
        $categories = Category::withCount('approvedVideos')->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display videos in a specific category.
     */
    public function show(Category $category): View
    {
        $videos = $category->approvedVideos()
            ->with('user')
            ->withCount('likes')
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'videos'));
    }
}
