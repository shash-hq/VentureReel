<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4">
        
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white tracking-tight leading-tight mb-4">
                Explore Categories
            </h1>
            <p class="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">
                Discover founder stories, pitches, and startup lessons across various industries and domains.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="group relative bg-white dark:bg-dark-surface rounded-3xl p-8 border border-gray-200 dark:border-dark-border hover:border-brand dark:hover:border-brand hover:shadow-xl dark:hover:shadow-black/50 transition-all overflow-hidden flex flex-col items-center text-center">
                <!-- Background decorative blob -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-brand/5 dark:bg-brand/10 rounded-full blur-3xl group-hover:bg-brand/10 dark:group-hover:bg-brand/20 transition-colors"></div>
                
                <div class="w-16 h-16 rounded-2xl bg-brand/10 dark:bg-brand/20 border border-brand/20 flex items-center justify-center text-2xl font-bold text-brand mb-6 shadow-sm group-hover:scale-110 transition-transform duration-300 relative z-10">
                    {{ substr($category->name, 0, 1) }}
                </div>
                
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 relative z-10 group-hover:text-brand transition-colors">
                    {{ $category->name }}
                </h2>
                
                <div class="mt-auto pt-6 flex items-center justify-center gap-2 relative z-10">
                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-brand/10 text-brand text-xs font-semibold">
                        {{ $category->approved_videos_count }} videos
                    </span>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</x-app-layout>
