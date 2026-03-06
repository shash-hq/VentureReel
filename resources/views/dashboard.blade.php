<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4">
        
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200 dark:border-white/5">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">My Videos</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Manage your submitted stories and pitches.</p>
            </div>
            <a href="{{ route('videos.create') }}" class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-brand hover:bg-brand-hover focus:outline-none transition-colors gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                New Video
            </a>
        </div>

        @if($videos->count() > 0)
            <div class="glass-panel p-0 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-white/5">
                        <thead class="bg-gray-50 dark:bg-[#1a1a1a]">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Video</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Engagement</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/5 bg-white/20 dark:bg-dark-surface/50">
                            @foreach($videos as $video)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 h-16 w-28 rounded-lg overflow-hidden bg-gray-100 dark:bg-dark-bg border border-gray-200 dark:border-white/5">
                                                <img class="h-full w-full object-cover" src="{{ $video->thumbnail_url }}" alt="">
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900 dark:text-white line-clamp-1 max-w-sm">{{ $video->title }}</div>
                                                <div class="text-sm text-gray-500 mt-1">{{ formated_limit($video->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($video->is_approved)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                Approved
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                Pending Review
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center gap-1.5" title="Views">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                {{ number_format($video->views_count) }}
                                            </div>
                                            <div class="flex items-center gap-1.5" title="Likes">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                                {{ number_format($video->likes_count) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $video->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('videos.show', $video) }}" class="text-gray-500 hover:text-brand transition-colors" title="View">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('videos.edit', $video) }}" class="text-blue-500 hover:text-blue-700 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('videos.destroy', $video) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-8">
                {{ $videos->links() }}
            </div>
        @else
            <div class="text-center py-24 glass-panel !rounded-[32px]">
                <div class="mx-auto w-20 h-20 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">You haven't uploaded any videos</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">Share your entrepreneurial journey or pitch with the VentureReel community.</p>
                <a href="{{ route('videos.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-brand hover:bg-brand-hover focus:outline-none transition-colors">
                    Upload Your First Video
                </a>
            </div>
        @endif

        {{-- Bookmarks Section --}}
        <div class="mt-16 mb-8 pb-4 border-b border-gray-200 dark:border-white/5">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Bookmarked Videos</h2>
        </div>

        @if($bookmarks->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($bookmarks as $video)
                    <x-video-card :video="$video" />
                @endforeach
            </div>
            
            @if($bookmarks->hasPages())
                <div class="mt-8">
                    {{ $bookmarks->appends(request()->except('bookmarks_page'))->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12 glass-panel flex flex-col items-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No bookmarks</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Save videos to watch them later here.</p>
            </div>
        @endif

        {{-- Followed Collections Section --}}
        <div class="mt-16 mb-8 pb-4 border-b border-gray-200 dark:border-white/5">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Followed Collections</h2>
        </div>

        @if($collections->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($collections as $collection)
                    <a href="{{ route('collections.show', $collection) }}" class="group block relative glass-card aspect-[4/3] overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-200 ease-out">
                        @if($collection->cover_image)
                            <img src="{{ $collection->cover_image }}" alt="{{ $collection->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-dark-bg text-gray-400 group-hover:bg-gray-300 transition-colors">
                                <svg class="h-10 w-10 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-4 w-full">
                            <h3 class="text-white font-bold text-lg line-clamp-1 group-hover:text-brand transition-colors">{{ $collection->title }}</h3>
                            <p class="text-gray-300 text-xs mt-1">{{ $collection->videos_count }} videos</p>
                        </div>
                    </a>
                @endforeach
            </div>
            
            @if($collections->hasPages())
                <div class="mt-8">
                    {{ $collections->appends(request()->except('collections_page'))->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12 glass-panel flex flex-col items-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No followed collections</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Follow curated collections to see them here.</p>
            </div>
        @endif

    </div>
</x-app-layout>
