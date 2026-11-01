@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen" x-data="{ activeCategory: 'all', searchQuery: '' }">
    <!-- Hero Section Blog & Edukasi (Informatif & Anti-Slop) -->
    <section class="relative bg-white border-b border-slate-200 pt-8 pb-10 sm:pt-12 sm:pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-4 font-medium reveal-fade" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-700 font-bold">Blog</span>
            </nav>

            <div class="text-center max-w-3xl mx-auto">
                <p class="text-xs font-bold text-sky-700 tracking-wider uppercase mb-2 reveal-fade">
                    Blog Resmi &amp; Publikasi Edukasi Drainusantara
                </p>

                <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-tight text-slate-900 reveal-soft">
                    Panduan Perawatan &amp; Tips Saluran Pipa
                </h1>

                <p class="mt-3 text-xs sm:text-base text-slate-600 leading-relaxed reveal-soft delay-100">
                  Pahami risiko fatal penggunaan bahan kimia korosif seperti soda api yang bisa merusak struktur pipa, lihat bagaimana teknologi modern dari Drainusantara bekerja secara profesional, lalu amankan paket promo pemeliharaan berkala kami sebelum penawaran terbatas ini berakhir.
                </p>
            </div>

            <!-- 3 Pilar Informasi Blog (Informatif, Terarah, Bebas Badge Slop) -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 max-w-5xl mx-auto reveal-soft delay-150">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-sky-800 font-bold text-xs uppercase tracking-wider mb-1.5">
                        <span>01. Edukasi Residensial</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Panduan praktis merawat wastafel dapur, leher angsa kloset, floor drain kamar mandi, dan pipa talang rumah.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-sky-800 font-bold text-xs uppercase tracking-wider mb-1.5">
                        <span>02. Teknologi &amp; K3</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Standar mekanis mesin rooter spiral baja Ridgid, kamera inspeksi CCTV IP68, dan disiplin higienitas teknisi.
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-sky-800 font-bold text-xs uppercase tracking-wider mb-1.5">
                        <span>03. Komersial &amp; B2B</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Solusi penanganan grease trap restoran, audit drainase ruko &amp; gedung perkantoran, serta penawaran berkala.
                    </p>
                </div>
            </div>

            <!-- Search Bar Interaktif (Minimalis Berkontras Tinggi) -->
            <div class="mt-8 max-w-xl mx-auto relative reveal-soft delay-200">
                <div class="relative flex items-center">
                    <input type="text"
                           x-model="searchQuery"
                           placeholder="Cari topik panduan (misal: soda api, wastafel, grease trap, cctv)..."
                           class="w-full pl-11 pr-10 py-3 sm:py-3.5 text-xs sm:text-sm bg-white border border-slate-300 focus:border-sky-700 rounded-xl shadow-2xs focus:ring-2 focus:ring-sky-100 focus:outline-hidden transition-all text-slate-900 placeholder:text-slate-400">
                    <div class="absolute left-3.5 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="button"
                            x-show="searchQuery.length > 0"
                            @click="searchQuery = ''"
                            class="absolute right-3 p-1 text-slate-400 hover:text-slate-600 rounded-md transition-colors"
                            aria-label="Bersihkan pencarian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <section class="py-8 sm:py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Category Filter Tabs -->
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar sm:flex-wrap sm:justify-center mb-8 sm:mb-12 pb-1 -mx-4 px-4 sm:mx-0 sm:px-0 reveal-soft">
                <button type="button"
                        @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                        class="px-3.5 sm:px-5 py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap shrink-0 transition-all cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Semua Artikel ({{ $articles->total() }})
                </button>
                <button type="button"
                        @click="activeCategory = 'edukasi'"
                        :class="activeCategory === 'edukasi' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                        class="px-3.5 sm:px-5 py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap shrink-0 transition-all cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Edukasi
                </button>
                <button type="button"
                        @click="activeCategory = 'penguatan-brand'"
                        :class="activeCategory === 'penguatan-brand' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                        class="px-3.5 sm:px-5 py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap shrink-0 transition-all cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Penguatan Brand
                </button>
                <button type="button"
                        @click="activeCategory = 'promo-penawaran'"
                        :class="activeCategory === 'promo-penawaran' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                        class="px-3.5 sm:px-5 py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap shrink-0 transition-all cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Promo Penawaran
                </button>
            </div>

            <!-- Featured Article Showcase (Shown on 'all' view when not searching) -->
            @if(isset($featuredArticle) && $featuredArticle)
                <div x-show="activeCategory === 'all' && searchQuery.trim() === ''"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-98"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="mb-10 sm:mb-14 bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs hover:border-slate-300 transition-all reveal-soft">
                    <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 items-stretch">
                        <!-- Content Side -->
                        <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-3 flex-wrap text-xs">
                                    <span class="font-bold text-sky-800 tracking-wider uppercase">
                                        PANDUAN UTAMA
                                    </span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span class="text-slate-500 font-medium">
                                        {{ $featuredArticle->published_at ? $featuredArticle->published_at->format('d M Y') : $featuredArticle->created_at->format('d M Y') }}
                                    </span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span class="text-slate-500 font-medium">
                                        {{ $featuredArticle->reading_time }} Menit Baca
                                    </span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span class="text-slate-500 font-medium">
                                        {{ number_format($featuredArticle->views_count) }}x Dilihat
                                    </span>
                                </div>

                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold tracking-tight text-slate-900 leading-snug">
                                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="hover:text-sky-700 transition-colors focus:outline-hidden focus-visible:underline">
                                        {{ $featuredArticle->title }}
                                    </a>
                                </h2>

                                <p class="mt-3 text-slate-600 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                    {{ $featuredArticle->excerpt ?? Str::limit(strip_tags($featuredArticle->content), 170) }}
                                </p>
                            </div>

                            <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-2 text-xs text-slate-600">
                                    <div class="w-7 h-7 rounded-md bg-sky-100 text-sky-800 flex items-center justify-center font-bold text-[11px] border border-sky-200">
                                        DN
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $featuredArticle->author_name }}</div>
                                        <div class="text-[11px] text-slate-500">{{ $featuredArticle->author_role }}</div>
                                    </div>
                                </div>

                                <a href="{{ route('articles.show', $featuredArticle->slug) }}" 
                                   class="btn-press inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs sm:text-sm transition-colors shadow-xs">
                                    <span>Baca Panduan Lengkap</span>
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Image Side -->
                        <div class="lg:col-span-5 relative overflow-hidden bg-slate-100 min-h-[220px] sm:min-h-[280px]">
                            @if($featuredArticle->thumbnail)
                                <img src="{{ $featuredArticle->thumbnail }}" 
                                     alt="{{ $featuredArticle->title }}" 
                                     width="1200" 
                                     height="630" 
                                     loading="eager"
                                     fetchpriority="high"
                                     decoding="async"
                                     class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center p-8 text-center bg-slate-100 text-slate-400 gap-2">
                                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-500">Panduan Resmi Drainusantara</span>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 bg-slate-900/85 backdrop-blur-xs text-white text-[11px] font-bold px-2.5 py-1 rounded-md border border-white/20 shadow-xs">
                                {{ $featuredArticle->category_label }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Articles Grid: 2 kolom di mobile, 2 kolom di tablet, 3 kolom di desktop -->
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3.5 sm:gap-6 lg:gap-8">
                @forelse($articles as $article)
                    @php
                        $catSlug = $article->category_slug;
                        $searchHaystack = strtolower($article->title . ' ' . ($article->excerpt ?? '') . ' ' . strip_tags($article->content) . ' ' . ($article->tags ?? ''));
                    @endphp
                    <article x-data="{
                                 matchesCategory() {
                                     return activeCategory === 'all' || activeCategory === '{{ $catSlug }}';
                                 },
                                 matchesSearch() {
                                     if (!searchQuery || searchQuery.trim() === '') return true;
                                     return {{ json_encode($searchHaystack) }}.indexOf(searchQuery.trim().toLowerCase()) !== -1;
                                 }
                             }"
                             x-show="matchesCategory() && matchesSearch()"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-98"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="bg-white rounded-xl border border-slate-200 shadow-2xs hover:border-sky-300 hover:shadow-md transition-all flex flex-col group card-lift reveal-soft overflow-hidden">
                        
                        <!-- Thumbnail Cover Image -->
                        <a href="{{ route('articles.show', $article->slug) }}" class="block relative overflow-hidden aspect-16/10 bg-slate-100 border-b border-slate-100">
                            @if($article->thumbnail)
                                <img src="{{ $article->thumbnail }}" 
                                     alt="{{ $article->title }}" 
                                     width="600"
                                     height="375"
                                     loading="lazy"
                                     decoding="async"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-slate-100 text-slate-400 gap-1.5">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                    <span class="text-[11px] font-semibold text-slate-500">Panduan Teknis</span>
                                </div>
                            @endif

                            <span class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5 bg-slate-900/85 backdrop-blur-xs text-white text-[10px] sm:text-[11px] font-bold px-2 py-0.5 rounded-md border border-white/20 shadow-xs">
                                {{ $article->category_label }}
                            </span>
                        </a>

                        <!-- Card Body (Ergonomis untuk 2 Kolom Mobile) -->
                        <div class="p-3 sm:p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-xs text-slate-500 mb-1.5 sm:mb-2 font-medium flex-wrap">
                                    <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span>{{ $article->reading_time }} mnt</span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span class="text-sky-700 font-semibold">{{ number_format($article->views_count) }}x</span>
                                </div>

                                <h2 class="text-xs sm:text-base font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug tracking-tight line-clamp-2">
                                    <a href="{{ route('articles.show', $article->slug) }}" class="focus:outline-hidden focus-visible:underline">
                                        {{ $article->title }}
                                    </a>
                                </h2>

                                <p class="mt-1.5 sm:mt-2 text-slate-600 text-[11px] sm:text-xs leading-relaxed line-clamp-2 hidden sm:block">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 90) }}
                                </p>
                            </div>

                            <!-- Card Footer -->
                            <div class="mt-3 sm:mt-4 pt-2.5 sm:pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] sm:text-xs">
                                <span class="text-slate-500 font-medium truncate max-w-[90px] sm:max-w-none">
                                    Drainusantara
                                </span>

                                <a href="{{ route('articles.show', $article->slug) }}" 
                                   class="font-bold text-sky-700 group-hover:text-sky-800 inline-flex items-center gap-0.5 sm:gap-1 transition-colors shrink-0">
                                    <span>Baca</span>
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-500 text-sm bg-white rounded-xl border border-slate-200 p-8">
                        Belum ada panduan edukasi yang dipublikasikan.
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links -->
            @if($articles->hasPages())
                <div class="mt-10 sm:mt-12">
                    {{ $articles->links() }}
                </div>
            @endif

            <!-- YouTube Video Showcase Section (Sebelum CTA Konsultasi Bawah) -->
            <section class="mt-16 sm:mt-20 pt-12 border-t border-slate-200 reveal-soft">
                <div class="mb-8">
                    <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                        DOKUMENTASI TINDAKAN LAPANGAN
                    </span>
                    <h2 class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Video Praktik Pelancaran &amp; Cara Kerja Mesin Rooter
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                        Saksikan pembuktian metode mekanis 100% tanpa bongkar keramik: bagaimana spiral baja menembus kerak lemak dan kamera CCTV mendeteksi titik masalah di dalam pipa.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
                    @foreach($youtubeVideos ?? [] as $video)
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-2xs hover:border-sky-300 transition-all flex flex-col justify-between">
                            <div>
                                <!-- Responsive 16:9 Video Container -->
                                <div class="relative aspect-16/9 bg-slate-900">
                                    <iframe 
                                        src="https://www.youtube-nocookie.com/embed/{{ $video['id'] }}?rel=0" 
                                        title="{{ $video['title'] }}"
                                        loading="lazy"
                                        class="w-full h-full border-0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>

                                <div class="p-3 sm:p-5">
                                    <div class="flex items-center justify-between text-xs mb-1.5 sm:mb-2 gap-1">
                                        <span class="font-bold text-sky-800 text-[10px] sm:text-[11px] uppercase tracking-wider truncate">
                                            {{ $video['tag'] }}
                                        </span>
                                        <span class="text-slate-400 font-mono text-[10px] sm:text-[11px] shrink-0">
                                            {{ $video['duration'] }}
                                        </span>
                                    </div>

                                    <h3 class="text-xs sm:text-base font-bold text-slate-900 leading-snug line-clamp-2">
                                        {{ $video['title'] }}
                                    </h3>

                                    <p class="mt-1.5 sm:mt-2 text-[11px] sm:text-xs text-slate-600 leading-relaxed line-clamp-2 hidden sm:block">
                                        {{ $video['description'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-3 pt-0 sm:p-5 sm:pt-0">
                                <a href="https://wa.me/{{ config('app.whatsapp_number', '6285609009009') }}?text={{ rawurlencode('Halo Admin Drainusantara, saya tertarik dengan penanganan saluran seperti di video ' . $video['title'] . '. Mohon info jadwal teknisi.') }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-emerald-700 hover:text-emerald-800 transition-colors">
                                    <span class="truncate">Konsultasi Serupa</span>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Help Consultation Box at Bottom -->
            <div class="mt-16 p-6 sm:p-8 rounded-xl bg-white border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-6 reveal-soft">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 border border-sky-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900">Saluran Pipa Anda Sedang Bermasalah Saat Ini?</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-xl leading-relaxed">
                            Jangan biarkan sumbatan merusak instalasi pipa rumah atau usaha Anda. Konsultasikan langsung dengan teknisi siaga Drainusantara bebas biaya melalui WhatsApp resmi.
                        </p>
                    </div>
                </div>

                <a href="https://wa.me/{{ config('app.whatsapp_number', '6285609009009') }}?text={{ rawurlencode('Halo Admin Drainusantara, saya ingin konsultasi teknis penanganan saluran pipa mampet.') }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn-press inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors shrink-0 w-full md:w-auto justify-center min-h-[46px]">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Konsultasi Darurat via WA</span>
                </a>
            </div>

        </div>
    </section>
</div>
@endsection
