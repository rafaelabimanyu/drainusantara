@extends('layouts.app')

@section('content')
<div class="services-index-page bg-slate-50 min-h-screen">
    <!-- 1. Hero Section Katalog Layanan -->
    <section class="relative bg-white border-b border-slate-200 pt-6 pb-12 sm:pt-10 sm:pb-16 lg:pt-14 lg:pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium flex-wrap" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-800 font-semibold">Layanan</span>
            </nav>

            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider mb-3">
                    <svg class="w-3.5 h-3.5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>KATALOG SPESIALIS RESMI DRAINUSANTARA</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Layanan Jasa Saluran Pipa Mampet <span class="text-sky-700">100% Tanpa Bongkar</span>
                </h1>
                <p class="text-slate-600 text-sm sm:text-base lg:text-lg mt-4 leading-relaxed">
                    Spesialis pelancaran saluran pipa pembuangan air tersumbat untuk hunian pribadi, ruko, restoran, dan gedung komersial. Menggunakan mesin spiral rotary Ridgid USA &amp; Hydro Jetting tanpa merusak ubin lantai keramik, didukung garansi resmi 30 hari kalender serta komitmen <em>No Cure No Pay</em>.
                </p>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 mt-6 pt-2">
                    <a href="{{ $contextualWaUrl }}" target="_blank" rel="noopener noreferrer" 
                       class="inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg shadow-xs hover:shadow transition-all">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi Darurat (WhatsApp)</span>
                    </a>
                    <a href="#daftar-layanan" 
                       class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm sm:text-base px-6 py-3 rounded-lg border border-slate-800 shadow-2xs transition-colors">
                        <span>Pilih Jenis Layanan</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Grid Kartu Layanan Dedicated -->
    <section id="daftar-layanan" class="py-12 lg:py-18">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Katalog Solusi Saluran Pipa Mampet Spesifik
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2">
                    Pilih titik saluran pipa Anda untuk melihat metode pengerjaan, rincian biaya, dan garansi resmi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($services as $item)
                    @php
                        $detailUrl = route('services.show', ['slug' => $item['slug']]);
                        $itemWaMsg = "Halo Tim Drainusantara, saya ingin konsultasi penanganan untuk {$item['name']}. Mohon info estimasi biaya dan jadwal teknisi.";
                        $itemWaUrl = 'https://wa.me/' . (config('app.whatsapp_number') ?: '6285609009009') . '?text=' . rawurlencode($itemWaMsg);
                    @endphp
                    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden shadow-2xs hover:shadow-sm hover:border-sky-300 transition-all flex flex-col justify-between group">
                        <div>
                            <!-- Visual Banner -->
                            <a href="{{ $detailUrl }}" class="block relative aspect-16/10 bg-slate-100 overflow-hidden">
                                <img src="{{ asset($item['image'] ?? 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp') }}" 
                                     alt="{{ $item['name'] }} - Teknisi Drainusantara" 
                                     width="600"
                                     height="375"
                                     loading="lazy" 
                                     decoding="async"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-bold tracking-wider uppercase bg-slate-950/80 text-white backdrop-blur-xs border border-white/10">
                                    {{ $item['badge'] }}
                                </span>
                            </a>

                            <div class="p-5 sm:p-6 space-y-3">
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-sky-700 transition-colors leading-snug">
                                    <a href="{{ $detailUrl }}">{{ $item['name'] }}</a>
                                </h3>

                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">
                                    {{ $item['hero_excerpt'] }}
                                </p>

                                <div class="pt-2 border-t border-slate-100">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Gejala Umum:</span>
                                    <ul class="text-xs text-slate-600 space-y-1">
                                        @foreach(array_slice($item['symptoms'], 0, 2) as $symptom)
                                            <li class="flex items-start gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                </svg>
                                                <span class="line-clamp-1">{{ $symptom }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6 pt-0 space-y-3">
                            <div class="p-3 bg-slate-50 rounded-md border border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-slate-500 uppercase font-bold block">Estimasi Tarif:</span>
                                    <strong class="text-sm font-extrabold text-slate-900">Mulai Rp {{ number_format($item['price_starting_from'], 0, ',', '.') }}</strong>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                    No Cure No Pay
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <a href="{{ $detailUrl }}" 
                                   class="inline-flex items-center justify-center text-xs font-bold px-3 py-2.5 rounded-md bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 transition-colors text-center">
                                    <span>Detail Layanan</span>
                                </a>
                                <a href="{{ $itemWaUrl }}" target="_blank" rel="noopener noreferrer" 
                                   class="inline-flex items-center justify-center gap-1.5 text-xs font-bold px-3 py-2.5 rounded-md bg-emerald-700 hover:bg-emerald-800 text-white shadow-2xs transition-colors text-center">
                                    <span>Pesan via WA</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 3. Internal Linking: Cakupan Area Kota Utama -->
    @if(isset($majorCities) && $majorCities->isNotEmpty())
        <section class="py-10 bg-white border-y border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                            Posko Teknisi di Kota-Kota Utama
                        </h3>
                        <p class="text-xs text-slate-500">Layanan pelancaran pipa siaga 24 jam di kota dan kabupaten terdekat Anda.</p>
                    </div>
                    <a href="{{ route('area.index') }}" class="text-xs font-bold text-sky-700 hover:text-sky-900 transition-colors">
                        Lihat Seluruh Wilayah &rarr;
                    </a>
                </div>

                <div class="flex flex-wrap gap-2 text-xs">
                    @foreach($majorCities as $c)
                        <a href="{{ route('area.city', ['city' => $c->slug]) }}" 
                           class="px-3 py-2 rounded-md bg-slate-50 hover:bg-sky-50 text-slate-700 hover:text-sky-800 border border-slate-200 hover:border-sky-300 font-medium transition-all">
                            <span>Jasa Pipa Mampet {{ $c->city }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 4. Internal Linking: Panduan & Edukasi Terkait -->
    @if(isset($featuredArticles) && $featuredArticles->isNotEmpty())
        <section class="py-12 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                            Panduan Teknis &amp; Tips Sanitasi Pipa
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600">Pelajari teknik pencegahan sumbatan pipa dari teknisi profesional.</p>
                    </div>
                    <a href="{{ route('articles.index') }}" class="text-xs font-bold text-sky-700 hover:text-sky-900 transition-colors">
                        Lihat Semua Artikel &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($featuredArticles as $art)
                        <article class="bg-white rounded-lg border border-slate-200 p-4 shadow-2xs hover:border-sky-300 transition-colors flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-sky-700 block mb-1">
                                    {{ $art->category_label }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-900 hover:text-sky-800 transition-colors leading-snug line-clamp-2 mb-2">
                                    <a href="{{ $art->silo_url }}">{{ $art->title }}</a>
                                </h4>
                                <p class="text-xs text-slate-600 line-clamp-2">
                                    {{ $art->excerpt }}
                                </p>
                            </div>
                            <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                                <span>{{ $art->published_at ? $art->published_at->format('d M Y') : '' }}</span>
                                <a href="{{ $art->silo_url }}" class="font-bold text-sky-700 hover:underline">Baca Selengkapnya</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
@endsection
