<footer class="bg-slate-900 text-slate-300 pt-12 pb-24 md:pb-12 border-t border-slate-800" id="footer-workshop">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Section: 3 Kolom Ringkas & Berbobot (Fokus Informasi Inti & Kredibilitas) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10 mb-10 pb-10 border-b border-slate-800/80">
            <!-- Kolom 1: Profil & Workshop Pusat -->
            <div class="space-y-3.5">
                <a href="{{ url('/') }}" class="inline-block max-w-full rounded-sm focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-400">
                    <img src="{{ asset('images/logo/LOGOFULL.webp') }}" alt="Drainusantara" class="block h-auto w-52 max-w-full object-contain" width="687" height="363" loading="lazy" decoding="async">
                </a>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Spesialis pelancaran saluran pipa mampet mekanis profesional 100% tanpa bongkar keramik dan bebas bahan kimia korosif soda api.
                </p>
                <div class="pt-1 text-xs text-slate-400 space-y-1">
                    <div class="text-slate-200 font-bold uppercase text-[11px] tracking-wider">Workshop Pusat:</div>
                    <p class="leading-relaxed">Jl. Duren Sawit Raya No. 45, Duren Sawit, Jakarta Timur 13440</p>
                    <div class="text-[11px] text-emerald-400 font-semibold pt-0.5">
                        Siaga 24 Jam Nonstop
                    </div>
                </div>
            </div>

            <!-- Kolom 2: Jaminan Layanan & Standar Resmi -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-3.5 pb-2 border-b border-slate-800">Standar Mutu &amp; Jaminan</h3>
                <ul class="space-y-2.5 text-xs text-slate-300">
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>Sistem <strong>No Cure No Pay</strong> (Air lancar baru bayar)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>Garansi Tertulis 30 Hari Kalender</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>100% Tanpa Bongkar Keramik Lantai</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>Zero Chemical / Bebas Soda Api Korosif</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-400 font-bold select-none">[✓]</span>
                        <span>e-Faktur Pajak PPN &amp; Dokumen BAST B2B</span>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: Layanan Dispatch & Bantuan Cepat -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-3.5 pb-2 border-b border-slate-800">Dispatch Siaga 24 Jam</h3>
                <p class="text-xs text-slate-400 leading-relaxed mb-3.5">
                    Saluran air meluap darurat atau butuh survei grease trap gedung? Penugasan teknisi terdekat langsung dari posko siaga untuk respon cepat.
                </p>
                <div class="space-y-2.5">
                    <a href="https://wa.me/{{ config('app.whatsapp_number') ?: '6285609009009' }}?text={{ rawurlencode('Halo Admin Drainusantara, saya membutuhkan info teknisi terdekat untuk penanganan saluran mampet.') }}"
                       :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saya membutuhkan info teknisi terdekat untuk penanganan saluran mampet.')"
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg border border-emerald-800 shadow-xs transition-colors btn-press">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Chat WhatsApp Dispatch</span>
                    </a>
                    <div class="text-[11px] text-slate-400">
                        Posko respon darurat se-Jabodetabek, Semarang, &amp; Lampung
                    </div>
                </div>
            </div>
        </div>

        <!-- Peta Workshop & Pusat Informasi Posko Siaga Terpadu -->
        <div class="mb-10 p-5 sm:p-6 rounded-lg bg-slate-800/80 border border-slate-700/80 grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            <!-- Map Embed Preview (4 Kolom) -->
            <div class="lg:col-span-4 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-700/70 text-slate-200 text-xs font-semibold border border-slate-600">
                            <span>Workshop &amp; Gudang Armada</span>
                        </span>
                        <span class="text-[11px] font-semibold text-slate-400">Jakarta Timur</span>
                    </div>
                    <div class="rounded-lg overflow-hidden border border-slate-700 aspect-16/10 bg-slate-950 relative shadow-inner">
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

            <!-- Informasi Posko Siaga & Kelengkapan Armada (8 Kolom) -->
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
                    <div class="p-3.5 rounded-lg bg-slate-900/70 border border-slate-700/70 flex flex-col justify-between">
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
                    <div class="p-3.5 rounded-lg bg-slate-900/70 border border-slate-700/70 flex flex-col justify-between">
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
                    <div class="p-3.5 rounded-lg bg-slate-900/70 border border-slate-700/70 flex flex-col justify-between">
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
                <div class="p-3.5 bg-slate-900/90 rounded-lg border border-slate-700/70 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2.5 text-slate-300">
                        <svg class="w-5 h-5 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Saluran pipa meluap mendesak atau butuh survei grease trap gedung? Teknisi kami siap meluncur dari posko terdekat.</span>
                    </div>
                    <a href="https://wa.me/{{ config('app.whatsapp_number') ?: '6285609009009' }}?text={{ rawurlencode('Halo Admin Drainusantara, saya membutuhkan info kedatangan teknisi ke alamat saya.') }}"
                       :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saya membutuhkan info kedatangan teknisi ke alamat saya.')"
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="shrink-0 inline-flex items-center gap-2 px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-lg transition-colors shadow-2xs btn-press">
                        <span>Hubungi Dispatch WhatsApp</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Note -->
        <div class="pt-6 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-slate-400">
            <p>&copy; {{ date('Y') }} Drainusantara. Rooter &amp; Plumbing Engineering. 100% Tanpa Bongkar Keramik &amp; Bebas Bahan Kimia Korosif.</p>
            <div class="flex items-center gap-4 text-slate-400 text-[11px]">
                <a href="{{ route('about.warranty') }}" class="hover:text-white transition-colors">Ketentuan Garansi</a>
                <span>&bull;</span>
                <a href="{{ route('about.k3') }}" class="hover:text-white transition-colors">Standar K3</a>
                <span>&bull;</span>
                <a href="{{ route('about.faq') }}" class="hover:text-white transition-colors">FAQ</a>
            </div>
        </div>
    </div>
</footer>
