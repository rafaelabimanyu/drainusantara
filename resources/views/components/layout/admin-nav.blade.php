<div class="flex flex-1 flex-col justify-between">
    <div class="space-y-6">
        <div>
            <p class="px-2.5 text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">
                Menu Utama
            </p>
            <ul role="list" class="space-y-1">
                <!-- 1. Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-sky-700 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- 2. Layanan -->
                <li>
                    <a href="{{ route('admin.services.index') }}" 
                       class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('admin.services*') ? 'bg-sky-700 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.services*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Kelola Layanan</span>
                    </a>
                </li>

                <!-- 3. Area Jangkauan -->
                <li>
                    <a href="{{ route('admin.coverage-areas.index') }}" 
                       class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('admin.coverage-areas*') ? 'bg-sky-700 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.coverage-areas*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Area Jangkauan (SEO)</span>
                    </a>
                </li>

                <!-- 4. Galeri Dokumentasi -->
                <li>
                    <a href="{{ route('admin.galleries.index') }}" 
                       class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('admin.galleries*') ? 'bg-sky-700 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.galleries*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Galeri Dokumentasi</span>
                    </a>
                </li>

                <!-- 5. Portofolio Klien B2B -->
                <li>
                    <a href="{{ route('admin.portfolios.index') }}" 
                       class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('admin.portfolios*') ? 'bg-sky-700 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.portfolios*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Portofolio Klien B2B</span>
                    </a>
                </li>

                <!-- 6. Peralatan & Mesin -->
                <li>
                    <a href="{{ route('admin.equipments.index') }}" 
                       class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('admin.equipments*') ? 'bg-sky-700 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.equipments*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Peralatan &amp; Armada</span>
                    </a>
                </li>

                <!-- 7. Artikel & Edukasi -->
                <li>
                    <a href="{{ route('admin.articles.index') }}" 
                       class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('admin.articles*') ? 'bg-sky-700 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.articles*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span>Artikel &amp; Edukasi</span>
                    </a>
                </li>

                <!-- 8. Testimoni Pelanggan -->
                <li>
                    <a href="{{ route('admin.reviews.index') }}" 
                       class="group flex items-center gap-x-3 rounded-lg px-3 py-2 text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('admin.reviews*') ? 'bg-sky-700 text-white shadow-2xs' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('admin.reviews*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span>Testimoni Pelanggan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Quick Access & Logout -->
    <div class="pt-4 border-t border-slate-800 space-y-1.5">
        <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" 
           class="group flex items-center justify-between rounded-lg px-3 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span>Lihat Website</span>
            </span>
            <span class="text-[10px] bg-slate-800 border border-slate-700 px-1.5 py-0.5 rounded text-slate-400">Live</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full group flex items-center justify-between rounded-lg px-3 py-2 text-xs font-semibold text-rose-400 hover:bg-rose-950/40 hover:text-rose-300 transition-colors cursor-pointer text-left">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar Sesi</span>
                </span>
                <span class="text-[10px] text-slate-500">Logout</span>
            </button>
        </form>
    </div>
</div>
