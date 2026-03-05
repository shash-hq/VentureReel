<x-app-layout>
    <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6">
        
        <div class="bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-[32px] overflow-hidden shadow-sm">
            <div class="px-8 py-8 md:p-12">
                <div class="mb-10 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-brand/10 text-brand mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Submit a Pitch or Story</h1>
                    <p class="mt-3 text-gray-500 dark:text-gray-400">Share your journey or submit an inspiring founder story to the VentureReel community.</p>
                </div>

                <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- URL -->
                    <div>
                        <label for="youtube_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">YouTube URL</label>
                        <input type="url" name="youtube_url" id="youtube_url" value="{{ old('youtube_url') }}" required placeholder="https://www.youtube.com/watch?v=..." class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm">
                        @error('youtube_url') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Video Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="E.g. How we scaled to $10k MRR" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm">
                            @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Entrepreneur Name -->
                        <div>
                            <label for="entrepreneur_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Founder/Entrepreneur Name</label>
                            <input type="text" name="entrepreneur_name" id="entrepreneur_name" value="{{ old('entrepreneur_name') }}" required class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm">
                            @error('entrepreneur_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Business Name -->
                        <div>
                            <label for="business_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Business/Startup Name</label>
                            <input type="text" name="business_name" id="business_name" value="{{ old('business_name') }}" required class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm">
                            @error('business_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Story Description</label>
                        <textarea name="description" id="description" rows="4" required class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm resize-none" placeholder="What makes this story compelling?">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select name="category_id" id="category_id" required class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tags -->
                        <div>
                            <label for="tags" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tags <span class="font-normal text-gray-400 dark:text-gray-500">(comma separated)</span></label>
                            <input type="text" name="tags" id="tags" value="{{ old('tags') }}" placeholder="saas, bootstrap, marketing" class="block w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-dark-bg focus:border-brand focus:ring-brand shadow-sm sm:text-sm">
                            @error('tags') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Custom Thumbnail -->
                    <div class="pt-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Custom Thumbnail (Optional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-2xl group hover:border-brand dark:hover:border-brand transition-colors cursor-pointer bg-gray-50 dark:bg-dark-bg" onclick="document.getElementById('thumbnail').click()">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-400 group-hover:text-brand transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                    <span class="relative font-medium text-brand hover:text-brand-hover focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/jpeg,image/png,image/webp">
                                    </span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG, WEBP up to 2MB</p>
                                <p class="text-xs text-gray-400 dark:text-gray-600 italic">If left empty, YouTube thumbnail will be used automatically.</p>
                            </div>
                        </div>
                        <div id="file-name-display" class="mt-2 text-sm text-gray-500 hidden text-center font-medium"></div>
                        @error('thumbnail') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        
                        <script>
                            document.getElementById('thumbnail').addEventListener('change', function(e) {
                                var fileName = e.target.files[0].name;
                                var display = document.getElementById('file-name-display');
                                display.textContent = 'Selected: ' + fileName;
                                display.classList.remove('hidden');
                            });
                        </script>
                    </div>

                    <div class="pt-6 border-t border-gray-200 dark:border-dark-border flex items-center justify-end gap-4">
                        <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Cancel</a>
                        <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-brand hover:bg-brand-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-colors">
                            Submit for Review
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
