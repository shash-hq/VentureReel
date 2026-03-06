<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 pb-12 pt-4">
        
        <div class="lg:flex gap-8 items-start">
            <!-- Main Video Content -->
            <div class="flex-1 min-w-0">
                <div class="bg-black rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl mb-6 relative aspect-video border border-gray-200 dark:border-white/5">
                    <iframe 
                        src="{{ $video->embed_url }}?autoplay=1" 
                        class="absolute inset-0 w-full h-full border-0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>

                <div class="glass-panel !rounded-2xl sm:!rounded-3xl p-5 sm:p-6 md:p-8 shadow-sm">
                    <!-- Title & Tags -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($video->category)
                        <a href="{{ route('categories.show', $video->category) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 text-gray-700 dark:text-gray-300 text-xs font-semibold hover:bg-gray-200 dark:hover:bg-white/10 transition-colors">
                            {{ $video->category->name }}
                        </a>
                        @endif
                        
                        @foreach($video->tags_array as $tag)
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400 text-xs hover:bg-gray-200 dark:hover:bg-white/10 transition-colors">
                            #{{ $tag }}
                        </span>
                        @endforeach
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white leading-tight mb-6">
                        {{ $video->title }}
                    </h1>

                    <!-- Actions & Meta -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-4 border-y border-gray-100 dark:border-white/5 mb-8">
                        <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1.5 bg-gray-50 dark:bg-white/5 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-white/5">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span class="font-medium text-gray-900 dark:text-gray-200">{{ number_format($video->views_count) }}</span> views
                            </div>
                            <span class="hidden sm:block">•</span>
                            <span>{{ $video->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            @auth
                            <form action="{{ route('videos.like', $video) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-full border {{ auth()->user()->hasLiked($video) ? 'border-brand text-brand bg-brand/10' : 'border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5' }} transition-colors">
                                    <svg class="w-5 h-5 {{ auth()->user()->hasLiked($video) ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    <span class="font-medium">{{ $video->likes_count ?? $video->likes()->count() }}</span>
                                </button>
                            </form>
                            <form action="{{ route('videos.bookmark', $video) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-full border {{ auth()->user()->hasBookmarked($video) ? 'border-brand text-brand bg-brand/10' : 'border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5' }} transition-colors">
                                    <svg class="w-5 h-5 {{ auth()->user()->hasBookmarked($video) ? 'fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                                </button>
                            </form>
                            @else
                            <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span class="font-medium">{{ $video->likes_count ?? $video->likes()->count() }}</span>
                            </a>
                            @endauth
                            
                            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!')" class="flex items-center justify-center p-2.5 rounded-full border border-gray-200 dark:border-white/10 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors" title="Share">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="prose prose-gray dark:prose-invert max-w-none">
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $video->description }}</p>
                    </div>

                    <!-- Founder Info box -->
                    <div class="mt-8 p-6 glass-panel !bg-white/40 dark:!bg-white/5 !rounded-2xl">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Featured Founder</h3>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center font-bold text-xl">
                                {{ substr($video->entrepreneur_name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $video->entrepreneur_name }}</p>
                                <p class="text-brand font-medium block">{{ $video->business_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Context -->
            <div class="w-full lg:w-80 flex-shrink-0 mt-8 lg:mt-0 space-y-6">
                <!-- Submitter Profile -->
                <div class="glass-panel p-6 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-4">Submitted by</h3>
                    @if($video->user)
                    <a href="{{ route('user.profile', $video->user) }}" class="flex items-center gap-4 group">
                        <img src="{{ $video->user->avatar_url }}" alt="{{ $video->user->name }}" class="w-14 h-14 rounded-full object-cover border border-gray-200 dark:border-gray-700 group-hover:border-brand transition-colors" loading="lazy">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white group-hover:text-brand transition-colors">{{ $video->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ '@' . $video->user->username }}</p>
                        </div>
                    </a>
                    @if($video->user->bio)
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 line-clamp-3">{{ $video->user->bio }}</p>
                    @endif
                    @else
                    <div class="flex items-center gap-4 group">
                        <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center border border-gray-200 dark:border-gray-700">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white group-hover:text-brand transition-colors">{{ $video->youtube_channel_name ?? 'Imported Video' }}</p>
                            <p class="text-sm text-gray-500">From YouTube</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Related Videos -->
                @if($relatedVideos->count() > 0)
                <div class="glass-panel p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ $video->category ? 'More in ' . $video->category->name : 'Related Videos' }}</h3>
                    <div class="space-y-4">
                        @foreach($relatedVideos as $related)
                        <a href="{{ route('videos.show', $related) }}" class="flex gap-3 group">
                            <div class="w-32 aspect-video flex-shrink-0 rounded-lg overflow-hidden border border-gray-100 dark:border-white/5 relative">
                                <img src="{{ $related->thumbnail_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" loading="lazy">
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-200 line-clamp-2 group-hover:text-brand transition-colors leading-tight mb-1">
                                    {{ $related->title }}
                                </h4>
                                <span class="text-xs text-gray-500">{{ number_format($related->views_count) }} views</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
