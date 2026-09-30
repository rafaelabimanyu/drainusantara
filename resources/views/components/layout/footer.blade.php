<footer class="content-auto bg-slate-900 text-slate-300 pt-16 pb-28 md:pb-12 border-t border-slate-800" id="footer-workshop">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 mb-12">
            <!-- Kolom 1: Workshop Pusat & Identitas Legal -->
            <div class="space-y-4 lg:col-span-1">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-sky-600 text-white flex items-center justify-center font-extrabold text-sm shadow-xs">
                        DN
                    </div>
                    <div>
                        <span class="text-base font-extrabold tracking-tight text-white block">DRAINUSANTARA</span>
                        <span class="text-[10px] text-sky-400 font-semibold block tracking-wider uppercase">Plumbing &amp; Rooter Engineering</span>
                    </div>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Layanan spesialis pelancaran pipa mampet mekanik profesional 100% tanpa bongkar keramik dan bebas bahan kimia korosif. Menggunakan mesin spiral baja torsi tinggi serta kamera inspeksi endoskopi CCTV 30 meter.
                </p>
                <div class="text-xs text-slate-400 space-y-1.5 pt-1">
                    <div class="text-slate-200 font-bold uppercase text-[11px] tracking-wider text-sky-400">Workshop &amp; Posko Pusat:</div>
                    <p class="leading-relaxed">Jl. Duren Sawit Raya No. 45, Duren Sawit, Jakarta Timur 13440</p>
                    <div class="pt-1 text-[11px] text-emerald-400 font-semibold">
                        Siaga 24 Jam Nonstop
                    </div>
                </div>
            </div>

            <!-- Kolom 2: Layanan Residensial (Rumah & Ruko) -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Layanan Residensial</h3>
                <ul class="space-y-2 text-xs text-slate-400">
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white hover:text-sky-300 transition-colors">Wastafel &amp; Sink Cuci Piring</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white hover:text-sky-300 transition-colors">Kloset &amp; Toilet Duduk/Jongkok</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white hover:text-sky-300 transition-colors">Floor Drain Kamar Mandi</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white hover:text-sky-300 transition-colors">Bak Kontrol Pipa Pembuangan</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white hover:text-sky-300 transition-colors">Talang Air Hujan Rooftop / Dak</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white hover:text-sky-300 transition-colors">Pipa Buang Mesin Cuci</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white hover:text-sky-300 transition-colors">Inspeksi Kamera CCTV 30M</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Solusi B2B & Gedung -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Solusi B2B &amp; Gedung</h3>
                <ul class="space-y-2 text-xs text-slate-400">
                    <li><a href="{{ url('/#portofolio-b2b') }}" class="hover:text-white hover:text-sky-300 transition-colors">De-Greasing Grease Trap Restoran</a></li>
                    <li><a href="{{ url('/#portofolio-b2b') }}" class="hover:text-white hover:text-sky-300 transition-colors">Pembersihan Manhole Komunal Tenant</a></li>
                    <li><a href="{{ url('/#portofolio-b2b') }}" class="hover:text-white hover:text-sky-300 transition-colors">Pipa Vertikal Gedung Bertingkat</a></li>
                    <li><a href="{{ url('/#portofolio-b2b') }}" class="hover:text-white hover:text-sky-300 transition-colors">Saluran Limbah Dapur Industri</a></li>
                    <li><a href="{{ url('/#portofolio-b2b') }}" class="hover:text-white hover:text-sky-300 transition-colors">Perawatan Berkala After-Hours</a></li>
                    <li><a href="{{ url('/#portofolio-b2b') }}" class="hover:text-white hover:text-sky-300 transition-colors">e-Faktur Pajak &amp; Berita Acara (BAST)</a></li>
                    <li class="pt-1"><a href="{{ route('about.portfolio') }}" class="text-sky-400 hover:text-sky-300 font-semibold inline-flex items-center gap-1">Portofolio Mitra B2B</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Area Jangkauan Jabodetabek -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Posko Jabodetabek</h3>
                <ul class="space-y-1.5 text-xs text-slate-400">
                    <li><a href="{{ route('area.province', ['province' => 'dki-jakarta']) }}" class="hover:text-white font-semibold text-sky-300">Provinsi DKI Jakarta</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-selatan']) }}" class="hover:text-white">Jakarta Selatan (Tebet &amp; Cilandak)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-timur']) }}" class="hover:text-white">Jakarta Timur (Duren Sawit)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-barat']) }}" class="hover:text-white">Jakarta Barat (Kebon Jeruk &amp; Puri)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-utara']) }}" class="hover:text-white">Jakarta Utara (Kelapa Gading &amp; PIK)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-pusat']) }}" class="hover:text-white">Jakarta Pusat (Kemayoran)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'tangerang-selatan']) }}" class="hover:text-white">Tangerang Selatan (BSD &amp; Bintaro)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'tangerang-kota']) }}" class="hover:text-white">Tangerang Kota (Karawaci &amp; Ciledug)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'bekasi-cikarang']) }}" class="hover:text-white">Bekasi &amp; Cikarang Industri</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'depok-cinere']) }}" class="hover:text-white">Depok &amp; Cinere (Margonda)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'bogor']) }}" class="hover:text-white">Bogor &amp; Sentul City</a></li>
                </ul>
            </div>

            <!-- Kolom 5: Hub Luar Kota & Edukasi Sanitasi -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Hub Regional &amp; Edukasi</h3>
                <ul class="space-y-2 text-xs text-slate-400">
                    <li><a href="{{ route('area.province', ['province' => 'jawa-tengah']) }}" class="hover:text-white font-semibold text-sky-300">Provinsi Jawa Tengah</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'semarang']) }}" class="hover:text-white">Kota Semarang (Candisari &amp; Tembalang)</a></li>
                    <li><a href="{{ route('area.province', ['province' => 'lampung']) }}" class="hover:text-white font-semibold text-sky-300">Provinsi Lampung</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'bandar-lampung']) }}" class="hover:text-white">Bandar Lampung (Kedaton &amp; Tjg. Karang)</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'bandung']) }}" class="hover:text-white">Kota Bandung (Jawa Barat)</a></li>
                    <li class="pt-1"><a href="{{ route('articles.index') }}" class="hover:text-white font-semibold text-sky-300">Artikel &amp; Edukasi Sanitasi</a></li>
                    <li><a href="{{ route('gallery') }}" class="hover:text-white">Galeri Bukti Before &amp; After</a></li>
                    <li class="pt-1">
                        <a href="{{ route('area.index') }}" class="inline-flex items-center gap-1 text-[11px] text-sky-400 hover:text-sky-300 underline font-medium">
                            Indeks Lengkap 38 Area
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 6: Standar Mutu, K3 & Legalitas -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-4 border-b border-slate-800 pb-2">Standar Mutu &amp; K3</h3>
                <div class="space-y-2.5 text-xs text-slate-400">
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>Sistem No Cure No Pay</span>
                    </div>
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>Garansi Tertulis 30 Hari Kerja</span>
                    </div>
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>100% Tanpa Bongkar Keramik</span>
                    </div>
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>Zero Chemical / Bebas Soda Api</span>
                    </div>
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>Teknisi Bersepatu &amp; APD Steril</span>
                    </div>
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>Faktur Pajak B2B &amp; Dokumen BAST</span>
                    </div>
                    <div class="pt-2">
                        <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saya ingin konsultasi penanganan saluran pipa mampet.')" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl border border-emerald-700 shadow-sm transition-colors cursor-pointer">
                            <span>Konsultasi CS Siaga</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peta Workshop & Pusat Informasi Posko Siaga Terpadu -->
        <div class="mb-10 p-5 sm:p-6 rounded-xl bg-slate-800/80 border border-slate-700/80 grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            <!-- Map Embed Preview (4 Kolom) -->
            <div class="lg:col-span-4 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-700/70 text-slate-200 text-xs font-semibold border border-slate-600">
                            <span>Workshop &amp; Gudang Armada</span>
                        </span>
                        <span class="text-[11px] font-semibold text-slate-400">Jakarta Timur</span>
                    </div>
                    <div class="rounded-xl overflow-hidden border border-slate-700 aspect-[16/10] bg-slate-950 relative shadow-inner">
                        <iframe 
                            title="Peta Lokasi Workshop Pusat Drainusantara"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.28318721204!2d106.82056!3d-6.2297464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e46c757c23%3A0xa6436e2f694dc50!2sJakarta%20Timur%2C%20Kota%20Jakarta%20Timur%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                            class="w-full h-full border-0 contrast-125 opacity-90 hover:opacity-100 transition-opacity" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <div class="absolute bottom-2 left-2 right-2 bg-slate-950/90 backdrop-blur-xs text-white text-[11px] p-2 rounded-lg border border-slate-700 flex items-center justify-between">
                            <span class="truncate">📍 Jl. Duren Sawit Raya No. 45, Jaktim</span>
                            <a href="https://maps.google.com/?q=Jakarta+Timur" target="_blank" rel="noopener noreferrer" class="text-sky-400 hover:text-sky-300 font-semibold shrink-0 ml-2">Buka Peta ↗</a>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-3 leading-relaxed">
                    Pusat perawatan mesin rooter spiral, kalibrasi kamera inspeksi CCTV pipa, serta posko pemberangkatan armada teknisi siaga ke seluruh wilayah Jabodetabek.
                </p>
            </div>

            <!-- Informasi Posko Siaga & Kelengkapan Armada (8 Kolom) - Menggantikan Kotak Disclaimer Lama -->
            <div class="lg:col-span-8 flex flex-col justify-between space-y-4">
                <!-- Top Operational Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-700/80">
                    <div>
                        <h3 class="text-sm sm:text-base font-bold text-white tracking-tight">
                            Posko Siaga Armada &amp; Spesifikasi Tindakan Lapangan
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Penugasan teknisi terdekat langsung dari posko siaga masing-masing kota untuk respon cepat.</p>
                    </div>
                    <div class="inline-flex items-center px-3 py-1 bg-emerald-500/15 border border-emerald-500/30 rounded-md text-emerald-400 text-xs font-semibold shrink-0">
                        <span>Siaga 24 Jam Nonstop</span>
                    </div>
                </div>

                <!-- 3 Structured Operational Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Card 1: Jaringan Posko Terdekat -->
                    <div class="p-3.5 rounded-xl bg-slate-900/70 border border-slate-700/70 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-sky-400 font-bold text-xs mb-2">
                                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Jaringan Posko Siaga</span>
                            </div>
                            <ul class="text-[11px] text-slate-300 space-y-1.5 leading-snug">
                                <li><strong class="text-white">DKI Jakarta:</strong> Duren Sawit, Tebet, Kebon Jeruk, Kelapa Gading</li>
                                <li><strong class="text-white">BODETABEK:</strong> BSD, Bintaro, Karawaci, Margonda, Sentul, Cikarang</li>
                                <li><strong class="text-white">Jawa Tengah:</strong> Candisari &amp; Banyumanik, Semarang</li>
                                <li><strong class="text-white">Lampung:</strong> Kedaton &amp; Tjg. Karang, Bandar Lampung</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-2.5 border-t border-slate-800 text-[10px] text-slate-400 font-medium">
                            Koordinasi Cepat via WhatsApp
                        </div>
                    </div>

                    <!-- Card 2: Alat Kerja Standar Industri -->
                    <div class="p-3.5 rounded-xl bg-slate-900/70 border border-slate-700/70 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-sky-400 font-bold text-xs mb-2">
                                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Kelengkapan Alat Armada</span>
                            </div>
                            <ul class="text-[11px] text-slate-300 space-y-1.5 leading-snug">
                                <li><strong class="text-white">Mesin Rooter Elektrik:</strong> Spiral baja lentur 16mm &amp; 22mm hingga 30+ meter</li>
                                <li><strong class="text-white">Kamera Inspeksi CCTV:</strong> Monitor HD IP68 tahan air untuk deteksi endapan</li>
                                <li><strong class="text-white">Mata Pisau Khusus:</strong> Cutter lemak beku, pengait kain/tisu, pemotong akar</li>
                                <li><strong class="text-white">Perlindungan APD:</strong> Sepatu pelindung &amp; sanitasi pasca pengerjaan</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-2.5 border-t border-slate-800 text-[10px] text-slate-400 font-medium">
                            100% Mekanis Bebas Bahan Kimia
                        </div>
                    </div>

                    <!-- Card 3: Garansi & Transparansi Biaya -->
                    <div class="p-3.5 rounded-xl bg-slate-900/70 border border-slate-700/70 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-emerald-400 font-bold text-xs mb-2">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                <span>Jaminan Layanan &amp; Biaya</span>
                            </div>
                            <ul class="text-[11px] text-slate-300 space-y-1.5 leading-snug">
                                <li><strong class="text-white">No Cure No Pay:</strong> Biaya jasa hanya dibayar jika air buangan lancar tuntas</li>
                                <li><strong class="text-white">Garansi 30 Hari:</strong> Dilengkapi surat garansi fisik &amp; digital tertulis</li>
                                <li><strong class="text-white">Tanpa Biaya Tersembunyi:</strong> Estimasi harga disepakati sebelum tindakan</li>
                                <li><strong class="text-white">Kelengkapan B2B:</strong> Invoice resmi, e-Faktur Pajak PPN &amp; Berita Acara</li>
                            </ul>
                        </div>
                        <div class="mt-3 pt-2.5 border-t border-slate-800 text-[10px] text-slate-400 font-medium">
                            Surat Garansi Resmi Bermeterai
                        </div>
                    </div>
                </div>

                <!-- Bottom Action Bar: Respon Cepat -->
                <div class="p-3.5 bg-slate-900/90 rounded-xl border border-slate-700/70 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2.5 text-slate-300">
                        <svg class="w-5 h-5 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Saluran pipa meluap mendesak atau butuh survei grease trap gedung? Teknisi kami siap meluncur dari posko terdekat.</span>
                    </div>
                    <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saya membutuhkan info kedatangan teknisi ke alamat saya.')" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-colors shadow-2xs">
                        <span>Hubungi Dispatch WhatsApp</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Note -->
        <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-slate-500">
            <p>&copy; {{ date('Y') }} Drainusantara. Rooter &amp; Plumbing Engineering. 100% Tanpa Bongkar Keramik &amp; Tanpa Bahan Kimia Korosif.</p>
            <div class="flex items-center gap-4 text-slate-400">
                <span>Spiral Baja Elektrik</span>
                <span>&bull;</span>
                <span>CCTV IP68 30M</span>
                <span>&bull;</span>
                <span>Garansi Resmi 30 Hari</span>
            </div>
        </div>
    </div>
</footer>
