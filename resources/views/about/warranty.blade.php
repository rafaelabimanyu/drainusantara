@extends('layouts.app')

@section('content')
@include('about.partials.nav', [
    'activeTitle' => 'Ketentuan Garansi',
    'eyebrow' => 'Perlindungan Konsumen',
    'heading' => 'Ketentuan Resmi Garansi 30 Hari Kalender',
    'subheading' => 'Perlindungan purna jual tertulis dan komitmen No Cure No Pay untuk menjamin ketenangan pikiran Anda.'
])

<!-- Main Warranty Content -->
<section id="garansi" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Jaminan Kualitas
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Komitmen Tertulis Pengerjaan Tuntas &amp; No Cure No Pay
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Kami percaya pada kualitas mesin dan keahlian teknisi kami. Jika saluran yang kami tangani tidak berhasil lancar, Anda bebas dari segala kewajiban biaya jasa pelancaran.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12">
            <!-- Left: 4 Ketentuan Garansi Pokok -->
            <div class="lg:col-span-7 space-y-4">
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-2xs">
                    <span class="text-xs font-bold text-sky-700 block mb-1">01. Durasi 30 Hari Kalender</span>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Garansi berlaku terhitung sejak tanggal pengerjaan selesai yang tertera pada nota digital atau invoice resmi pengerjaan.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-2xs">
                    <span class="text-xs font-bold text-sky-700 block mb-1">02. Kunjungan Ulang Bebas Biaya</span>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Jika titik saluran yang sama mengalami mampet kembali dalam masa garansi tanpa faktor sabotase atau benda asing baru, teknisi kami datang kembali tanpa biaya jasa tambahan.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-2xs">
                    <span class="text-xs font-bold text-sky-700 block mb-1">03. Syarat Nota Digital Resmi</span>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Klaim cukup melampirkan foto nota digital atau nomor WhatsApp pemesan yang tercatat di sistem dispatch pusat Drainusantara.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-2xs">
                    <span class="text-xs font-bold text-sky-700 block mb-1">04. Batasan Pengecualian Adil</span>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Garansi tidak mencakup kerusakan fisik pipa pecah akibat konstruksi pihak ketiga, pipa amblas tanah, atau masuknya adukan semen basah renovasi baru.
                    </p>
                </div>
            </div>

            <!-- Right: 3 Langkah Klaim Garansi -->
            <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xs">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500 block mb-4">
                    Alur Klaim 3 Langkah Cepat
                </span>

                <div class="space-y-6 text-xs sm:text-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-800 font-bold flex items-center justify-center shrink-0 text-xs">
                            1
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Kirim Bukti Nota Digital</span>
                            <p class="text-slate-600 text-xs mt-0.5">Kirimkan foto nota atau nomor pesanan Anda ke WhatsApp layanan purna jual kami.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-800 font-bold flex items-center justify-center shrink-0 text-xs">
                            2
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Verifikasi &amp; Penjadwalan Cepat</span>
                            <p class="text-slate-600 text-xs mt-0.5">Admin dispatch memvalidasi data dan memprioritaskan jadwal armada siaga terdekat.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-800 font-bold flex items-center justify-center shrink-0 text-xs">
                            3
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">Kedatangan Teknisi &amp; Penuntasan</span>
                            <p class="text-slate-600 text-xs mt-0.5">Teknisi meluncur dan menuntaskan kembali saluran pipa hingga plong lancar.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100">
                    <a href="https://wa.me/{{ config('app.whatsapp_number') ?: '6281234567890' }}?text={{ urlencode('Halo Admin Drainusantara, saya ingin konsultasi garansi pengerjaan saluran.') }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-press w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-xs shadow-xs transition-colors min-h-[44px]">
                        <span>Hubungi Layanan Garansi</span>
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
