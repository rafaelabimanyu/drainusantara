<!-- ====================================================================
     1. EDITORIAL HEADER & MINIMALIST NAVBAR
     border-b border-slate-200/80 bg-white/80 backdrop-blur-md sticky top-0 z-40
==================================================================== -->
<header class="border-b border-slate-200/80 bg-white/80 backdrop-blur-md sticky top-0 z-40 transition-all shadow-2xs"
        @click.outside="activeMenu = null">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Identity: DRAIN (Midnight Navy) + NUSANTARA (Crimson Red) -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 rounded-xl bg-slate-900 border border-slate-800 text-white flex items-center justify-center group-hover:bg-blue-700 transition-colors shadow-2xs shrink-0">
                    <svg class="w-4 h-4 text-blue-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <div>
                    <span class="text-lg font-extrabold tracking-tight text-slate-900 block leading-none">
                        DRAIN<span class="text-red-600">NUSANTARA</span>
                    </span>
                    <span class="text-[9px] font-mono font-bold tracking-widest text-slate-500 uppercase block mt-0.5">
                        PRECISION PIPE ENGINEERING
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Items -->
            <nav class="hidden md:flex items-center space-x-7 text-xs font-semibold text-slate-700 tracking-tight">
                <!-- Dropdown Trigger: Layanan (Smart Mega Menu) -->
                <button @click="activeMenu = (activeMenu === 'layanan' ? null : 'layanan')"
                        type="button" 
                        class="inline-flex items-center gap-1.5 py-2 hover:text-blue-700 transition-colors focus:outline-hidden cursor-pointer"
                        :class="{ 'text-blue-700 font-bold': activeMenu === 'layanan' }">
                    <span>Layanan Spesialis</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-blue-700': activeMenu === 'layanan' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Nav Link: Cara Kerja (3 Langkah) -->
                <a href="{{ url('/#cara-kerja') }}" class="py-2 hover:text-blue-700 transition-colors">
                    Sistem Kerja
                </a>

                <!-- Nav Link: Bukti Kerja (Before-After) -->
                <a href="{{ url('/galeri') }}" class="py-2 hover:text-blue-700 transition-colors {{ request()->is('galeri*') ? 'text-blue-700 font-bold' : '' }}">
                    Bukti Lapangan
                </a>

                <!-- Dropdown Trigger: Cakupan Wilayah (Quick Area Finder) -->
                <button @click="activeMenu = (activeMenu === 'wilayah' ? null : 'wilayah')"
                        type="button" 
                        class="inline-flex items-center gap-1.5 py-2 hover:text-blue-700 transition-colors focus:outline-hidden cursor-pointer"
                        :class="{ 'text-blue-700 font-bold': activeMenu === 'wilayah' }">
                    <span>Posko Wilayah</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-blue-700': activeMenu === 'wilayah' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Nav Link: Edukasi Audit Pipa -->
                <a href="{{ url('/#edukasi') }}" class="py-2 hover:text-blue-700 transition-colors">
                    Audit Soda Api
                </a>
            </nav>

            <!-- Desktop CTA: Tombol 'Hubungi Kami' Deep Emerald -->
            <div class="hidden md:flex items-center">
                <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')"
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl px-5 py-2.5 shadow-xs hover:shadow transition-all inline-flex items-center gap-2 active:scale-98">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Dispatch Teknisi WA</span>
                </a>
            </div>

            <!-- Mobile Top Mini Indicator -->
            <div class="flex items-center gap-2 md:hidden">
                <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')"
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="bg-emerald-700 hover:bg-emerald-800 text-white text-[11px] font-bold px-3 py-1.5 rounded-xl border border-emerald-800 shadow-2xs inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-ping"></span>
                    <span>Hotline WA 24H</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mega Menus (Included inside header scope) -->
    @include('layouts.partials.mega-menu-layanan')
    @include('layouts.partials.mega-menu-wilayah')
</header>
