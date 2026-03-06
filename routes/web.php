<?php

use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TrendingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage — video listing
Route::get('/', [VideoController::class, 'index'])->name('home');

// Public video & category browsing (search route has rate limiting of 30 requests per minute)
Route::get('/videos', [VideoController::class, 'index'])->middleware('throttle:30,1')->name('videos.index');
Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
Route::get('/videos/import/{youtube_id}', [VideoController::class, 'importYouTube'])->name('videos.import');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/trending', [TrendingController::class, 'index'])->name('trending');
Route::get('/collections/{collection:slug}', [CollectionController::class, 'show'])->name('collections.show');

// Public user profiles
Route::get('/users/{user}', [UserProfileController::class, 'show'])->name('user.profile');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('verified')->group(function () {
        // Video CRUD (create, edit, update, delete)
        Route::get('/videos/submit/new', [VideoController::class, 'create'])->name('videos.create');
        Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
        Route::get('/videos/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
        Route::put('/videos/{video}', [VideoController::class, 'update'])->name('videos.update');
        Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');

        // Likes & Bookmarks
        Route::post('/videos/{video}/like', [LikeController::class, 'toggle'])->name('videos.like');
        Route::post('/videos/{video}/bookmark', [BookmarkController::class, 'toggle'])->name('videos.bookmark');
        Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
        
        // Collection Follows
        Route::post('/collections/{collection}/follow', [\App\Http\Controllers\CollectionFollowController::class, 'toggle'])->name('collections.follow');
    });

    // User profile edit
    Route::get('/my-profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/my-profile', [UserProfileController::class, 'update'])->name('user.profile.update');

    // Breeze account settings (email, password, delete account)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard — user's own videos, bookmarks, and followed collections
    Route::get('/my-feed', function () {
        $user = auth()->user();
        
        $videos = $user->videos()
            ->with('category')
            ->withCount('likes')
            ->latest()
            ->paginate(12, ['*'], 'videos_page');
            
        $bookmarks = $user->bookmarkedVideos()
            ->with('category', 'user')
            ->withCount('likes')
            ->latest('bookmarks.created_at')
            ->paginate(12, ['*'], 'bookmarks_page');
            
        $collections = $user->followedCollections()
            ->withCount('videos')
            ->latest('collection_user.created_at')
            ->paginate(12, ['*'], 'collections_page');

        return view('dashboard', compact('videos', 'bookmarks', 'collections'));
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/videos/{video}/approve', [AdminController::class, 'approve'])->name('videos.approve');
    Route::delete('/videos/{video}/reject', [AdminController::class, 'reject'])->name('videos.reject');
    
    // Founder Collections Admin
    Route::resource('collections', AdminCollectionController::class)->except(['show']);
});

require __DIR__.'/auth.php';
