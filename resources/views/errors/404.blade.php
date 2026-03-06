<x-guest-layout>
    <div class="text-center py-4">
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-brand/10 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
        <h1 class="text-6xl font-extrabold text-brand mb-4">404</h1>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Page not found</h2>
        <p class="text-gray-500 dark:text-gray-400 mb-8">Sorry, we couldn't find the page you're looking for.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-brand border border-transparent rounded-xl font-semibold text-white hover:bg-brand-hover active:bg-brand focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 dark:focus:ring-offset-deep-charcoal transition ease-in-out duration-150 shadow-md shadow-brand/20">
            Back to homepage
        </a>
    </div>
</x-guest-layout>
