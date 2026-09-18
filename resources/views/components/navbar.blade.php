<nav class="sticky top-0 z-50 bg-background/80 backdrop-blur-md border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        {{-- Logo --}}
        <a href="/" class="text-xl font-extrabold text-secondary tracking-tight">
            DRAIN<span class="text-CTA">USANTARA</span> <span>/ ATAU LOGO</span>
        </a>

        {{-- Isi nav --}}
        <ul class="hidden md:flex items-center gap-8 font-semibold text-sm text-slate-700">
            <li><a href="/" class="hover:text-primary transition-colors text-md font-bold">Beranda</a></li>
            <li class="relative group cursor-pointer py-5">
                <div class="flex items-center gap-1.5 hover:text-primary transition-colors">
                    <span class="text-md font-bold">Tentang Kami</span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform group-hover:rotate-180 group-hover:text-primary"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Dropdown Card -->
                <ul
                    class="absolute left-0 top-full hidden group-hover:flex flex-col bg-white shadow-xl rounded-xl w-60 py-2 border border-slate-100 z-50">
                    <li>
                        <a href="#profil-perusahaan"
                            class="block px-4 py-2.5 text-md text-slate-700 hover:bg-slate-50 hover:text-primary">
                            Profil Perusahaan
                        </a>
                    </li>
                    <li>
                        <a href="#peralatan"
                            class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            Peralatan & Teknologi
                        </a>
                    </li>
                    <li>
                        <a href="#portfolio"
                            class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            Klien & Portofolio
                        </a>
                    </li>
                    <li>
                        <a href="#garansi"
                            class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            Ketentuan Garansi
                        </a>
                    </li>
                    <li>
                        <a href="#FAQ"
                            class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            Pertanyaan Umum
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Dropdown Layanan -->
            <li class="relative group cursor-pointer py-5">
                <div class="flex items-center gap-1.5 hover:text-primary transition-colors">
                    <span class="text-md font-bold">Layanan</span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform group-hover:rotate-180 group-hover:text-primary"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Dropdown Card -->
                <ul
                    class="absolute left-0 top-full hidden group-hover:flex flex-col bg-white shadow-xl rounded-xl w-60 py-2 border border-slate-100 z-50">
                    <li>
                        <a href="#saluran-mampet"
                            class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            Saluran Mampet
                        </a>
                    </li>
                    <li>
                        <a href="#deteksi-bocor"
                            class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            Deteksi Pipa Bocor
                        </a>
                    </li>
                    <li>
                        <a href="#instalasi-pipa"
                            class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            Instalasi Pipa Baru
                        </a>
                    </li>
                </ul>
            </li>

            <li><a href="#dokumentasi" class="hover:text-primary transition-colors text-md font-bold">Dokumentasi</a>
            </li>
            <li><a href="#pengetahuan" class="hover:text-primary transition-colors text-md font-bold">Pengetahuan</a>
            </li>

            <!-- Dropdown Area Layanan -->
            <li class="relative group cursor-pointer py-5">
                <div class="flex items-center gap-1.5 hover:text-primary transition-colors">
                    <span class="text-md font-bold">Area Layanan</span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform group-hover:rotate-180 group-hover:text-primary"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Dropdown Tingkat 1 -->
                <ul
                    class="absolute left-0 top-full hidden group-hover:flex flex-col bg-white shadow-xl rounded-xl w-60 py-2 border border-slate-100 z-50">

                    <!-- Item dengan Sub-Menu (Gunakan group/sub) -->
                    <li class="relative group/sub">
                        <div
                            class="flex items-center justify-between px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            <span>DKI JAKARTA</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover/sub:text-primary" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>



                        <ul
                            class="absolute left-full -top-2 hidden group-hover/sub:flex flex-col bg-white shadow-xl rounded-xl w-52 py-2 border border-slate-100 z-50 ml-1">
                            <li>
                                <a href="#jakarta-selatan"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Jakarta Selatan
                                </a>
                            </li>
                            <li>
                                <a href="#jakarta-barat"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Jakarta Barat
                                </a>
                            </li>
                            <li>
                                <a href="#jakarta-timur"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Jakarta Timur
                                </a>
                            </li>
                            <li>
                                <a href="#jakarta-pusat"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Jakarta Pusat
                                </a>
                            </li>
                            <li>
                                <a href="#jakarta-utara"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Jakarta Utara
                                </a>
                            </li>
                        </ul>
                    </li>



                    <li class="relative group/sub">
                        <div
                            class="flex items-center justify-between px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            <span>BODETABEK</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover/sub:text-primary" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <ul
                            class="absolute left-full -top-2 hidden group-hover/sub:flex flex-col bg-white shadow-xl rounded-xl w-52 py-2 border border-slate-100 z-50 ml-1">
                            <li>
                                <a href="#bogor"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Bogor (Kota & Kab)
                                </a>
                            </li>
                            <li>
                                <a href="#depok-cinere"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Depok & Cinere
                                </a>
                            </li>
                            <li>
                                <a href="#tangerang-kota"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Tangerang Kota
                                </a>
                            </li>
                            <li>
                                <a href="tangerang-selatan"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Tangerang Selatan
                                </a>
                            </li>
                            <li>
                                <a href="bekasi-cikarang"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Bekasi & Cikarang
                                </a>
                            </li>
                        </ul>
                    </li>



                    <li class="relative group/sub">
                        <div
                            class="flex items-center justify-between px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                            <span>LAMPUNG & SEMARANG</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover/sub:text-primary" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>

                        <ul
                            class="absolute left-full -top-2 hidden group-hover/sub:flex flex-col bg-white shadow-xl rounded-xl w-52 py-2 border border-slate-100 z-50 ml-1">
                            <li>
                                <a href="#jakarta-selatan"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Kota Lampung
                                </a>
                            </li>
                            <li>
                                <a href="#jakarta-barat"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary">
                                    Kota Semarang
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Action Button Nav -->
        <a href="https://wa.me/628xxxxxxx" target="_blank"
            class="hidden sm:inline-flex items-center gap-2 bg-CTA text-white px-4 py-2 rounded-lg font-bold text-xs hover:bg-CTA-hover transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24">
                <title>phone-bold</title>
                <path fill="currentColor"
                    d="M16.5562 12.9062L16.1007 13.359C16.1007 13.359 15.0181 14.4355 12.0631 11.4972C9.10812 8.55901 10.1907 7.48257 10.1907 7.48257L10.4775 7.19738C11.1841 6.49484 11.2507 5.36691 10.6342 4.54348L9.37326 2.85908C8.61028 1.83992 7.13596 1.70529 6.26145 2.57483L4.69185 4.13552C4.25823 4.56668 3.96765 5.12559 4.00289 5.74561C4.09304 7.33182 4.81071 10.7447 8.81536 14.7266C13.0621 18.9492 17.0468 19.117 18.6763 18.9651C19.1917 18.9171 19.6399 18.6546 20.0011 18.2954L21.4217 16.883C22.3806 15.9295 22.1102 14.2949 20.8833 13.628L18.9728 12.5894C18.1672 12.1515 17.1858 12.2801 16.5562 12.9062Z" />
            </svg>
            <span>Panggil Teknisi</span>
        </a>
    </div>
</nav>