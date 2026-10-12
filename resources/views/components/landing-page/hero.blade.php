@props([
    'generalWaUrl',
    'whatsappNumber' => null,
])

<section class="relative min-h-[calc(100vh-5rem)] flex items-center bg-white border-b border-slate-200 overflow-hidden py-12 lg:py-20">
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <picture class="w-full h-full">
            <source media="(max-width: 640px)" srcset="{{ asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp') }}" type="image/webp">
            <img 
                src="{{ asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp') }}"
                alt="Jasa Saluran Pipa Mampet Teknisi Profesional Drainusantara" 
                class="w-full h-full object-cover object-center"
                loading="eager"
                fetchpriority="high"
                decoding="async"
                onerror="this.style.display='none'"
            >
        </picture>
        <div class="absolute inset-0 bg-linear-to-r from-[#090D16] via-[#090D16]/60 to-[#090D16]/55"></div>
        <div class="absolute inset-0 bg-slate-900/5"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
            
            <div class="lg:col-span-7 space-y-6 text-left">
                
                <div class="inline-flex items-center px-3 py-1 bg-slate-100 border border-slate-200 rounded-md text-xs font-semibold text-slate-700">
                    <span>Armada Siaga: Jabodetabek, Semarang &amp; Bandar Lampung</span>
                </div>

                <h1 class="text-white text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight sm:leading-[1.12]">
                    Jasa Saluran Mampet & Tukang Pipa Tersumbat <br>    
                    <span class="text-sky-500">Tanpa Bongkar Keramik & Bergaransi.</span>
                </h1>

                <p class="text-sm md:text-lg font-semibold text-white leading-relaxed max-w-2xl">
                    Jasa pelancaran saluran pipa mampet untuk rumah tinggal, ruko, dan resto di Jabodetabek, Semarang, dan Lampung. Mengatasi wastafel dapur berlemak, kloset meluap, serta floor drain buntu menggunakan mesin spiral baja Ridgid tanpa membongkar lantai keramik. Garansi tertulis 30 hari.
                </p>

                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs sm:text-sm font-semibold text-white pt-1">
                    <span class="flex items-center gap-1.5">
                        <span>Keramik Utuh</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span>Inspeksi CCTV 30M</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span>Garansi 30 Hari</span>
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
                    <a href="{{ $generalWaUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-press inline-flex items-center justify-center gap-3 bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-base px-7 py-3.5 rounded-md shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 min-h-12">
                        <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi Saluran Mampet (WA)</span>
                    </a>

                    <a href="#layanan" 
                       class="btn-press inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 active:bg-slate-100 text-slate-800 font-bold text-base px-6 py-3.5 rounded-md border border-slate-300 shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 min-h-12">
                        <span>Lihat Biaya Layanan</span>
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>

            </div>

            <div class="hidden lg:block lg:col-span-5">
                <div class="bg-white rounded-lg p-3 sm:p-4 border border-slate-200 shadow-sm space-y-3 card-lift">
                    <div class="relative rounded-md overflow-hidden aspect-16/11 bg-slate-900 border border-slate-200">
                        <img 
                            src="{{ asset('images/dokumentasi/proses-pelancaran-gutter-restoran-jakarta.webp') }}" 
                            alt="Teknisi Drainusantara Pelancaran Saluran Tanpa Bongkar" 
                            width="800" 
                            height="550" 
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
