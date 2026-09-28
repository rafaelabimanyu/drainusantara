@extends('layouts.app')

@section('content')
@include('about.partials.nav', [
    'activeTitle' => 'Struktur Holding',
    'eyebrow' => 'Struktur Korporasi',
    'heading' => 'Ekosistem Terintegrasi Holding J&J Group',
    'subheading' => 'Drainusantara beroperasi dengan dukungan penuh holding J&J Group, memastikan keandalan modal, armada mandiri, dan standarisasi operasional berkelanjutan.'
])

<!-- Main Holding Content -->
<section id="holding" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Sinergi Holding
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Kekuatan Jaringan &amp; Tata Kelola J&amp;J Group
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Sebagai unit spesialis dalam naungan J&amp;J Group, Drainusantara didukung infrastruktur logistik terpusat, pengadaan mesin drain cleaning pabrikan resmi, serta tata kelola administrasi transparan berstandar B2B.
            </p>
        </div>

        <!-- 3 Pilar Sinergi Holding -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center font-bold text-sm mb-4 border border-sky-100">
                        01
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Logistik &amp; Armada Terpadu</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Pengelolaan armada teknisi berbasis posko terkoordinasi di Jabodetabek, Semarang, dan Lampung untuk menjamin respon darurat tercepat di bawah 60 menit.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 text-xs text-slate-500 font-medium">
                    Sistem Dispatch Posko Terpusat
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center font-bold text-sm mb-4 border border-sky-100">
                        02
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Kendali Mutu &amp; K3 Terpusat</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Pemberlakuan SOP K3 berkala, audit kelayakan kabel spiral baja, kalibrasi kamera inspeksi CCTV pipa, serta pelatihan bersertifikat bagi setiap teknisi lapangan.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 text-xs text-slate-500 font-medium">
                    Audit Kinerja Teknis Berkala
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center font-bold text-sm mb-4 border border-sky-100">
                        03
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Akuntabilitas Legal &amp; Pajak</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Kemudahan administrasi bagi mitra korporat komersial, mulai dari penerbitan Faktur Pajak resmi, Berita Acara Serah Terima (BAST), hingga terms of payment fleksibel.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 text-xs text-slate-500 font-medium">
                    Dukungan Kemitraan B2B &amp; SLA
                </div>
            </div>
        </div>

        <!-- Detail Peran Holding Banner -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Ingin Mengetahui Standar Keselamatan Kerja Teknisi?</h3>
                    <p class="text-slate-600 text-xs sm:text-sm mt-1 max-w-2xl">
                        Pelajari protokol K3, pemakaian cover sepatu khusus saat memasuki hunian konsumen, dan uji sanitasi pasca pengerjaan.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('about.k3') }}" class="btn-press inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs shadow-xs transition-colors min-h-[44px]">
                        <span>Buka Standar SOP K3</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
