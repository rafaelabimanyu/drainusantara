@extends('layouts.app')

@section('content')
@include('about.partials.nav', [
    'activeTitle' => 'Profil Perusahaan',
    'eyebrow' => 'Profil Entitas',
    'heading' => 'Dedikasi Pelayanan Sanitasi Higienis Sejak Awal Berdiri',
    'subheading' => 'Rekayasa mekanis perpipaan tanpa bongkar ubin keramik berlandaskan 3 pilar integritas teknis dan komitmen transparansi biaya.'
])

<!-- Main Profile Content -->
<section id="profil" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Left Info -->
            <div class="lg:col-span-7">
                <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                    Latar Belakang &amp; Visi Layanan
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Solusi Pipa Tersumbat Tanpa Merusak Bangunan
                </h2>
                <div class="space-y-4 text-sm sm:text-base text-slate-600 leading-relaxed">
                    <p>
                        Drainusantara didirikan atas kebutuhan mendesak masyarakat urban akan penanganan pipa pembuangan yang aman, cepat, dan tidak destruktif. Selama bertahun-tahun, metode konvensional kerap merugikan pemilik properti karena mengharuskan pembongkaran lantai keramik berbiaya mahal, atau pemakaian soda api berbahaya yang justru merusak sambungan pipa PVC dan memicu kebocoran tersembunyi di bawah lantai cor.
                    </p>
                    <p>
                        Dengan mengadopsi mesin drain rooter spiral baja berstandar internasional, teknisi kami mampu menjangkau titik sumbatan hingga puluhan meter mengikuti liukan leher angsa dan belokan elbow pipa. Kami memberikan kepastian hasil tuntas dengan prinsip kerja bersih, transparan, dan berorientasi pada kepuasan pelanggan.
                    </p>
                </div>

                <!-- 3 Pilar Integritas -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mt-8">
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                        <span class="text-xs font-bold text-sky-700 block mb-1">01. 100% Non-Destruktif</span>
                        <p class="text-xs text-slate-600">Nol pembongkaran keramik ubin atau dinding semen hunian Anda.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                        <span class="text-xs font-bold text-sky-700 block mb-1">02. Bebas Bahan Kimia</span>
                        <p class="text-xs text-slate-600">Aman untuk pipa AW dan D tanpa risiko korosi atau pipa meleleh.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-2xs">
                        <span class="text-xs font-bold text-sky-700 block mb-1">03. Garansi 30 Hari</span>
                        <p class="text-xs text-slate-600">Perlindungan purna jual resmi dengan komitmen No Cure No Pay.</p>
                    </div>
                </div>
            </div>

            <!-- Right Fact Sheet -->
            <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xs">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-4">
                    Ringkasan Entitas Operasional
                </span>
                
                <div class="space-y-4 text-xs sm:text-sm">
                    <div class="pb-3 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Nama Brand</span>
                        <span class="font-bold text-slate-900">Drainusantara</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Induk Holding</span>
                        <span class="font-bold text-sky-700">J&amp;J Group</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Spesialisasi</span>
                        <span class="font-bold text-slate-900">Mechanical Drain Cleaning</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Cakupan Wilayah</span>
                        <span class="font-bold text-slate-900 text-right">Jabodetabek, Semarang, Lampung</span>
                    </div>
                    <div class="pb-3 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Waktu Layanan</span>
                        <span class="font-bold text-emerald-700">24 Jam Siaga Darurat</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Prinsip Kerja</span>
                        <span class="font-bold text-slate-900">No Cure No Pay</span>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-slate-100">
                    <a href="{{ route('about.holding') }}" class="btn-press w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors min-h-[44px]">
                        <span>Pelajari Struktur Holding J&amp;J Group</span>
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
