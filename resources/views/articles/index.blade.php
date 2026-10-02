@extends('layouts.app')

@section('content')
<div>
    <!-- Hero Banner -->
    <section class="relative bg-slate-50 border-b border-slate-200 pt-8 pb-12 lg:pt-12 lg:pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <!-- Breadcrumb -->
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

            <span class="text-xs font-bold uppercase tracking-widest text-sky-700 block mb-2 reveal-fade">
                Pusat Pengetahuan &amp; Edukasi Sanitasi
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight max-w-3xl mx-auto leading-tight text-slate-900 reveal-soft">
                Panduan Perawatan & Tips <span class="text-sky-700">Saluran Pipa</span>
            </h1>
            <p class="mt-3 text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed reveal-soft delay-100">
                Analisis penyebab saluran tersumbat, risiko bahaya zat kimia korosif soda api pada pipa PVC, dan protokol pembersihan mekanis pipa standar industri modern.
            </p>
        </div>
    </section>

    <!-- Articles Section with Interactive Alpine.js Filter -->
    <section class="py-12 sm:py-16 bg-white border-b border-slate-200" x-data="{ activeCategory: 'all' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Interactive Category Filter Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-10 reveal-soft delay-150">
                <button type="button" @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-4 py-2 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Semua Panduan ({{ count($articles) }})
                </button>
                <button type="button" @click="activeCategory = 'tips'"
                        :class="activeCategory === 'tips' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-4 py-2 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Tips &amp; Edukasi
                </button>
                <button type="button" @click="activeCategory = 'perawatan'"
                        :class="activeCategory === 'perawatan' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-4 py-2 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Perawatan Rumah
                </button>
                <button type="button" @click="activeCategory = 'teknologi'"
                        :class="activeCategory === 'teknologi' ? 'bg-sky-700 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold'"
                        class="px-4 py-2 rounded-lg text-xs transition-colors cursor-pointer focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600 min-h-[38px]">
                    Teknologi Plumbing
                </button>
            </div>

            <!-- Featured Article Showcase (Shown on 'all' view) -->
            @if(isset($featuredArticle) && $featuredArticle)
                @php
                    $featWords = str_word_count(strip_tags($featuredArticle->content));
                    $featReadTime = max(2, ceil($featWords / 180));
                @endphp
                <div x-show="activeCategory === 'all'" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-98"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="mb-12 bg-slate-900 rounded-xl border border-slate-800 text-white overflow-hidden shadow-sm hover:border-slate-700 transition-all reveal-soft">
                    <div class="grid grid-cols-1 lg:grid-cols-12 items-center">
                        <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-between h-full">
                            <div>
                                <div class="flex items-center gap-2.5 mb-4">
                                    <span class="px-2.5 py-0.5 text-[11px] font-bold bg-sky-500/20 text-sky-300 border border-sky-400/30 rounded-md">
                                        ARTIKEL UTAMA REKOMENDASI
                                    </span>
                                    <span class="text-xs text-slate-400">
                                        {{ $featuredArticle->published_at ? $featuredArticle->published_at->format('d M Y') : $featuredArticle->created_at->format('d M Y') }}
                                    </span>
                                </div>

                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold tracking-tight text-white leading-snug">
                                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="hover:text-sky-400 transition-colors">
                                        {{ $featuredArticle->title }}
                                    </a>
                                </h2>

                                <p class="mt-3 text-slate-300 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                    {{ $featuredArticle->excerpt ?? Str::limit(strip_tags($featuredArticle->content), 160) }}
                                </p>
                            </div>

                            <div class="mt-6 pt-5 border-t border-slate-800/80 flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Estimasi {{ $featReadTime }} Menit Baca &bull; Ditulis oleh Teknisi Spesialis</span>
                                </div>
                                <a href="{{ route('articles.show', $featuredArticle->slug) }}" 
                                   class="btn-press inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-sky-700 hover:bg-sky-600 active:bg-sky-800 text-white font-bold text-xs transition-colors min-h-[38px]">
                                    <span>Baca Panduan Lengkap</span>
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-5 h-64 lg:h-full relative overflow-hidden bg-slate-950">
                            @if($featuredArticle->thumbnail)
                                <img src="{{ $featuredArticle->thumbnail }}" 
                                     alt="{{ $featuredArticle->title }}" 
                                     width="700" 
                                     height="450" 
                                     loading="eager"
                                     fetchpriority="high"
                                     decoding="async"
                                     class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-slate-800/50 text-slate-400 gap-2">
                                    <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                    <span class="text-xs font-semibold">Panduan Resmi Drainusantara</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Articles Grid Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @forelse($articles as $article)
                    @php
                        // Normalize category tag for Alpine filter
                        $catRaw = strtolower($article->category ?? 'tips');
                        $catSlug = 'tips';
                        if (str_contains($catRaw, 'rumah') || str_contains($catRaw, 'perawatan')) {
                            $catSlug = 'perawatan';
                        } elseif (str_contains($catRaw, 'teknologi') || str_contains($catRaw, 'cctv') || str_contains($catRaw, 'plumbing')) {
                            $catSlug = 'teknologi';
                        }
                        $wordCount = str_word_count(strip_tags($article->content));
                        $readTime = max(1, ceil($wordCount / 180));
                    @endphp
                    <article x-show="activeCategory === 'all' || activeCategory === '{{ $catSlug }}'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-98"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="bg-white rounded-xl border border-slate-200 shadow-xs hover:border-sky-300 hover:shadow-md transition-all flex flex-col group card-lift reveal-soft stagger-{{ ($loop->iteration % 3) + 1 }} overflow-hidden">
                        
                        <a href="{{ route('articles.show', $article->slug) }}" class="block relative overflow-hidden aspect-video bg-slate-100 border-b border-slate-100">
                            @if($article->thumbnail)
                                <img src="{{ $article->thumbnail }}" 
                                     alt="{{ $article->title }}" 
                                     width="800"
                                     height="450"
                                     loading="lazy"
                                     decoding="async"
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-slate-50 text-slate-400 gap-2">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                    <span class="text-xs font-semibold">Artikel Sanitasi</span>
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-xs text-white text-[11px] font-bold px-2.5 py-0.5 rounded-md border border-white/20 shadow-xs">
                                {{ $article->category ?? 'Tips & Edukasi' }}
                            </span>
                        </a>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 text-xs text-slate-500 mb-2.5 font-medium">
                                    <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $readTime }} Menit Baca</span>
                                </div>

                                <h2 class="text-lg sm:text-xl font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug tracking-tight">
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h2>

                                <p class="mt-2.5 text-slate-600 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                                </p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('articles.show', $article->slug) }}" 
                                   class="text-xs font-bold text-sky-700 hover:text-sky-800 inline-flex items-center gap-1 transition-colors">
                                    <span>Baca Panduan Lengkap</span>
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                                <span class="text-[11px] text-slate-400 font-medium">Tim Drainusantara</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 py-16 text-center text-slate-500 text-sm bg-slate-50 rounded-xl border border-slate-200">
                        Belum ada artikel teknis yang dipublikasikan.
                    </div>
                @endforelse
            </div>

            @if($articles->hasPages())
                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
