<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center sm:text-left flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
            <div class="flex items-center gap-6">
                @if($collection->cover_image)
                    <img src="{{ $collection->cover_image }}" alt="" class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-2xl shadow-sm border border-gray-200 dark:border-white/10 hidden sm:block">
                @endif
                <div>
                    <span class="text-brand font-semibold tracking-wider uppercase text-sm mb-2 block">Founder Collection</span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">{{ $collection->title }}</h1>
                    @if($collection->description)
                        <p class="mt-3 text-lg text-gray-500 dark:text-gray-400 max-w-2xl leading-relaxed">{{ $collection->description }}</p>
                    @endif
                    <div class="mt-4 flex items-center gap-3 text-sm font-medium text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $videos->total() }} Videos
                        </span>
                    </div>
                </div>
            </div>
            
            <div>
                @auth
                    @php
                        $isFollowing = auth()->user()->followedCollections()->where('collection_id', $collection->id)->exists();
                    @endphp
                    <form action="{{ route('collections.follow', $collection) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 font-semibold rounded-full transition-colors shadow-sm {{ $isFollowing ? 'bg-gray-200 dark:bg-dark-surface text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-white/10 hover:bg-gray-300 dark:hover:bg-white/5' : 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:bg-gray-800 dark:hover:bg-gray-100' }}">
                            {{ $isFollowing ? 'Following' : 'Follow Collection' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-block px-6 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors shadow-sm">
                        Login to Follow
                    </a>
                @endauth
            </div>
        </div>

        @if($videos->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                @foreach($videos as $video)
                    <x-video-card :video="$video" />
                @endforeach
            </div>
            
            <div class="mt-12">
                {{ $videos->links() }}
            </div>
        @else
            <div class="text-center py-24 bg-white dark:bg-dark-surface rounded-[32px] border border-gray-200 dark:border-dark-border">
                <div class="mx-auto w-16 h-16 bg-gray-50 dark:bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No videos yet</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">This collection is empty right now. Check back later.</p>
                @if(auth()->check() && auth()->user()->is_admin)
                    <div class="mt-6">
                        <a href="{{ route('admin.collections.edit', $collection) }}" class="text-brand font-medium hover:underline">Manage Collection →</a>
                    </div>
                @endif
            </div>
        @endif

    </div>
</x-app-layout>
