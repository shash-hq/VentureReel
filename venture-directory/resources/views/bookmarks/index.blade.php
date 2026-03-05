<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4">
        
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200 dark:border-white/5">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Saved Stories</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Pitches and founder stories you've bookmarked for later.</p>
            </div>
            <div class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-dark-surface border border-gray-200 dark:border-dark-border text-gray-600 dark:text-gray-300">
                {{ $bookmarkedVideos->total() }} {{ Str::plural('Saved Video', $bookmarkedVideos->total()) }}
            </div>
        </div>

        @if($bookmarkedVideos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($bookmarkedVideos as $video)
                    <x-video-card :video="$video" />
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $bookmarkedVideos->links() }}
            </div>
        @else
            <div class="text-center py-24 bg-white dark:bg-dark-surface rounded-[32px] border border-gray-200 dark:border-dark-border">
                <div class="mx-auto w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No saved stories</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">You haven't bookmarked any videos yet. Browse the community to find inspiring pitches and stories.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-brand hover:bg-brand-hover focus:outline-none transition-colors">
                    Explore Videos
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
