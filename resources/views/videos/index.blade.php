<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-12">

        @if(!request('search') && !request('category'))
            {{-- Featured Video Hero --}}
            @if($videos->count() > 0)
                @php $featuredVideo = $videos->first(); @endphp
                <div class="mb-10 relative rounded-2xl sm:rounded-3xl overflow-hidden group border border-gray-200 dark:border-white/10 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 ease-out">
                    <a href="{{ route('videos.show', $featuredVideo) }}" class="block aspect-video sm:aspect-[2.35/1] relative">
                        <img src="{{ $featuredVideo->thumbnail_url }}" alt="{{ $featuredVideo->title }}" class="w-full h-full object-cover transition-transform duration-[8s] ease-out group-hover:scale-105" loading="lazy" onerror="this.onerror=null;this.src='https://placehold.co/1200x500/111/333?text=VentureReel';">

                        {{-- Gradients --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/50 to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-gray-900/90 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 p-4 sm:p-8 md:p-10 w-full max-w-3xl z-10 flex flex-col justify-end h-full">
                            <div>
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 sm:px-2.5 sm:py-1 rounded-lg bg-black/50 backdrop-blur-md border border-white/10 text-white text-[10px] sm:text-[11px] font-semibold tracking-wide mb-2 sm:mb-4">
                                    <svg class="w-3 h-3 text-brand" viewBox="0 0 20 20" fill="currentColor"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    FEATURED
                                </span>

                                <h2 class="text-lg sm:text-2xl md:text-3xl font-bold text-white leading-tight mb-2 sm:mb-4 line-clamp-2 tracking-tight drop-shadow-md">
                                    {{ $featuredVideo->title }}
                                </h2>

                                <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-gray-300 text-xs sm:text-[13px] font-medium drop-shadow-md">
                                    <div class="flex items-center gap-1.5 sm:gap-2">
                                        <img src="{{ $featuredVideo->user->avatar_url }}" alt="" class="w-5 h-5 sm:w-6 sm:h-6 rounded-full border border-white/20 object-cover" loading="lazy">
                                        <span class="text-white">{{ $featuredVideo->channel_name ?? $featuredVideo->user->name }}</span>
                                    </div>
                                    <span class="w-1 h-1 rounded-full bg-gray-500"></span>
                                    <span>{{ number_format($featuredVideo->views_count) }} views</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-500 hidden sm:block"></span>
                                    <span class="hidden sm:block">{{ $featuredVideo->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            
            {{-- Founder Collections --}}
            @if(isset($featuredCollections) && $featuredCollections->count() > 0)
                <div class="mb-12">
                    <div class="flex items-end justify-between mb-5 border-b border-gray-200 dark:border-white/5 pb-3">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                            Founder Collections
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($featuredCollections as $collection)
                            <div class="group relative glass-card overflow-hidden flex flex-col h-full hover:shadow-xl hover:-translate-y-1 transition-all duration-200 ease-out">
                                <a href="{{ route('collections.show', $collection) }}" class="block aspect-[4/3] relative overflow-hidden shrink-0">
                                    @if($collection->cover_image)
                                        <img src="{{ $collection->cover_image }}" alt="{{ $collection->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-dark-bg text-gray-400 group-hover:bg-gray-300 transition-colors">
                                            <svg class="h-10 w-10 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/10 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4 w-full flex items-end justify-between">
                                        <p class="text-gray-300 text-xs font-semibold tracking-wide uppercase">{{ $collection->videos_count }} videos</p>
                                    </div>
                                </a>
                                
                                <div class="p-4 flex flex-col flex-grow">
                                    <a href="{{ route('collections.show', $collection) }}" class="block focus:outline-none">
                                        <h3 class="text-gray-900 dark:text-white font-bold text-[17px] leading-snug line-clamp-1 group-hover:text-brand transition-colors mb-1.5">{{ $collection->title }}</h3>
                                    </a>
                                    <p class="text-gray-500 dark:text-gray-400 text-[13px] leading-relaxed line-clamp-2">{{ $collection->description }}</p>
                                    
                                    <div class="mt-auto pt-4 relative z-10">
                                        @auth
                                            @php
                                                $isFollowing = auth()->user()->followedCollections()->where('collection_id', $collection->id)->exists();
                                            @endphp
                                            <form action="{{ route('collections.follow', $collection) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full text-center px-4 py-2.5 text-sm font-semibold rounded-xl transition-all {{ $isFollowing ? 'bg-brand text-white border border-brand hover:bg-brand-hover shadow-sm' : 'bg-transparent border border-brand text-brand hover:bg-brand hover:text-white shadow-sm' }}">
                                                    {{ $isFollowing ? 'Following' : 'Follow' }}
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 text-sm font-semibold rounded-xl bg-transparent border border-brand text-brand hover:bg-brand hover:text-white transition-all shadow-sm">
                                                Follow
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        {{-- Based on your searches --}}
        @if(isset($recommendedVideos) && $recommendedVideos->count() > 0)
            <div class="mb-12">
                <div class="flex items-end justify-between mb-5 border-b border-gray-200 dark:border-white/5 pb-3">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                        Based on your searches
                    </h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($recommendedVideos as $video)
                        <x-video-card :video="$video" />
                    @endforeach
                </div>
            </div>
        @endif

        @if(isset($youtubeError) && $youtubeError)
            <div class="mb-6 p-4 rounded-2xl glass-panel border border-amber-500/30 bg-amber-500/10 flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-400">Live search is temporarily unavailable &mdash; showing saved results only.</h3>
                </div>
            </div>
        @endif

        {{-- Section Header --}}
        <div class="flex items-end justify-between mb-5 border-b border-gray-200 dark:border-white/5 pb-3">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                @if(request('search'))
                    Results for <span class="text-brand">"{{ request('search') }}"</span>
                @elseif(request('category'))
                    {{ $categories->firstWhere('slug', request('category'))->name ?? 'Category' }}
                @else
                    Recommended for You
                @endif
            </h2>
        </div>

        {{-- Video Grid --}}
        @if($videos->count() > 0 || !empty($youtubeResults))
            @if($videos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @php
                        $videosToLoop = (!request('search') && !request('category') && $videos->currentPage() == 1 && $videos->count() > 0)
                            ? $videos->skip(1)
                            : $videos;
                    @endphp

                    @foreach($videosToLoop as $video)
                        <x-video-card :video="$video" />
                    @endforeach
                </div>

                @if($videos->hasPages())
                    <div class="mt-10">
                        {{ $videos->links() }}
                    </div>
                @endif
            @endif

            {{-- YouTube API Search Results (Organic Growth) --}}
            @if(!empty($youtubeResults))
                <!-- YOUTUBE SEARCH RESULTS: {{ isset($youtubeCached) && $youtubeCached ? 'CACHED' : 'LIVE' }} -->
                @if($videos->count() > 0)
                    <div class="mt-16 flex items-end justify-between mb-5 border-b border-gray-200 dark:border-white/5 pb-3">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M21.582,6.186c-0.23-0.86-0.908-1.538-1.768-1.768C18.254,4,12,4,12,4s-6.254,0-7.814,0.418 c-0.86,0.23-1.538,0.908-1.768,1.768C2,7.746,2,12,2,12s0,4.254,0.418,5.814c0.23,0.86,0.908,1.538,1.768,1.768 C5.746,20,12,20,12,20s6.254,0,7.814-0.418c0.86-0.23,1.538-0.908,1.768-1.768C22,16.254,22,12,22,12S22,7.746,21.582,6.186z M10,15.464V8.536L16,12L10,15.464z"/></svg>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                                From YouTube
                            </h2>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Click to import and watch</span>
                    </div>
                @endif
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($youtubeResults as $ytVideo)
                        {{-- Mock a video object for the component, but map the URL to our import route --}}
                        @php
                            $ytAvatar = 'https://ui-avatars.com/api/?name=YT&color=fff&background=ef4444';
                            $parsedDate = \Carbon\Carbon::parse($ytVideo['published_at'])->diffForHumans();
                        @endphp
                        
                        <a href="{{ route('videos.import', $ytVideo['video_id']) }}" class="group block h-full select-none cursor-pointer">
                            <div class="relative glass-card p-3 hover:border-brand/30 dark:hover:border-brand/30 hover:shadow-xl dark:hover:shadow-[0_8px_30px_rgb(0,0,0,0.5)] transition-all duration-200 ease-out transform group-hover:-translate-y-1 h-full flex flex-col">
                                
                                {{-- Thumbnail Area --}}
                                <div class="relative aspect-video rounded-xl sm:rounded-2xl overflow-hidden mb-4 bg-gray-100 dark:bg-dark-bg shrink-0">
                                    <img src="{{ $ytVideo['thumbnail_url'] }}" alt="{{ html_entity_decode($ytVideo['title']) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" onerror="this.onerror=null;this.src='https://placehold.co/600x400/111/333?text=YouTube';">
                                    
                                    {{-- Play Button Overlay --}}
                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-md border border-white/30 transform scale-90 group-hover:scale-100 transition-all duration-300">
                                            <svg class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                        </div>
                                    </div>
                                    
                                    <div class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded bg-black/70 text-white text-[10px] font-bold tracking-wider">
                                        IMPORT
                                    </div>
                                </div>

                                {{-- Details Area --}}
                                <div class="px-1 flex flex-col flex-grow">
                                    <h3 class="text-[15px] sm:text-[16px] font-bold text-gray-900 dark:text-white leading-snug mb-2 group-hover:text-brand transition-colors line-clamp-2">
                                        {{ html_entity_decode($ytVideo['title']) }}
                                    </h3>
                                    
                                    <div class="mt-auto pt-3 border-t border-gray-100 dark:border-white/5">
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center shrink-0">
                                                <svg class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M21.582,6.186c-0.23-0.86-0.908-1.538-1.768-1.768C18.254,4,12,4,12,4s-6.254,0-7.814,0.418 c-0.86,0.23-1.538,0.908-1.768,1.768C2,7.746,2,12,2,12s0,4.254,0.418,5.814c0.23,0.86,0.908,1.538,1.768,1.768 C5.746,20,12,20,12,20s6.254,0,7.814-0.418c0.86-0.23,1.538-0.908,1.768-1.768C22,16.254,22,12,22,12S22,7.746,21.582,6.186z M10,15.464V8.536L16,12L10,15.464z"/></svg>
                                            </div>
                                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate tracking-tight">
                                                {{ $ytVideo['channel_title'] }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-[11px] font-medium text-gray-500 dark:text-gray-400 pl-7">
                                            <span>{{ $parsedDate }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        @else
            <div class="text-center py-20 glass-panel flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mb-6 border border-gray-100 dark:border-white/10 shadow-sm">
                    <svg class="w-10 h-10 text-brand opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No results found</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">
                    @if(isset($youtubeError) && $youtubeError)
                        We couldn't find any saved videos matching your search, and live YouTube search is currently offline. Please try again later.
                    @else
                        We couldn't find any videos matching your search locally or on YouTube. Try adjusting your keywords.
                    @endif
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 border border-brand text-brand hover:bg-brand hover:text-white rounded-xl font-medium transition-all shadow-sm">
                    Clear Search
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
