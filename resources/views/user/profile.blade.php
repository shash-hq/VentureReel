<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4">
        
        <!-- Profile Header -->
        <div class="bg-white dark:bg-dark-surface rounded-[32px] p-8 md:p-12 mb-10 border border-gray-200 dark:border-dark-border relative overflow-hidden flex flex-col md:flex-row items-center md:items-start gap-8">
            <!-- Background element -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand/5 dark:bg-brand/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="relative z-10 flex-shrink-0">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white dark:border-dark-bg object-cover shadow-lg" loading="lazy">
            </div>
            
            <div class="relative z-10 flex-1 text-center md:text-left flex flex-col justify-center h-full pt-2">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white tracking-tight flex items-center justify-center md:justify-start gap-3">
                            {{ $user->name }}
                            @if($user->isAdmin())
                                <span class="bg-brand/10 text-brand text-xs px-2.5 py-1 rounded-full uppercase tracking-wide font-bold self-center mt-1">Admin</span>
                            @endif
                        </h1>
                        <p class="text-lg text-gray-500 dark:text-gray-400 mt-1">{{ '@' . $user->username }}</p>
                    </div>
                    
                    @auth
                        @if(auth()->id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 rounded-full shadow-sm text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-dark-surface hover:bg-gray-50 dark:hover:bg-white/5 focus:outline-none transition-colors">
                                Edit Profile
                            </a>
                        @endif
                    @endauth
                </div>
                
                @if($user->bio)
                    <p class="text-gray-700 dark:text-gray-300 max-w-2xl leading-relaxed">{{ $user->bio }}</p>
                @endif
                
                <div class="mt-8 flex items-center justify-center md:justify-start gap-6 text-sm">
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-bold text-xl text-gray-900 dark:text-white">{{ $videos->total() }}</span>
                        <span class="text-gray-500 dark:text-gray-400 uppercase tracking-wide text-xs font-semibold">Videos</span>
                    </div>
                    <div class="w-1 h-8 bg-gray-200 dark:bg-white/10 rounded-full"></div>
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-bold text-xl text-gray-900 dark:text-white">{{ number_format($videos->sum('views_count')) }}</span>
                        <span class="text-gray-500 dark:text-gray-400 uppercase tracking-wide text-xs font-semibold">Total Views</span>
                    </div>
                    <div class="w-1 h-8 bg-gray-200 dark:bg-white/10 rounded-full"></div>
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-bold text-xl text-gray-900 dark:text-white">{{ number_format($videos->sum('likes_count') ?? 0) }}</span>
                        <span class="text-gray-500 dark:text-gray-400 uppercase tracking-wide text-xs font-semibold">Likes</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- User's Videos -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Videos by {{ explode(' ', $user->name)[0] }}</h2>
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
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">{{ $user->name }} hasn't published any videos or pitches yet.</p>
                @auth
                    @if(auth()->id() === $user->id)
                    <a href="{{ route('videos.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-brand hover:bg-brand-hover focus:outline-none transition-colors">
                        Upload Your First Video
                    </a>
                    @endif
                @endauth
            </div>
        @endif

    </div>
</x-app-layout>
