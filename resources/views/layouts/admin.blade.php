<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | CMS Drainusantara</title>

    <!-- Google Fonts (Asynchronous & Non-render-blocking) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    </noscript>

    <!-- Vite Assets (Compiled Tailwind CSS & Alpine.js Bundle) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }">
    <div class="min-h-full flex">
        <!-- Off-canvas mobile menu (Alpine.js) -->
        <div x-cloak x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm"></div>

            <div class="fixed inset-0 flex">
                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="relative mr-16 flex w-full max-w-xs flex-1">
                    <div class="flex flex-col grow gap-y-5 overflow-y-auto bg-slate-900 px-6 pb-4">
                        <!-- Mobile Brand Logo -->
                        <div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-800">
                            <div class="w-9 h-9 rounded-lg bg-sky-600 text-white flex items-center justify-center font-bold text-sm">
                                DN
                            </div>
                            <div>
                                <span class="font-extrabold text-white text-base">DRAINUSANTARA</span>
                                <span class="text-[10px] text-sky-400 block font-semibold tracking-wider uppercase">Custom CMS</span>
                            </div>
                        </div>
                        
                        <!-- Mobile Nav -->
                        <nav class="flex flex-1 flex-col">
                            @include('layouts.partials.admin-nav')
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Static desktop sidebar -->
        <aside class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col border-r border-slate-800 bg-slate-900">
            <div class="flex flex-col grow gap-y-5 overflow-y-auto px-6 pb-4">
                <!-- Brand Logo Header -->
                <div class="flex h-20 shrink-0 items-center justify-between border-b border-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-600 text-white flex items-center justify-center font-extrabold shadow-md shadow-sky-600/30">
                            DN
                        </div>
                        <div>
                            <span class="font-extrabold text-white text-lg tracking-tight block">DRAINUSANTARA</span>
                            <span class="text-[10px] text-sky-400 font-bold tracking-widest uppercase block">CMS Dashboard</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-sky-500/20 text-sky-300 text-[10px] font-bold border border-sky-500/30">v1.0</span>
                </div>

                <!-- Desktop Nav -->
                <nav class="flex flex-1 flex-col">
                    @include('layouts.partials.admin-nav')
                </nav>
            </div>
        </aside>

        <!-- Main content column -->
        <div class="lg:pl-72 flex flex-col flex-1 min-w-0">
            <!-- Top Navbar -->
            <header class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200 bg-white px-4 shadow-2xs sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" @click="sidebarOpen = true" class="-m-2.5 p-2.5 text-slate-700 lg:hidden" aria-label="Buka navigasi">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="h-6 w-px bg-slate-200 lg:hidden"></div>

                <!-- Breadcrumb / Header Title -->
                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6 items-center">
                    <div class="flex items-center gap-2 text-sm text-slate-500">
                        <span class="font-medium text-slate-700">Admin Area</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="font-bold text-sky-700">@yield('page-title', 'Dashboard')</span>
                    </div>
                </div>

                <!-- Top Right Actions -->
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-sky-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span class="hidden sm:inline">Lihat Website</span>
                    </a>

                    <!-- Admin Profile Badge -->
                    <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-xs">
                            DN
                        </div>
                        <div class="hidden sm:block text-left">
                            <span class="text-xs font-bold text-slate-900 block leading-tight">{{ Auth::user()?->name ?? 'Drainusantara@admin' }}</span>
                            <span class="text-[10px] text-emerald-600 font-medium block">&bull; Online</span>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 px-3 py-1.5 rounded-lg transition-colors cursor-pointer" title="Keluar dari sesi CMS">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Flash Session Alerts -->
            <div class="px-4 sm:px-6 lg:px-8 pt-6">
                @if(session('success'))
                    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-800 flex items-center justify-between shadow-2xs">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700" aria-label="Tutup pesan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-800 shadow-2xs">
                        <div class="font-bold mb-1">Terjadi kesalahan pengisian data:</div>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page Body Content -->
            <main class="py-6 px-4 sm:px-6 lg:px-8 flex-1">
                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center text-xs text-slate-500">
                &copy; {{ date('Y') }} Drainusantara Custom CMS &bull; Sistem Pengelolaan Jasa Pipa Mampet & SEO Lokal
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
