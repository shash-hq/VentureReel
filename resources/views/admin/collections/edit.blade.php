<x-app-layout>
    <div class="max-w-4xl mx-auto pb-12 pt-4 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="{{ route('admin.collections.index') }}" class="text-sm text-gray-500 hover:text-brand mb-2 inline-block">← Back to Collections</a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Edit Collection</h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Update details or manage videos in this collection.</p>
        </div>

        <div class="bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-dark-border">
                <form action="{{ route('admin.collections.update', $collection) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <x-input-label for="title" :value="__('Collection Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $collection->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description (Optional)')" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $collection->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="cover_image" :value="__('Cover Image URL (Optional)')" />
                            <x-text-input id="cover_image" class="block mt-1 w-full" type="url" name="cover_image" :value="old('cover_image', $collection->cover_image)" />
                            <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.collections.index') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Cancel</a>
                        <x-primary-button>
                            {{ __('Save Changes') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            
            <div class="p-6 sm:p-8 bg-gray-50 dark:bg-white/5">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Add Video to Collection</h3>
                <form action="{{ route('admin.collections.update', $collection) }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="title" value="{{ $collection->title }}">
                    @foreach($collection->videos->pluck('id') as $vid)
                        <input type="hidden" name="video_ids[]" value="{{ $vid }}">
                    @endforeach
                    
                    <div class="flex-grow">
                        <select name="video_ids[]" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-brand dark:focus:border-brand focus:ring-brand rounded-md shadow-sm">
                            <option value="">Select a video...</option>
                            @foreach($availableVideos as $v)
                               @if(!$collection->videos->contains($v->id))
                                   <option value="{{ $v->id }}">{{ $v->title }} ({{ $v->channel_name }})</option>
                               @endif
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button class="whitespace-nowrap sm:w-auto">Add Video</x-primary-button>
                </form>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Videos in Collection</h2>
                <span class="text-sm font-medium bg-gray-100 dark:bg-[#1a1a1a] text-gray-600 dark:text-gray-400 px-3 py-1 rounded-full">{{ $collection->videos->count() }}</span>
            </div>
            
            @if($collection->videos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($collection->videos as $video)
                        <div class="relative group">
                            <div class="pointer-events-none">
                                <x-video-card :video="$video" />
                            </div>
                            
                            <form action="{{ route('admin.collections.update', $collection) }}" method="POST" class="absolute top-2 right-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity focus-within:opacity-100 backdrop-blur-sm bg-red-600/20 rounded-full p-1 border border-red-600/50">
                                @csrf
                                @method('PUT')
                                <!-- Keep title so validation passes -->
                                <input type="hidden" name="title" value="{{ $collection->title }}">
                                <!-- Re-submit all current video IDs EXCEPT this one -->
                                @foreach($collection->videos->pluck('id')->reject(fn($id) => $id == $video->id) as $vid)
                                    <input type="hidden" name="video_ids[]" value="{{ $vid }}">
                                @endforeach
                                <button type="submit" class="bg-red-600 text-white rounded-full p-2 shadow-lg hover:bg-red-700 hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600" title="Remove from Collection">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-xl shadow-sm">
                    <p class="text-gray-500 dark:text-gray-400">No videos in this collection yet.</p>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
