@extends('layouts.app')

@section('content')
@include('about.partials.nav', [
    'activeTitle' => 'Peralatan & Teknologi',
    'eyebrow' => 'Spesifikasi Peralatan',
    'heading' => 'Peralatan Mekanis Spiral Baja & Kamera Inspeksi CCTV',
    'subheading' => 'Peralatan berstandar industri internasional untuk menembus, mengikis, dan menarik sumbatan tanpa merusak dinding pipa PVC.'
])

@php
    $equipmentList = (isset($equipments) && $equipments->isNotEmpty()) 
        ? $equipments 
        : \App\Models\Equipment::where('is_active', true)->orderBy('order')->get();

    $mainMachines = $equipmentList->where('category', '!=', 'Mata Cutter');
    $cutterUnits = $equipmentList->where('category', 'Mata Cutter');
@endphp

<!-- Main Equipment Content -->
<section id="peralatan" class="py-16 lg:py-20 bg-slate-50 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-2">
                Teknologi Tanpa Bongkar
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Standar Mesin Pelancar Pipa Modern
            </h2>
            <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
                Kami tidak mengandalkan bahan kimia korosif seperti soda api yang merusak pipa. Kami menginvestasikan armada mesin drain cleaning berstandar internasional yang bekerja secara mekanis, terukur, dan aman untuk jangka panjang.
            </p>
        </div>

        @if($mainMachines->isNotEmpty())
        <!-- Main Machine Cards Grid (Dynamically from CMS) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-14">
            @foreach($mainMachines as $machine)
            <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs flex flex-col justify-between card-lift">
                <div>
                    <!-- Container Gambar Foto Peralatan -->
                    <div class="relative aspect-[16/10] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 mb-6 group">
                        <img 
                            src="{{ $machine->image ?: asset('assets/TOOLKIT/mesin-spiral-rotary.svg') }}" 
                            alt="{{ $machine->name }}" 
                            width="800" 
                            height="500" 
                            loading="lazy" 
                            decoding="async" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-spiral-rotary.svg') }}';"
                        >
                        @if($machine->badge)
                        <div class="absolute top-2.5 left-2.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-900/85 backdrop-blur-xs text-[11px] font-bold text-white border border-slate-700">
                                {{ $machine->badge }}
                            </span>
                        </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700">
                            {{ $machine->category ?? 'Unit Armada' }}
                        </span>
                        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                            100% Mekanis
                        </span>
                    </div>

                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2.5 leading-snug">
                        {{ $machine->name }}
                    </h3>
                    @if($machine->short_description)
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        {{ $machine->short_description }}
                    </p>
                    @endif
                    
                    @php
                        $specs = $machine->specs_list;
                    @endphp
                    @if(!empty($specs))
                    <div class="space-y-2 text-xs text-slate-700 border-t border-slate-100 pt-4">
                        @foreach($specs as $spec)
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                            <span>{{ $spec }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Standar Industri Plumbing</span>
                    <span class="text-sky-700 font-bold">Tanpa Bongkar Pipa</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Fallback Default 3 Main Machine Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-14">
            <!-- Machine 1: Mesin Spiral Rotary Ridgid -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs flex flex-col justify-between card-lift">
                <div>
                    <div class="relative aspect-[16/10] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 mb-6 group">
                        <img 
                            src="{{ asset('assets/TOOLKIT/mesin-spiral-rotary.webp') }}" 
                            alt="Mesin Drain Rooter Spiral Baja Rotary Ridgid K-50 &amp; K-60" 
                            width="800" 
                            height="500" 
                            loading="eager" 
                            decoding="async" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/mesin-spiral-rotary.svg') }}';"
                        >
                        <div class="absolute top-2.5 left-2.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-slate-900/85 backdrop-blur-xs text-[11px] font-bold text-white border border-slate-700">
                                Unit Utama Lapangan
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700">Rotary Rooter</span>
                        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">100% Mekanis</span>
                    </div>

                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2.5 leading-snug">
                        Mesin Drain Rooter Spiral Baja Rotary Ridgid K-50 &amp; K-60
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Mesin drain cleaner bertenaga motor elektrik berkecepatan 400 RPM yang memutar kabel spiral baja lentur berinti kawat karbon. Mampu meluncur melewati belokan leher angsa dan elbow 90 derajat tanpa melubangi pipa PVC.
                    </p>
                    
                    <div class="space-y-2 text-xs text-slate-700 border-t border-slate-100 pt-4">
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                            <span><strong>Jangkauan:</strong> Hingga 30 meter sambung modular</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                            <span><strong>Diameter Pipa:</strong> Efektif untuk pipa 1.5 sampai 6 inci</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                            <span><strong>Aksi Kerja:</strong> Mengikis lemak padat, menarik rambut, dan memotong akar</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Motor Listrik 220V</span>
                    <span class="text-sky-700 font-bold">Standard Industri</span>
                </div>
            </div>

            <!-- Machine 2: CCTV Pipe Inspection -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs flex flex-col justify-between card-lift">
                <div>
                    <div class="relative aspect-[16/10] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 mb-6 group">
                        <img 
                            src="{{ asset('assets/TOOLKIT/kamera-cctv-pipa.webp') }}" 
                            alt="Kamera Inspeksi Endoskopi CCTV Pipa IP68 30 Meter" 
                            width="800" 
                            height="500" 
                            loading="eager" 
                            decoding="async" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/kamera-cctv-pipa.svg') }}';"
                        >
                        <div class="absolute top-2.5 left-2.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-sky-950/85 backdrop-blur-xs text-[11px] font-bold text-sky-300 border border-sky-700">
                                Diagnosis Visual
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-700">Pipe Inspection</span>
                        <span class="text-xs font-bold text-sky-700 bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-md">Kamera IP68 Digital</span>
                    </div>

                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2.5 leading-snug">
                        Kamera CCTV Endoskopi Pipa IP68 30 Meter
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Unit kamera industri tahan air beresolusi tinggi dengan lampu LED sorot adjustable dan kabel dorong fleksibel kaku. Memberikan inspeksi visual real-time kondisi bagian dalam pipa pada layar monitor LCD.
                    </p>
                    
                    <div class="space-y-2 text-xs text-slate-700 border-t border-slate-100 pt-4">
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                            <span><strong>Jangkauan:</strong> Push-rod fiberglass tahan tekuk 30M</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                            <span><strong>Pencahayaan:</strong> 12 LED ultra-bright + lensa safir</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mt-1.5 shrink-0"></span>
                            <span><strong>Dokumentasi:</strong> Video MP4 &amp; foto detail posisi sumbatan</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>IP68 Submersible</span>
                    <span class="text-sky-700 font-bold">Titik Pasti</span>
                </div>
            </div>

            <!-- Machine 3: High Pressure Hydro Jetting -->
            <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-7 shadow-2xs flex flex-col justify-between card-lift">
                <div>
                    <div class="relative aspect-[16/10] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 mb-6 group">
                        <img 
                            src="{{ asset('assets/TOOLKIT/hydro-jetting.webp') }}" 
                            alt="Unit High Pressure Hydro Jetting Drainusantara" 
                            width="800" 
                            height="500" 
                            loading="lazy" 
                            decoding="async" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/hydro-jetting.svg') }}';"
                        >
                        <div class="absolute top-2.5 left-2.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded bg-amber-950/85 backdrop-blur-xs text-[11px] font-bold text-amber-300 border border-amber-700">
                                Lemak &amp; Restoran
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-700">Hydro Jetting</span>
                        <span class="text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md">Tekanan Tinggi</span>
                    </div>

                    <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-2.5 leading-snug">
                        Unit Pembersih Saluran High Pressure Hydro Jetting
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                        Menembakkan semburan air mikro bertekanan 100-200 bar untuk mengikis dan membilas bersih tumpukan minyak beku, kerak lumpur, dan sisa limbah padat di restoran, ruko, serta instalasi industri.
                    </p>
                    
                    <div class="space-y-2 text-xs text-slate-700 border-t border-slate-100 pt-4">
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                            <span><strong>Tekanan Air:</strong> 100 - 200 Bar nozel multifungsi</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                            <span><strong>Target Masalah:</strong> Grease trap, pipa dapur resto, sedimentasi pasir</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                            <span><strong>Hasil:</strong> Dinding pipa bersih total seperti baru dipasang</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Eco-Friendly (Tanpa Kimia)</span>
                    <span class="text-amber-700 font-bold">Bilas Bersih Total</span>
                </div>
            </div>
        </div>
        @endif

        <!-- 4 Specialized Cutter Heads Section with Visual Card -->
        <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-2xs">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center mb-8">
                <div class="lg:col-span-8">
                    <span class="text-xs font-bold uppercase tracking-wider text-sky-700 block mb-1">
                        Mata Potong Modular
                    </span>
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">
                        4 Jenis Mata Pemotong Spiral Baja Khusus
                    </h3>
                    <p class="text-slate-600 text-xs sm:text-sm leading-relaxed max-w-2xl">
                        Setiap jenis sumbatan memiliki karakteristik fisik yang berbeda. Teknisi Drainusantara menggunakan ujung pemotong spesifik sesuai jenis hambatan di dalam pipa untuk hasil maksimal tanpa merusak dinding pipa.
                    </p>
                </div>
                
                <!-- Visual Box Mata Cutter -->
                <div class="lg:col-span-4">
                    <div class="relative aspect-[16/9] bg-slate-900 rounded-lg overflow-hidden border border-slate-200 group">
                        <img 
                            src="{{ asset('assets/TOOLKIT/cutter-mata-spiral.webp') }}" 
                            alt="Set 4 Jenis Mata Pemotong Spiral Baja" 
                            width="600" 
                            height="340" 
                            loading="lazy" 
                            decoding="async" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            onerror="this.onerror=null; this.src='{{ asset('assets/TOOLKIT/cutter-mata-spiral.svg') }}';"
                        >
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200/90 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-sky-800">Bulb Auger</span>
                            <span class="text-[10px] font-semibold text-slate-500 bg-white px-2 py-0.5 rounded border border-slate-200">Fleksibel</span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">Kepala spiral bulat untuk menembus belokan leher angsa dan melilit gumpalan rambut atau tisu basah.</p>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-200/60 text-[11px] text-slate-500">
                        Target: Wastafel &amp; Kamar Mandi
                    </div>
                </div>

                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200/90 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-sky-800">Grease Cutter</span>
                            <span class="text-[10px] font-semibold text-slate-500 bg-white px-2 py-0.5 rounded border border-slate-200">Pengikis</span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">Mata pisau pengikis khusus endapan minyak beku dan kerak lemak jenuh bak cuci piring dapur resto.</p>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-200/60 text-[11px] text-slate-500">
                        Target: Sink Dapur &amp; Grease Trap
                    </div>
                </div>

                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200/90 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-sky-800">Spade Cutter</span>
                            <span class="text-[10px] font-semibold text-slate-500 bg-white px-2 py-0.5 rounded border border-slate-200">Pisau Pipih</span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">Mata pisau pipih untuk mengikis kerak semen, pasir, dan lumpur padat pada floor drain dan pipa luar.</p>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-200/60 text-[11px] text-slate-500">
                        Target: Floor Drain &amp; Bak Kontrol
                    </div>
                </div>

                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200/90 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-sky-800">Sawtooth Root Cutter</span>
                            <span class="text-[10px] font-semibold text-slate-500 bg-white px-2 py-0.5 rounded border border-slate-200">Gigi Gergaji</span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">Gigi gergaji melingkar berdaya potong tinggi untuk memotong akar pohon yang menerobos sambungan pipa bawah tanah.</p>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-200/60 text-[11px] text-slate-500">
                        Target: Pipa Bawah Tanah / Taman
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
