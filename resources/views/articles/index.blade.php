@extends('layouts.app')

@section('content')
<main class="flex-grow">
    <!-- Hero Banner -->
    <section class="bg-gradient-to-b from-sky-900 via-sky-800 to-slate-900 text-white py-16 sm:py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center fade-up">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/20 text-sky-200 border border-sky-400/30 text-xs font-bold uppercase tracking-wider mb-4">
                <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Pusat Pengetahuan & Solusi
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight max-w-3xl mx-auto leading-tight">
                Edukasi & Tips Seputar <span class="text-sky-400">Saluran Pipa</span>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-sky-100/90 max-w-2xl mx-auto leading-relaxed">
                Panduan praktis mencegah saluran mampet, bahaya penggunaan bahan kimia berbahaya, dan rekomendasi perawatan pipa rumah dan tempat usaha.
            </p>
        </div>
    </section>

    <!-- Articles Grid Section -->
    <section class="py-16 sm:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($articles as $article)
                <article class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group fade-up delay-{{ min($loop->iteration * 100, 300) }}">
                    <a href="{{ route('articles.show', $article->slug) }}" class="block relative overflow-hidden aspect-video bg-slate-100">
                        <img src="{{ $article->thumbnail ?: 'https://placehold.co/800x500/0284c7/ffffff?text=' . urlencode($article->title) }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        <span class="absolute top-3 left-3 bg-sky-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md">
                            {{ $article->category ?? 'Tips & Edukasi' }}
                        </span>
                    </a>

                    <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                <span>&bull;</span>
                                <span>5 Menit Baca</span>
                            </div>

                            <h2 class="text-xl font-bold text-slate-900 group-hover:text-sky-600 transition leading-snug">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h2>

                            <p class="mt-3 text-slate-600 text-sm leading-relaxed line-clamp-3">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('articles.show', $article->slug) }}" 
                               class="text-xs font-bold text-sky-600 hover:text-sky-700 flex items-center gap-1">
                                Baca Selengkapnya &rarr;
                            </a>
                            <span class="text-[11px] text-slate-400">Tim Drainusantara</span>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-3 py-16 text-center text-slate-400">
                    Belum ada artikel yang dipublikasikan.
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
</main>
@endsection
