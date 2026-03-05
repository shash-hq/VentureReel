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

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-dark-bg text-gray-900 dark:text-gray-100 transition-colors">

            {{-- Theme Toggle --}}
            <div class="w-full flex justify-end px-6 pt-4 sm:pt-0 sm:absolute sm:top-6 sm:right-6">
                <button @click="darkMode = !darkMode" class="p-2 rounded-full text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-200/50 dark:hover:bg-white/5 transition-all focus:outline-none" aria-label="Toggle theme">
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>

            {{-- Logo --}}
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="w-14 h-14 rounded-2xl bg-brand/10 flex items-center justify-center group-hover:bg-brand/15 transition-colors">
                        <svg class="h-7 w-7 text-brand" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">VentureReel</span>
                </a>
            </div>

            {{-- Card --}}
            <div class="w-full sm:max-w-md px-8 py-8 sm:px-10 sm:py-10 bg-white dark:bg-dark-surface shadow-xl shadow-black/5 dark:shadow-black/40 border border-gray-200 dark:border-dark-border sm:rounded-2xl transition-colors relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-brand/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            {{-- Footer --}}
            <p class="mt-8 text-xs text-gray-400 dark:text-gray-600">&copy; {{ date('Y') }} VentureReel. All rights reserved.</p>
        </div>
    </body>
</html>
