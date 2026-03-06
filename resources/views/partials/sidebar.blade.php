<aside class="w-64 flex-shrink-0 bg-white/60 dark:bg-white/5 backdrop-blur-xl border-r border-white/30 dark:border-white/10 flex flex-col h-screen overflow-y-auto no-scrollbar
             fixed inset-y-0 left-0 z-50 md:relative md:z-auto
             transform transition-transform duration-300 ease-in-out
             md:translate-x-0"
      :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
      @click.away="sidebarOpen = false">

    {{-- Top: Logo + Mobile Close --}}
    <div class="px-5 py-4 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group" @click="sidebarOpen = false">
            <svg class="h-6 w-6 text-brand" viewBox="0 0 24 24" fill="currentColor">
                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
            </svg>
            <span class="text-lg font-bold text-gray-900 dark:text-white tracking-tight">VentureReel</span>
        </a>
        <button @click="sidebarOpen = false" class="md:hidden p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    @auth
    {{-- User Profile Snippet --}}
    <a href="{{ route('user.profile', auth()->user()) }}" @click="sidebarOpen = false" class="mx-3 px-3 py-3 flex items-center gap-3 rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group">
        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="h-9 w-9 rounded-full object-cover border border-brand/20 group-hover:border-brand transition-colors">
        <div class="flex flex-col overflow-hidden">
            <span class="text-sm font-semibold text-gray-900 dark:text-white leading-tight truncate">{{ auth()->user()->name }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ '@' . auth()->user()->username }}</span>
        </div>
    </a>
    @endauth

    {{-- Nav Links --}}
    <nav class="px-3 mt-3 space-y-0.5">
        <a href="{{ route('home') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[14px] {{ request()->routeIs('home') || request()->routeIs('videos.index') ? 'bg-brand/10 text-brand font-semibold' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }} transition-all">
            <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Home
        </a>
        <a href="{{ route('trending') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[14px] {{ request()->routeIs('trending') ? 'bg-brand/10 text-brand font-semibold' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }} transition-all">
            <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" /></svg>
            Trending
        </a>
        @auth
        <a href="{{ route('dashboard') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[14px] {{ request()->routeIs('dashboard') ? 'bg-brand/10 text-brand font-semibold' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }} transition-all">
            <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            My Feed
        </a>
        <a href="{{ route('bookmarks.index') }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[14px] {{ request()->routeIs('bookmarks.index') ? 'bg-brand/10 text-brand font-semibold' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5' }} transition-all">
            <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
            Saved Stories
        </a>
        @endauth
    </nav>

    {{-- Categories --}}
    <div class="px-5 mt-6 mb-4 border-t border-gray-100 dark:border-white/5 pt-5">
        <h3 class="text-[11px] font-semibold text-gray-400 dark:text-gray-500 tracking-wider uppercase mb-3">Categories</h3>
        <ul class="space-y-0.5">
            @php $allCategories = \App\Models\Category::all(); @endphp
            @foreach($allCategories as $category)
            <li>
                <a href="{{ route('categories.show', $category) }}" @click="sidebarOpen = false" class="flex items-center gap-3 px-3 py-2 rounded-xl text-[13px] {{ request()->is('categories/'.$category->slug) ? 'text-gray-900 dark:text-white font-semibold bg-gray-50 dark:bg-white/5' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-white/5' }} transition-all">
                    <span>{{ $category->name }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</aside>
