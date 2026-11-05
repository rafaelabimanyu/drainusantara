<footer class="bg-slate-900 text-slate-300 pt-12 pb-24 md:pb-12 border-t border-slate-800" id="footer-workshop">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- 4 Kolom Ramping, Terstruktur & Kaya Informasi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10 pb-10 border-b border-slate-800">
            
            <!-- Kolom 1: Profil & Hotline & Social Media -->
            <div class="space-y-4">
                <a href="{{ url('/') }}" class="inline-block max-w-full rounded-sm focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-sky-400">
                    <img src="{{ asset('images/logo/LOGOFULL.webp') }}" alt="Drainusantara - PT Jawa Jaya Rooter" class="block h-auto w-48 max-w-full object-contain" width="687" height="363" loading="lazy" decoding="async">
                </a>
                <p class="text-xs font-bold text-white tracking-wide">
                    PT JAWA JAYA ROOTER
                </p>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Spesialis pelancaran saluran pipa mampet mekanis profesional 100% tanpa bongkar keramik lantai dan bebas bahan kimia berbahaya soda api.
                </p>
                
                <div class="pt-1 text-xs text-slate-400 space-y-1">
                    <div class="text-slate-200 font-bold uppercase text-[11px] tracking-wider">Hotline &amp; Dispatch 24 Jam:</div>
                    <a href="tel:085609009009" class="text-sky-400 hover:text-sky-300 font-bold text-xs inline-flex items-center gap-1.5 transition-colors">
                        <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span>0856-0900-9009 / (021) 8560-9009</span>
                    </a>
                    <div class="text-[11px] text-slate-400">Siaga 24 Jam Nonstop &bull; No Cure No Pay</div>
                </div>

                {{-- Alamat Kantor & Workshop (Otomatis tampil jika konfigurasi / env COMPANY_OFFICE_ADDRESS diisi) --}}
                @if(filled(config('services.company.address', env('COMPANY_OFFICE_ADDRESS'))))
                <div class="pt-1 text-xs text-slate-400 space-y-1">
                    <div class="text-slate-200 font-bold uppercase text-[11px] tracking-wider">Kantor &amp; Workshop:</div>
                    <p class="text-xs text-slate-300 leading-relaxed flex items-start gap-1.5">
                        <svg class="w-3.5 h-3.5 text-sky-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ config('services.company.address', env('COMPANY_OFFICE_ADDRESS')) }}</span>
                    </p>
                </div>
                @endif

                <!-- Icon Sosial Media Terhubung -->
                <div class="pt-2">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">Ikuti Media Sosial:</div>
                    <div class="flex items-center gap-2.5">
                        <!-- Instagram -->
                        <a href="{{ config('services.social.instagram', 'https://instagram.com/drainusantara') }}" 
                           target="_blank" rel="noopener noreferrer" 
                           title="Instagram Drainusantara" aria-label="Instagram Drainusantara"
                           class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-gradient-to-tr hover:from-amber-500 hover:via-rose-500 hover:to-purple-600 border border-slate-700 hover:border-transparent text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>

                        <!-- TikTok -->
                        <a href="{{ config('services.social.tiktok', 'https://tiktok.com/@drainusantara') }}" 
                           target="_blank" rel="noopener noreferrer" 
                           title="TikTok Drainusantara" aria-label="TikTok Drainusantara"
                           class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-black border border-slate-700 hover:border-cyan-400 text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-1.01-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </a>

                        <!-- YouTube -->
                        <a href="{{ config('services.social.youtube', 'https://youtube.com/@drainusantara') }}" 
                           target="_blank" rel="noopener noreferrer" 
                           title="YouTube Drainusantara" aria-label="YouTube Drainusantara"
                           class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-red-600 border border-slate-700 hover:border-red-500 text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>

                        <!-- Facebook -->
                        <a href="{{ config('services.social.facebook', 'https://facebook.com/drainusantara') }}" 
                           target="_blank" rel="noopener noreferrer" 
                           title="Facebook Drainusantara" aria-label="Facebook Drainusantara"
                           class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-blue-600 border border-slate-700 hover:border-blue-500 text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>

                        <!-- WhatsApp -->
                        <a href="{{ $contextualWaUrl ?? 'https://wa.me/' . ($whatsappNumber ?? '6285609009009') . '?text=' . rawurlencode('Halo Admin Drainusantara, saya membutuhkan info teknisi terdekat untuk penanganan saluran mampet.') }}" 
                           target="_blank" rel="noopener noreferrer" 
                           title="Chat WhatsApp Resmi" aria-label="WhatsApp Drainusantara"
                           class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-emerald-600 border border-slate-700 hover:border-emerald-500 text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </a>

                        <!-- LinkedIn -->
                        <a href="{{ config('services.social.linkedin', 'https://linkedin.com/company/drainusantara') }}" 
                           target="_blank" rel="noopener noreferrer" 
                           title="LinkedIn PT Jawa Jaya Rooter" aria-label="LinkedIn Drainusantara"
                           class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-sky-700 border border-slate-700 hover:border-sky-600 text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kolom 2: Layanan Spesialis Pipa -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-3.5 pb-2 border-b border-slate-800">Layanan Spesialis</h3>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li>
                        <a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Kloset &amp; WC Duduk/Jongkok Mampet</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Wastafel &amp; Bak Cuci Piring Berlemak</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Floor Drain Kamar Mandi Tersumbat</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Pipa Talang Air Hujan &amp; Corong Roof Drain</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Bak Kontrol &amp; Jalur Pembuangan Utama</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Grease Trap Restoran &amp; Dapur Bisnis F&amp;B</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/#layanan') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Inspeksi Kamera CCTV Pipa IP68</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: Informasi Perusahaan -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-3.5 pb-2 border-b border-slate-800">Tentang Kami</h3>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li>
                        <a href="{{ route('about.profile') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Profil Perusahaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('how-it-works') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Cara Kerja &amp; Metode Non-Destruktif</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about.holding') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Induk PT Jawa Jaya Rooter</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about.k3') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Standar SOP K3 &amp; Higienitas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about.equipment') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Peralatan &amp; Mesin Rooter Modern</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about.portfolio') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Kemitraan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about.warranty') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Garansi Tertulis 30 Hari Kalender</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about.faq') }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="text-sky-400 font-bold">&rsaquo;</span>
                            <span>Pusat Bantuan &amp; FAQ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-sky-400 hover:text-sky-300 font-bold transition-colors flex items-center gap-1.5">
                            <span>&rsaquo;</span>
                            <span>Hubungi Kami / Form Layanan</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 4: Jaringan Posko Siaga & Dispatch Cepat -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-sky-400 mb-3.5 pb-2 border-b border-slate-800">Posko Siaga Armada</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Armada teknisi siaga standby di posko kota untuk respon cepat langsung ke rumah, ruko, restoran, atau gedung Anda.
                </p>
                <div class="space-y-2 text-xs">
                    <div class="p-2.5 rounded-lg bg-slate-800/80 border border-slate-700/80">
                        <div class="font-bold text-white text-[11px]">Posko Jabodetabek:</div>
                        <div class="text-slate-400 text-[11px]">Jakarta, Bogor, Depok, Tangerang, Bekasi, Sentul &amp; Cikarang</div>
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-800/80 border border-slate-700/80">
                        <div class="font-bold text-white text-[11px]">Posko Bandung Raya:</div>
                        <div class="text-slate-400 text-[11px]">Kota Bandung, Kab. Bandung, Kota Cimahi (Utara, Barat, Tengah, Timur)</div>
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-800/80 border border-slate-700/80">
                        <div class="font-bold text-white text-[11px]">Posko Semarang Raya &amp; Demak:</div>
                        <div class="text-slate-400 text-[11px]">Kota Semarang, Kab. Semarang, Kab. Demak, &amp; Bandar Lampung</div>
                    </div>
                </div>
                <div class="pt-1">
                    <a href="{{ $contextualWaUrl ?? 'https://wa.me/' . ($whatsappNumber ?? '6285609009009') . '?text=' . rawurlencode('Halo Admin Drainusantara, saya membutuhkan info teknisi terdekat ke alamat saya.') }}"
                       :href="'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent(contextualWaMsg || 'Halo Admin Drainusantara, saya membutuhkan info teknisi terdekat ke alamat saya.')"
                       target="_blank" 
                       rel="noopener noreferrer" 
                       data-track-location="footer"
                       class="w-full inline-flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-4 py-2.5 rounded-lg border border-emerald-800 shadow-xs transition-colors btn-press">
                        <span>Panggil Teknisi Terdekat</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Footer Bottom Note -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-slate-400">
            <p>&copy; {{ date('Y') }} PT JAWA JAYA ROOTER &bull; Drainusantara. Non-Destructive Plumbing &amp; Drain Rooter Engineering.</p>
            <div class="flex items-center gap-4 text-slate-400 text-[11px] flex-wrap justify-center">
                <a href="{{ route('contact') }}" class="hover:text-white transition-colors font-bold text-sky-400">Kontak Kami</a>
                <span>&bull;</span>
                <a href="{{ route('how-it-works') }}" class="hover:text-white transition-colors">Cara Kerja</a>
                <span>&bull;</span>
                <a href="{{ route('about.warranty') }}" class="hover:text-white transition-colors">Ketentuan Garansi</a>
                <span>&bull;</span>
                <a href="{{ route('about.k3') }}" class="hover:text-white transition-colors">Standar K3</a>
                <span>&bull;</span>
                <a href="{{ route('about.faq') }}" class="hover:text-white transition-colors">FAQ</a>
                <span>&bull;</span>
                <a href="{{ route('legal.privacy') }}" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                <span>&bull;</span>
                <a href="{{ route('legal.terms') }}" class="hover:text-white transition-colors">Syarat &amp; Ketentuan</a>
                <span>&bull;</span>
                <a href="{{ route('sitemap.html') }}" class="hover:text-white transition-colors">Peta Situs</a>
            </div>
        </div>
    </div>
</footer>
