<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6">
        
        <div class="bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-[32px] overflow-hidden shadow-sm mb-8">
            <div class="px-8 py-8 md:p-12">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Public Profile</h2>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Update your public profile information, username, and bio.</p>
                </div>

                <form method="post" action="{{ route('user.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Display Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm">
                        @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Username</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-white/5 text-gray-500 dark:text-gray-400 sm:text-sm">
                                @
                            </span>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required class="flex-1 block w-full rounded-none rounded-r-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand sm:text-sm">
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">Only letters, numbers, and dashes. Must be unique.</p>
                        @error('username') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="4" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm resize-none" placeholder="Tell us about yourself and your ventures...">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-white/5">
                        <button type="submit" class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-brand hover:bg-brand-hover focus:outline-none transition-colors">
                            Save Profile
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-green-600 dark:text-green-400 font-medium" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)">Saved.</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Links to standard Breeze settings -->
        <div class="bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-[32px] overflow-hidden shadow-sm">
            <div class="px-8 py-8 md:p-12">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">Account Settings</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update your email address or password.</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-full shadow-sm text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-dark-surface hover:bg-gray-50 dark:hover:bg-white/5 focus:outline-none transition-colors">
                        Go to Settings
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</x-app-layout>
