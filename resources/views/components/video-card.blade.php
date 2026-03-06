@props(['video'])

<div class="glass-card overflow-hidden transition-all duration-200 ease-out group flex flex-col h-full">
    {{-- Thumbnail --}}
    <a href="{{ route('videos.show', $video) }}" class="block relative aspect-video overflow-hidden">
        <img src="{{ $video->thumbnail_url }}"
             alt="{{ $video->title }}"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
             loading="lazy"
             onerror="this.onerror=null;this.src='https://placehold.co/640x360/111/333?text=Video+Unavailable';">

        {{-- Duration Badge --}}
        @if($video->duration)
        <div class="absolute bottom-2 right-2 bg-black/80 backdrop-blur-sm text-white text-[11px] font-medium px-1.5 py-0.5 rounded">
            {{ $video->duration }}
        </div>
        @endif

        {{-- Category Badge --}}
        @if($video->category)
        <div class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-md border border-white/10 text-white text-[11px] font-semibold tracking-wide">{{ $video->category->name }}</div>
        @endif

        {{-- Play Button Overlay --}}
        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                <div class="w-9 h-9 bg-brand rounded-full flex items-center justify-center pl-0.5 shadow-lg shadow-brand/30">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M5 3l14 9-14 9V3z"></path></svg>
                </div>
            </div>
        </div>
    </a>

    {{-- Content --}}
    <div class="p-4 flex flex-col flex-1">
        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white leading-snug mb-3 line-clamp-2">
            <a href="{{ route('videos.show', $video) }}" class="hover:text-brand transition-colors duration-150">
                {{ $video->title }}
            </a>
        </h3>

        <div class="mt-auto flex items-center justify-between">
            {{-- Author --}}
            <a href="{{ route('user.profile', $video->user) }}" class="flex items-center gap-2 group/author min-w-0">
                <img src="{{ $video->user->avatar_url }}"
                     alt="{{ $video->channel_name ?? $video->user->name }}"
                     class="w-7 h-7 rounded-full object-cover border border-gray-200 dark:border-gray-700 flex-shrink-0"
                     loading="lazy"
                     onerror="this.onerror=null;this.style.display='none';">
                <div class="flex flex-col min-w-0">
                    <span class="text-[13px] font-medium text-gray-700 dark:text-gray-300 group-hover/author:text-brand transition-colors truncate">{{ $video->channel_name ?? $video->user->name }}</span>
                    <span class="text-[11px] text-gray-400 dark:text-gray-500 truncate">{{ $video->business_name }}</span>
                </div>
            </a>

            {{-- Stats --}}
            <div class="flex items-center gap-2.5 text-gray-400 dark:text-gray-500 flex-shrink-0">
                <div class="flex items-center gap-1 text-[11px]">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span>{{ number_format($video->views_count) }}</span>
                </div>

                @auth
                <form action="{{ route('videos.bookmark', $video) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-brand transition-colors duration-150 focus:outline-none" aria-label="Bookmark">
                        <svg class="w-4 h-4 {{ auth()->user()->hasBookmarked($video) ? 'fill-brand text-brand' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </div>
</div>
