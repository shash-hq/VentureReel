<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches), sidebarOpen: false }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
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
    <body class="font-sans antialiased text-gray-900 bg-white dark:bg-dark-bg dark:text-gray-100 flex h-screen overflow-hidden">

        {{-- Mobile Sidebar Overlay --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 md:hidden"
             style="display: none;"></div>

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Main Content Wrapper --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-white dark:bg-dark-bg">
            {{-- Top Navbar --}}
            @include('partials.navbar')

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto w-full">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="bg-accent/10 border border-accent/20 text-accent px-4 py-3 rounded-xl mx-4 sm:mx-6 mt-4 sm:mt-6 text-sm flex items-center gap-2" role="alert">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-brand/10 border border-brand/20 text-brand px-4 py-3 rounded-xl mx-4 sm:mx-6 mt-4 sm:mt-6 text-sm flex items-center gap-2" role="alert">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{-- Unverified Email Banner --}}
                @if (auth()->check() && !auth()->user()->hasVerifiedEmail())
                    <div class="bg-yellow-50 dark:bg-yellow-900/40 border border-yellow-200 dark:border-yellow-800 rounded-xl mx-4 sm:mx-6 mt-4 sm:mt-6 px-4 py-4 text-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-yellow-800 dark:text-yellow-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span>Please verify your email address to upload videos and bookmark content.</span>
                        </div>
                        <form method="POST" action="{{ route('verification.send') }}" class="inline m-0">
                            @csrf
                            <button type="submit" class="font-semibold underline hover:text-yellow-900 dark:hover:text-white whitespace-nowrap">Resend email</button>
                        </form>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

    </body>
</html>
