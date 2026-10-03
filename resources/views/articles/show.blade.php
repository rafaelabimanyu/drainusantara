@extends('layouts.app')

@section('content')
<div class="py-8 sm:py-14 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-6 overflow-x-auto reveal-fade" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5 shrink-0">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('articles.index') }}" class="hover:text-sky-700 transition-colors shrink-0">Edukasi Sanitasi</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 truncate font-semibold">{{ $article->title }}</span>
        </nav>

        <!-- Article Card Container -->
        <article class="bg-white rounded-xl border border-slate-200 p-6 sm:p-10 shadow-xs overflow-hidden reveal-soft">
            <!-- Header Metadata -->
            <header class="mb-8">
                <div class="flex flex-wrap items-center gap-2.5 mb-4 text-xs font-medium text-slate-500">
                    <span class="px-2.5 py-0.5 rounded-md text-xs font-bold bg-sky-50 text-sky-800 border border-sky-200">
                        {{ $article->category ?? 'Tips & Edukasi' }}
                    </span>
                    <span>Dipublikasikan: {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}</span>
                    <span class="text-slate-300">&bull;</span>
                    <span>Oleh: Tim Ahli Drainusantara</span>
                </div>

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $article->title }}
                </h1>

                @if($article->excerpt)
                <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed font-normal border-l-4 border-sky-700 pl-4 bg-sky-50/50 py-3 rounded-r-lg">
                    {{ $article->excerpt }}
                </p>
                @endif
            </header>

            <!-- Featured Thumbnail -->
            @if($article->thumbnail)
            <div class="mb-10 rounded-xl overflow-hidden border border-slate-200 shadow-xs bg-slate-100">
                <img src="{{ $article->thumbnail }}" alt="{{ $article->title }}" width="800" height="460" loading="lazy" decoding="async" class="w-full max-h-[460px] object-cover">
            </div>
            @endif

            <!-- Body Content (Clean Typography) -->
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed space-y-6 text-base sm:text-lg">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Edukasi Bahaya Kimia Soda Api vs Mekanis Spiral -->
            <div class="mt-10 p-6 sm:p-7 rounded-xl bg-amber-50/70 border border-amber-200/90 space-y-4">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-md bg-amber-700 text-white text-[11px] font-bold uppercase tracking-wider">
                        EDUKASI KESELAMATAN PIPA
                    </span>
                    <span class="text-xs font-bold text-amber-900">Bahaya Reaksi Kimia Soda Api vs Metode Spiral Baja</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm">
                    <div class="p-4 rounded-lg bg-white border border-red-200 space-y-2">
                        <div class="font-bold text-red-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Risiko Menuang Soda Api / Asam Keras:</span>
                        </div>
                        <ul class="space-y-1.5 text-slate-600 text-xs leading-relaxed">
                            <li class="flex items-start gap-1.5">
                                <span class="text-red-500 font-bold">&bull;</span>
                                <span>Reaksi panas eksotermik melunakkan dan meretakkan paralon PVC.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="text-red-500 font-bold">&bull;</span>
                                <span>Lem sambungan pipa mencair memicu rembesan bocor ke dak lantai beton.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="text-red-500 font-bold">&bull;</span>
                                <span>Bereaksi dengan sisa lemak membentuk gumpalan sabun padat sekeras semen.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="p-4 rounded-lg bg-white border border-emerald-200 space-y-2">
                        <div class="font-bold text-emerald-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Solusi Mekanis Drainusantara:</span>
                        </div>
                        <ul class="space-y-1.5 text-slate-600 text-xs leading-relaxed">
                            <li class="flex items-start gap-1.5">
                                <span class="text-emerald-500 font-bold">&bull;</span>
                                <span>Kabel spiral baja fleksibel torsi tinggi meliuk mengikuti lekukan leher angsa.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="text-emerald-500 font-bold">&bull;</span>
                                <span>100% aman untuk dinding pipa PVC, sambungan fitting, dan keramik.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="text-emerald-500 font-bold">&bull;</span>
                                <span>Menghancurkan sumbatan hingga tuntas bergaransi resmi 30 hari.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Emergency Consultation Banner -->
            @php
                $waMsg = urlencode("Halo Teknisi Drainusantara, saya baru membaca panduan '{$article->title}' dan ingin konsultasi penanganan pipa mampet di rumah.");
                $waLink = "https://wa.me/" . config('app.whatsapp_number', '6281234567890') . "?text={$waMsg}";
            @endphp
            <div class="mt-10 p-6 sm:p-8 rounded-xl bg-slate-900 border border-slate-800 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm reveal-soft">
                <div>
                    <span class="text-xs uppercase tracking-widest text-sky-400 font-bold block mb-1">KONSULTASI TEKNIS BEBAS BIAYA</span>
                    <h3 class="text-lg sm:text-xl font-extrabold tracking-tight">Mengalami Kendala Saluran Pipa Serupa?</h3>
                    <p class="text-xs sm:text-sm text-slate-400 mt-1 max-w-md leading-relaxed">
                        Hindari menuang bahan kimia berbahaya. Konsultasikan langsung dengan teknisi siaga Drainusantara tanpa bongkar lantai dan bergaransi 30 hari.
                    </p>
                </div>
                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" 
                   class="btn-press inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors shrink-0 w-full sm:w-auto min-h-[48px]">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Teknisi via WhatsApp</span>
                </a>
            </div>
        </article>

        <!-- Quick Consultation Action Card at bottom of Article -->
        <div class="mt-8 p-4 sm:p-5 rounded-xl bg-white border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4 reveal-soft">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-900">Butuh Solusi Pipa Mampet Cepat?</div>
                    <div class="text-[11px] text-slate-500">Armada siaga terdekat langsung ke lokasi &bull; Garansi 30 hari</div>
                </div>
            </div>
            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" 
               class="btn-press inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs shadow-xs transition-colors shrink-0 w-full sm:w-auto justify-center min-h-[44px]">
                <span>Tanya Teknisi Sekarang</span>
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Related Articles -->
        @if($recentArticles->isNotEmpty())
        <div class="mt-12 reveal-soft">
            <div class="flex items-center gap-2 mb-6">
                <span class="text-xs font-bold uppercase px-2.5 py-0.5 bg-sky-50 text-sky-800 border border-sky-200 rounded-md">PANDUAN TERKAIT</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Artikel Terkait Lainnya</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($recentArticles as $related)
                <a href="{{ route('articles.show', $related->slug) }}" 
                   class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs hover:border-sky-300 hover:shadow-md transition-all block group card-lift reveal-soft stagger-{{ $loop->iteration }}">
                    <span class="text-xs font-bold text-sky-800 bg-sky-50 px-2 py-0.5 rounded-md border border-sky-200">{{ $related->category ?? 'Tips' }}</span>
                    <h3 class="font-bold text-slate-900 group-hover:text-sky-700 transition-colors text-sm sm:text-base mt-2.5 leading-snug tracking-tight">
                        {{ $related->title }}
                    </h3>
                    <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                        {{ $related->excerpt ?? Str::limit(strip_tags($related->content), 70) }}
                    </p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
