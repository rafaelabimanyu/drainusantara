@extends('layouts.app')

@section('content')
<div>
    <!-- Hero Banner -->
    <section class="relative bg-slate-50 border-b border-slate-200 pt-8 pb-12 lg:pt-12 lg:pb-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center fade-up">
            <!-- Breadcrumb -->
            <nav class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-6 font-medium" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-700 font-bold">Artikel & Edukasi</span>
            </nav>

            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-full uppercase tracking-wider mb-3 shadow-2xs">
                DATABASE EDUKASI SANITASI
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight max-w-3xl mx-auto leading-tight text-slate-900">
                Panduan Perawatan & Tips <span class="text-sky-700">Saluran Pipa</span>
            </h1>
            <p class="mt-3 text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Analisis penyebab saluran tersumbat, risiko bahaya zat kimia korosif soda api, dan protokol pembersihan mekanis pipa standar industri modern.
            </p>
        </div>
    </section>

    <!-- Articles Grid Section -->
    <section class="py-14 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @forelse($articles as $article)
                <article class="bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:border-sky-300 hover:shadow-md transition-all flex flex-col group fade-up delay-{{ min($loop->iteration * 100, 300) }} overflow-hidden">
                    <a href="{{ route('articles.show', $article->slug) }}" class="block relative overflow-hidden aspect-video bg-slate-100 border-b border-slate-100">
                        <img src="{{ $article->thumbnail ?: 'https://placehold.co/800x450/0284c7/ffffff?text=' . urlencode($article->title) }}" 
                             alt="{{ $article->title }}" 
                             width="800"
                             height="450"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-xs text-slate-800 text-xs font-bold px-3 py-1 rounded-full border border-slate-200 shadow-2xs">
                            {{ $article->category ?? 'Tips & Edukasi' }}
                        </span>
                    </a>

                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-xs text-slate-500 mb-2.5 font-medium">
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                <span>•</span>
                                <span>5 Menit Baca</span>
                            </div>

                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 group-hover:text-sky-700 transition leading-snug tracking-tight">
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
                               class="text-xs font-bold text-sky-700 hover:text-sky-800 flex items-center gap-1 transition-colors">
                                <span>Baca Panduan Lengkap</span>
                                <span>&rarr;</span>
                            </a>
                            <span class="text-xs text-slate-400 font-medium">Tim Drainusantara</span>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-3 py-16 text-center text-slate-500 text-sm bg-slate-50 rounded-2xl border border-slate-200">
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
