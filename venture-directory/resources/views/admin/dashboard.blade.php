<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4">
        
        <div class="mb-10 text-center sm:text-left flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Admin Dashboard</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Review and moderate video submissions.</p>
            </div>
            
            <div class="flex items-center justify-center gap-4 text-sm font-medium">
                <div class="px-4 py-2 bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-xl">
                    <span class="text-gray-500 dark:text-gray-400 block text-xs uppercase tracking-wider mb-0.5">Pending</span>
                    <span class="text-xl text-yellow-600 dark:text-yellow-500">{{ \App\Models\Video::where('is_approved', false)->count() }}</span>
                </div>
                <div class="px-4 py-2 bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-xl">
                    <span class="text-gray-500 dark:text-gray-400 block text-xs uppercase tracking-wider mb-0.5">Approved</span>
                    <span class="text-xl text-green-600 dark:text-green-500">{{ \App\Models\Video::where('is_approved', true)->count() }}</span>
                </div>
            </div>
        </div>

        @if($pendingVideos->count() > 0)
            <div class="bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-2xl overflow-hidden shadow-sm">
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
                        <tbody class="divide-y divide-gray-200 dark:divide-white/5 bg-white dark:bg-dark-surface">
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
            <div class="text-center py-24 bg-white dark:bg-dark-surface rounded-[32px] border border-gray-200 dark:border-dark-border">
                <div class="mx-auto w-20 h-20 bg-green-50 dark:bg-green-900/10 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">All caught up!</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">There are no pending video submissions to review. Excellent work keeping the queue clean.</p>
            </div>
        @endif

    </div>
</x-app-layout>
