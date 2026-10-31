@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-10 lg:py-16 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        <!-- Header Showcase -->
        <div class="text-center max-w-3xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-widest text-sky-700 block mb-2">
                Showcase Komponen UI
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Preview Blade Components
            </h1>
            <p class="mt-2 text-sm text-slate-600">
                Pratinjau komponen kartu studi kasus (<code class="bg-slate-200 px-1 py-0.5 rounded text-xs">&lt;x-case-study-card&gt;</code>) dan kemitraan (<code class="bg-slate-200 px-1 py-0.5 rounded text-xs">&lt;x-partnership-card&gt;</code>).
            </p>
            <div class="mt-4 flex flex-wrap justify-center gap-3">
                <a href="{{ route('case-study.show', 'pelancaran-pipa-saluran-lemak-restoran') }}" class="text-xs font-semibold text-sky-700 bg-sky-50 border border-sky-200 px-3 py-1.5 rounded-md hover:bg-sky-100 transition-colors">
                    Lihat Contoh Studi Kasus &rarr;
                </a>
                <a href="{{ route('partnership.show', 'mie-gacoan-kemitraan-sanitasi-restoran') }}" class="text-xs font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-md hover:bg-emerald-100 transition-colors">
                    Lihat Contoh Kemitraan &rarr;
                </a>
            </div>
        </div>

        <!-- 1. Case Study Cards Showcase -->
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                        1. Case Study Cards (<code class="text-sky-700 text-sm">&lt;x-case-study-card&gt;</code>)
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Komponen kartu untuk galeri portofolio penanganan kendala pipa.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1: Lengkap Gambar -->
                <x-case-study-card 
                    slug="pelancaran-pipa-saluran-lemak-restoran" 
                    title="Pelancaran Pipa Saluran Lemak Restoran Tersumbat Total" 
                    location="Kebayoran Baru, Jakarta Selatan" 
                    :propertyTypes="['Restoran', 'Komersial B2B']" 
                    beforeImage="images/dokumentasi/pelancar-saluran-gutter-resto-jakarta.webp" 
                    duration="2 Jam Pengerjaan" 
                    :problemTypes="['Lemak Mengeras', 'Bak Kontrol']" 
                />

                <!-- Card 2: Foto Kloset -->
                <x-case-study-card 
                    slug="pelancaran-saluran-kloset-toilet-duduk-mampet" 
                    title="Pelancaran Saluran Kloset Toilet Duduk Mampet Tanpa Bongkar" 
                    location="Bekasi Barat" 
                    :propertyTypes="['Rumah Tinggal']" 
                    beforeImage="images/dokumentasi/pelancar-saluran-kloset-toilet-mampet.webp" 
                    duration="1.5 Jam" 
                    :problemTypes="['Sumbatan Tisu', 'Pipa Leher Angsa']" 
                />

                <!-- Card 3: Fallback Tanpa Foto -->
                <x-case-study-card 
                    slug="pembersihan-grease-trap-sentral" 
                    title="Pembersihan Berkala Sentral Grease Trap Foodcourt" 
                    location="Tangerang Selatan" 
                    :propertyTypes="['Apartemen', 'Foodcourt']" 
                    :beforeImage="null" 
                    duration="3 Jam" 
                    :problemTypes="['Endapan Minyak']" 
                />
            </div>
        </section>

        <!-- 2. Partnership Cards Showcase -->
        <section class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                        2. Partnership Cards (<code class="text-sky-700 text-sm">&lt;x-partnership-card&gt;</code>)
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Komponen kartu profil mitra usaha B2B.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Mitra 1: Dengan Logo Asli -->
                <x-partnership-card 
                    slug="mie-gacoan-network" 
                    businessName="Mie Gacoan Network" 
                    logoUrl="images/portfolio/gacoan-mitra-kepercayaan-drainusantara-jasa-saluran-pipa-mampet.webp" 
                    businessType="F&B Restoran Skala Nasional" 
                    partnershipType="kontrak-maintenance" 
                    location="Jabodetabek & Jabar" 
                    :services="['Kuras Grease Trap', 'Pembersihan Pipa Sink', 'Inspeksi CCTV']" 
                />

                <!-- Mitra 2: Kerjasama Proyek -->
                <x-partnership-card 
                    slug="rs-siloam-hospitals" 
                    businessName="Siloam Hospitals Group" 
                    :logoUrl="null" 
                    businessType="Fasilitas Layanan Kesehatan" 
                    partnershipType="kerjasama-proyek" 
                    location="Bekasi & Cikarang" 
                    :services="['Drain Cleaning Sentral', 'Flushing Pipa IPAL']" 
                />

                <!-- Mitra 3: Layanan Darurat -->
                <x-partnership-card 
                    slug="kopi-kenangan-outlet" 
                    businessName="Kopi Kenangan Chain" 
                    :logoUrl="null" 
                    businessType="Coffee Shop & Retail F&B" 
                    partnershipType="emergency" 
                    location="Jakarta Selatan" 
                    :services="['Pelancaran Bar Sink', 'Emergency 24 Jam']" 
                />
            </div>
        </section>

    </div>
</div>
@endsection

