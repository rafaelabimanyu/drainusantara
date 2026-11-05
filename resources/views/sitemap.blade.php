@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10 sm:py-14 lg:py-20 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16">
        
        <!-- Header -->
        <header class="max-w-3xl">
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-sky-700 transition-colors">Beranda</a>
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-slate-900 font-semibold">Peta Situs</span>
            </nav>

            <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                DIREKTORI NAVIGASI RESMI
            </p>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Peta Situs &amp; Panduan Direktori Drainusantara
            </h1>
            <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
                Akses cepat menuju seluruh halaman direktori layanan pelancaran saluran pipa, jangkauan posko siaga kota, dokumentasi teknis lapangan, kemitraan komersial B2B, serta artikel edukasi sanitasi.
            </p>

            <div class="mt-4 flex items-center gap-3">
                <a href="{{ url('/sitemap.xml') }}" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-700 hover:text-sky-700 bg-white hover:bg-slate-50 border border-slate-300 px-3.5 py-2 rounded-lg transition-colors shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Format XML Bersih (/sitemap.xml)</span>
                </a>
            </div>
        </header>

        <!-- Grid Direktori 2 Kolom -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
            
            <!-- Kolom 1: Layanan & Wilayah -->
            <div class="space-y-8">
                
                <!-- 1. Katalog Layanan Spesialis -->
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs">
                    <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-sky-800">KATALOG UTAMA</p>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-0.5">Layanan Pelancar Saluran Pipa</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-medium">{{ count($services) }} Layanan</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs sm:text-sm">
                        @foreach($services as $serv)
                            <a href="{{ url('/') }}/#layanan-{{ $serv->slug }}" 
                               class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all font-medium flex items-center justify-between group">
                                <span class="truncate">{{ $serv->name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-sky-700 shrink-0 ml-1.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </section>

                <!-- 2. Jangkauan Posko & Wilayah Layanan -->
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs">
                    <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-sky-800">CAKUPAN OPERASIONAL</p>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-0.5">Wilayah Layanan Siaga 24 Jam</h2>
                        </div>
                        <a href="{{ route('area.index') }}" class="text-xs font-semibold text-sky-700 hover:underline">
                            Semua Posko &rarr;
                        </a>
                    </div>

                    <div class="space-y-4">
                        @foreach($provinces as $provSlug => $prov)
                            <div class="border-t border-slate-100 pt-3 first:border-t-0 first:pt-0">
                                <a href="{{ route('area.province', ['province' => $provSlug]) }}" 
                                   class="font-bold text-xs sm:text-sm text-slate-900 hover:text-sky-700 transition-colors inline-block mb-1.5">
                                    {{ $prov['name'] }}
                                </a>
                                <div class="flex flex-wrap gap-1.5 text-xs text-slate-600">
                                    @foreach($prov['cities'] as $citySlug => $city)
                                        <a href="{{ route('area.city', ['city' => $citySlug]) }}" 
                                           class="px-2.5 py-1 rounded-md bg-slate-50 hover:bg-sky-50 text-slate-700 hover:text-sky-800 border border-slate-200/80 transition-colors">
                                            {{ $city['name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

            </div>

            <!-- Kolom 2: Profil, Portofolio & Pengetahuan -->
            <div class="space-y-8">
                
                <!-- 3. Profil Perusahaan & Legalitas -->
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs">
                    <div class="pb-3.5 border-b border-slate-100 mb-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-sky-800">TENTANG KAMI</p>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-0.5">Profil Perusahaan &amp; Tata Kelola</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm">
                        <a href="{{ route('about.profile') }}" class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all font-medium flex items-center justify-between group">
                            <span>Profil Resmi Perusahaan</span>
                            <span class="text-slate-400 group-hover:text-sky-700">&rarr;</span>
                        </a>
                        <a href="{{ route('about.holding') }}" class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all font-medium flex items-center justify-between group">
                            <span>Induk PT Jawa Jaya Rooter</span>
                            <span class="text-slate-400 group-hover:text-sky-700">&rarr;</span>
                        </a>
                        <a href="{{ route('about.k3') }}" class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all font-medium flex items-center justify-between group">
                            <span>Standar SOP K3 &amp; Higienitas</span>
                            <span class="text-slate-400 group-hover:text-sky-700">&rarr;</span>
                        </a>
                        <a href="{{ route('about.equipment') }}" class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all font-medium flex items-center justify-between group">
                            <span>Peralatan Spiral &amp; Kamera CCTV</span>
                            <span class="text-slate-400 group-hover:text-sky-700">&rarr;</span>
                        </a>
                        <a href="{{ route('about.portfolio') }}" class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all font-medium flex items-center justify-between group">
                            <span>Portofolio Mitra B2B</span>
                            <span class="text-slate-400 group-hover:text-sky-700">&rarr;</span>
                        </a>
                        <a href="{{ route('about.warranty') }}" class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all font-medium flex items-center justify-between group">
                            <span>Ketentuan Garansi 30 Hari</span>
                            <span class="text-slate-400 group-hover:text-sky-700">&rarr;</span>
                        </a>
                        <a href="{{ route('about.faq') }}" class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all font-medium flex items-center justify-between group sm:col-span-2">
                            <span>Pusat Bantuan &amp; Tanya Jawab (FAQ)</span>
                            <span class="text-slate-400 group-hover:text-sky-700">&rarr;</span>
                        </a>
                    </div>

                    @if(isset($equipments) && $equipments->isNotEmpty())
                    <div class="mt-4 pt-3.5 border-t border-slate-100">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-2">Spesifikasi Unit Mesin &amp; Toolkit:</span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            @foreach($equipments as $eq)
                            <a href="{{ route('equipment.show', $eq->slug) }}" class="p-2 rounded-md hover:bg-slate-50 text-slate-700 hover:text-sky-700 flex items-center justify-between border border-slate-100 group">
                                <span class="truncate">{{ $eq->name }}</span>
                                <span class="text-slate-400 group-hover:text-sky-700 shrink-0 ml-1">&rarr;</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </section>

                <!-- 4. Dokumentasi & Studi Kasus Lapangan -->
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs">
                    <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-sky-800">BUKTI TEKNIS</p>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-0.5">Studi Kasus &amp; Galeri Pengerjaan</h2>
                        </div>
                        <a href="{{ url('/galeri') }}" class="text-xs font-semibold text-sky-700 hover:underline">
                            Semua Galeri &rarr;
                        </a>
                    </div>

                    @if($caseStudies->isNotEmpty())
                        <div class="space-y-2 text-xs sm:text-sm">
                            @foreach($caseStudies as $study)
                                <a href="{{ route('case-study.show', $study->slug) }}" 
                                   class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all block">
                                    <span class="font-semibold block truncate text-slate-900 hover:text-sky-700">{{ $study->title }}</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5 truncate">{{ $study->location }} &bull; {{ $study->category }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500">
                            Dokumentasi foto pengerjaan saluran mampet dapat dilihat langsung pada halaman <a href="{{ url('/galeri') }}" class="text-sky-700 font-semibold underline">Galeri Before &amp; After</a>.
                        </p>
                    @endif
                </section>

                <!-- 5. Artikel & Panduan Edukasi Sanitasi -->
                <section class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs">
                    <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-sky-800">EDUKASI TEKNIS</p>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 mt-0.5">Artikel &amp; Panduan Pipa Mampet</h2>
                        </div>
                        <a href="{{ route('articles.index') }}" class="text-xs font-semibold text-sky-700 hover:underline">
                            Semua Artikel &rarr;
                        </a>
                    </div>

                    @if($articles->isNotEmpty())
                        <div class="space-y-2 text-xs sm:text-sm">
                            @foreach($articles->take(6) as $art)
                                <a href="{{ route('articles.show', $art->slug) }}" 
                                   class="p-2.5 rounded-lg border border-slate-100 hover:border-sky-300 hover:bg-sky-50/40 text-slate-700 hover:text-sky-800 transition-all block">
                                    <span class="font-semibold block truncate text-slate-900 hover:text-sky-700">{{ $art->title }}</span>
                                    <span class="text-[11px] text-slate-400 block mt-0.5">{{ $art->category ?? 'Tips & Edukasi' }} &bull; {{ $art->reading_time }} Menit Baca</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500">
                            Kunjungi pusat pengetahuan teknis di halaman <a href="{{ route('articles.index') }}" class="text-sky-700 font-semibold underline">Artikel Edukasi Sanitasi</a>.
                        </p>
                    @endif
                </section>

            </div>

        </div>

    </div>
</div>
@endsection

