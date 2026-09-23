<!-- Mega Footer 6 Kolom Terstruktur (Swiss Industrial Engineering) -->
<footer class="bg-slate-900 text-slate-300 pt-16 pb-28 md:pb-12 border-t border-slate-800" id="footer-workshop">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 mb-12">
            <!-- Kolom 1: Workshop & Alamat Utama -->
            <div class="space-y-4 lg:col-span-1">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-slate-800 border border-slate-700 text-white flex items-center justify-center font-extrabold text-xs shadow-xs">
                        DN
                    </div>
                    <span class="text-base font-extrabold tracking-tight text-white">
                        DRAIN<span class="text-red-500">NUSANTARA</span>
                    </span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Pusat rekayasa pelancaran pipa mampet profesional tanpa bongkar keramik. Dilengkapi kamera inspeksi CCTV pipa 30M dan garansi resmi 30 hari.
                </p>
                <div class="text-xs text-slate-400 space-y-1 pt-1 font-mono">
                    <div class="text-slate-200 font-bold">WORKSHOP PUSAT:</div>
                    <p class="leading-relaxed text-[11px]">Jl. Duren Sawit Raya No. 45, Jakarta Timur / Posko Siaga Jabodetabek</p>
                </div>
            </div>

            <!-- Kolom 2: Layanan Residensial -->
            <div>
                <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-blue-400 mb-4 border-b border-slate-800 pb-2">Residensial</h3>
                <ul class="space-y-2 text-xs text-slate-400">
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Wastafel & Sink Dapur</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Kloset & Toilet Duduk/Jongkok</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Floor Drain Kamar Mandi</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Bak Kontrol & Pipa Pembuangan</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Pipa Pembuangan Mesin Cuci</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Solusi B2B & Gedung -->
            <div>
                <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-blue-400 mb-4 border-b border-slate-800 pb-2">Solusi B2B & Gedung</h3>
                <ul class="space-y-2 text-xs text-slate-400">
                    <li><a href="{{ url('/#b2b') }}" class="hover:text-white transition-colors">Sedot Lemak Grease Trap Resto</a></li>
                    <li><a href="{{ url('/#b2b') }}" class="hover:text-white transition-colors">Talang Hujan & Pipa Rooftop</a></li>
                    <li><a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors">Inspeksi Kamera CCTV 30M</a></li>
                    <li><a href="{{ url('/#b2b') }}" class="hover:text-white transition-colors">Kontrak Maintenance Rutin</a></li>
                    <li><a href="{{ url('/#b2b') }}" class="hover:text-white transition-colors">Faktur Pajak & Penagihan Resmi</a></li>
                </ul>
            </div>

            <!-- Kolom 4: Area Jangkauan Jabodetabek -->
            <div>
                <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-blue-400 mb-4 border-b border-slate-800 pb-2">Wilayah Jabodetabek</h3>
                <ul class="space-y-1.5 text-xs text-slate-400">
                    <li><a href="{{ route('area.province', ['province' => 'dki-jakarta']) }}" class="hover:text-white font-semibold text-blue-300">Provinsi DKI Jakarta &rarr;</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-timur']) }}" class="hover:text-white">Jakarta Timur</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-selatan']) }}" class="hover:text-white">Jakarta Selatan</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-barat']) }}" class="hover:text-white">Jakarta Barat</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-utara']) }}" class="hover:text-white">Jakarta Utara</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'jakarta-pusat']) }}" class="hover:text-white">Jakarta Pusat</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'bogor']) }}" class="hover:text-white">Bogor & Sentul</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'depok-cinere']) }}" class="hover:text-white">Depok & Cinere</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'tangerang-selatan']) }}" class="hover:text-white">Tangerang & Tangsel</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'bekasi-cikarang']) }}" class="hover:text-white">Bekasi & Cikarang</a></li>
                </ul>
            </div>

            <!-- Kolom 5: Hub Kota Lain -->
            <div>
                <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-blue-400 mb-4 border-b border-slate-800 pb-2">Provinsi & Hub Lain</h3>
                <ul class="space-y-2 text-xs text-slate-400">
                    <li><a href="{{ route('area.province', ['province' => 'jawa-barat']) }}" class="hover:text-white font-semibold text-blue-300">Provinsi Jawa Barat</a></li>
                    <li><a href="{{ route('area.province', ['province' => 'banten']) }}" class="hover:text-white font-semibold text-blue-300">Provinsi Banten</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'bandung']) }}" class="hover:text-white">Kota Bandung</a></li>
                    <li><a href="{{ route('area.province', ['province' => 'jawa-tengah']) }}" class="hover:text-white font-semibold text-blue-300">Provinsi Jawa Tengah</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'semarang']) }}" class="hover:text-white">Kota Semarang</a></li>
                    <li><a href="{{ route('area.province', ['province' => 'lampung']) }}" class="hover:text-white font-semibold text-blue-300">Provinsi Lampung</a></li>
                    <li><a href="{{ route('area.city', ['city' => 'bandar-lampung']) }}" class="hover:text-white">Bandar Lampung</a></li>
                    <li class="pt-2">
                        <a href="{{ route('area.index') }}" class="inline-flex items-center gap-1 text-[11px] font-mono text-blue-400 hover:text-blue-300 underline">
                            Lihat Semua Area &rarr;
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 6: Legalitas & K3 -->
            <div>
                <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-blue-400 mb-4 border-b border-slate-800 pb-2">Legalitas & K3</h3>
                <div class="space-y-2.5 text-xs text-slate-400">
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-500 font-bold select-none">[✓]</span>
                        <span>Badan Usaha Resmi Terdaftar</span>
                    </div>
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-500 font-bold select-none">[✓]</span>
                        <span>Garansi Tertulis 30 Hari Kerja</span>
                    </div>
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-500 font-bold select-none">[✓]</span>
                        <span>Teknisi Bersepatu & APD Steril</span>
                    </div>
                    <div class="flex items-start gap-1.5">
                        <span class="text-emerald-500 font-bold select-none">[✓]</span>
                        <span>Tanpa Kimia / Bebas Soda Api</span>
                    </div>
                    <div class="pt-2">
                        <a :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent('Halo Admin Drainusantara, saya ingin konsultasi teknis.')" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-3.5 py-2.5 rounded-xl border border-emerald-600 shadow-xs transition-colors">
                            <span>Hubungi CS Dispatch</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peta Workshop & Disclaimer Anti-Soda Api Bar -->
        <div class="mb-10 p-5 rounded-2xl bg-slate-800/80 border border-slate-700/80 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            <!-- Map Embed Preview -->
            <div class="lg:col-span-4 rounded-xl overflow-hidden border border-slate-700 aspect-[16/9] bg-slate-950 relative">
                <iframe 
                    title="Peta Posko Siaga Drainusantara"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.28318721204!2d106.82056!3d-6.2297464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e46c757c23%3A0xa6436e2f694dc50!2sJakarta%20Timur%2C%20Kota%20Jakarta%20Timur%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                    class="w-full h-full border-0 grayscale contrast-125 opacity-80 hover:opacity-100 transition-opacity" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="absolute bottom-2 left-2 bg-slate-900/90 text-white text-[10px] font-mono px-2 py-0.5 rounded-xs border border-slate-700">
                    📍 Posko Siaga 24 Jam
                </div>
            </div>

            <!-- 24 Jam Operasional & Anti-Soda Api Disclaimer -->
            <div class="lg:col-span-8 space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        OPERASIONAL 24 JAM &bull; TANGGAL MERAH TETAP BUKA
                    </span>
                    <span class="text-xs text-slate-400 font-mono">Respon Darurat &lt; 15 Menit</span>
                </div>

                <div class="p-3.5 rounded-xl bg-red-950/40 border border-red-900/60 text-xs text-red-200/90 leading-relaxed font-mono">
                    <strong class="text-red-400 font-bold block mb-1">⚠️ AUDIT KESELAMATAN PIPA (PERINGATAN SODA API):</strong>
                    Menumpuk soda api (NaOH) atau asam sulfat pada pipa PVC memicu reaksi eksotermik di atas 90°C yang melunakkan paralon, melelehkan sambungan lem, dan memicu reaksi saponifikasi (minyak membatu). Drainusantara hanya menggunakan metode mekanis spiral baja lentur dan inspeksi visual CCTV sonar IP68.
                </div>
            </div>
        </div>

        <!-- Footer Bottom Note -->
        <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-slate-500 font-mono">
            <p>&copy; {{ date('Y') }} Drainusantara. Precision Pipe & Drainage Engineering. Toleransi 0% Kerusakan Ubin & Tanpa Soda Api.</p>
            <div class="flex items-center gap-4 text-slate-400">
                <span>Spiral Rotary Elektrik</span>
                <span>&bull;</span>
                <span>CCTV IP68 30M</span>
                <span>&bull;</span>
                <span>Garansi Nota 30 Hari</span>
            </div>
        </div>
    </div>
</footer>
