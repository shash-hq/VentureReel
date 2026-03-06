<x-app-layout>
    <div class="max-w-4xl mx-auto pb-12 pt-4 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="{{ route('admin.collections.index') }}" class="text-sm text-gray-500 hover:text-brand mb-2 inline-block">← Back to Collections</a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Create Collection</h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Curate a new playlist to feature on the homepage.</p>
        </div>

        <form action="{{ route('admin.collections.store') }}" method="POST" class="bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-xl shadow-sm p-6 sm:p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <x-input-label for="title" :value="__('Collection Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Scaling from 0 to 1" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description (Optional)')" />
                    <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="What is this collection about?">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="cover_image" :value="__('Cover Image URL (Optional)')" />
                    <x-text-input id="cover_image" class="block mt-1 w-full" type="url" name="cover_image" :value="old('cover_image')" placeholder="https://example.com/image.jpg" />
                    <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Prefer horizontal images (16:9) for best display.</p>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-4">
                <a href="{{ route('admin.collections.index') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Cancel</a>
                <x-primary-button>
                    {{ __('Create Collection') }}
                </x-primary-button>
            </div>
        </form>

    </div>
</x-app-layout>
