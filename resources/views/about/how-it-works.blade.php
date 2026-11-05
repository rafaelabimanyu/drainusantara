@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $howItWorksWaText = urlencode("Halo Admin PT JAWA JAYA ROOTER (Drainusantara), saya ingin menanyakan proses kerja dan pemesanan teknisi pelancar saluran tanpa bongkar.");
    $howItWorksWaUrl = "https://wa.me/{$whatsappNumber}?text={$howItWorksWaText}";
@endphp

<x-about.subnav 
    active-title="Cara Kerja & Proses"
    eyebrow="STANDAR OPERASIONAL NON-DESTRUKTIF"
    heading="Proses Kerja Pelancaran Pipa Tanpa Bongkar"
    subheading="Drainusantara menerapkan metode rekayasa sanitasi mekanis modern di bawah PT JAWA JAYA ROOTER. Melalui 5 tahapan kerja sistematis, seluruh penyumbatan pipa dituntaskan langsung dari lubang saringan atau leher angsa eksisting tanpa membongkar keramik lantai dan 100% bebas dari bahan kimia korosif seperti soda api."
    :bg-image="asset('assets/banner/hero-peralatan-drainusantara.webp')"
/>

<!-- Section: 5 Tahapan Sistematis Proses Kerja -->
<section id="tahapan-kerja" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12 reveal-soft">
            <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                METODOLOGI SISTEMATIS
            </p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                5 Tahapan Pelancaran Saluran Pipa Mekanis
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2.5 leading-relaxed">
                Setiap penanganan saluran pipa mampet di hunian privat, restoran, ruko, maupun gedung komersial dikerjakan dengan disiplin operasional terukur oleh teknisi ber-APD resmi.
            </p>
        </div>

        <!-- 5 Steps List (Fully Responsive Vertical Stack & Step Flow) -->
        <div class="relative max-w-4xl mx-auto">
            <div class="space-y-4 sm:space-y-6">
                
                <!-- Step 1 -->
                <div id="langkah-1" class="scroll-mt-24 bg-white p-5 sm:p-7 rounded-xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row gap-4 sm:gap-6 items-start hover:border-sky-300 transition-colors">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-slate-900 text-white font-extrabold text-base sm:text-lg flex items-center justify-center shrink-0 shadow-2xs">
                        01
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                                Diagnosa &amp; Inspeksi Visual Endoskopi CCTV
                            </h3>
                            <span class="text-[11px] font-bold text-sky-800 bg-sky-50 border border-sky-200 px-2.5 py-0.5 rounded-md">Tahap Awal</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Teknisi memasukkan kabel probe kamera endoskopi waterproof IP68 ke dalam lubang pipa pembuangan. Layar monitor resolusi tinggi akan memetakan posisi sumbatan, jarak meteran dari lubang masuk, mendeteksi jenis penghambat (lemak beku, kain/tisu, pasir sisa bangunan, atau akar pohon), serta memverifikasi ada tidaknya pipa pecah atau kemiringan pipa yang tidak tepat.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div id="langkah-2" class="scroll-mt-24 bg-white p-5 sm:p-7 rounded-xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row gap-4 sm:gap-6 items-start hover:border-sky-300 transition-colors">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-slate-900 text-white font-extrabold text-base sm:text-lg flex items-center justify-center shrink-0 shadow-2xs">
                        02
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                                Penetrasi Spiral Baja Lentur (Ridgid Rotary Rooter)
                            </h3>
                            <span class="text-[11px] font-bold text-sky-800 bg-sky-50 border border-sky-200 px-2.5 py-0.5 rounded-md">Metode Mekanis</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kabel spiral baja fleksibel (high-tensile spring steel) diputar oleh mesin elektrik dengan torsi terukur. Kabel ini meliuk secara fleksibel mengikuti lekukan leher angsa (P-trap) dan sambungan knee pipa 90 derajat tanpa menyebabkan gesekan berlebih yang dapat meretakkan sambungan fitting pipa PVC.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div id="langkah-3" class="scroll-mt-24 bg-white p-5 sm:p-7 rounded-xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row gap-4 sm:gap-6 items-start hover:border-sky-300 transition-colors">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-slate-900 text-white font-extrabold text-base sm:text-lg flex items-center justify-center shrink-0 shadow-2xs">
                        03
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                                Pengikisan Kerak Lemak &amp; Ekstraksi Sumbatan
                            </h3>
                            <span class="text-[11px] font-bold text-sky-800 bg-sky-50 border border-sky-200 px-2.5 py-0.5 rounded-md">Pembersihan Total</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Ujung spiral dipasangi mata pisau pemotong khusus yang disesuaikan dengan sumber masalah: Grease Cutter untuk menghancurkan lemak beku yang melapisi dinding pipa, Root Saw untuk memotong serat akar pohon yang merangsek masuk sambungan, atau Retrieving Auger untuk menarik gumpalan rambut, kain, dan pembalut keluar dari jalur pipa.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div id="langkah-4" class="scroll-mt-24 bg-white p-5 sm:p-7 rounded-xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row gap-4 sm:gap-6 items-start hover:border-sky-300 transition-colors">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-slate-900 text-white font-extrabold text-base sm:text-lg flex items-center justify-center shrink-0 shadow-2xs">
                        04
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                                Pembilasan Debit Air Deras (Flushing) &amp; Uji Alir Bersama
                            </h3>
                            <span class="text-[11px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-md">Verifikasi Aliran</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Setelah material sumbatan terdorong hancur dan ditarik keluar, teknisi mengalirkan debit air deras secara bersamaan dengan pemilik rumah atau perwakilan gedung. Pemeriksaan dilakukan langsung di bak kontrol pembuangan akhir untuk memastikan laju aliran air lancar sempurna dan tidak ada pusaran balik.
                        </p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div id="langkah-5" class="scroll-mt-24 bg-white p-5 sm:p-7 rounded-xl border border-slate-200 shadow-2xs flex flex-col sm:flex-row gap-4 sm:gap-6 items-start hover:border-emerald-300 transition-colors">
                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-lg bg-emerald-700 text-white font-extrabold text-base sm:text-lg flex items-center justify-center shrink-0 shadow-2xs">
                        05
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">
                                Sanitasi Area Kerja &amp; Penerbitan Surat Garansi 30 Hari
                            </h3>
                            <span class="text-[11px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-md">Garansi Resmi</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Teknisi membersihkan dan mendisinfeksi area kerja pasca operasional sehingga ruangan kembali higienis dan rapi. Selanjutnya, tim menerbitkan dokumen Berita Acara Serah Terima (BAST) pekerjaan serta Surat Garansi Tertulis 30 Hari Kalender resmi dari PT JAWA JAYA ROOTER yang terdata di sistem pusat.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Section: Tabel Perbandingan Metode (Non-Slop, Clean Data Matrix) -->
<section id="perbandingan-metode" class="py-16 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-10 reveal-soft">
            <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                PERBANDINGAN TEKNIS
            </p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Drainusantara vs Tukang Biasa vs Soda Api
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2.5 leading-relaxed">
                Pahami perbedaan mendasar antara penanganan mekanis bersertifikasi dengan cara konvensional yang kerap menimbulkan kerusakan fatal pada instalasi saluran Anda.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm border-collapse border border-slate-200">
                <thead>
                    <tr class="bg-slate-900 text-white">
                        <th class="p-3.5 sm:p-4 font-bold border border-slate-700 w-1/4">Parameter Penanganan</th>
                        <th class="p-3.5 sm:p-4 font-bold border border-slate-700 w-1/4 bg-sky-900 text-white">Metode Drainusantara</th>
                        <th class="p-3.5 sm:p-4 font-bold border border-slate-700 w-1/4 text-slate-300">Tukang Bongkar Biasa</th>
                        <th class="p-3.5 sm:p-4 font-bold border border-slate-700 w-1/4 text-slate-300">Penggunaan Soda Api</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr class="hover:bg-slate-50">
                        <td class="p-3.5 sm:p-4 font-semibold text-slate-900 border border-slate-200">Kondisi Keramik / Lantai</td>
                        <td class="p-3.5 sm:p-4 font-bold text-sky-900 bg-sky-50/50 border border-slate-200">100% Utuh Tanpa Bongkar</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Dibongkar dan dipahat berantakan</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Tidak dibongkar, tapi risiko rembes</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="p-3.5 sm:p-4 font-semibold text-slate-900 border border-slate-200">Keamanan Pipa PVC</td>
                        <td class="p-3.5 sm:p-4 font-bold text-sky-900 bg-sky-50/50 border border-slate-200">Sangat Aman (Spiral Lentur)</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Risiko pecah akibat bobokan linggis</td>
                        <td class="p-3.5 sm:p-4 text-red-700 font-semibold border border-slate-200">Bahaya Fatal (Panas &gt; 100&deg;C melunakkan lem pipa)</td>
                    </tr>
                   
                    <tr class="hover:bg-slate-50">
                        <td class="p-3.5 sm:p-4 font-semibold text-slate-900 border border-slate-200">Jaminan Garansi</td>
                        <td class="p-3.5 sm:p-4 font-bold text-sky-900 bg-sky-50/50 border border-slate-200">Garansi Tertulis 30 Hari</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Tidak ada garansi tertulis</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Nihil garansi</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="p-3.5 sm:p-4 font-semibold text-slate-900 border border-slate-200">Skema Pembayaran</td>
                        <td class="p-3.5 sm:p-4 font-bold text-sky-900 bg-sky-50/50 border border-slate-200">No Cure No Pay (Lancar Baru Bayar)</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Uang muka material + ongkos harian</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Beli bahan kimia tanpa kepastian hasil</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="p-3.5 sm:p-4 font-semibold text-slate-900 border border-slate-200">Legalitas &amp; Dokumen Pajak</td>
                        <td class="p-3.5 sm:p-4 font-bold text-sky-900 bg-sky-50/50 border border-slate-200">PT Resmi &amp; e-Faktur PPN 11%</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Perorangan tanpa badan hukum</td>
                        <td class="p-3.5 sm:p-4 text-slate-600 border border-slate-200">Nota toko bahan bangunan biasa</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</section>



<!-- Section: CTA Dispatch PT JAWA JAYA ROOTER -->
<section id="cta-cara-kerja" class="py-14 lg:py-16 bg-slate-900 text-white relative overflow-hidden reveal-soft">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-2">
                    KONSULTASI &amp; DISPATCH RESMI PT JAWA JAYA ROOTER
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Saluran Pipa Mampet? Panggil Teknisi Kami Sekarang
                </h2>
                <p class="text-slate-300 text-xs sm:text-sm mt-2 leading-relaxed">
                    Jangan tunggu pipa meluap atau terlanjur rusak karena soda api. Tim teknisi Drainusantara dari PT JAWA JAYA ROOTER siap meluncur dari posko siaga terdekat ke lokasi Anda.
                </p>
            </div>
            
            <div class="shrink-0 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ $howItWorksWaUrl }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="min-h-[44px] inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-lg shadow-sm transition-all btn-press focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Hubungi Dispatch WhatsApp</span>
                </a>
                <a href="{{ route('about.warranty') }}" 
                   class="min-h-[44px] inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs sm:text-sm px-5 py-3 rounded-lg border border-slate-700 transition-colors btn-press focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <span>Pelajari Ketentuan Garansi 30 Hari</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
