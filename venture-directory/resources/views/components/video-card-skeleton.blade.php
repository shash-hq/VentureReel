{{-- Skeleton loader matching video-card dimensions --}}
<div class="bg-white dark:bg-dark-surface rounded-2xl overflow-hidden border border-gray-200 dark:border-dark-border flex flex-col h-full animate-pulse">
    {{-- Thumbnail skeleton --}}
    <div class="aspect-video bg-gray-200 dark:bg-white/5"></div>

    {{-- Content skeleton --}}
    <div class="p-4 flex flex-col flex-1">
        {{-- Title --}}
        <div class="h-4 bg-gray-200 dark:bg-white/5 rounded-lg w-full mb-2"></div>
        <div class="h-4 bg-gray-200 dark:bg-white/5 rounded-lg w-2/3 mb-4"></div>

        {{-- Author row --}}
        <div class="mt-auto flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-white/5"></div>
            <div class="flex-1">
                <div class="h-3 bg-gray-200 dark:bg-white/5 rounded w-24 mb-1.5"></div>
                <div class="h-2.5 bg-gray-200 dark:bg-white/5 rounded w-16"></div>
            </div>
        </div>
    </div>
</div>
