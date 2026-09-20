<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login CMS Admin | Drainusantara</title>

    <!-- Google Fonts (Asynchronous) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    </noscript>

    <!-- Vite Assets (Tailwind & Bundled Alpine.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4 sm:p-6 font-sans antialiased relative overflow-hidden bg-radial from-slate-900 via-slate-950 to-black text-slate-100">
    <!-- Ambient glowing backdrop -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-sky-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-600 to-sky-400 text-white flex items-center justify-center font-extrabold text-xl shadow-lg shadow-sky-500/30 group-hover:scale-105 transition-transform">
                    DN
                </div>
                <div class="text-left">
                    <span class="text-2xl font-black tracking-tight text-white block">DRAINUSANTARA</span>
                    <span class="text-xs font-semibold uppercase tracking-widest text-sky-400 block -mt-1">CMS Control Panel</span>
                </div>
            </a>
            <p class="mt-3 text-sm text-slate-400">
                Silakan masuk untuk mengelola portal layanan & operasional
            </p>
        </div>

        <!-- Card Container -->
        <div class="bg-slate-800/80 backdrop-blur-xl rounded-3xl border border-slate-700/80 shadow-2xl p-6 sm:p-8" x-data="{ showPassword: false }">
            @if(session('info'))
                <div class="mb-5 p-3.5 rounded-xl bg-sky-500/10 border border-sky-500/30 text-sky-300 text-xs sm:text-sm flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs sm:text-sm flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.attempt') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Pengguna / Email -->
                <div>
                    <label for="login" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        Nama Pengguna / Akun Admin
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            name="login" 
                            id="login" 
                            required 
                            autofocus 
                            value="{{ old('login', 'Drainusantara@admin') }}"
                            placeholder="Drainusantara@admin" 
                            class="w-full pl-11 pr-4 py-3 rounded-xl bg-slate-900/90 border border-slate-600 text-white placeholder-slate-500 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-hidden transition"
                        >
                    </div>
                </div>

                <!-- Kata Sandi -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            name="password" 
                            id="password" 
                            required 
                            value="{{ old('login') ? '' : 'Drainusantara123' }}"
                            placeholder="••••••••••••" 
                            class="w-full pl-11 pr-11 py-3 rounded-xl bg-slate-900/90 border border-slate-600 text-white placeholder-slate-500 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-hidden transition"
                        >
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-white transition-colors"
                            aria-label="Toggle password visibility"
                        >
                            <!-- Eye icon -->
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye slash icon -->
                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer text-xs sm:text-sm text-slate-300">
                        <input type="checkbox" name="remember" checked class="w-4 h-4 rounded-sm border-slate-600 bg-slate-900 text-sky-600 focus:ring-sky-500 focus:ring-offset-slate-800">
                        <span>Ingat sesi masuk ini</span>
                    </label>
                    <span class="text-xs text-sky-400 font-semibold">Akses Terenkripsi</span>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3.5 px-4 rounded-xl bg-sky-600 hover:bg-sky-500 active:bg-sky-700 text-white font-bold text-sm shadow-lg shadow-sky-600/30 transition-all transform active:scale-98 flex items-center justify-center gap-2 cursor-pointer"
                >
                    <span>Masuk ke Dashboard CMS</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <!-- Credential Info Helper Pill -->
            <div class="mt-6 pt-5 border-t border-slate-700/60 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-900/70 border border-slate-700 text-[11px] text-slate-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Admin User: <strong class="text-white">Drainusantara@admin</strong></span>
                    <span class="text-slate-500">&bull;</span>
                    <span>Pass: <strong class="text-white">Drainusantara123</strong></span>
                </div>
            </div>
        </div>

        <!-- Back to Website Link -->
        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Halaman Utama Drainusantara</span>
            </a>
        </div>
    </div>
</body>
</html>
