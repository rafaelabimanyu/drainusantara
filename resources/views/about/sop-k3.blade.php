@extends('layouts.app')

@section('content')
<x-about.subnav 
    active-title="SOP K3"
    eyebrow="Keselamatan & Kesehatan Kerja"
    heading="Perlengkapan APD K3 Teknisi Lapangan Drainusantara"
    subheading="Standar perlindungan diri teknisi kami sebelum memasuki area kerja Anda, memastikan tidak ada risiko kontaminasi atau bahaya selama proses perbaikan pipa."
    :bg-image="asset('assets/banner/hero-k3-drainusantara.webp')"
/>

<!-- Main SOP K3 Content -->
<section id="sop-k3" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Protokol Higienitas Lapangan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                4 Disiplin Utama Pelayanan Sanitasi Bersih
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
               Sebelum menginjakkan kaki di lokasi pelanggan (hunian, restoran, hotel, atau pabrik), teknisi Drainusantara diwajibkan menerapkan standar proteksi K3 lengkap.
            </p>
        </div>

        <!-- 4 Disiplin APD Cards (Mobile Carousel, Desktop Grid) -->
        <div x-data="mobileCarousel(4, 4000)"
             class="mb-12">
            <div x-ref="slider" tabindex="0" role="region" aria-label="Alat pelindung diri - geser untuk melihat lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
             @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-2 md:gap-6 lg:gap-8 md:overflow-visible md:pb-0">
                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between card-lift reveal-soft stagger-1">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 border border-sky-200 flex items-center justify-center font-bold text-sm shrink-0">
                                01
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-snug">Sarung Tangan Heavy-Duty Anti-Slip</h3>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Melindungi tangan teknisi dari gesekan kabel spiral baja Ridgid Amerika saat rotasi kecepatan tinggi serta mencegah kontak langsung dengan mikroba saluran.
                        </p>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between card-lift reveal-soft stagger-2">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 border border-sky-200 flex items-center justify-center font-bold text-sm shrink-0">
                                02
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-snug">Sepatu Boot Safety &amp; Pelindung Alas Footwear</h3>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Memastikan teknisi tidak membawa debu atau kotoran luar ke dalam area lantai bersih hunian, dapur restoran, maupun fasilitas steril.
                        </p>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between card-lift reveal-soft stagger-3">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 border border-sky-200 flex items-center justify-center font-bold text-sm shrink-0">
                                03
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-snug">Respirator Mask &amp; Safety Goggles</h3>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Melindungi teknisi dari cipratan air limbah serta uap gas amonia/asam yang terperangkap dalam saluran saat penghembusan Hydro-jetting.
                        </p>
                    </div>
                </div>

                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs flex flex-col justify-between card-lift reveal-soft stagger-4">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-sky-50 text-sky-700 border border-sky-200 flex items-center justify-center font-bold text-sm shrink-0">
                                04
                            </div>
                            <h3 class="text-base font-bold text-slate-900 leading-snug">Seragam Kerja Khusus &amp; Identitas Resmi</h3>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Setiap personel menggunakan seragam kerja resmi berlogo Drainusantara dan dibekali ID Card terverifikasi untuk keamanan &amp; ketenangan pelanggan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dots indicator for 4 APD cards on mobile -->
            <div class="flex md:hidden justify-center items-center flex-wrap gap-1.5 mt-5">
                <template x-for="i in total" :key="i">
                    <button :aria-current="active === i - 1 ? 'true' : 'false'" type="button"
                            @click="goTo(i - 1)"
                            class="carousel-dot"

                            :aria-label="'SOP ' + i">
                    <span aria-hidden="true" class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75" :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"></span></button>
                </template>
            </div>
        </div>
    </div>
</section>

<!-- Section 2: Protokol Desinfeksi Mesin Ridgid & Hydro-Jetting (3 Cards with Mobile Carousel) -->
<section id="protokol-desinfeksi" class="py-16 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Dekontaminasi Alat Kerja
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Protokol Desinfeksi Mesin Ridgid &amp; Hydro-Jetting
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Setiap unit mekanis dan selang jetting melewati sterilisasi terstruktur pasca pengerjaan di lapangan guna memutus rantai transmisi bakteri dan memastikan higienitas alat sebelum masuk ke properti berikutnya.
            </p>
        </div>

        <div x-data="mobileCarousel(3, 4000)">
            <div x-ref="slider" tabindex="0" role="region" aria-label="Prosedur desinfeksi - geser untuk melihat lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
             @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-5 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-3 md:gap-6 lg:gap-8 md:overflow-visible md:pb-0">
                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 flex flex-col justify-between card-lift reveal-soft stagger-1">
                    <div>
                        <div class="w-12 h-12 rounded-lg bg-sky-100 text-sky-800 border border-sky-200 flex items-center justify-center font-bold text-base mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">Unit Mekanis Rotary</span>
                        <h3 class="text-lg font-bold text-slate-900 mb-3">Sterilisasi Kabel Spiral Ridgid</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            Kabel spiral baja fleksibel ditarik keluar dari drum penggerak, disemprot larutan klorin desinfektan netral non-korosif, lalu dilap bersih untuk menyingkirkan lapisan lemak dan biofilm sebelum pengeringan serta pelumasan anti-karat.
                        </p>
                    </div>
                    
                </div>

                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 flex flex-col justify-between card-lift reveal-soft stagger-2">
                    <div>
                        <div class="w-12 h-12 rounded-lg bg-sky-100 text-sky-800 border border-sky-200 flex items-center justify-center font-bold text-base mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">Tekanan Tinggi 250 Bar</span>
                        <h3 class="text-lg font-bold text-slate-900 mb-3">Flushing &amp; Dekontaminasi Selang Jetting</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            Selang termoplastik tahan gesek dibilas sirkulasi air bersih bertekanan pasca pelarutan lemak beku grease trap. Kepala nozel baja stainless disikat dan direndam cairan dekontaminasi anti-mikroba.
                        </p>
                    </div>
                   
                </div>

                <div class="w-[85vw] sm:w-[350px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 sm:p-7 rounded-xl border border-slate-200 flex flex-col justify-between card-lift reveal-soft stagger-3">
                    <div>
                        <div class="w-12 h-12 rounded-lg bg-sky-100 text-sky-800 border border-sky-200 flex items-center justify-center font-bold text-base mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">Optik Inspeksi Saluran</span>
                        <h3 class="text-lg font-bold text-slate-900 mb-3">Sanitasi Optik &amp; Kabel CCTV IP68</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            Head kamera safir anti-gores dan kabel push-rod serat kaca dilap menggunakan tisu alkohol isopropil 70%. Unit monitor dan koper pelindung anti-air dibersihkan menyeluruh sebelum disimpan ke kendaraan operasional.
                        </p>
                    </div>
                   
                </div>
            </div>

            <!-- Dots indicator for 3 Desinfeksi cards on mobile -->
            <div class="flex md:hidden justify-center items-center flex-wrap gap-1.5 mt-5">
                <template x-for="i in total" :key="i">
                    <button :aria-current="active === i - 1 ? 'true' : 'false'" type="button"
                            @click="goTo(i - 1)"
                            class="carousel-dot"

                            :aria-label="'Desinfeksi ' + i">
                    <span aria-hidden="true" class="h-2 rounded-full transition-all duration-300 ease-out cursor-pointer active:scale-75" :class="active === (i - 1) ? 'w-6 bg-sky-700' : 'w-2 bg-slate-300 hover:bg-slate-400'"></span></button>
                </template>
            </div>
        </div>
    </div>
</section>
    </div>
</section>

<!-- Section 3: Point Checklist Verifikasi Pasca Kerja -->
<section id="verifikasi-pasca-kerja" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mb-12 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Quality Assurance Mandiri
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Point Checklist Verifikasi Pasca Kerja
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Pekerjaan baru dinyatakan tuntas apabila teknisi dan pemilik properti telah melakukan verifikasi bersama melalui 5 parameter kontrol kualitas berikut ini.
            </p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-200 shadow-xs mb-10 reveal-soft">
            <div class="p-5 sm:p-6 flex items-start gap-4">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-slate-900 leading-snug">
                        Uji Alir Debit Air Penuh (Full Flow Test)
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                        Pengujian penggelontoran air volume tinggi selama 5 hingga 10 menit secara terus menerus disaksikan langsung oleh pelanggan untuk memastikan tidak ada backflow (air meluap balik) dan vortex pusaran air di mulut pipa berjalan lancar.
                    </p>
                </div>
                <span class="hidden sm:inline-flex text-xs font-semibold px-2.5 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200 shrink-0">
                    Mandatori
                </span>
            </div>

            <div class="p-5 sm:p-6 flex items-start gap-4">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-slate-900 leading-snug">
                        Pembersihan &amp; Sanitasi Area Kerja (Housekeeping Total)
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                        Seluruh sisa cipratan air limbah atau kotoran di lantai, keramik dinding, bak kontrol, atau area kolong kitchen sink dibersihkan dan dipel menggunakan karbol desinfektan wangi hingga kering dan higienis.
                    </p>
                </div>
                <span class="hidden sm:inline-flex text-xs font-semibold px-2.5 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200 shrink-0">
                    Higienitas
                </span>
            </div>

            <div class="p-5 sm:p-6 flex items-start gap-4">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-slate-900 leading-snug">
                        Pemeriksaan Seal Karet &amp; Sambungan Leher Angsa (P-Trap)
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                        Pemasangan kembali sifon atau sambungan pipa wastafel diperiksa teliti. Teknisi memastikan seal paking kedap air terpasang presisi tanpa ada rembesan atau tetesan air di bawah instalasi pipa.
                    </p>
                </div>
                <span class="hidden sm:inline-flex text-xs font-semibold px-2.5 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200 shrink-0">
                    Bebas Bocor
                </span>
            </div>

            <div class="p-5 sm:p-6 flex items-start gap-4">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-slate-900 leading-snug">
                        Validasi Berita Acara &amp; Aktivasi Kartu Garansi 30 Hari
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                        Penandatanganan lembar Berita Acara Penyelesaian Pekerjaan (BAPP) dan pencatatan nomor resi garansi resmi 30 hari kalender. Pelanggan memegang bukti fisik atau digital untuk perlindungan pasca pengerjaan.
                    </p>
                </div>
                <span class="hidden sm:inline-flex text-xs font-semibold px-2.5 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200 shrink-0">
                    Proteksi
                </span>
            </div>

            <div class="p-5 sm:p-6 flex items-start gap-4">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-slate-900 leading-snug">
                        Serah Terima Faktur / Kuitansi Resmi Berstempel
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                        Pemberian nota rincian biaya transparan sesuai penawaran awal tanpa biaya tersembunyi. Bagi klien korporat atau restoran berbadan hukum, invoice dan faktur pajak PPN 11% diproses sesuai ketentuan perpajakan resmi.
                    </p>
                </div>
                <span class="hidden sm:inline-flex text-xs font-semibold px-2.5 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200 shrink-0">
                    Administrasi
                </span>
            </div>
        </div>

        <div class="bg-slate-900 text-white p-6 sm:p-8 rounded-xl border border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-6 reveal-soft">
            <div class="max-w-xl text-center sm:text-left">
                <h4 class="text-lg font-bold text-white mb-1">
                    Butuh Standar Sanitasi Ketat di Tempat Usaha Anda?
                </h4>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                    Kami melayani restoran mall, hotel berbintang, dan fasilitas komersial dengan standar SOP K3 higienis dan peralatan mekanis modern tanpa bongkar.
                </p>
            </div>
            @php
                $sopWaNumber = config('app.whatsapp_number') ?: '6285609009009';
                $sopWaText = urlencode('Halo Drainusantara, saya ingin konsultasi layanan saluran mampet dengan standar SOP K3.');
            @endphp
            <a href="https://wa.me/{{ $sopWaNumber }}?text={{ $sopWaText }}"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-sm transition-colors duration-150 shrink-0">
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                <span>Konsultasi SOP K3 via WhatsApp</span>
            </a>
        </div>
    </div>
</section>
@endsection
