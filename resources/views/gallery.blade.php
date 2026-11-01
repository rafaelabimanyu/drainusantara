@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number', '6285609009009');
    $generalWaUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Halo Drainusantara, saya ingin konsultasi penanganan saluran pipa mampet.");

    $categoriesList = [
        'all' => 'Semua Sektor',
        'rumahan' => 'Rumahan / Residensial',
        'fnb' => 'Restoran & Kafe (FnB)',
        'b2b' => 'B2B / Komersial',
        'ruko' => 'Ruko & Komersial',
        'perkantoran' => 'Perkantoran',
        'gedung' => 'Gedung & Apartemen',
        'pabrik' => 'Pabrik & Industri',
    ];
@endphp

<div>
    <!-- 1. HERO SECTION INFORMATIF -->
    <section class="relative bg-slate-50 border-b border-slate-200 pt-8 pb-12 lg:pt-12 lg:pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <nav class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-4 font-medium reveal-fade" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-700 font-bold">Galeri Hasil Pengerjaan</span>
            </nav>

            <span class="text-xs font-bold uppercase tracking-widest text-sky-800 block mb-2 reveal-fade">
                Dokumentasi Teknis &amp; Studi Kasus Lapangan
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight max-w-4xl mx-auto leading-tight reveal-soft">
                Galeri Hasil Pengerjaan <span class="text-sky-700">Saluran Pipa Mampet</span>
            </h1>
            <p class="mt-3.5 text-slate-600 text-sm sm:text-base max-w-3xl mx-auto leading-relaxed reveal-soft delay-100">
                Dokumentasi autentik pekerjaan pelancaran saluran pipa tersumbat di berbagai sektor properti—mulai dari residensial hunian, restoran &amp; kafe (FnB), perkantoran, hingga ruko dan fasilitas industri. Ditangani langsung menggunakan mesin spiral baja rotary Ridgid mekanis dan kamera endoskopi digital IP68 tanpa merusak lantai keramik serta bebas bahan kimia korosif.
            </p>

            <!-- 4 Keunggulan Teknis Nyata -->
            <div class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 max-w-4xl mx-auto text-left reveal-soft delay-150">
                <div class="p-3.5 bg-white rounded-lg border border-slate-200 shadow-2xs">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-5 h-5 rounded-sm bg-slate-100 text-slate-700 font-mono text-[10px] font-bold flex items-center justify-center border border-slate-200 shrink-0">01</span>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tanpa Bongkar Keramik</h2>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-snug">Kabel spiral lentur menjangkau belokan leher angsa pipa tanpa memecah lantai.</p>
                </div>

                <div class="p-3.5 bg-white rounded-lg border border-slate-200 shadow-2xs">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-5 h-5 rounded-sm bg-slate-100 text-slate-700 font-mono text-[10px] font-bold flex items-center justify-center border border-slate-200 shrink-0">02</span>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Garansi Nota 30 Hari</h2>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-snug">Jaminan pengerjaan tuntas bergaransi resmi; mampet kembali teknisi datang gratis.</p>
                </div>

                <div class="p-3.5 bg-white rounded-lg border border-slate-200 shadow-2xs">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-5 h-5 rounded-sm bg-slate-100 text-slate-700 font-mono text-[10px] font-bold flex items-center justify-center border border-slate-200 shrink-0">03</span>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tuntas Cepat</h2>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-snug">Peralatan mekanis bertenaga tinggi menghemat waktu tanpa mengganggu aktivitas.</p>
                </div>

                <div class="p-3.5 bg-white rounded-lg border border-slate-200 shadow-2xs">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="w-5 h-5 rounded-sm bg-slate-100 text-slate-700 font-mono text-[10px] font-bold flex items-center justify-center border border-slate-200 shrink-0">04</span>
                        <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Bebas Bahan Kimia Berbahaya</h2>
                    </div>
                    <p class="text-[11px] text-slate-600 leading-snug">Aman untuk instalasi PVC tanpa risiko sambungan lem meleleh atau pipa pecah.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SECTION GALERI DENGAN SEARCH BAR & FILTER KATEGORI -->
    <section class="py-10 sm:py-14 bg-white border-b border-slate-200" 
             x-data="{
                 activeFilter: 'all',
                 searchQuery: '',
                 currentPage: 1,
                 perPageMobile: 10,
                 isMobile: typeof window !== 'undefined' ? window.innerWidth < 768 : false,
                 items: [
                     @foreach($galleries as $item)
                     {
                         id: {{ $item->id }},
                         category: '{{ $item->category ?? 'rumahan' }}',
                         title: {{ Js::from($item->title) }},
                         location: {{ Js::from($item->location ?? '') }},
                         drain_type: {{ Js::from($item->drain_type ?? '') }},
                         method: {{ Js::from($item->method ?? '') }},
                         description: {{ Js::from($item->description ?? '') }},
                         category_label: {{ Js::from($item->category_label) }}
                     }{{ !$loop->last ? ',' : '' }}
                     @endforeach
                 ],
                 init() {
                     this.isMobile = window.innerWidth < 768;
                     window.addEventListener('resize', () => {
                         this.isMobile = window.innerWidth < 768;
                     });
                     this.$watch('activeFilter', () => { this.currentPage = 1; });
                     this.$watch('searchQuery', () => { this.currentPage = 1; });
                 },
                 matches(id) {
                     const item = this.items.find(i => i.id === id);
                     if (!item) return false;

                     // Filter kategori
                     if (this.activeFilter !== 'all') {
                         if (this.activeFilter === 'b2b') {
                             if (!['b2b', 'fnb', 'gedung', 'perkantoran', 'pabrik', 'ruko'].includes(item.category)) {
                                 return false;
                             }
                         } else if (item.category !== this.activeFilter) {
                             return false;
                         }
                     }

                     // Filter pencarian
                     if (this.searchQuery.trim() !== '') {
                         const q = this.searchQuery.toLowerCase().trim();
                         const matchTitle = item.title && item.title.toLowerCase().includes(q);
                         const matchLoc = item.location && item.location.toLowerCase().includes(q);
                         const matchDrain = item.drain_type && item.drain_type.toLowerCase().includes(q);
                         const matchDesc = item.description && item.description.toLowerCase().includes(q);
                         const matchMethod = item.method && item.method.toLowerCase().includes(q);
                         const matchCat = item.category_label && item.category_label.toLowerCase().includes(q);

                         if (!matchTitle && !matchLoc && !matchDrain && !matchDesc && !matchMethod && !matchCat) {
                             return false;
                         }
                     }

                     return true;
                 },
                 get visibleItems() {
                     return this.items.filter(i => this.matches(i.id));
                 },
                 get countVisible() {
                     return this.visibleItems.length;
                 },
                 get totalPages() {
                     return Math.max(1, Math.ceil(this.visibleItems.length / this.perPageMobile));
                 },
                 isInCurrentMobilePage(id) {
                     if (!this.isMobile) return true;
                     const index = this.visibleItems.findIndex(i => i.id === id);
                     if (index === -1) return false;
                     const start = (this.currentPage - 1) * this.perPageMobile;
                     const end = start + this.perPageMobile;
                     return index >= start && index < end;
                 },
                 isVisible(id) {
                     return this.matches(id) && (!this.isMobile || this.isInCurrentMobilePage(id));
                 },
                 goToPage(page) {
                     if (page < 1 || page > this.totalPages) return;
                     this.currentPage = page;
                     this.$nextTick(() => {
                         const el = document.getElementById('gallery-cards-grid');
                         if (el) {
                             const topOffset = el.getBoundingClientRect().top + window.pageYOffset - 90;
                             window.scrollTo({ top: topOffset, behavior: 'smooth' });
                         }
                     });
                 },
                 get paginationPages() {
                     const total = this.totalPages;
                     if (total <= 5) {
                         return Array.from({ length: total }, (_, i) => i + 1);
                     }
                     const current = this.currentPage;
                     if (current <= 3) {
                         return [1, 2, 3, 4, '...', total];
                     }
                     if (current >= total - 2) {
                         return [1, '...', total - 3, total - 2, total - 1, total];
                     }
                     return [1, '...', current - 1, current, current + 1, '...', total];
                 }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- SEARCH BAR & FILTER TABS HEADER -->
            <div class="mb-8 space-y-4">
                <!-- Search Input Bar -->
                <div class="max-w-2xl mx-auto">
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Cari pengerjaan (misal: wastafel, Kelapa Gading, restoran, kloset, spiral rotary)..." 
                               class="w-full pl-10 pr-10 py-2.5 sm:py-3 text-xs sm:text-sm rounded-lg border border-slate-300 bg-white placeholder-slate-400 text-slate-900 focus:outline-hidden focus:ring-2 focus:ring-sky-600 focus:border-sky-600 shadow-2xs transition-all">
                        <button type="button" 
                                x-show="searchQuery.length > 0" 
                                @click="searchQuery = ''" 
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer"
                                title="Hapus pencarian">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Category Filter Pills -->
                <div class="flex justify-center">
                    <div class="inline-flex p-1 bg-slate-100 rounded-lg border border-slate-200/80 max-w-full overflow-x-auto no-scrollbar shadow-2xs gap-1">
                        @foreach($categoriesList as $catKey => $catLabel)
                            <button type="button" @click="activeFilter = '{{ $catKey }}'"
                                    :class="activeFilter === '{{ $catKey }}' ? 'bg-white text-sky-800 font-bold shadow-xs border border-slate-200' : 'text-slate-600 hover:text-slate-900 font-medium'"
                                    class="px-3.5 py-1.5 rounded-md text-xs transition-all cursor-pointer whitespace-nowrap min-h-[38px] flex items-center gap-1.5 focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                                <span>{{ $catLabel }}</span>
                                @if($catKey === 'all')
                                    <span class="text-[10px] py-0.5 px-1.5 rounded-sm bg-slate-200/60 text-slate-700 font-semibold">{{ count($galleries) }}</span>
                                @else
                                    @php
                                        $catCount = $galleries->where('category', $catKey)->count();
                                    @endphp
                                    @if($catCount > 0)
                                        <span class="text-[10px] py-0.5 px-1.5 rounded-sm bg-slate-200/60 text-slate-700 font-semibold">{{ $catCount }}</span>
                                    @endif
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Result Counter Line -->
                <div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
                    <div>
                        Menampilkan <span class="font-bold text-slate-800" x-text="countVisible"></span> dari {{ count($galleries) }} hasil dokumentasi teknis
                    </div>
                    <div x-show="searchQuery.trim() !== ''" class="flex items-center gap-1.5 text-sky-800 font-medium">
                        <span>Filter: "<span x-text="searchQuery"></span>"</span>
                        <button type="button" @click="searchQuery = ''" class="underline hover:text-sky-900 cursor-pointer">Reset</button>
                    </div>
                </div>
            </div>

            <!-- GALLERY CARDS GRID -->
            <div id="gallery-cards-grid" class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 lg:gap-7 scroll-mt-24">
                @forelse($galleries as $item)
                    @php
                        $photoUrl = $item->image ?: ($item->after_image ?: $item->before_image);
                        $detailUrl = !empty($item->slug) ? route('case-study.show', $item->slug) : null;
                    @endphp
                    <div x-show="isVisible({{ $item->id }})"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-98"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="bg-white rounded-lg border border-slate-200 shadow-2xs hover:shadow-md hover:border-sky-300 transition-all flex flex-col group card-lift">
                        
                        <!-- Thumbnail Image -->
                        <div class="relative aspect-[16/10] bg-slate-950 overflow-hidden border-b border-slate-100 group/img">
                            @if($detailUrl)
                                <a href="{{ $detailUrl }}" class="block w-full h-full focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600" title="Lihat detail studi kasus: {{ $item->title }}">
                            @endif
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" 
                                     alt="{{ $item->title }}" 
                                     width="800" 
                                     height="500" 
                                     loading="lazy" 
                                     decoding="async" 
                                     class="w-full h-full object-cover transform group-hover/img:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-slate-400 gap-2 p-3 sm:p-4 text-center">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-[10px] sm:text-xs font-semibold">Dokumentasi Lapangan</span>
                                </div>
                            @endif
                            @if($detailUrl)
                                </a>
                            @endif

                            <!-- Sector Badge di Atas Gambar -->
                            <span class="absolute top-1.5 left-1.5 sm:top-2.5 sm:left-2.5 bg-slate-900/90 text-white text-[9px] sm:text-[11px] font-semibold px-1.5 py-0.5 sm:px-2 rounded-sm truncate max-w-[75%]">
                                {{ $item->category_label }}
                            </span>

                            @if($item->hasBeforeAfter())
                                <span class="absolute top-1.5 right-1.5 sm:top-2.5 sm:right-2.5 bg-sky-900/90 text-sky-200 text-[9px] sm:text-[10px] font-semibold px-1.5 py-0.5 sm:px-2 rounded-sm">
                                    Before-After
                                </span>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="p-3 sm:p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <!-- Location & Saluran Header Row -->
                                <div class="flex items-center justify-between gap-1 mb-1.5 sm:mb-2">
                                    @if(!empty($item->location))
                                        <span class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-semibold text-slate-700 truncate">
                                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-sky-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="truncate">{{ $item->location }}</span>
                                        </span>
                                    @endif

                                    @if(!empty($item->duration))
                                        <span class="text-[9px] sm:text-[11px] font-medium text-slate-500 shrink-0">
                                            {{ $item->duration }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-xs sm:text-base font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug line-clamp-2">
                                    @if($detailUrl)
                                        <a href="{{ $detailUrl }}" class="hover:underline">
                                            {{ $item->title }}
                                        </a>
                                    @else
                                        {{ $item->title }}
                                    @endif
                                </h3>

                                @if(!empty($item->drain_type))
                                    <p class="mt-1 text-[10px] sm:text-[11px] font-semibold text-sky-800 truncate">
                                        Saluran: {{ $item->drain_type }}
                                    </p>
                                @endif

                                <p class="mt-1.5 sm:mt-2 text-slate-600 text-[11px] sm:text-xs leading-relaxed line-clamp-2">
                                    {{ $item->description }}
                                </p>
                            </div>

                            <!-- Footer Details & CTAs -->
                            @php
                                $waMessage = urlencode("Halo Tim Drainusantara, saya tertarik dengan pengerjaan '{$item->title}' di {$item->location}. Saluran pipa saya mengalami kendala serupa, mohon info estimasi biaya dan teknisi terdekat.");
                                $waUrl = "https://wa.me/{$whatsappNumber}?text={$waMessage}";
                            @endphp
                            <div class="mt-3 sm:mt-4 pt-2.5 sm:pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5 sm:gap-2">
                                @if($detailUrl)
                                    <a href="{{ $detailUrl }}" 
                                       class="inline-flex items-center justify-between sm:justify-start gap-1 text-[11px] sm:text-xs font-semibold text-sky-700 hover:text-sky-800 transition-colors py-0.5 sm:py-1.5">
                                        <span>Detail <span class="hidden sm:inline">Studi </span>Kasus</span>
                                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                @endif
                                <a href="{{ $waUrl }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="btn-press {{ $detailUrl ? '' : 'w-full' }} inline-flex items-center justify-center gap-1 px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-md sm:rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-[11px] sm:text-xs shadow-2xs transition-colors min-h-[36px] sm:min-h-[40px]">
                                    <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                    </svg>
                                    <span>Konsultasi<span class="hidden sm:inline"> Serupa</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 px-4 text-center bg-white rounded-lg border border-slate-200 text-slate-500 reveal-soft">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center border border-slate-200">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 mb-1">Dokumentasi Belum Tersedia</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto">Saat ini belum ada dokumentasi foto yang dipublikasikan. Foto pengerjaan akan tampil di sini setelah ditambahkan.</p>
                    </div>
                @endforelse

                <!-- Empty State untuk Hasil Pencarian -->
                <div x-show="countVisible === 0 && items.length > 0" class="col-span-full py-12 px-4 text-center bg-slate-50 rounded-lg border border-slate-200 text-slate-500">
                    <p class="text-sm font-semibold text-slate-800">Tidak ada hasil pengerjaan yang cocok</p>
                    <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian yang lebih umum atau ganti filter sektor kategori.</p>
                    <button type="button" @click="searchQuery = ''; activeFilter = 'all'" 
                            class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-sky-700 hover:text-sky-800 px-3 py-1.5 rounded-md border border-sky-300 bg-white">
                        <span>Reset Semua Filter</span>
                    </button>
                </div>
            </div>

            <!-- Mobile Pagination Bar (< md, 10 cards per page) -->
            <div x-cloak x-show="isMobile && totalPages > 1" 
                 class="flex md:hidden flex-col items-center gap-3 mt-8 pt-6 border-t border-slate-200"
                 aria-label="Paginasi Galeri Mobile">
                
                <!-- Info Paginasi -->
                <p class="text-xs text-slate-600 font-medium">
                    Halaman <span class="font-bold text-slate-900" x-text="currentPage"></span> dari <span class="font-bold text-slate-900" x-text="totalPages"></span>
                    (<span x-text="visibleItems.length"></span> dokumentasi)
                </p>

                <!-- Tombol Navigasi Paginasi -->
                <div class="flex items-center gap-1.5">
                    <!-- Prev Button -->
                    <button type="button" 
                            @click="goToPage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'opacity-35 cursor-not-allowed bg-slate-50 text-slate-400' : 'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-900 cursor-pointer active:scale-95'"
                            class="w-10 h-10 rounded-lg border border-slate-200 flex items-center justify-center transition-all shadow-2xs"
                            aria-label="Halaman sebelumnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    <!-- Page Numbers -->
                    <template x-for="(page, idx) in paginationPages" :key="idx">
                        <div>
                            <template x-if="page === '...'">
                                <span class="w-7 text-center text-xs text-slate-400 font-mono select-none">&hellip;</span>
                            </template>
                            <template x-if="page !== '...'">
                                <button type="button"
                                        @click="goToPage(page)"
                                        :class="currentPage === page ? 'bg-sky-700 text-white font-bold border-sky-700 shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border-slate-200 font-medium'"
                                        class="min-w-10 h-10 px-2 rounded-lg border text-xs flex items-center justify-center transition-all cursor-pointer shadow-2xs active:scale-95"
                                        :aria-current="currentPage === page ? 'page' : false"
                                        :aria-label="'Ke halaman ' + page"
                                        x-text="page">
                                </button>
                            </template>
                        </div>
                    </template>

                    <!-- Next Button -->
                    <button type="button" 
                            @click="goToPage(currentPage + 1)"
                            :disabled="currentPage === totalPages"
                            :class="currentPage === totalPages ? 'opacity-35 cursor-not-allowed bg-slate-50 text-slate-400' : 'bg-white text-slate-700 hover:bg-slate-100 hover:text-slate-900 cursor-pointer active:scale-95'"
                            class="w-10 h-10 rounded-lg border border-slate-200 flex items-center justify-center transition-all shadow-2xs"
                            aria-label="Halaman berikutnya">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. EDUKASI SANITASI AMAN (BAHAYA SODA API) -->
    <section class="py-14 lg:py-20 bg-slate-50 border-t border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg border border-slate-200 p-6 sm:p-10 shadow-2xs">
                <div class="max-w-3xl mx-auto text-center mb-8">
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-800 mb-2">
                        Peringatan Sanitasi Saluran
                    </p>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Mengapa Harus Menghindari Penggunaan Soda Api?
                    </h2>
                    <p class="mt-2 text-slate-600 text-xs sm:text-sm leading-relaxed">
                        Cairan atau bubuk kimia korosif seperti soda api sering kali memperparah kerusakan instalasi saluran pipa rumah tangga dan bisnis Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                        <span class="font-bold text-slate-900 block text-sm">1. Merusak &amp; Melelehkan Pipa PVC</span>
                        <p class="text-slate-600 leading-relaxed">Reaksi soda api dengan air menghasilkan suhu panas ekstrem yang dapat melunakkan dan membengkokkan dinding pipa PVC.</p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                        <span class="font-bold text-slate-900 block text-sm">2. Melarutkan Lem Sambungan</span>
                        <p class="text-slate-600 leading-relaxed">Panas tinggi melemahkan lem pada sambungan elbow pipa, memicu kebocoran tersembunyi di dalam dinding atau bawah lantai.</p>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-xs space-y-1.5">
                        <span class="font-bold text-slate-900 block text-sm">3. Mengkristal Jadi Semen Batu</span>
                        <p class="text-slate-600 leading-relaxed">Jika sumbatan tidak tembus, sisa soda api akan mengeras seperti semen batu yang menutup saluran secara permanen.</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-center sm:text-left">
                        <h3 class="text-sm font-bold text-slate-900">Solusi Aman Mekanis Drainusantara</h3>
                        <p class="text-xs text-slate-600 mt-0.5">Penanganan dengan mesin spiral rotary tanpa merusak pipa, bergaransi nota resmi 30 hari.</p>
                    </div>
                    <a href="{{ $generalWaUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-press shrink-0 inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs sm:text-sm shadow-2xs transition-colors min-h-[46px]">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi Penanganan Tanpa Kimia</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
