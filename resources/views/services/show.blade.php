@extends('layouts.app')

@section('content')
<div class="service-detail-page bg-slate-50 min-h-screen">
    <!-- 1. Hero Section Layanan Dedicated -->
    <section class="relative bg-white border-b border-slate-200 pt-6 pb-12 sm:pt-10 sm:pb-16 lg:pt-14 lg:pb-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium flex-wrap" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('services.index') }}" class="hover:text-sky-700 transition-colors">Layanan</a>
                <span class="text-slate-300">/</span>
                <span class="text-sky-800 font-semibold">{{ $service['name'] }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <div class="lg:col-span-7 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-800 text-xs font-bold uppercase tracking-wider">
                        <span>{{ $service['badge'] }}</span>
                        <span class="text-slate-300">•</span>
                        <span>100% TANPA BONGKAR KERAMIK</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $service['h1'] }}
                    </h1>

                    <p class="text-slate-600 text-sm sm:text-base lg:text-lg leading-relaxed">
                        {{ $service['hero_excerpt'] }}
                    </p>

                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-200 flex flex-wrap items-center justify-between gap-3 text-xs">
                        <div>
                            <span class="text-slate-500 font-medium block">Estimasi Tarif Penanganan:</span>
                            <strong class="text-lg font-extrabold text-slate-900">Mulai Rp {{ number_format($service['price_starting_from'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                No Cure No Pay
                            </span>
                            <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-sky-100 text-sky-900 border border-sky-300">
                                Garansi 30 Hari
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                        <a href="{{ $contextualWaUrl }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center justify-center gap-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-lg shadow-xs hover:shadow transition-all">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Panggil Teknisi via WhatsApp</span>
                        </a>
                        <a href="tel:085609009009" 
                           class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm sm:text-base px-6 py-3.5 rounded-lg border border-slate-800 shadow-2xs transition-colors">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>Hotline: 0856-0900-9009</span>
                        </a>
                    </div>
                </div>

                <!-- Visual Foto Banner Pengerjaan -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-xl p-3 sm:p-4 border border-slate-200 shadow-xs space-y-3">
                        <div class="relative rounded-lg overflow-hidden aspect-4/3 bg-slate-900 border border-slate-200">
                            <img src="{{ asset($service['image'] ?? 'images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp') }}" 
                                 alt="{{ $service['h1'] }}" 
                                 width="700"
                                 height="525"
                                 loading="eager"
                                 fetchpriority="high"
                                 decoding="async"
                                 class="w-full h-full object-cover">
                            <div class="absolute bottom-2 left-2 right-2 bg-slate-950/85 backdrop-blur-xs px-3 py-1.5 rounded-md text-white text-[11px] flex items-center justify-between border border-white/10">
                                <span>Armada Siaga Teknisi</span>
                                <span class="text-sky-300 font-bold">Ridgid USA 400 RPM</span>
                            </div>
                        </div>
                        <div class="px-1 flex items-center justify-between text-xs text-slate-600">
                            <span class="font-medium text-slate-700">Respon Cepat 30-45 Menit</span>
                            <span class="text-emerald-700 font-bold">100% Bebas Bongkar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Gejala & Penyebab Utama Saluran Tersumbat -->
    <section class="py-12 lg:py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Gejala -->
                <div class="bg-slate-50 rounded-lg border border-slate-200 p-6 sm:p-8 space-y-4">
                    <div class="inline-flex items-center gap-2 text-amber-800 font-bold text-xs uppercase tracking-wider">
                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>Tanda &amp; Gejala Kerusakan</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        Ciri-Ciri Saluran Membutuhkan Penanganan Segera
                    </h2>
                    <ul class="space-y-3 text-sm text-slate-700">
                        @foreach($service['symptoms'] as $symptom)
                            <li class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">!</span>
                                <span class="leading-relaxed">{{ $symptom }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Penyebab Utama -->
                <div class="bg-slate-50 rounded-lg border border-slate-200 p-6 sm:p-8 space-y-4">
                    <div class="inline-flex items-center gap-2 text-sky-800 font-bold text-xs uppercase tracking-wider">
                        <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Analisis Lapangan</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        Faktor Penyebab Kerak &amp; Sumbatan Pipa
                    </h2>
                    <ul class="space-y-3 text-sm text-slate-700">
                        @foreach($service['causes'] as $cause)
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-sky-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="leading-relaxed">{{ $cause }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Metode Penanganan Mekanis Non-Destruktif -->
    <section class="py-12 lg:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">STANDAR OPERASIONAL TEKNISI</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Prosedur Pelancaran Mekanis Tanpa Bobok Lantai
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2">
                    Metode modern berstandar internasional yang menjamin keutuhan pipa PVC dan keramik lantai properti Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($service['methods'] as $idx => $method)
                    <div class="bg-white rounded-lg border border-slate-200 p-5 space-y-3 shadow-2xs hover:border-sky-300 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-sky-100 text-sky-900 font-extrabold text-sm flex items-center justify-center">
                            0{{ $idx + 1 }}
                        </div>
                        <h3 class="text-sm font-bold text-slate-900">
                            Langkah Tahap {{ $idx + 1 }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $method }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. Pertanyaan Sering Diajukan (FAQ) -->
    @if(!empty($service['faqs']))
        <section class="py-12 lg:py-16 bg-white border-b border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">TANYA JAWAB TEKNIS</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Pertanyaan Sering Diajukan Seputar {{ $service['name'] }}
                    </h2>
                </div>

                <div class="space-y-4">
                    @foreach($service['faqs'] as $faq)
                        <div class="p-5 rounded-lg bg-slate-50 border border-slate-200 space-y-2">
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 flex items-start gap-2.5">
                                <span class="text-sky-700 font-extrabold shrink-0">Q:</span>
                                <span>{{ $faq['question'] }}</span>
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 pl-6 leading-relaxed">
                                {{ $faq['answer'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 5. Internal Linking: Layanan Spesialis Lainnya -->
    @if(!empty($otherServices))
        <section class="py-12 bg-slate-50 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                        Katalog Layanan Spesialis Lainnya
                    </h2>
                    <a href="{{ route('services.index') }}" class="text-xs font-bold text-sky-700 hover:text-sky-900 transition-colors">
                        Lihat Semua Layanan &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($otherServices as $other)
                        <a href="{{ route('services.show', ['slug' => $other['slug']]) }}" 
                           class="p-4 rounded-lg bg-white border border-slate-200 hover:border-sky-300 hover:shadow-2xs transition-all block group">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-sky-800 block mb-1">
                                {{ $other['badge'] }}
                            </span>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-sky-700 transition-colors line-clamp-2">
                                {{ $other['name'] }}
                            </h3>
                            <span class="text-[11px] text-slate-500 font-semibold block mt-2">
                                Mulai Rp {{ number_format($other['price_starting_from'], 0, ',', '.') }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 6. Internal Linking: Posko Kota & Wilayah Terdekat -->
    @if(isset($majorCities) && $majorCities->isNotEmpty())
        <section class="py-10 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                            Posko Teknisi {{ $service['name'] }} di Kota Anda
                        </h3>
                        <p class="text-xs text-slate-500">Armada siaga meluncur langsung ke lokasi rumah atau properti Anda.</p>
                    </div>
                    <a href="{{ route('area.index') }}" class="text-xs font-bold text-sky-700 hover:text-sky-900 transition-colors">
                        Semua Kota &rarr;
                    </a>
                </div>

                <div class="flex flex-wrap gap-2 text-xs">
                    @foreach($majorCities as $c)
                        <a href="{{ route('area.city', ['city' => $c->slug]) }}" 
                           class="px-3 py-2 rounded-md bg-slate-50 hover:bg-sky-50 text-slate-700 hover:text-sky-800 border border-slate-200 hover:border-sky-300 font-medium transition-all">
                            <span>Teknisi {{ $c->city }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 7. Internal Linking: Artikel Panduan & Edukasi Terkait -->
    @if(isset($relatedArticles) && $relatedArticles->isNotEmpty())
        <section class="py-12 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                            Artikel &amp; Panduan Terkait {{ $service['name'] }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600">Tips merawat dan mencegah sumbatan pipa dari praktisi lapangan.</p>
                    </div>
                    <a href="{{ route('articles.index') }}" class="text-xs font-bold text-sky-700 hover:text-sky-900 transition-colors">
                        Semua Artikel &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $art)
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
                                <a href="{{ $art->silo_url }}" class="font-bold text-sky-700 hover:underline">Baca Panduan</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
@endsection
