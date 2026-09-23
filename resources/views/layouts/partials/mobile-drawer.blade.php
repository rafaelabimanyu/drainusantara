<!-- ====================================================================
     SLIDE-OVER DRAWER MENU (K3 & AUDIT TEKNIS)
==================================================================== -->
<div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-50 md:hidden" role="dialog" aria-modal="true">
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-200 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 max-w-xs w-full bg-white border-l border-slate-200 shadow-2xl p-6 flex flex-col justify-between overflow-y-auto">
        
        <div>
            <!-- Header inside drawer -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex items-center justify-center font-extrabold text-xs shadow-xs">
                        DN
                    </div>
                    <div>
                        <span class="font-extrabold text-slate-900 tracking-tight block text-sm">
                            DRAIN<span class="text-red-600">NUSANTARA</span>
                        </span>
                        <span class="text-[9px] font-mono text-slate-500 font-bold block">PRECISION PIPE ENGINEERING</span>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="p-2 text-slate-400 hover:text-slate-700 rounded-xl hover:bg-slate-100 focus:outline-hidden transition-colors" aria-label="Tutup menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-4 flex flex-col space-y-1 text-xs">
                <a href="{{ url('/') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-blue-700 transition-colors">
                    Beranda Utama
                </a>
                <a href="{{ url('/#layanan') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-blue-700 transition-colors">
                    Katalog Spesialis Masalah
                </a>
                <a href="{{ url('/#cara-kerja') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-blue-700 transition-colors">
                    Sistem Kerja 3 Langkah
                </a>
                <a href="{{ url('/galeri') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-blue-700 transition-colors">
                    Bukti Lapangan (Before-After)
                </a>
                <a href="{{ url('/#edukasi') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-blue-700 transition-colors">
                    Audit Bahaya Soda Api
                </a>
                <a href="{{ url('/#b2b') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-blue-700 transition-colors">
                    Solusi Hydro-Jetting B2B
                </a>
                <a href="{{ url('/#area') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-blue-700 transition-colors">
                    Daftar Posko Wilayah
                </a>
                <a href="{{ url('/#footer-workshop') }}" @click="sidebarOpen = false" class="flex items-center px-3.5 py-2.5 font-bold rounded-xl text-slate-800 hover:bg-slate-100 hover:text-blue-700 transition-colors">
                    Workshop & Kontak
                </a>
            </nav>

            <!-- K3 & Legalitas Info Box -->
            <div class="mt-5 p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                <span class="text-[10px] font-mono font-bold text-blue-700 uppercase tracking-wider block mb-2">STANDAR K3 & LEGALITAS:</span>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-700 font-bold select-none">✓</span>
                        <span>Badan Usaha Resmi Terdaftar</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-700 font-bold select-none">✓</span>
                        <span>Garansi Tertulis 30 Hari Kerja</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-700 font-bold select-none">✓</span>
                        <span>Teknisi Bersepatu & APD Steril</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-emerald-700 font-bold select-none">✓</span>
                        <span>Faktur Pajak B2B & Penagihan Resmi</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Action CTA -->
        <div class="pt-4 border-t border-slate-200 mt-6">
            <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saya butuh penanganan darurat pipa mampet.')" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="w-full flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-3 px-4 rounded-xl shadow-xs transition-colors text-xs">
                <span>Dispatch Teknisi 24 Jam</span>
            </a>
            <p class="text-[10px] text-center text-slate-500 mt-2 font-mono">Standby 24 Jam &bull; Respon &lt; 15 Menit</p>
        </div>
    </div>
</div>
