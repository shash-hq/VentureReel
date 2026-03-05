<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4">
        
        <!-- Category Header -->
        <div class="bg-white dark:bg-dark-surface rounded-[32px] p-8 md:p-12 mb-10 border border-gray-200 dark:border-dark-border text-center relative overflow-hidden">
            <!-- Background Blob -->
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-brand/5 dark:bg-brand/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-20 h-20 rounded-2xl bg-brand/10 dark:bg-brand/20 border border-brand/20 flex items-center justify-center text-3xl font-bold text-brand mb-6 shadow-sm">
                    {{ substr($category->name, 0, 1) }}
                </div>
                
                <h1 class="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tight mb-4">
                    {{ $category->name }}
                </h1>
                
                <p class="text-lg text-gray-500 dark:text-gray-400">
                    Explore {{ $videos->total() }} founder stories and pitches in this category.
                </p>
            </div>
        </div>

        @if($videos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($videos as $video)
                    <x-video-card :video="$video" />
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $videos->links() }}
            </div>
        @else
            <div class="text-center py-24 bg-white dark:bg-dark-surface rounded-[32px] border border-gray-200 dark:border-dark-border">
                <div class="mx-auto w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No videos yet</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">Be the first to share your startup journey or pitch in the {{ $category->name }} category.</p>
                <a href="{{ route('videos.create', ['category_id' => $category->id]) }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-brand hover:bg-brand-hover focus:outline-none transition-colors">
                    Upload Video
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
