<section id="faq" class="py-16 lg:py-24 bg-slate-50 border-b border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-14 reveal-soft">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Tanya Jawab Teknis
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Tanya Jawab Seputar Saluran Pipa Mampet
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-2">
                Jawaban lengkap mengenai metode pengerjaan tanpa bongkar keramik, estimasi biaya, dan ketentuan garansi resmi 30 hari.
            </p>
        </div>

        <div x-data="{ active: null }" class="space-y-3.5 reveal-soft">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 1 ? null : 1)"
                    aria-expanded="false" :aria-expanded="active === 1" aria-controls="home-faq-answer-1"
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Apakah pengerjaan benar-benar 100% tanpa bongkar keramik atau lantai?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="home-faq-answer-1" x-show="active === 1" x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Benar, 100% tanpa bongkar ubin keramik! Kami menggunakan mesin drain rooter fleksibel berteknologi spiral baja yang mampu meliuk mengikuti belokan pipa (knee/elbow) hingga ke titik sumbatan. Mesin ini mengikis kerak minyak beku atau menarik benda asing keluar tanpa melukai pipa PVC hunian Anda.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 2 ? null : 2)"
                    aria-expanded="false" :aria-expanded="active === 2" aria-controls="home-faq-answer-2"
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Berapa lama estimasi waktu pengerjaan saluran mampet?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="home-faq-answer-2" x-show="active === 2" x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    {{ config('service_facts.duration_answer') }}
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 3 ? null : 3)"
                    aria-expanded="false" :aria-expanded="active === 3" aria-controls="home-faq-answer-3"
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Bagaimana syarat dan klaim Garansi 30 Hari Drainusantara?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="home-faq-answer-3" x-show="active === 3" x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Setiap pengerjaan kami berikan nota garansi resmi selama 30 hari kalender. Apabila dalam kurun waktu tersebut saluran pada titik yang sama mengalami mampet kembali, teknisi kami siap datang kembali untuk penanganan ulang tanpa dipungut biaya jasa tambahan apapun.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 4 ? null : 4)"
                    aria-expanded="false" :aria-expanded="active === 4" aria-controls="home-faq-answer-4"
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Mengapa tidak disarankan menggunakan soda api?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="home-faq-answer-4" x-show="active === 4" x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Soda api bereaksi menghasilkan panas eksotermik di atas 90°C sehingga sangat rentan membengkokkan pipa PVC dan merusak lem sambungan pipa. Selain itu, soda api yang bereaksi dengan minyak makanan akan mengeras menjadi sabun padat seperti batu semen (saponifikasi), yang justru membuat pipa tersumbat total secara permanen.
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="bg-white rounded-xl border border-slate-200/90 overflow-hidden shadow-2xs hover:border-sky-300 transition-colors">
                <button 
                    @click="active = (active === 5 ? null : 5)"
                    aria-expanded="false" :aria-expanded="active === 5" aria-controls="home-faq-answer-5"
                    class="w-full flex items-center justify-between p-5 text-left font-bold text-slate-900 hover:text-sky-700 transition-colors focus:outline-hidden cursor-pointer"
                    type="button"
                >
                    <span class="text-base sm:text-lg font-bold tracking-tight">Bagaimana cara memesan jadwal kedatangan teknisi?</span>
                    <svg class="w-5 h-5 shrink-0 transform transition-transform duration-200 text-slate-400" :class="{ 'rotate-180 text-sky-700': active === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="home-faq-answer-5" x-show="active === 5" x-cloak class="px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-4">
                    Cukup klik tombol hijau WhatsApp <strong>"Panggil Teknisi via WhatsApp"</strong> di website ini untuk terhubung langsung dengan admin kami. Sampaikan jenis masalah saluran Anda beserta alamat, teknisi terdekat akan segera dijadwalkan meluncur menuju lokasi Anda.
                </div>
            </div>
        </div>

    </div>
</section>
