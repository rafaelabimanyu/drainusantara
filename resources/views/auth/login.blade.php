<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk Admin CMS | Drainusantara</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    </noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-full flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 font-sans antialiased bg-slate-100 text-slate-900">
    <main class="w-full max-w-5xl grid lg:grid-cols-[0.85fr_1.15fr] bg-white border border-slate-200 rounded-lg overflow-hidden">
        <aside class="hidden lg:flex flex-col justify-between bg-slate-900 text-white p-10 xl:p-12">
            <div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-sky-700 text-white flex items-center justify-center font-extrabold text-lg tracking-wider">DN</div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight block leading-tight">DRAINUSANTARA</span>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-sky-300 block">CMS Control Panel</span>
                    </div>
                </div>
                <div class="mt-16 border-l-2 border-sky-500 pl-5">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-sky-300">Ruang kerja admin</p>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight leading-tight">Jaga layanan tetap bergerak.</h1>
                    <p class="mt-4 text-sm leading-6 text-slate-300">Kelola layanan, proyek, ulasan, dan area teknisi dari satu panel operasional.</p>
                </div>
            </div>
            <p class="text-xs text-slate-400">Akses internal Drainusantara</p>
        </aside>
        <section class="p-6 sm:p-10 lg:p-12">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Brand Header -->
        <div class="text-center lg:hidden">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group focus:outline-hidden focus:ring-2 focus:ring-sky-700 focus:ring-offset-2 rounded-lg p-1">
                <div class="w-11 h-11 rounded-lg bg-sky-700 text-white flex items-center justify-center font-extrabold text-lg tracking-wider shadow-2xs group-hover:bg-sky-800 transition-colors">
                    DN
                </div>
                <div class="text-left">
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 block leading-tight">DRAINUSANTARA</span>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-sky-700 block">CMS Control Panel</span>
                </div>
            </a>
            <h1 class="mt-4 text-lg font-bold text-slate-900">
                Masuk ke Panel Operasional
            </h1>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Kelola konten layanan, portofolio proyek, ulasan, dan data armada teknisi.
            </p>
        </div>

        <!-- Auth Card -->
        <div class="mt-8" x-data="{ showPassword: false }">
            @if(session('info'))
                <div class="mb-5 p-3.5 rounded-lg bg-sky-50 border border-sky-200 text-sky-800 text-xs sm:text-sm flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-sky-700 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-rose-700 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.attempt') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nama Pengguna / Email -->
                <div>
                    <label for="login" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Pengguna / Akun Admin
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            name="login" 
                            id="login" 
                            required 
                            autofocus 
                            value="{{ old('login') }}"
                            placeholder="Masukkan nama pengguna / email" 
                            class="w-full pl-9 pr-3.5 py-3 rounded-md border border-slate-300 bg-white text-slate-900 placeholder-slate-400 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition"
                        >
                    </div>
                </div>

                <!-- Kata Sandi -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="••••••••••••" 
                            class="w-full pl-9 pr-10 py-3 rounded-md border border-slate-300 bg-white text-slate-900 placeholder-slate-400 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition"
                        >
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-700 transition-colors focus:outline-hidden"
                            aria-label="Tampilkan atau sembunyikan kata sandi"
                        >
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Security Status -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-700">
                        <input type="checkbox" name="remember" checked class="w-4 h-4 rounded-sm border-slate-300 text-sky-700 focus:ring-sky-700 focus:ring-offset-1">
                        <span>Ingat sesi masuk</span>
                    </label>
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        Akses Terenkripsi
                    </span>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full mt-2 py-3 px-4 rounded-md bg-sky-700 hover:bg-sky-800 text-white font-semibold text-sm transition-colors flex items-center justify-center gap-2 cursor-pointer focus:outline-hidden focus:ring-2 focus:ring-sky-700 focus:ring-offset-2"
                >
                    <span>Masuk ke Dashboard</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <div class="mt-6 pt-4 border-t border-slate-200 text-left">
                <div class="text-xs text-slate-500">
                    <span>Akses hanya untuk personel internal yang berwenang.</span>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="mt-8 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-sky-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Website Drainusantara</span>
            </a>
        </div>
    </div>
        </section>
    </main>
</body>
</html>
