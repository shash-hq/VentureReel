<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'VentureReel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased"
          x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
          x-init="
              if (darkMode) document.documentElement.classList.add('dark');
              $watch('darkMode', val => {
                  localStorage.setItem('darkMode', val);
                  document.documentElement.classList.toggle('dark', val);
              })
          "
          :class="{ 'dark': darkMode }">

        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 pt-6 sm:pt-0 bg-base-cream dark:bg-deep-charcoal text-gray-900 dark:text-gray-100 transition-colors">

            {{-- Theme Toggle --}}
            <div class="w-full flex justify-end pt-4 sm:pt-0 sm:absolute sm:top-6 sm:right-6">
                <button @click="darkMode = !darkMode" class="p-2 rounded-full text-gray-500 hover:text-gray-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-white/10 transition-all focus:outline-none" aria-label="Toggle theme">
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>

            {{-- Logo --}}
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center gap-4 group">
                    <div class="w-16 h-16 rounded-2xl bg-brand/10 dark:bg-brand/20 flex items-center justify-center group-hover:bg-brand/20 dark:group-hover:bg-brand/30 transition-colors shadow-lg shadow-brand/5 border border-brand/20">
                        <svg class="h-8 w-8 text-brand" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                        </svg>
                    </div>
                    <span class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">VentureReel</span>
                </a>
            </div>

            {{-- Card --}}
            <div class="w-full sm:max-w-md px-8 py-8 sm:px-10 sm:py-10 glass-panel shadow-xl shadow-black/5 dark:shadow-black/40 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-brand/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            {{-- Footer --}}
            <p class="mt-8 text-xs text-gray-400 dark:text-gray-600">&copy; {{ date('Y') }} VentureReel. All rights reserved.</p>
        </div>
    </body>
</html>
