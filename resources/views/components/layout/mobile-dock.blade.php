<nav class="fixed bottom-3 inset-x-4 max-w-md mx-auto z-50 bg-slate-900/95 text-white backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-2 flex items-center justify-around md:hidden mobile-nav-dock transition-all duration-300 ease-in-out"
     :class="{ 'translate-y-28 opacity-0 pointer-events-none': mobileSearchOpen || sidebarOpen }"
     aria-label="Navigasi Mobile Floating Dock">
    <!-- 1. Beranda (Icon Home) -->
    <a href="{{ url('/') }}" class="flex flex-col items-center justify-center py-1 px-2.5 text-xs {{ Request::is('/') ? 'text-sky-400 font-bold' : 'text-slate-300' }} hover:text-white transition-colors btn-press active:scale-90">
        <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="text-[10px] tracking-tight font-semibold">Beranda</span>
    </a>

    <!-- 2. Layanan (Icon Tools) -->
    <a href="{{ url('/#layanan') }}" class="flex flex-col items-center justify-center py-1 px-2.5 text-xs text-slate-300 hover:text-white transition-colors btn-press active:scale-90">
        <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span class="text-[10px] tracking-tight font-semibold">Layanan</span>
    </a>

    <!-- 3. WhatsApp Hero Center (Tombol bulat hijau empuk menonjol di tengah) -->
    <div class="relative px-1">
        <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saluran air di rumah saya sedang mampet. Mohon info teknisi terdekat.')" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="-mt-6 bg-emerald-600 hover:bg-emerald-700 text-white p-3.5 rounded-full shadow-lg border-4 border-slate-900 flex items-center justify-center btn-press pulse-ring-emerald" 
           aria-label="Panggil Teknisi via WhatsApp">
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
    </a>
</div>

    <!-- 4. Cari Wilayah (Icon Search / Pin) -->
    <button @click="mobileSearchOpen = true; activeMenu = null" type="button" class="flex flex-col items-center justify-center py-1 px-2.5 text-xs text-slate-300 hover:text-white transition-colors cursor-pointer btn-press active:scale-90" aria-label="Cari Wilayah">
        <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <span class="text-[10px] tracking-tight font-semibold">Area</span>
    </button>

    <!-- 5. Drawer Menu (Icon Hamburger) -->
    <button @click="sidebarOpen = true" type="button" class="flex flex-col items-center justify-center py-1 px-2.5 text-xs text-slate-300 hover:text-white transition-colors cursor-pointer btn-press active:scale-90" aria-label="Menu Lengkap">
        <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <span class="text-[10px] tracking-tight font-semibold">Menu</span>
    </button>
</nav>
