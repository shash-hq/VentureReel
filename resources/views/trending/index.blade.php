<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-12">

        {{-- Page Header --}}
        <div class="pt-8 pb-6 border-b border-gray-200 dark:border-white/5 mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center">
                    <svg class="h-5 w-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" /></svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Trending This Week</h1>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">The most-watched founder stories and startup talks</p>
        </div>

        {{-- Trending on VentureReel --}}
        <section class="mb-12">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-brand"></span>
                Trending on VentureReel
            </h2>

            @if($localTrending->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($localTrending as $video)
                        <x-video-card :video="$video" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 glass-panel flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mb-6 border border-gray-100 dark:border-white/10 shadow-sm">
                        <svg class="w-10 h-10 text-brand opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No trending videos yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">There isn't enough viewership data to show trending videos right now. Be the first to submit something great!</p>
                    <a href="{{ route('videos.create') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent bg-brand text-white hover:bg-brand-hover rounded-xl font-medium transition-all shadow-sm">
                        Submit a Video
                    </a>
                </div>
            @endif
        </section>

        {{-- Trending on YouTube --}}
        @if(count($youtubeTrending) > 0)
        <section>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                Trending on YouTube
                <span class="text-xs font-normal text-gray-400 dark:text-gray-500 ml-1">via YouTube Data API</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($youtubeTrending as $yt)
                <a href="{{ $yt['youtube_url'] }}" target="_blank" rel="noopener" class="glass-card overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-200 ease-out group flex flex-col h-full">
                    {{-- Thumbnail --}}
                    <div class="relative aspect-video overflow-hidden">
                        <img src="{{ $yt['thumbnail_url'] }}" alt="{{ $yt['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" onerror="this.src='https://placehold.co/640x360/111/333?text=Video'">
                        <div class="absolute top-3 right-3 px-2 py-1 rounded-md bg-red-600 text-white text-xs font-bold flex items-center gap-1">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0C.488 3.45.029 5.804 0 12c.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0C23.512 20.55 23.971 18.196 24 12c-.029-6.185-.484-8.549-4.385-8.816zM9 16V8l8 4-8 4z"/></svg>
                            YouTube
                        </div>
                        {{-- Play overlay --}}
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                <div class="w-9 h-9 bg-red-600 rounded-full flex items-center justify-center pl-0.5">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M5 3l14 9-14 9V3z"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white leading-snug line-clamp-2 mb-2 group-hover:text-brand transition-colors">{{ html_entity_decode($yt['title']) }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-auto">{{ $yt['channel_title'] }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</x-app-layout>
