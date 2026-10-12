@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen" x-data="{ activeCategory: 'all', searchQuery: '' }">
    <!-- Hero Hub Banner -->
    <section class="relative bg-white border-b border-slate-200 pt-8 pb-10 sm:pt-12 sm:pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <!-- Breadcrumbs -->
            <nav class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-4 font-medium reveal-fade" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-700 font-bold">Edukasi Sanitasi</span>
            </nav>

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-sky-50 text-sky-800 text-[11px] sm:text-xs font-bold border border-sky-200 mb-3 tracking-wide uppercase reveal-fade">
                <span class="w-2 h-2 rounded-full bg-sky-600"></span>
                Pusat Pengetahuan &amp; Edukasi Sanitasi
            </span>

            <h1 class="text-2xl sm:text-4xl md:text-5xl font-extrabold tracking-tight max-w-3xl mx-auto leading-tight text-slate-900 reveal-soft">
                Panduan Perawatan &amp; Tips <span class="text-sky-700">Saluran Pipa</span>
            </h1>

            <p class="mt-3 text-xs sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed reveal-soft delay-100">
                Kumpulan panduan teknis perpipaan: mitigasi risiko reaksi kimia soda api, pembersihan lemak kitchen sink, protokol pemeliharaan grease trap, dan standar mekanis spiral baja.
            </p>

            <!-- Search Bar Interaktif -->
            <div class="mt-6 sm:mt-8 max-w-xl mx-auto relative reveal-soft delay-150">
                <div class="relative flex items-center">
                    <input type="text"
                           x-model="searchQuery"
                           placeholder="Cari topik panduan (misal: soda api, wastafel, grease trap, cctv)..."
                           class="w-full pl-11 pr-10 py-3 sm:py-3.5 text-xs sm:text-sm bg-slate-50 hover:bg-white focus:bg-white border border-slate-300 focus:border-sky-600 rounded-xl shadow-2xs focus:ring-2 focus:ring-sky-100 focus:outline-hidden transition-all text-slate-900 placeholder:text-slate-400">
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
                    Semua Panduan ({{ count($articles) }})
                </button>
                <button type="button"
                        @click="activeCategory = 'tips'"
                        :class="activeCategory === 'tips' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                        class="px-3.5 sm:px-5 py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap shrink-0 transition-all cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Tips &amp; Edukasi
                </button>
                <button type="button"
                        @click="activeCategory = 'perawatan'"
                        :class="activeCategory === 'perawatan' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                        class="px-3.5 sm:px-5 py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap shrink-0 transition-all cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Perawatan Rumah
                </button>
                <button type="button"
                        @click="activeCategory = 'teknologi'"
                        :class="activeCategory === 'teknologi' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-white hover:bg-slate-100 text-slate-700 font-semibold border border-slate-200'"
                        class="px-3.5 sm:px-5 py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap shrink-0 transition-all cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Teknologi Plumbing
                </button>
            </div>

            <!-- Featured Article Showcase (Shown on 'all' view when not searching) -->
            @if(isset($featuredArticle) && $featuredArticle)
                <div x-show="activeCategory === 'all' && searchQuery.trim() === ''"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-98"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="mb-10 sm:mb-14 bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:border-slate-300 transition-all reveal-soft">
                    <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 items-stretch">
                        <!-- Content Side -->
                        <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2.5 mb-3 flex-wrap">
                                    <span class="px-2.5 py-0.5 text-[10px] sm:text-[11px] font-bold bg-amber-50 text-amber-900 border border-amber-200 rounded-md tracking-wider uppercase">
                                        PANDUAN UTAMA PILIHAN
                                    </span>
                                    <span class="text-xs text-slate-500 font-medium">
                                        {{ $featuredArticle->published_at ? $featuredArticle->published_at->format('d M Y') : $featuredArticle->created_at->format('d M Y') }}
                                    </span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span class="text-xs text-slate-500 font-medium">
                                        {{ $featuredArticle->reading_time }} Menit Baca
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
                                    <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-800 flex items-center justify-center font-bold text-[11px] border border-sky-200">
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
                            <div class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-xs text-white text-[11px] font-bold px-2.5 py-1 rounded-md border border-white/20 shadow-xs">
                                {{ $featuredArticle->category ?? 'Tips & Edukasi' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Articles Grid (1 col on mobile, 2 col on tablet, 3 col on desktop) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @forelse($articles as $article)
                    @php
                        $catRaw = strtolower($article->category ?? 'tips');
                        $catSlug = 'tips';
                        if (str_contains($catRaw, 'rumah') || str_contains($catRaw, 'perawatan')) {
                            $catSlug = 'perawatan';
                        } elseif (str_contains($catRaw, 'teknologi') || str_contains($catRaw, 'cctv') || str_contains($catRaw, 'plumbing')) {
                            $catSlug = 'teknologi';
                        }
                        $searchHaystack = strtolower($article->title . ' ' . ($article->excerpt ?? '') . ' ' . strip_tags($article->content));
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
                                <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-slate-100 text-slate-400 gap-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-500">Artikel Edukasi</span>
                                </div>
                            @endif

                            <span class="absolute top-3 left-3 bg-slate-900/85 backdrop-blur-xs text-white text-[11px] font-bold px-2.5 py-1 rounded-md border border-white/20 shadow-xs">
                                {{ $article->category ?? 'Tips & Edukasi' }}
                            </span>
                        </a>

                        <!-- Card Body -->
                        <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 text-xs text-slate-500 mb-2.5 font-medium">
                                    <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                    <span class="text-slate-300">&bull;</span>
                                    <span>{{ $article->reading_time }} Menit Baca</span>
                                </div>

                                <h2 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug tracking-tight line-clamp-2">
                                    <a href="{{ route('articles.show', $article->slug) }}" class="focus:outline-hidden focus-visible:underline">
                                        {{ $article->title }}
                                    </a>
                                </h2>

                                <p class="mt-2 text-slate-600 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                                </p>
                            </div>

                            <!-- Card Footer -->
                            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
                                    <div class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center text-[10px] font-bold">
                                        DN
                                    </div>
                                    <span>{{ $article->author_name }}</span>
                                </div>

                                <a href="{{ route('articles.show', $article->slug) }}" 
                                   class="text-xs font-bold text-sky-700 group-hover:text-sky-800 inline-flex items-center gap-1 transition-colors">
                                    <span>Baca Panduan</span>
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            @if($articles->hasPages())
                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            @endif

            <!-- Help Consultation Box at Bottom -->
            <div class="mt-16 p-6 sm:p-8 rounded-2xl bg-white border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-6 reveal-soft">
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
                   class="btn-press inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors shrink-0 w-full md:w-auto justify-center min-h-[46px]">
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
