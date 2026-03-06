<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4">
        
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Admin Dashboard</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Platform metrics and moderation queue.</p>
            </div>
        </div>

        {{-- Top Level Metrics --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Total Videos -->
            <div class="glass-panel p-5 transition-transform hover:-translate-y-1">
                <span class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider font-semibold">Total Videos</span>
                <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_videos']) }}</div>
            </div>
            <!-- Total Users -->
            <div class="glass-panel p-5 transition-transform hover:-translate-y-1">
                <span class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider font-semibold">Total Users</span>
                <div class="mt-2 text-3xl font-bold text-brand">{{ number_format($stats['total_users']) }}</div>
            </div>
            <!-- Pending Videos -->
            <div class="glass-panel p-5 transition-transform hover:-translate-y-1">
                <span class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider font-semibold">Pending Approval</span>
                <div class="mt-2 text-3xl font-bold text-yellow-600 dark:text-yellow-500">{{ number_format($stats['pending_videos']) }}</div>
            </div>
            <!-- DAU Chart -->
            <div class="glass-panel p-5 transition-transform hover:-translate-y-1">
                <span class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider font-semibold">DAU (7 Days)</span>
                <div class="mt-3 flex items-end justify-between h-8 gap-1.5">
                    @php $maxDAU = max(1, max(array_values($dauChart))); @endphp
                    @foreach($dauChart as $date => $count)
                        <div class="w-full bg-brand/20 rounded-t relative group h-full flex items-end">
                            <div class="w-full bg-brand rounded-t transition-all duration-500" style="height: {{ ($count / $maxDAU) * 100 }}%"></div>
                            <div class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2 py-1 rounded pointer-events-none whitespace-nowrap z-10 transition-opacity">
                                {{ \Carbon\Carbon::parse($date)->format('M d') }}: {{ $count }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Detailed Data Grids --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
            <!-- Most Searched Keywords -->
            <div class="glass-panel p-0 overflow-hidden flex flex-col">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-[#1a1a1a]">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Top Searches</h3>
                </div>
                <ul class="divide-y divide-gray-200 dark:divide-white/5 bg-white/20 dark:bg-dark-surface/50 flex-grow">
                    @forelse($mostSearched as $search)
                        <li class="px-5 py-3.5 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate pr-4">{{ $search->query }}</span>
                            <span class="text-[11px] font-bold bg-brand/10 text-brand px-2 py-1 rounded-full shrink-0">{{ $search->count }}</span>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No searches performed yet.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Most Viewed Videos -->
            <div class="glass-panel p-0 overflow-hidden flex flex-col">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-[#1a1a1a]">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Most Viewed</h3>
                </div>
                <ul class="divide-y divide-gray-200 dark:divide-white/5 bg-white/20 dark:bg-dark-surface/50 flex-grow">
                    @forelse($mostViewedVideos as $video)
                        <li class="px-5 py-3 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <a href="{{ route('videos.show', $video) }}" class="flex flex-col gap-1 group" target="_blank">
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-200 line-clamp-1 group-hover:text-brand transition-colors">{{ $video->title }}</span>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">{{ number_format($video->views_count) }} views</span>
                            </a>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No views recorded yet.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Newest Imports -->
            <div class="glass-panel p-0 overflow-hidden flex flex-col">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-[#1a1a1a]">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Recent YouTube Imports</h3>
                </div>
                <ul class="divide-y divide-gray-200 dark:divide-white/5 bg-white/20 dark:bg-dark-surface/50 flex-grow">
                    @forelse($newestImports as $video)
                        <li class="px-5 py-3 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <a href="{{ route('videos.show', $video) }}" class="flex flex-col gap-1 group" target="_blank">
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-200 line-clamp-1 group-hover:text-brand transition-colors">{{ $video->title }}</span>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">from {{ $video->channel_name }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No imports yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Moderation Queue</h2>
        </div>

        @if($pendingVideos->count() > 0)
            <div class="glass-panel p-0 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-white/5">
                        <thead class="bg-gray-50 dark:bg-[#1a1a1a]">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Submission</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/5 bg-white/20 dark:bg-dark-surface/50">
                            @foreach($pendingVideos as $video)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0 h-16 w-28 rounded-lg overflow-hidden bg-gray-100 dark:bg-dark-bg border border-gray-200 dark:border-white/5">
                                                <img class="h-full w-full object-cover" src="{{ $video->thumbnail_url }}" alt="">
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900 dark:text-white line-clamp-1 max-w-md">{{ $video->title }}</div>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="inline-flex items-center gap-1 text-xs text-gray-500 bg-gray-100 dark:bg-white/5 px-2 py-0.5 rounded">
                                                        {{ $video->category->name ?? 'Uncategorized' }}
                                                    </span>
                                                    <a href="{{ route('videos.show', $video) }}" target="_blank" class="text-xs text-brand hover:underline">View Preview →</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $video->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $video->user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $video->created_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-3">
                                            <form action="{{ route('admin.videos.approve', $video) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-full shadow-sm text-xs font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                                    Approve
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.videos.reject', $video) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject and delete this submission?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-full shadow-sm text-xs font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-dark-surface hover:bg-gray-50 dark:hover:bg-white/5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand transition-colors">
                                                    Reject
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
                {{ $pendingVideos->links() }}
            </div>
        @else
            <div class="text-center py-24 glass-panel !rounded-[32px]">
                <div class="mx-auto w-20 h-20 bg-green-50 dark:bg-green-900/10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">All caught up!</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">There are no pending video submissions to review. Excellent work keeping the queue clean.</p>
            </div>
        @endif

    </div>
</x-app-layout>
