@extends('layouts.app')

@section('content')
@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
    $profileWaText = urlencode("Halo Admin Drainusantara, saya ingin berkonsultasi mengenai profil layanan dan penjadwalan teknisi pelancar saluran mampet.");
    $profileWaUrl = "https://wa.me/{$whatsappNumber}?text={$profileWaText}";
@endphp

<x-about.subnav 
    active-title="Profil Perusahaan"
    eyebrow="Profil Entitas Legal"
    heading="Profil Resmi Drainusantara"
    subheading="Drainusantara merupakan entitas bisnis spesialis pelancaran dan pemeliharaan saluran pipa pembuangan modern yang beroperasi secara sah di bawah naungan PT JAWA JAYA ROOTER (dikenal secara luas sebagai J&J Group). Didukung legalitas perseroan resmi, NIB OSS, dan tertib administrasi e-Faktur PPN, kami menghadirkan standar penanganan mekanis berstandar industri tanpa bongkar keramik lantai dan bebas zat kimia berbahaya, siap melayani sektor properti residensial maupun fasilitas komersial B2B dengan jaminan garansi tertulis 30 hari kalender."
    :bg-image="asset('assets/banner/hero-profil-perusahaan-drainusantara.webp')"
/>

<section id="profil" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <div class="lg:col-span-7 reveal-soft">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                    PROFIL RESMI DRAINUSANTARA &bull; PT JAWA JAYA ROOTER
                </p>
                
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Mitra Terpercaya Properti Residensial &amp; Sektor Komersial B2B
                </h2>
                
                <div class="space-y-4 text-sm sm:text-base text-slate-600 leading-relaxed">
                    <p>
                        Sejak awal beroperasi, Drainusantara menerapkan metode perbaikan pipa mekanis tanpa pembongkaran struktur di bawah badan hukum resmi <strong>PT JAWA JAYA ROOTER</strong>. Nama <strong>J&amp;J Group</strong> merupakan singkatan dan identitas holding ekosistem sanitasi yang menaungi divisi teknologi perpipaan, rantai pasok mesin rotary berstandar internasional, serta armada penanganan cepat. Seluruh operasional kami didukung legalitas usaha yang sah, siap melayani pengadaan B2B, penerbitan SPK, BAST, serta Faktur PPN resmi untuk kualifikasi SLA gedung dan fasilitas industri.
                    </p>
                    <p>
                        Sebagai pilar operasional dari <strong>PT JAWA JAYA ROOTER</strong>, kami hadir menyelesaikan keresahan pemilik properti terhadap metode konvensional yang merusak instalasi, mulai dari pembongkaran keramik lantai berbiaya tinggi hingga bahaya penggunaan soda api yang merusak pipa PVC akibat reaksi eksotermik. Mengandalkan unit mesin spiral rotary berstandar industri dan kamera endoskopi pipa CCTV IP68 jangkauan 30 meter, setiap penanganan diselesaikan secara presisi, higienis, dan terukur.
                    </p>
                </div>

                <!-- 3 Pilar Integritas Teknis (Mobile Carousel, Tablet/Desktop Grid) -->
                <div x-data="mobileCarousel(3, 4000)"
                     class="mt-8">
                    
            <div x-ref="slider" tabindex="0" role="region" aria-label="Pilar perusahaan - geser untuk melihat lainnya"
                         @scroll.passive="onScroll()"
                         @touchstart="pause()"
                         @touchend="resume()"
             @touchcancel="resume()"
                         class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-4 pb-3 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 sm:grid sm:grid-cols-3 sm:overflow-visible sm:pb-0">
                        
                        <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-5 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-1">
                            <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 font-extrabold text-xs flex items-center justify-center mb-3 border border-sky-100">
                                01
                            </div>
                            <span class="text-xs font-bold text-slate-900 block mb-1">100% Non-Destruktif</span>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Pengerjaan langsung dari lubang pipa eksisting tanpa membongkar keramik lantai, marmer, atau dinding cor.
                            </p>
                        </div>

                        <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-5 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-2">
                            <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 font-extrabold text-xs flex items-center justify-center mb-3 border border-emerald-100">
                                02
                            </div>
                            <span class="text-xs font-bold text-slate-900 block mb-1">Bebas Bahan Kimia</span>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Aman untuk seluruh jenis pipa PVC kelas AW maupun D tanpa risiko pelunakan sambungan fitting atau kebocoran.
                            </p>
                        </div>

                        <div class="w-[85vw] sm:w-auto shrink-0 snap-center bg-white p-5 rounded-xl border border-slate-200 shadow-2xs card-lift reveal-soft stagger-3">
                            <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 font-extrabold text-xs flex items-center justify-center mb-3 border border-amber-100">
                                03
                            </div>
                            <span class="text-xs font-bold text-slate-900 block mb-1">Garansi 30 Hari</span>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Dilindungi bukti nota garansi tertulis 30 hari kalender dengan komitmen No Cure No Pay yang nyata.
                            </p>
                        </div>
                    </div>

                    <!-- Mobile Slide Counter -->
                    <div class="flex items-center justify-center gap-3 mt-4 sm:hidden text-xs text-slate-500 font-mono">
                        <button type="button" @click="goTo(Math.max(0, active - 1))"
                                :disabled="active === 0"
                                :class="active === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                                class="p-1.5 rounded-md border border-slate-200 transition-colors"
                                aria-label="Pilar sebelumnya">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <span>Pilar <strong class="text-slate-900" x-text="active + 1">1</strong> dari <span x-text="total"></span></span>
                        <button type="button" @click="goTo(Math.min(total - 1, active + 1))"
                                :disabled="active === total - 1"
                                :class="active === total - 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                                class="p-1.5 rounded-md border border-slate-200 transition-colors"
                                aria-label="Pilar berikutnya">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Fact Sheet Entitas Operasional -->
            <div class="lg:col-span-5 bg-white p-6 sm:p-7 rounded-xl border border-slate-200 shadow-xs card-lift reveal-soft">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700">
                        DATA ENTITAS BISNIS &amp; OPERASIONAL
                    </span>
                </div>
                
                <div class="space-y-3.5 text-xs sm:text-sm">
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Nama Brand</span>
                        <span class="font-bold text-slate-900">Drainusantara</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Badan Hukum (PT)</span>
                        <span class="font-bold text-sky-800">PT JAWA JAYA ROOTER</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Induk Holding</span>
                        <span class="font-bold text-slate-800">J&amp;J Group</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Legalitas &amp; Pajak</span>
                        <span class="font-bold text-slate-900 text-right">NIB OSS &bull; PKP e-Faktur PPN</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Spesialisasi</span>
                        <span class="font-bold text-slate-900 text-right">Pipa Mampet &amp; Inspeksi CCTV</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Cakupan Posko</span>
                        <span class="font-bold text-slate-900 text-right">Jabodetabek, Semarang, Lampung</span>
                    </div>
                    <div class="pb-2.5 border-b border-slate-100 flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Waktu Operasional</span>
                        <span class="font-bold text-emerald-800">24 Jam Siaga Darurat</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Prinsip Layanan</span>
                        <span class="font-bold text-slate-900">No Cure No Pay</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 space-y-2.5">
                    <a href="{{ route('about.holding') }}" 
                       class="btn-press w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors min-h-[44px] shadow-2xs">
                        <span>Legalitas PT JAWA JAYA ROOTER &amp; Holding</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="{{ $profileWaUrl }}" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="btn-press w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs transition-colors min-h-[44px] shadow-2xs">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Konsultasi Hotline PT JAWA JAYA ROOTER</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<section id="standar-pelayanan" class="py-16 lg:py-20 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12 reveal-soft">
            <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                DISIPLIN KERJA &amp; HIGIENITAS
            </p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                4 Standar Mutu Pelayanan Teknisi Drainusantara
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Setiap kunjungan teknisi ke hunian privat maupun area komersial B2B dijalankan dengan protokol sanitasi ketat untuk melindungi kebersihan dan kenyamanan ruangan Anda.
            </p>
        </div>

        <!-- 4 Standar Mutu Pelayanan (Mobile Carousel, Tablet/Desktop Grid) -->
        <div x-data="mobileCarousel(4, 4000)">
            <div x-ref="slider" tabindex="0" role="region" aria-label="Standar pelayanan - geser untuk melihat lainnya"
                 @scroll.passive="onScroll()"
                 @touchstart="pause()"
                 @touchend="resume()"
             @touchcancel="resume()"
                 class="flex overflow-x-auto snap-x snap-mandatory no-scrollbar gap-6 pb-4 pt-1 px-1 -mx-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-2 lg:grid-cols-4 md:overflow-visible md:pb-0">
                
                <!-- Standar 01 -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-white hover:shadow-xs transition-all card-lift reveal-soft stagger-1 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Protokol APD &amp; Cover Sepatu</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Teknisi wajib mengenakan seragam resmi, sarung tangan steril, dan pelindung sepatu khusus saat melangkah ke dalam ruangan Anda guna mencegah jejak kotor.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-bold text-slate-700">
                        Perlindungan Sanitasi Ruangan
                    </div>
                </div>

                <!-- Standar 02 -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-white hover:shadow-xs transition-all card-lift reveal-soft stagger-2 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Peralatan Spiral Terkalibrasi</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Kabel spiral baja rotary dibersihkan dan disanitasi berkala pasca operasional, mencegah perpindahan kotoran atau kontaminasi silang antar lokasi kerja.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-[11px]">
                        <span class="font-bold text-slate-700">Higienitas Unit Mesin Terjaga</span>
                        <a href="{{ route('about.equipment') }}" class="font-bold text-sky-700 hover:text-sky-800 inline-flex items-center gap-1 group/link">
                            <span>Katalog Peralatan</span>
                            <svg class="w-3.5 h-3.5 transition-transform group-hover/link:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Standar 03 -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-white hover:shadow-xs transition-all card-lift reveal-soft stagger-3 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Uji Alir Air Bersama</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Sebelum pekerjaan dinyatakan selesai, teknisi melakukan tes debit air deras bersama Anda untuk memastikan pipa benar-benar plong dan lancar sempurna.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-bold text-slate-700">
                        Verifikasi Langsung di Tempat
                    </div>
                </div>

                <!-- Standar 04 -->
                <div class="w-[85vw] sm:w-[320px] md:w-auto shrink-0 snap-center bg-slate-50 p-6 rounded-xl border border-slate-200 hover:border-sky-300 hover:bg-white hover:shadow-xs transition-all card-lift reveal-soft stagger-4 flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-sky-700 flex items-center justify-center mb-4 shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Nota Garansi 30 Hari</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Penerbitan nota resmi fisik atau digital dengan nomor registrasi yang tercatat di sistem pusat. Jika mampet kembali, teknisi datang tanpa biaya tambahan.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-bold text-slate-700">
                        Jaminan Purna Jual Tertulis
                    </div>
                </div>

            </div>

            <!-- Mobile Slide Counter -->
            <div class="flex items-center justify-center gap-3 mt-4 md:hidden text-xs text-slate-500 font-mono">
                <button type="button" @click="goTo(Math.max(0, active - 1))"
                        :disabled="active === 0"
                        :class="active === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                        class="p-1.5 rounded-md border border-slate-200 transition-colors"
                        aria-label="Standar sebelumnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <span>Standar <strong class="text-slate-900" x-text="active + 1">1</strong> dari <span x-text="total"></span></span>
                <button type="button" @click="goTo(Math.min(total - 1, active + 1))"
                        :disabled="active === total - 1"
                        :class="active === total - 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-slate-100 hover:text-slate-900 cursor-pointer'"
                        class="p-1.5 rounded-md border border-slate-200 transition-colors"
                        aria-label="Standar berikutnya">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

    </div>
</section>

<!-- Subsection: Staff Kami -->
<section id="staff-kami" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200" x-data="{ activeTab: 'all' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-8 reveal-soft">
            <p class="text-xs font-bold uppercase tracking-wider text-sky-800 mb-2">
                STAFF &amp; TEKNISI DRAINUSANTARA PT JAWA JAYA ROOTER
            </p>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Staff &amp; Teknisi Lapangan Siaga
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2.5 leading-relaxed">
                Struktur organisasi terpadu dari pimpinan operasional, tim customer service dispatch, hingga teknisi pipa berlisensi yang siap melayani penanganan darurat 24 jam dengan standar kerja higienis.
            </p>
        </div>

        @php
            $staffList = $staffMembers ?? collect();

            $categorizedStaff = [
                'leader' => [],
                'staff' => [],
                'teknisi' => [],
            ];

            foreach ($staffList as $member) {
                $mRole = is_object($member) ? ($member->role ?? '') : ($member['role'] ?? '');
                $mName = is_object($member) ? ($member->name ?? '') : ($member['name'] ?? '');
                $mCat = is_object($member) ? ($member->category ?? null) : ($member['category'] ?? null);

                if (!$mCat) {
                    $lowerRole = strtolower($mRole);
                    $lowerName = strtolower($mName);
                    if (str_contains($lowerRole, 'lead') || str_contains($lowerRole, 'supervisor') || str_contains($lowerRole, 'kepala') || str_contains($lowerRole, 'koordinator') || str_contains($lowerName, 'abimanyu') || str_contains($lowerName, 'santoso') || str_contains($lowerRole, 'plumbing senior')) {
                        $mCat = 'leader';
                    } elseif (str_contains($lowerRole, 'it') || str_contains($lowerRole, 'marketing') || str_contains($lowerRole, 'customer') || str_contains($lowerRole, 'admin') || str_contains($lowerRole, 'sosial media') || str_contains($lowerRole, 'manage') || str_contains($lowerRole, 'staff')) {
                        $mCat = 'staff';
                    } else {
                        $mCat = 'teknisi';
                    }
                }
                $categorizedStaff[$mCat][] = $member;
            }
        @endphp

        @if(count($staffList) === 0)
            <div class="p-8 sm:p-12 text-center bg-white rounded-xl border border-dashed border-slate-300">
                <div class="w-12 h-12 mx-auto rounded-full bg-sky-50 text-sky-700 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-sm sm:text-base font-bold text-slate-900">Daftar Staff &amp; Teknisi Lapangan Sedang Diperbarui</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-md mx-auto">
                    Seluruh teknisi Drainusantara bersertifikasi K3, berseragam rapi, dan siaga 24 jam melayani penanganan saluran pipa mampet di seluruh posko operasional.
                </p>
            </div>
        @else
        <!-- Simple Clean Tabs (No AI Slop Dots or Badges) -->
        <div class="flex flex-wrap items-center gap-2 mb-8 border-b border-slate-200">
            <button type="button" 
                    @click="activeTab = 'all'"
                    :class="activeTab === 'all' ? 'border-b-2 border-slate-900 text-slate-900 font-bold pb-3 px-3' : 'text-slate-600 hover:text-slate-900 pb-3 px-3'"
                    class="text-xs transition-colors cursor-pointer">
                Semua Bagian ({{ count($staffList) }})
            </button>
            <button type="button" 
                    @click="activeTab = 'leader'"
                    :class="activeTab === 'leader' ? 'border-b-2 border-sky-800 text-sky-800 font-bold pb-3 px-3' : 'text-slate-600 hover:text-slate-900 pb-3 px-3'"
                    class="text-xs transition-colors cursor-pointer">
                1. Leader ({{ count($categorizedStaff['leader']) }})
            </button>
            <button type="button" 
                    @click="activeTab = 'staff'"
                    :class="activeTab === 'staff' ? 'border-b-2 border-indigo-800 text-indigo-800 font-bold pb-3 px-3' : 'text-slate-600 hover:text-slate-900 pb-3 px-3'"
                    class="text-xs transition-colors cursor-pointer">
                2. Staff &amp; Dispatch ({{ count($categorizedStaff['staff']) }})
            </button>
            <button type="button" 
                    @click="activeTab = 'teknisi'"
                    :class="activeTab === 'teknisi' ? 'border-b-2 border-emerald-800 text-emerald-800 font-bold pb-3 px-3' : 'text-slate-600 hover:text-slate-900 pb-3 px-3'"
                    class="text-xs transition-colors cursor-pointer">
                3. Teknisi Lapangan ({{ count($categorizedStaff['teknisi']) }})
            </button>
        </div>

        <!-- Bagian 1: Leader -->
        <div x-show="activeTab === 'all' || activeTab === 'leader'" x-cloak class="mb-10">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-200">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900">1. Pimpinan &amp; Koordinator Operasional (Leader)</h3>
                <span class="text-xs text-slate-500 font-medium">{{ count($categorizedStaff['leader']) }} orang</span>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($categorizedStaff['leader'] as $member)
                    @php
                        $mName = is_object($member) ? $member->name : ($member['name'] ?? '');
                        $mRole = is_object($member) ? ($member->role ?? 'Lead Koordinator') : ($member['role'] ?? 'Lead Koordinator');
                        $mPhoto = is_object($member) ? $member->photo : ($member['photo'] ?? null);
                        $mInitials = is_object($member) ? $member->initials : ($member['initials'] ?? 'LD');
                    @endphp
                    <div class="bg-white p-4 rounded-lg border border-slate-200 hover:border-slate-300 transition-all flex flex-col items-center text-center">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 mb-3 flex items-center justify-center">
                            @if(!empty($mPhoto))
                                <img src="{{ $mPhoto }}" alt="{{ $mName }}" width="96" height="96" loading="lazy" decoding="async" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold uppercase text-slate-500 font-mono">{{ $mInitials }}</span>
                            @endif
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight line-clamp-1">
                            {{ $mName }}
                        </h4>
                        <p class="text-[11px] text-slate-600 mt-1 line-clamp-2">
                            {{ $mRole }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bagian 2: Staff -->
        <div x-show="activeTab === 'all' || activeTab === 'staff'" x-cloak class="mb-10">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-200">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900">2. Staff Dispatch &amp; Layanan Pelanggan (Staff)</h3>
                <span class="text-xs text-slate-500 font-medium">{{ count($categorizedStaff['staff']) }} orang</span>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($categorizedStaff['staff'] as $member)
                    @php
                        $mName = is_object($member) ? $member->name : ($member['name'] ?? '');
                        $mRole = is_object($member) ? ($member->role ?? 'Staff Operasional') : ($member['role'] ?? 'Staff Operasional');
                        $mPhoto = is_object($member) ? $member->photo : ($member['photo'] ?? null);
                        $mInitials = is_object($member) ? $member->initials : ($member['initials'] ?? 'ST');
                    @endphp
                    <div class="bg-white p-4 rounded-lg border border-slate-200 hover:border-slate-300 transition-all flex flex-col items-center text-center">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 mb-3 flex items-center justify-center">
                            @if(!empty($mPhoto))
                                <img src="{{ $mPhoto }}" alt="{{ $mName }}" width="96" height="96" loading="lazy" decoding="async" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold uppercase text-slate-500 font-mono">{{ $mInitials }}</span>
                            @endif
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight line-clamp-1">
                            {{ $mName }}
                        </h4>
                        <p class="text-[11px] text-slate-600 mt-1 line-clamp-2">
                            {{ $mRole }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Bagian 3: Teknisi -->
        <div x-show="activeTab === 'all' || activeTab === 'teknisi'" x-cloak class="mb-4">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-200">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900">3. Teknisi Lapangan Berpengalaman (Teknisi)</h3>
                <span class="text-xs text-slate-500 font-medium">{{ count($categorizedStaff['teknisi']) }} orang</span>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($categorizedStaff['teknisi'] as $member)
                    @php
                        $mName = is_object($member) ? $member->name : ($member['name'] ?? '');
                        $mRole = is_object($member) ? ($member->role ?? 'Teknisi Lapangan') : ($member['role'] ?? 'Teknisi Lapangan');
                        $mPhoto = is_object($member) ? $member->photo : ($member['photo'] ?? null);
                        $mInitials = is_object($member) ? $member->initials : ($member['initials'] ?? 'TK');
                    @endphp
                    <div class="bg-white p-4 rounded-lg border border-slate-200 hover:border-slate-300 transition-all flex flex-col items-center text-center">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden bg-slate-100 border border-slate-200 mb-3 flex items-center justify-center">
                            @if(!empty($mPhoto))
                                <img src="{{ $mPhoto }}" alt="{{ $mName }}" width="96" height="96" loading="lazy" decoding="async" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold uppercase text-slate-500 font-mono">{{ $mInitials }}</span>
                            @endif
                        </div>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 tracking-tight line-clamp-1">
                            {{ $mName }}
                        </h4>
                        <p class="text-[11px] text-slate-600 mt-1 line-clamp-2">
                            {{ $mRole }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

<!-- Subsection: Peralatan & Teknologi Armada -->
<x-area.equipment-section 
    title="Peralatan Mekanis & Diagnosis Visual Armada" 
    eyebrow="STANDAR PERALATAN TEKNISI" 
    bg-color="bg-white" 
/>

<section id="ekosistem" class="py-14 lg:py-16 bg-slate-900 text-white relative overflow-hidden reveal-soft">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-2">
                    BADAN HUKUM RESMI: PT JAWA JAYA ROOTER
                </p>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                    Solusi Sanitasi Pipa Bergaransi &amp; Kemitraan Korporat B2B
                </h2>
                <p class="text-slate-300 text-xs sm:text-sm mt-2 leading-relaxed">
                    Dikelola secara profesional oleh <strong>PT JAWA JAYA ROOTER</strong> (holding J&amp;J Group). Kami melayani proyek tender, SPK berkala pengelola gedung perkantoran, hotel, restoran, hingga panggilan darurat saluran perumahan dengan standar mekanis tanpa bongkar.
                </p>
            </div>
            
            <div class="shrink-0 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode('Halo Tim Legal & Operasional PT JAWA JAYA ROOTER, kami bermaksud mendiskusikan pengadaan jasa pemeliharaan pipa / kerja sama B2B.') }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="min-h-[44px] inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-lg shadow-sm transition-all btn-press focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Kerja Sama B2B PT JAWA JAYA ROOTER</span>
                </a>
                <a href="{{ route('about.holding') }}" 
                   class="min-h-[44px] inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs sm:text-sm px-5 py-3 rounded-lg border border-slate-700 transition-colors btn-press focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-600">
                    <span>Struktur Korporat Holding</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
