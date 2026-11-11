@props([
    'isModal' => false,
])

@php
    $whatsappNumber = config('app.whatsapp_number') ?: '6285609009009';
@endphp

<div x-data="{
    step: 1,
    problem: 'wastafel',
    problemTitle: 'Wastafel & Cuci Piring',
    property: 'residensial',
    propertyTitle: 'Rumah Tinggal',
    city: 'Jakarta Selatan',
    condition: 'Buntu Total (Meluap)',
    chemicalHistory: 'tidak',
    customerName: '',
    addressNotes: '',
    submitted: false,
    generatedWaUrl: '',

    getEstimate() {
        let min = 400;
        let max = 550;

        if (this.problem === 'kloset') { min = 450; max = 650; }
        else if (this.problem === 'floordrain') { min = 400; max = 550; }
        else if (this.problem === 'talang') { min = 450; max = 650; }
        else if (this.problem === 'greasetrap') { min = 550; max = 850; }
        else if (this.problem === 'pipautama') { min = 500; max = 750; }

        if (this.property === 'ruko') { min += 50; max += 100; }
        else if (this.property === 'resto') { min += 100; max += 150; }
        else if (this.property === 'kantor') { min += 100; max += 200; }

        return 'Rp ' + min + '.000 - Rp ' + max + '.000';
    },

    getMethodExplanation() {
        if (this.problem === 'wastafel') {
            return 'Pembersihan kerak minyak & lemak leher angsa menggunakan mesin spiral rotary Ridgid K-50 tanpa melepas sink.';
        }
        if (this.problem === 'kloset') {
            return 'Penetrasian leher angsa toilet duduk/jongkok menggunakan spiral fleksibel 400 RPM tanpa mencabut kloset.';
        }
        if (this.problem === 'floordrain') {
            return 'Pengikisan endapan rambut & busa sabun pipa pembuangan kamar mandi hingga plong tanpa membongkar keramik.';
        }
        if (this.problem === 'talang') {
            return 'Pembersihan endapan lumpur, lumut, dan tumpukan daun pada pipa vertikal rooftop dengan kabel spiral jangkauan panjang.';
        }
        if (this.problem === 'greasetrap') {
            return 'Pengangkatan kerak lemak beku & pembersihan saluran grease trap komersial berstandar higienis.';
        }
        return 'Pelancaran jalur pipa pembuangan induk / bak kontrol dengan mesin rooter berkekuatan putar tinggi.';
    },

    selectProblem(key, title) {
        this.problem = key;
        this.problemTitle = title;
    },

    selectProperty(key, title) {
        this.property = key;
        this.propertyTitle = title;
    },

    goToStep(nextStep) {
        if (nextStep > this.step) {
            if (this.step === 1 && (!this.problem || !this.property)) return;
            if (this.step === 2 && !this.city) return;
        }
        this.step = nextStep;
        if (window.trackConversion) {
            window.trackConversion('quick_quote_step', {
                step_number: nextStep,
                step_name: nextStep === 1 ? 'problem_selection' : (nextStep === 2 ? 'location_condition' : 'contact_summary'),
            });
        }
    },

    buildWaMessage() {
        const lines = [
            '*FORM ESTIMASI PENANGANAN PIPA MAMPET*',
            '----------------------------------------',
            '• Titik Masalah: ' + this.problemTitle,
            '• Tipe Bangunan: ' + this.propertyTitle,
            '• Wilayah Lokasi: ' + this.city,
            '• Kondisi Saluran: ' + this.condition,
            '• Estimasi Biaya Awal: ' + this.getEstimate() + ' (No Cure No Pay)',
            '• Riwayat Soda Api: ' + (this.chemicalHistory === 'ya' ? 'PERNAH PAKAI (Perlu penanganan khusus pipa PVC)' : 'Belum pernah pakai (Aman)'),
        ];
        if (this.customerName.trim()) {
            lines.push('• Nama Pemesan: ' + this.customerName.trim());
        }
        if (this.addressNotes.trim()) {
            lines.push('• Patokan Alamat: ' + this.addressNotes.trim());
        }
        lines.push('----------------------------------------');
        lines.push('Halo Admin Drainusantara, saya ingin konsultasi penanganan saluran pipa mampet di atas. Mohon info jadwal kedatangan teknisi terdekat dan diagnosa gratis. Terima kasih.');
        return lines.join('\n');
    },

    submitQuote() {
        const msg = this.buildWaMessage();
        const number = '{{ $whatsappNumber }}';
        this.generatedWaUrl = 'https://wa.me/' + number + '?text=' + encodeURIComponent(msg);

        if (window.trackConversion) {
            window.trackConversion('quick_quote_submit', {
                problem: this.problem,
                problem_title: this.problemTitle,
                property: this.property,
                city: this.city,
                condition: this.condition,
                chemical_history: this.chemicalHistory,
                cta_location: '{{ $isModal ? "quick_quote_modal" : "quick_quote_section" }}'
            });
        }

        this.submitted = true;
        window.open(this.generatedWaUrl, '_blank');
    },

    resetForm() {
        this.step = 1;
        this.submitted = false;
        this.customerName = '';
        this.addressNotes = '';
    }
}" class="w-full bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">

    <!-- Header & Progress Bar -->
    <div class="px-5 py-4 sm:px-6 border-b border-slate-200 bg-slate-900 text-white">
        <div class="flex items-center justify-between gap-3">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-sky-400 block mb-0.5">
                    Kalkulator &amp; Estimasi Cepat
                </span>
                <h3 class="text-base sm:text-lg font-bold text-white tracking-tight">
                    Hitung Estimasi Biaya &amp; Jadwal Teknisi
                </h3>
            </div>
            <div class="text-right shrink-0">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-slate-800 text-sky-300 border border-slate-700">
                    Langkah <span x-text="step" class="mx-0.5 font-extrabold text-white"></span>/3
                </span>
            </div>
        </div>

        <!-- Progress Track -->
        <div class="w-full bg-slate-800 h-1.5 rounded-full mt-3 overflow-hidden">
            <div class="bg-sky-400 h-full transition-all duration-300 ease-out"
                 :style="'width: ' + (step === 1 ? '33.33%' : (step === 2 ? '66.66%' : '100%'))"></div>
        </div>
    </div>

    <!-- Form Body -->
    <div class="p-5 sm:p-7">

        <!-- ======================= STEP 1 ======================= -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            
            <!-- 1. Titik Masalah -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2.5">
                    1. Pilih Titik Saluran yang Tersumbat:
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 sm:gap-3">
                    
                    <!-- Wastafel -->
                    <button type="button" 
                            @click="selectProblem('wastafel', 'Wastafel & Cuci Piring')"
                            class="p-3 rounded-lg border text-left transition-all cursor-pointer btn-press"
                            :class="problem === 'wastafel' ? 'border-sky-600 bg-sky-50/70 ring-1 ring-sky-600 text-sky-950' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        <div class="font-bold text-xs sm:text-sm mb-0.5">Wastafel &amp; Sink</div>
                        <div class="text-[11px] text-slate-500 leading-snug">Kerak minyak &amp; lemak</div>
                    </button>

                    <!-- Kloset -->
                    <button type="button" 
                            @click="selectProblem('kloset', 'Kloset & WC Meluap')"
                            class="p-3 rounded-lg border text-left transition-all cursor-pointer btn-press"
                            :class="problem === 'kloset' ? 'border-sky-600 bg-sky-50/70 ring-1 ring-sky-600 text-sky-950' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        <div class="font-bold text-xs sm:text-sm mb-0.5">Kloset &amp; WC</div>
                        <div class="text-[11px] text-slate-500 leading-snug">Tisu/pembalut meluap</div>
                    </button>

                    <!-- Floor Drain -->
                    <button type="button" 
                            @click="selectProblem('floordrain', 'Floor Drain Kamar Mandi')"
                            class="p-3 rounded-lg border text-left transition-all cursor-pointer btn-press"
                            :class="problem === 'floordrain' ? 'border-sky-600 bg-sky-50/70 ring-1 ring-sky-600 text-sky-950' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        <div class="font-bold text-xs sm:text-sm mb-0.5">Floor Drain</div>
                        <div class="text-[11px] text-slate-500 leading-snug">Rambut &amp; buih sabun</div>
                    </button>

                    <!-- Talang Rooftop -->
                    <button type="button" 
                            @click="selectProblem('talang', 'Talang Rooftop & Pipa Atap')"
                            class="p-3 rounded-lg border text-left transition-all cursor-pointer btn-press"
                            :class="problem === 'talang' ? 'border-sky-600 bg-sky-50/70 ring-1 ring-sky-600 text-sky-950' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        <div class="font-bold text-xs sm:text-sm mb-0.5">Talang Atap</div>
                        <div class="text-[11px] text-slate-500 leading-snug">Pasir &amp; daun rontok</div>
                    </button>

                    <!-- Grease Trap -->
                    <button type="button" 
                            @click="selectProblem('greasetrap', 'Kuras Grease Trap Resto')"
                            class="p-3 rounded-lg border text-left transition-all cursor-pointer btn-press"
                            :class="problem === 'greasetrap' ? 'border-sky-600 bg-sky-50/70 ring-1 ring-sky-600 text-sky-950' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        <div class="font-bold text-xs sm:text-sm mb-0.5">Grease Trap</div>
                        <div class="text-[11px] text-slate-500 leading-snug">Lemak dapur restoran</div>
                    </button>

                    <!-- Bak Kontrol / Utama -->
                    <button type="button" 
                            @click="selectProblem('pipautama', 'Pipa Utama / Bak Kontrol')"
                            class="p-3 rounded-lg border text-left transition-all cursor-pointer btn-press"
                            :class="problem === 'pipautama' ? 'border-sky-600 bg-sky-50/70 ring-1 ring-sky-600 text-sky-950' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        <div class="font-bold text-xs sm:text-sm mb-0.5">Pipa Utama</div>
                        <div class="text-[11px] text-slate-500 leading-snug">Bak kontrol induk</div>
                    </button>

                </div>
            </div>

            <!-- 2. Jenis Bangunan -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2.5">
                    2. Tipe Properti / Bangunan:
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <button type="button" 
                            @click="selectProperty('residensial', 'Rumah Tinggal')"
                            class="px-3 py-2.5 rounded-lg border text-center transition-all cursor-pointer btn-press text-xs font-semibold"
                            :class="property === 'residensial' ? 'border-sky-600 bg-sky-50/70 text-sky-900 ring-1 ring-sky-600 font-bold' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        Rumah Tinggal
                    </button>
                    <button type="button" 
                            @click="selectProperty('ruko', 'Ruko / Usaha')"
                            class="px-3 py-2.5 rounded-lg border text-center transition-all cursor-pointer btn-press text-xs font-semibold"
                            :class="property === 'ruko' ? 'border-sky-600 bg-sky-50/70 text-sky-900 ring-1 ring-sky-600 font-bold' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        Ruko / Toko
                    </button>
                    <button type="button" 
                            @click="selectProperty('resto', 'Restoran / Kafe')"
                            class="px-3 py-2.5 rounded-lg border text-center transition-all cursor-pointer btn-press text-xs font-semibold"
                            :class="property === 'resto' ? 'border-sky-600 bg-sky-50/70 text-sky-900 ring-1 ring-sky-600 font-bold' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        Restoran / Cafe
                    </button>
                    <button type="button" 
                            @click="selectProperty('kantor', 'Kantor / Gedung')"
                            class="px-3 py-2.5 rounded-lg border text-center transition-all cursor-pointer btn-press text-xs font-semibold"
                            :class="property === 'kantor' ? 'border-sky-600 bg-sky-50/70 text-sky-900 ring-1 ring-sky-600 font-bold' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        Kantor / Pabrik
                    </button>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-2 flex justify-end">
                <button type="button" 
                        @click="goToStep(2)" 
                        class="btn-press inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-sky-700 hover:bg-sky-800 active:bg-sky-900 text-white font-bold text-xs sm:text-sm transition-colors cursor-pointer min-h-[44px]">
                    <span>Lanjut ke Lokasi &amp; Kondisi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- ======================= STEP 2 ======================= -->
        <div x-show="step === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            
            <!-- 1. Kota / Wilayah -->
            <div>
                <label for="quote-city-select" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    1. Wilayah / Kota Lokasi Anda:
                </label>
                <select id="quote-city-select" 
                        x-model="city" 
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 focus:outline-hidden focus:border-sky-600 focus:bg-white font-medium">
                    <optgroup label="DKI Jakarta">
                        <option value="Jakarta Selatan">Jakarta Selatan</option>
                        <option value="Jakarta Timur">Jakarta Timur</option>
                        <option value="Jakarta Barat">Jakarta Barat</option>
                        <option value="Jakarta Pusat">Jakarta Pusat</option>
                        <option value="Jakarta Utara">Jakarta Utara</option>
                    </optgroup>
                    <optgroup label="Bodetabek">
                        <option value="Tangerang & Tangsel">Kota Tangerang &amp; Tangsel</option>
                        <option value="Bekasi & Cikarang">Bekasi &amp; Cikarang</option>
                        <option value="Depok & Cinere">Depok &amp; Cinere</option>
                        <option value="Bogor">Bogor &amp; Sekitarnya</option>
                    </optgroup>
                    <optgroup label="Hub Regional">
                        <option value="Semarang">Kota Semarang &amp; Sekitarnya</option>
                        <option value="Bandar Lampung">Bandar Lampung &amp; Sekitarnya</option>
                        <option value="Wilayah Lainnya">Wilayah Lainnya</option>
                    </optgroup>
                </select>
            </div>

            <!-- 2. Kondisi Aliran -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    2. Kondisi Sumbatan Saat Ini:
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <button type="button" 
                            @click="condition = 'Buntu Total (Meluap)'" 
                            class="p-3 rounded-lg border text-left transition-all cursor-pointer btn-press"
                            :class="condition === 'Buntu Total (Meluap)' ? 'border-red-500 bg-red-50/70 text-red-950 ring-1 ring-red-500' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        <div class="font-bold text-xs sm:text-sm mb-0.5">Buntu Total / Meluap</div>
                        <div class="text-[11px] text-slate-500 leading-snug">Air tidak turun sama sekali, meluber ke lantai</div>
                    </button>
                    <button type="button" 
                            @click="condition = 'Mengalir Lambat (Menumpuk)'" 
                            class="p-3 rounded-lg border text-left transition-all cursor-pointer btn-press"
                            :class="condition === 'Mengalir Lambat (Menumpuk)' ? 'border-sky-600 bg-sky-50/70 text-sky-950 ring-1 ring-sky-600' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        <div class="font-bold text-xs sm:text-sm mb-0.5">Mengalir Lambat</div>
                        <div class="text-[11px] text-slate-500 leading-snug">Air tergenang beberapa menit baru surut</div>
                    </button>
                </div>
            </div>

            <!-- 3. Riwayat Soda Api (Diagnostic Teknis Penting) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    3. Apakah Pernah Disiram Soda Api / Kimia Keras?
                </label>
                <div class="grid grid-cols-2 gap-2.5">
                    <button type="button" 
                            @click="chemicalHistory = 'tidak'" 
                            class="p-2.5 rounded-lg border text-center transition-all cursor-pointer btn-press text-xs font-semibold"
                            :class="chemicalHistory === 'tidak' ? 'border-sky-600 bg-sky-50/70 text-sky-900 ring-1 ring-sky-600 font-bold' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        Belum Pernah (Aman)
                    </button>
                    <button type="button" 
                            @click="chemicalHistory = 'ya'" 
                            class="p-2.5 rounded-lg border text-center transition-all cursor-pointer btn-press text-xs font-semibold"
                            :class="chemicalHistory === 'ya' ? 'border-amber-500 bg-amber-50/70 text-amber-950 ring-1 ring-amber-500 font-bold' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700'">
                        Pernah Pakai Soda Api
                    </button>
                </div>

                <!-- Technical advisory alert -->
                <div x-show="chemicalHistory === 'ya'" x-transition class="mt-2.5 p-3 rounded-lg bg-amber-50 border border-amber-200 text-amber-900 text-[11px] leading-relaxed">
                    <span class="font-bold">Catatan Teknis:</span> Reaksi panas soda api dapat melunakkan sambungan pipa leher angsa PVC. Teknisi kami akan menyiapkan mata spiral lentur khusus agar pengerjaan tetap aman tanpa merusak pipa Anda.
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-2 flex items-center justify-between">
                <button type="button" 
                        @click="goToStep(1)" 
                        class="btn-press inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs sm:text-sm transition-colors cursor-pointer min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali</span>
                </button>

                <button type="button" 
                        @click="goToStep(3)" 
                        class="btn-press inline-flex items-center justify-center gap-2 px-6 py-3 rounded-lg bg-sky-700 hover:bg-sky-800 active:bg-sky-900 text-white font-bold text-xs sm:text-sm transition-colors cursor-pointer min-h-[44px]">
                    <span>Lanjut ke Rincian Kontak</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- ======================= STEP 3 ======================= -->
        <div x-show="step === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
            
            <!-- Summary Card -->
            <div class="p-4 rounded-lg bg-slate-50 border border-slate-200/90 space-y-2.5 text-xs">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 pb-1.5">
                    Ringkasan Pilihan Permintaan:
                </div>
                <div class="grid grid-cols-2 gap-2 text-slate-700">
                    <div><span class="text-slate-500">Titik Saluran:</span> <span class="font-bold text-slate-900 block" x-text="problemTitle"></span></div>
                    <div><span class="text-slate-500">Tipe Bangunan:</span> <span class="font-bold text-slate-900 block" x-text="propertyTitle"></span></div>
                    <div><span class="text-slate-500">Wilayah:</span> <span class="font-bold text-slate-900 block" x-text="city"></span></div>
                    <div><span class="text-slate-500">Kondisi:</span> <span class="font-bold text-slate-900 block" x-text="condition"></span></div>
                </div>

                <div class="pt-2.5 border-t border-slate-200 space-y-1.5">
                    <div class="flex items-center justify-between text-xs font-semibold text-slate-800">
                        <span>Estimasi Rentang Biaya:</span>
                        <span class="text-emerald-700 font-extrabold text-sm sm:text-base" x-text="getEstimate()"></span>
                    </div>
                    <div class="text-[11px] text-slate-600 bg-white p-2.5 rounded-md border border-slate-200 mt-1">
                        <span class="font-bold text-sky-800 block mb-0.5">Metode Penanganan:</span>
                        <span x-text="getMethodExplanation()"></span>
                    </div>
                    <div x-show="chemicalHistory === 'ya'" class="text-[11px] text-amber-800 bg-amber-50 p-2.5 rounded-md border border-amber-200 mt-1">
                        ⚠️ <strong>Perhatian Khusus Soda Api:</strong> Karena pernah disiram zat kimia, teknisi akan menggunakan mata bor spiral fleksibel bertorsi halus untuk melindungi sambungan PVC yang rentan rapuh.
                    </div>
                </div>
                <div class="text-[10px] text-slate-500 pt-1">
                    * Garansi resmi 30 hari nota tertulis • 100% tanpa bongkar keramik • <strong>No Cure No Pay</strong> (tidak lancar tidak bayar).
                </div>
            </div>

            <!-- Optional Customer Name & Short Address -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="quote-name-input" class="block text-xs font-bold text-slate-700 mb-1">
                        Nama Pemesan (Opsional):
                    </label>
                    <input id="quote-name-input" 
                           type="text" 
                           x-model="customerName" 
                           placeholder="Contoh: Pak Budi / Ibu Siti"
                           class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 focus:outline-hidden focus:border-sky-600 focus:bg-white">
                </div>

                <div>
                    <label for="quote-address-input" class="block text-xs font-bold text-slate-700 mb-1">
                        Kecamatan / Patokan Alamat:
                    </label>
                    <input id="quote-address-input" 
                           type="text" 
                           x-model="addressNotes" 
                           placeholder="Contoh: Tebet, dkt stasiun"
                           class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-xs sm:text-sm text-slate-800 focus:outline-hidden focus:border-sky-600 focus:bg-white">
                </div>
            </div>

            <!-- Success confirmation state after click -->
            <div x-show="submitted" x-transition class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs space-y-2">
                <div class="flex items-center gap-2 font-bold text-emerald-800">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Pesan WhatsApp Berhasil Disiapkan!</span>
                </div>
                <p class="text-[11px] text-emerald-700">
                    Jika aplikasi WhatsApp belum terbuka secara otomatis, silakan klik tombol hijau di bawah untuk terhubung langsung dengan admin kami.
                </p>
                <div>
                    <a :href="generatedWaUrl" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       data-track-location="{{ $isModal ? 'quick_quote_modal_retry' : 'quick_quote_section_retry' }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs transition-colors">
                        <span>Buka Chat WhatsApp Sekarang</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-2 flex items-center justify-between gap-3">
                <button type="button" 
                        @click="goToStep(2)" 
                        class="btn-press inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs sm:text-sm transition-colors cursor-pointer min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali</span>
                </button>

                <button type="button" 
                        @click="submitQuote()" 
                        class="btn-press flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 active:bg-emerald-900 text-white font-bold text-xs sm:text-sm shadow-xs transition-colors cursor-pointer min-h-[44px]">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Konsultasi Biaya &amp; Jadwal via WhatsApp</span>
                </button>
            </div>
        </div>

    </div>
</div>

