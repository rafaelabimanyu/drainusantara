@props([
    'portfolios' => null,
    'whatsappNumber' => null,
])

@php
    $b2bProjects = (isset($portfolios) && $portfolios->isNotEmpty()) ? $portfolios : collect([
        (object)[
            'client_name' => "D'Cost Seafood Restaurant",
            'client_type' => 'Restoran & F&B Komersial',
            'location' => 'Mall Kelapa Gading, Jakarta Utara',
            'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Pengurasan & De-Greasing Grease Trap 800 Liter',
            'description' => 'Pembersihan kerak minyak jenuh dan lumpur lemak pada bak perangkap lemak dapur komersial sepanjang 25 meter. Dikerjakan malam hari (after-hours) tanpa mengganggu operasional restoran.',
            'specs' => ['Mesin Rooter Spiral K-60', 'After-Hours Service', 'Faktur Pajak B2B & BAST'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
        (object)[
            'client_name' => 'The Alana Hotel & Conference Center',
            'client_type' => 'Perhotelan Bintang 4',
            'location' => 'Sentul City, Bogor',
            'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Pelancaran Saluran Pembuangan Kamar Mandi 42 Kamar',
            'description' => 'Pembersihan endapan busa sabun dan gumpalan rambut pada jalur pipa vertikal kamar mandi tamu. Teknisi ber-APD higienis, pengerjaan cepat dan hening tanpa keluhan dari tamu menginap.',
            'specs' => ['Spiral Baja Lentur 16mm', 'Bebas Suara Bising', 'APD Steril & Rapi'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
        (object)[
            'client_name' => 'Food Court Living World',
            'client_type' => 'Pusat Kuliner Komersial',
            'location' => 'Alam Sutera, Tangerang Selatan',
            'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Inspeksi CCTV & Pelancaran Manhole Utama 16 Tenant',
            'description' => 'Penanganan pipa buang komunal grease trap yang meluap ke area servis. Deteksi koordinat endapan lemak beku dengan kamera CCTV pipa 30 meter dan pembersihan mekanis tuntas.',
            'specs' => ['Kamera CCTV IP68 30M', 'Spiral Heavy Duty 22mm', '100% Tanpa Bongkar'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
        (object)[
            'client_name' => 'Gedung Menara Sudirman',
            'client_type' => 'Gedung Perkantoran Bertingkat',
            'location' => 'SCBD, Jakarta Selatan',
            'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Pelancaran Saluran Pipa Talang Rooftop Vertikal 18 Lantai',
            'description' => 'Ekstraksi endapan lumpur dak beton, lumut, dan dedaunan yang menyumbat jalur pembuangan air hujan utama menjelang musim penghujan agar terhindar dari rembesan ke plafon tenant.',
            'specs' => ['Rooter Baja Jangkauan Panjang', 'Sertifikasi K3 Ketinggian', 'Dokumentasi Video CCTV'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
        (object)[
            'client_name' => 'PT Indofood CBP Sukses Makmur',
            'client_type' => 'Fasilitas Manufaktur & Industri',
            'location' => 'Kawasan Industri Cikarang, Bekasi',
            'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
            'project_title' => 'Pembersihan Jalur Limbah Domestik Kantin Kapasitas 1.200 Porsi',
            'description' => 'Pengerukan kerak lemak dan residu sisa makanan pada bak kontrol utama kantin pabrik. Menggunakan mesin spiral torsi tinggi bebas bahan kimia berbahaya sehingga aman bagi lingkungan.',
            'specs' => ['Rotary Cleaner Industri', 'Metode Ramah Lingkungan', 'Dokumen BAST Lengkap'],
            'guarantee' => 'Garansi Resmi 30 Hari'
        ],
    ]);
    $b2bWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Admin Drainusantara, saya ingin konsultasi penanganan saluran pipa & grease trap untuk perusahaan/gedung kami. Mohon info survey lokasi.");
@endphp

<section id="portofolio-b2b" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200 scroll-mt-20 lg:scroll-mt-24" 
         x-data="{
             activePage: 0,
             pageCount: {{ max(1, (int) ceil(count($b2bProjects) / 3)) }},
             totalCards: {{ count($b2bProjects) }},
             timer: null,
             _observer: null,
             init() {
                 if (typeof window === 'undefined') return;
                 if ('IntersectionObserver' in window && this.$refs.b2bSlider) {
                     this._observer = new IntersectionObserver((entries) => {
                         entries.forEach(entry => {
                             if (entry.isIntersecting && window.innerWidth < 1024) {
                                 this.startAuto();
                             } else {
                                 this.pause();
                             }
                         });
                     }, { threshold: 0.2 });
                     this._observer.observe(this.$refs.b2bSlider);
                 } else if (window.innerWidth < 1024) {
                     this.startAuto();
                 }
             },
             startAuto() {
                 if (this.pageCount <= 1 || window.innerWidth >= 1024) return;
                 this.pause();
                 this.timer = setInterval(() => { this.next(); }, 4500);
             },
             pause() {
                 if (this.timer) {
                     clearInterval(this.timer);
                     this.timer = null;
                 }
             },
             resume() {
                 if (window.innerWidth >= 1024) return;
                 this.startAuto();
             },
             next() {
                 this.goToPage((this.activePage + 1) % this.pageCount);
             },
             prev() {
                 this.goToPage((this.activePage - 1 + this.pageCount) % this.pageCount);
             },
             goToPage(p) {
                 this.activePage = p;
                 const slider = this.$refs.b2bSlider;
                 if (slider) {
                     const cards = slider.children;
                     const targetIndex = Math.min(p * 3, this.totalCards - 1);
                     if (cards[targetIndex]) {
                         const targetLeft = Math.max(0, cards[targetIndex].offsetLeft - slider.offsetLeft - 8);
                         slider.scrollTo({ 
                             left: targetLeft, 
                             behavior: 'smooth' 
                         });
                     }
                 }
             },
             onScroll() {
                 if (!this.$refs.b2bSlider) return;
                 const slider = this.$refs.b2bSlider;
                 const scrollLeft = slider.scrollLeft;
                 const firstCard = slider.firstElementChild;
                 if (!firstCard) return;
                 const cardWidth = firstCard.offsetWidth + 20;
                 const currentCardIndex = Math.round(scrollLeft / cardWidth);
                 const newPage = Math.min(this.pageCount - 1, Math.max(0, Math.floor(currentCardIndex / 3)));
                 if (newPage !== this.activePage) {
                     this.activePage = newPage;
                 }
             }
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header with Prev / Next Navigation -->
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-10 md:mb-12">
            <div class="reveal-soft">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                    Perusahaan Yang Menggunakan Jasa Kami &bull; Layanan Komersial &amp; Gedung
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Dipercaya Perusahaan F&amp;B, Perhotelan &amp; Gedung Bertingkat
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-2 max-w-2xl leading-relaxed">
                    Solusi pemeliharaan saluran pipa limbah dan grease trap berkala dengan standar kepatuhan K3, sertifikat garansi pengerjaan, dan faktur pajak resmi.
                </p>
            </div>

            <!-- Desktop Carousel Controls -->
            <div class="hidden sm:flex items-center gap-2 shrink-0 reveal-soft delay-100">
                <button type="button" 
                        @click="prev()" 
                        class="w-10 h-10 rounded-xl bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 border border-slate-200/90 hover:border-sky-300 transition-all shadow-2xs flex items-center justify-center cursor-pointer btn-press"
                        aria-label="Proyek Sebelumnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button type="button" 
                        @click="next()" 
                        class="w-10 h-10 rounded-xl bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 border border-slate-200/90 hover:border-sky-300 transition-all shadow-2xs flex items-center justify-center cursor-pointer btn-press"
                        aria-label="Proyek Berikutnya">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Carousel Slider Track -->
        <div x-ref="b2bSlider"
             @scroll.passive="onScroll()"
             @touchstart="pause()"
             @touchend="resume()"
             @mouseenter="pause()"
             @mouseleave="resume()"
             class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 lg:gap-6 pb-4 pt-1 px-1 -mx-1 sm:mx-0 sm:px-0">
            @foreach($b2bProjects as $project)
                <div class="w-[85vw] sm:w-[350px] lg:w-[calc(33.333%-1rem)] shrink-0 snap-center relative rounded-xl border border-slate-700/50 overflow-hidden min-h-[320px] sm:min-h-[340px] flex flex-col justify-between p-6 group transition-all duration-300 hover:border-sky-400/80 shadow-md card-lift">
                    <!-- Background Photo with Subtle Blur & Clear Visibility -->
                    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                        <img src="{{ $project->image ?? 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $project->client_name }}" 
                             loading="lazy"
                             class="w-full h-full object-cover blur-[1px] scale-105 brightness-[0.92] group-hover:scale-110 transition-transform duration-700">
                        <!-- Gradient Overlay: Transparent at top so the photo is clearly recognizable, dark at bottom for crisp text contrast -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 via-55% to-transparent"></div>
                    </div>

                    <!-- Content Relative z-10 -->
                    <div class="relative z-10">
                        <!-- Top Meta: Sector Badge & Location -->
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 bg-slate-900/80 backdrop-blur-xs text-sky-300 text-[11px] font-bold rounded-md border border-slate-700/70">
                                {{ $project->client_type }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-900/80 backdrop-blur-xs text-slate-200 text-[11px] font-medium rounded-md border border-slate-700/70 truncate max-w-[150px]">
                                <svg class="w-3 h-3 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="truncate">{{ $project->location }}</span>
                            </span>
                        </div>

                        <!-- Client Name -->
                        <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight line-clamp-1 mb-1 group-hover:text-sky-300 transition-colors drop-shadow-xs">
                            {{ $project->client_name }}
                        </h3>

                        <!-- Project Title -->
                        <div class="text-xs font-semibold text-sky-400/90 mb-3 drop-shadow-2xs">
                            {{ $project->project_title }}
                        </div>

                        <!-- Simplified Description -->
                        <p class="text-xs sm:text-sm text-slate-200/90 leading-relaxed line-clamp-3">
                            {{ $project->description }}
                        </p>
                    </div>

                    <!-- Bottom Bar: Guarantee & Tag -->
                    <div class="relative z-10 mt-5 pt-3.5 border-t border-white/15 flex items-center justify-between text-xs">
                        <span class="inline-flex items-center gap-1.5 font-bold text-emerald-400">
                            <svg class="w-3.5 h-3.5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $project->guarantee ?? 'Garansi Resmi 30 Hari' }}</span>
                        </span>
                        <span class="text-[11px] font-semibold text-slate-300 bg-white/10 px-2 py-0.5 rounded border border-white/10">
                            Bebas Bongkar
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Carousel Dots Indicator (1 titik untuk setiap 3 card) -->
        @php
            $b2bDotCount = max(1, (int) ceil(count($b2bProjects) / 3));
        @endphp
        @if($b2bDotCount > 1)
        <div class="flex justify-center items-center gap-1.5 mt-5">
            @for($p = 0; $p < $b2bDotCount; $p++)
                <button type="button" 
                        @click="goToPage({{ $p }})"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="activePage === {{ $p }} ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300'"
                        aria-label="Halaman Portofolio {{ $p + 1 }}">
                </button>
            @endfor
        </div>
        @endif

        <!-- B2B Direct Consultation Banner -->
        <div class="mt-10 bg-white rounded-xl border border-slate-200 p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-2xs reveal-soft">
            <div class="flex items-center gap-3.5 text-center sm:text-left">
                <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0 hidden sm:flex">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm sm:text-base font-bold text-slate-900">Butuh Survei Lokasi atau Penawaran Kontrak B2B?</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Tersedia invoice resmi, faktur pajak PPN, Berita Acara (BAST), dan penanganan di luar jam operasional bisnis.</p>
                </div>
            </div>
            <a href="{{ $b2bWaUrl }}" target="_blank" rel="noopener noreferrer" 
               class="shrink-0 inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-bold transition-colors shadow-2xs btn-press">
                <span>Konsultasi B2B via WhatsApp</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>
