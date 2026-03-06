<x-app-layout>
    <div class="max-w-7xl mx-auto pb-12 pt-4 px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-brand mb-2 inline-block">← Back to Dashboard</a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Founder Collections</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Curate playlists of videos.</p>
            </div>
            <div>
                <a href="{{ route('admin.collections.create') }}" class="px-4 py-2 bg-brand text-white font-semibold rounded-lg hover:bg-brand/90 transition-colors">Create Collection</a>
            </div>
        </div>

        <div class="bg-white dark:bg-dark-surface border border-gray-200 dark:border-dark-border rounded-xl shadow-sm overflow-hidden flex flex-col">
            <ul class="divide-y divide-gray-200 dark:divide-white/5 flex-grow">
                @forelse($collections as $collection)
                    <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                        <div class="flex items-center gap-4">
                            @if($collection->cover_image)
                                <img src="{{ $collection->cover_image }}" alt="" class="w-16 h-16 object-cover rounded-lg shadow-sm border border-gray-200 dark:border-white/10">
                            @else
                                <div class="w-16 h-16 bg-gray-100 dark:bg-[#1a1a1a] rounded-lg border border-gray-200 dark:border-white/5 flex items-center justify-center text-gray-400 shadow-sm">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white"><a href="{{ route('collections.show', $collection) }}" target="_blank" class="hover:text-brand transition-colors">{{ $collection->title }}</a></h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $collection->videos_count }} videos</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.collections.edit', $collection) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-brand dark:hover:text-brand transition-colors">Edit</a>
                            <form action="{{ route('admin.collections.destroy', $collection) }}" method="POST" onsubmit="return confirm('Delete this collection entirely?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 dark:text-red-500 hover:text-red-800 dark:hover:text-red-400 transition-colors">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-12 text-center text-gray-500">No collections found.</li>
                @endforelse
            </ul>
        </div>
        
        <div class="mt-6">
            {{ $collections->links() }}
        </div>
    </div>
</x-app-layout>
