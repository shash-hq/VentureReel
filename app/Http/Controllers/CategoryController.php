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
    public function show($identifier): View
    {
        try {
            $category = Category::where('slug', $identifier)->orWhere('id', $identifier)->firstOrFail();
        } catch (\Exception $e) {
            abort(404);
        }

        $videos = $category->approvedVideos()
            ->with('user')
            ->withCount('likes')
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'videos'));
    }
}
