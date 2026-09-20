@extends('layouts.app')

@section('content')
<main class="flex-grow py-10 sm:py-16 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-8 overflow-x-auto">
            <a href="{{ url('/') }}" class="hover:text-sky-600 transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('articles.index') }}" class="hover:text-sky-600 transition">Pengetahuan</a>
            <span>/</span>
            <span class="text-slate-700 truncate">{{ $article->title }}</span>
        </nav>

        <!-- Article Card Container -->
        <article class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-10 shadow-sm overflow-hidden fade-up">
            <!-- Header Metadata -->
            <header class="mb-8">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-sky-50 text-sky-700 border border-sky-200">
                        {{ $article->category ?? 'Tips & Edukasi' }}
                    </span>
                    <span class="text-xs text-slate-400">
                        Dipublikasikan {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}
                    </span>
                    <span class="text-xs text-slate-300">&bull;</span>
                    <span class="text-xs text-slate-400">Oleh Tim Ahli Drainusantara</span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $article->title }}
                </h1>

                @if($article->excerpt)
                <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed font-medium">
                    {{ $article->excerpt }}
                </p>
                @endif
            </header>

            <!-- Featured Thumbnail -->
            @if($article->thumbnail)
            <div class="mb-10 rounded-2xl overflow-hidden border border-slate-200 shadow-xs">
                <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" class="w-full max-h-[460px] object-cover">
            </div>
            @endif

            <!-- Body Content -->
            <div class="prose max-w-none text-slate-700 leading-relaxed space-y-6 text-base sm:text-lg">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Emergency Consultation Banner -->
            <div class="mt-12 p-6 sm:p-8 rounded-2xl bg-gradient-to-r from-sky-900 to-slate-900 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-md fade-up delay-100">
                <div>
                    <h3 class="text-lg sm:text-xl font-extrabold">Mengalami Masalah Pipa Serupa?</h3>
                    <p class="text-xs sm:text-sm text-sky-200 mt-1 max-w-md">
                        Jangan dibiarkan bertambah parah. Konsultasikan dengan teknisi ahli Drainusantara dan dapatkan solusi tuntas bergaransi 30 hari.
                    </p>
                </div>
                @php
                    $waMsg = urlencode("Halo Teknisi Drainusantara, saya baru membaca artikel '{$article->title}' dan butuh bantuan perbaikan saluran pipa di rumah.");
                    $waLink = "https://wa.me/" . config('app.whatsapp_number', '6281234567890') . "?text={$waMsg}";
                @endphp
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" 
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-orange-600 hover:bg-orange-700 text-white font-bold text-sm shadow-md shadow-orange-600/30 transition-all shrink-0">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    Tanya Teknisi Sekarang
                </a>
            </div>
        </article>

        <!-- Related Articles -->
        @if($recentArticles->isNotEmpty())
        <div class="mt-12 fade-up">
            <h2 class="text-xl font-extrabold text-slate-900 mb-6">Artikel Menarik Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($recentArticles as $related)
                <a href="{{ route('articles.show', $related->slug) }}" 
                   class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition block group fade-up delay-{{ min($loop->iteration * 100, 300) }}">
                    <span class="text-[11px] font-bold text-sky-600 uppercase">{{ $related->category ?? 'Tips' }}</span>
                    <h3 class="font-bold text-slate-900 group-hover:text-sky-600 transition text-sm mt-1 leading-snug">
                        {{ $related->title }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 line-clamp-2">
                        {{ $related->excerpt ?? Str::limit(strip_tags($related->content), 70) }}
                    </p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</main>
@endsection
