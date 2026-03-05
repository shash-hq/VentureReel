<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Display a user's public profile.
     */
    public function show(User $user): View
    {
        $videos = $user->videos()
            ->approved()
            ->with('category')
            ->withCount('likes')
            ->latest()
            ->paginate(12);

        return view('profiles.show', compact('user', 'videos'));
    }

    /**
     * Show the form for editing own profile.
     */
    public function edit(): View
    {
        return view('profiles.edit', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update own profile.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('user.profile', $user)
            ->with('success', 'Profile updated successfully.');
    }
}
