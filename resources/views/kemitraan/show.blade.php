@extends('layouts.app')

@php
    $whatsappNumber = config('app.whatsapp_number', '6285609009009');
    $waText = "Halo Drainusantara, saya tertarik kemitraan seperti {$partnership->client_name} untuk bisnis saya di {$partnership->location}.";
    $waUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($waText);

    $typeMap = [
        'kontrak-maintenance' => 'Kontrak Maintenance',
        'kerjasama-proyek' => 'Kerjasama Proyek',
        'sewa-alat' => 'Sewa Alat',
        'emergency' => 'Layanan Darurat',
    ];
    $partnerTypeLabel = $typeMap[$partnership->partnership_type] ?? ucwords(str_replace(['-', '_'], ' ', (string) ($partnership->partnership_type ?: 'Kerjasama Bisnis')));

    $servicesList = ($partnership->relationLoaded('services') ? $partnership->services : collect())->pluck('name')->filter()->values()->all();

    // Inisial klien untuk fallback logo jika file gambar tidak tersedia
    $clientInitials = '';
    $words = explode(' ', trim((string) $partnership->client_name));
    if (count($words) >= 2) {
        $clientInitials = \Illuminate\Support\Str::upper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
    } else {
        $clientInitials = \Illuminate\Support\Str::upper(mb_substr($partnership->client_name, 0, 2));
    }

    $seoImage = $partnership->image ?: ($partnership->logo ?: asset('images/drainusantara-jasa-saluran-pipa-mampet-teknisi-profesional.webp'));
    $seoImageUrl = filter_var($seoImage, FILTER_VALIDATE_URL) ? $seoImage : asset($seoImage);

    $articleJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => 'Kemitraan Pemeliharaan Saluran Drainase: ' . $partnership->client_name,
        'description' => \Illuminate\Support\Str::limit(strip_tags($partnership->description ?? ''), 160),
        'image' => $seoImageUrl,
        'datePublished' => optional($partnership->created_at)->toIso8601String() ?? now()->toIso8601String(),
        'dateModified' => optional($partnership->updated_at)->toIso8601String() ?? optional($partnership->created_at)->toIso8601String(),
        'author' => [
            '@type' => 'Organization',
            'name' => 'Drainusantara',
            'url' => url('/'),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Drainusantara',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('images/logo/WebIcon.webp'),
            ],
        ],
        'collaboratedWith' => [
            '@type' => 'Organization',
            'name' => $partnership->client_name,
            'description' => $partnership->client_type ?? 'Mitra Usaha',
            'address' => $partnership->location ?? 'Indonesia',
        ],
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => url()->current(),
        ],
    ];
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode($articleJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) !!}
</script>
@endpush

@push('styles')
<style>
    @media (max-width: 1023px) {
        .mobile-nav-dock { display: none !important; }
    }
</style>
@endpush

@section('content')
<article class="bg-white text-slate-800">
    
    <!-- 1. HERO SECTION -->
    <header class="bg-slate-50 border-b border-slate-200 pt-10 pb-12 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center justify-center gap-2 text-xs text-slate-500 mb-6 font-medium overflow-x-auto no-scrollbar" aria-label="Breadcrumb">
                <a href="{{ url('/') }}" class="hover:text-sky-700 transition-colors flex items-center gap-1.5 shrink-0">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <a href="{{ route('about.portfolio') }}" class="hover:text-sky-700 transition-colors shrink-0">
                    <span>Kemitraan</span>
                </a>
                <span class="text-slate-300" aria-hidden="true">/</span>
                <span class="text-slate-800 truncate font-semibold" aria-current="page">{{ $partnership->client_name }}</span>
            </nav>

            <!-- Logo Klien atau Fallback Inisial -->
            @if(!empty($partnership->logo))
                <div class="mb-4 flex items-center justify-center">
                    <img src="{{ $partnership->logo }}" 
                         alt="Logo {{ $partnership->client_name }}" 
                         width="140"
                         height="70"
                         loading="eager"
                         decoding="async"
                         class="max-w-[140px] max-h-20 h-auto object-contain mx-auto rounded-md">
                </div>
            @else
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-sky-50 border-2 border-sky-100 flex items-center justify-center text-sky-700 font-bold text-2xl shadow-2xs" aria-hidden="true">
                    {{ $clientInitials }}
                </div>
            @endif

            <!-- Context Eyebrow -->
            <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-1">
                Portofolio Kemitraan &amp; B2B
            </p>

            <!-- Nama Bisnis H1 -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                {{ $partnership->client_name }}
            </h1>

            <!-- Kemitraan Type Subtitle -->
            <p class="text-xs font-bold text-amber-800 mt-2 uppercase tracking-wide">
                {{ $partnerTypeLabel }}
            </p>

            <!-- Lokasi -->
            @if(!empty($partnership->location))
                <p class="text-sm text-slate-600 mt-2 flex items-center justify-center gap-1.5 font-medium">
                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $partnership->location }}</span>
                </p>
            @endif

            @if(!empty($partnership->description))
                <p class="mt-3 text-sm text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    {{ $partnership->description }}
                </p>
            @endif

        </div>
    </header>

    <!-- MAIN BODY GRID (CONTENT + SIDEBAR 320PX ON LG) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-8 items-start">
            
            <!-- KOLOM UTAMA -->
            <div class="min-w-0 space-y-10">

                <!-- 2. EXECUTIVE B2B PARTNERSHIP MEMO -->
                <section class="bg-white rounded-lg border border-slate-200 p-5 sm:p-6 shadow-2xs" aria-label="Ringkasan Kerjasama">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-md bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900 tracking-tight">Executive Partnership Memo</h2>
                                <p class="text-[11px] text-slate-500">Parameter kontrak pemeliharaan &amp; standar operasional</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-amber-800 uppercase tracking-wide self-start sm:self-auto">
                            {{ $partnerTypeLabel }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-5 gap-x-6 text-xs">
                        <!-- Jenis Usaha -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Sektor Bisnis</span>
                            <p class="text-sm font-semibold text-slate-900">{{ $partnership->client_type ?: 'Komersial / F&B' }}</p>
                        </div>

                        <!-- Lokasi -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Wilayah Operasional</span>
                            <p class="text-sm font-semibold text-slate-900">{{ $partnership->location ?: 'Indonesia' }}</p>
                        </div>

                        <!-- Durasi Kerjasama -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Durasi Kontrak</span>
                            <p class="text-sm font-semibold text-slate-900">{{ $partnership->duration ?: 'Kontrak Berkala' }}</p>
                        </div>

                        <!-- Jadwal Pengerjaan -->
                        <div class="space-y-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Jadwal Pengerjaan</span>
                            <p class="text-sm font-semibold text-slate-900">Luar Jam Buka Resto / Dini Hari</p>
                        </div>

                        <!-- Layanan Diterapkan -->
                        <div class="space-y-1 col-span-1 sm:col-span-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block">Cakupan Jalur Pipa</span>
                            <p class="text-sm font-semibold text-slate-900">{{ !empty($servicesList) ? implode(', ', $servicesList) : 'Pipa Pembuangan, Grease Trap, Bak Kontrol' }}</p>
                        </div>
                    </div>

                    <!-- B2B SLA Notice -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-600 bg-slate-50 -mx-5 sm:-mx-6 -mb-5 sm:-mb-6 p-4 rounded-b-lg border-t">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                            <span><strong>Kepatuhan B2B:</strong> Dilengkapi Berita Acara Pengerjaan (BAP), Dokumentasi Foto, & Faktur Resmi.</span>
                        </div>
                        <span class="text-[11px] text-slate-500 font-medium">Bebas Gangguan Tamu</span>
                    </div>
                </section>

                <!-- 3. KONTEN NARATIF -->
                <div class="space-y-8">
                    @if(!empty($partnership->about_client))
                        <section aria-label="Tentang Klien">
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-3 pb-2 border-b border-slate-100">
                                Profil & Kebutuhan Klien
                            </h2>
                            <div class="text-sm sm:text-base text-slate-700 leading-relaxed whitespace-pre-line">
                                {{ $partnership->about_client }}
                            </div>
                        </section>
                    @endif

                    @if(!empty($partnership->scope_of_work))
                        <section aria-label="Lingkup Kerjasama">
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-3 pb-2 border-b border-slate-100">
                                Ruang Lingkup Tindakan Teknis
                            </h2>
                            <div class="text-sm sm:text-base text-slate-700 leading-relaxed whitespace-pre-line">
                                {{ $partnership->scope_of_work }}
                            </div>
                        </section>
                    @endif

                    @if(!empty($partnership->results_benefit))
                        <section aria-label="Hasil dan Benefit">
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-3 pb-2 border-b border-slate-100">
                                Hasil & Nilai Tambah Operasional
                            </h2>
                            <div class="text-sm sm:text-base text-slate-700 leading-relaxed whitespace-pre-line">
                                {{ $partnership->results_benefit }}
                            </div>
                        </section>
                    @endif
                </div>

                <!-- 4. TESTIMONI -->
                @if(!empty($partnership->testimoni_quote))
                    <section class="pt-2" aria-label="Testimoni Klien">
                        <div class="bg-white border border-slate-200 rounded-lg p-6 sm:p-7 shadow-2xs relative">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-amber-500 font-bold text-base">&starf;&starf;&starf;&starf;&starf;</span>
                                <span class="text-xs font-semibold text-slate-500">Ulasan Mitra Operasional Resmi</span>
                            </div>
                            <blockquote class="text-sm sm:text-base italic leading-relaxed text-slate-800">
                                &ldquo;{{ $partnership->testimoni_quote }}&rdquo;
                            </blockquote>
                            @if(!empty($partnership->testimoni_name))
                                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                                    <div>
                                        <span class="text-sm font-bold text-slate-900 block">
                                            {{ $partnership->testimoni_name }}
                                        </span>
                                        @if(!empty($partnership->testimoni_title))
                                            <span class="text-xs text-slate-500 block mt-0.5">
                                                {{ $partnership->testimoni_title }} &bull; {{ $partnership->client_name }}
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-emerald-700 font-bold uppercase tracking-wider">
                                        Mitra Terverifikasi
                                    </span>
                                </div>
                            @endif
                        </div>
                    </section>
                @endif

            </div>

            <!-- 5. SIDEBAR CTA (DESKTOP: STICKY) -->
            <aside class="hidden lg:block lg:sticky lg:top-24">
                <div class="bg-white rounded-lg border border-slate-200 p-5 space-y-4 shadow-2xs">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-sky-800 mb-1">
                            Layanan Korporat &amp; B2B
                        </p>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug">
                            Konsultasi Kemitraan &amp; Pemeliharaan Rutin
                        </h3>
                        <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">
                            Cegah operasional bisnis dan dapur komersial terhenti akibat luapan saluran atau grease trap penuh. Tim teknisi kami siap survei lokasi dan menyusun jadwal pemeliharaan berkala.
                        </p>
                    </div>

                    <a href="{{ $waUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm rounded-lg px-5 py-3 min-h-[48px] w-full flex items-center justify-center gap-2 transition-colors shadow-2xs focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                        <!-- WhatsApp SVG Icon -->
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi via WhatsApp</span>
                    </a>

                    <div class="pt-3 border-t border-slate-100 space-y-2 text-[11px] text-slate-500">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Jadwal pengerjaan fleksibel di luar jam operasional</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Laporan Berita Acara &amp; Faktur Pajak Resmi</span>
                        </div>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <!-- 5. MOBILE FIXED BOTTOM CTA BAR (< lg) -->
    <div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white border-t border-slate-200 px-4 py-3 shadow-md" aria-label="Aksi Kemitraan Mobile">
        <div class="max-w-md mx-auto flex items-center justify-between gap-3">
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-900 truncate">Solusi Saluran Bisnis &amp; F&amp;B</p>
                <p class="text-[11px] text-slate-600 truncate">Konsultasi kontrak perawatan berkala</p>
            </div>
            <a href="{{ $waUrl }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="shrink-0 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs rounded-lg px-4 py-2.5 min-h-[48px] flex items-center justify-center gap-2 shadow-xs transition-colors focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>Hubungi WA</span>
            </a>
        </div>
    </div>
                 
            </a>
        </div>
    </div>

    <!-- 6. RELATED PARTNERSHIPS SECTION -->
    @if(isset($relatedPartnerships) && $relatedPartnerships->isNotEmpty())
    <section class="bg-slate-50 border-t border-slate-200 py-12" aria-label="Kemitraan Lainnya">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 text-center mb-8">
                Kemitraan Lainnya
            </h2>
            
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedPartnerships as $item)
                @php
                    $relServices = ($item->relationLoaded('services') ? $item->services : collect())->pluck('name')->toArray();
                @endphp
                <x-partnership-card 
                    :slug="$item->slug" 
                    :businessName="$item->client_name" 
                    :logoUrl="$item->logo" 
                    :businessType="$item->client_type" 
                    :partnershipType="$item->partnership_type" 
                    :location="$item->location" 
                    :services="$relServices" 
                />
            @endforeach
        </div>
        </div>
    </section>
    @endif

</article>
@endsection

