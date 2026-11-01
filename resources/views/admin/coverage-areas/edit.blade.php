@extends('layouts.admin')

@section('title', 'Edit Area Jangkauan')
@section('page-title', 'Edit Area')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Area: {{ $coverageArea->district }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola diferensiasi landing page (harga, gambar, SEO geo, posko, keunggulan, dan perbandingan).</p>
        </div>
        <a href="{{ route('admin.coverage-areas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.coverage-areas.update', $coverageArea) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-8 shadow-2xs">
        @csrf
        @method('PUT')

        <!-- SECTION 1: INFORMASI WILAYAH & HARGA -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">1. Wilayah &amp; Tarif Layanan</h2>
                <p class="text-xs text-slate-500">Pengaturan lokasi dasar dan diferensiasi harga mulai penanganan pipa.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kota / Wilayah *</label>
                    <input type="text" name="city" id="city" required value="{{ old('city', $coverageArea->city) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                    @error('city') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="district" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kecamatan / Area *</label>
                    <input type="text" name="district" id="district" required value="{{ old('district', $coverageArea->district) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                    @error('district') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="postal_code" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kode Pos (Opsional)</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $coverageArea->postal_code) }}" placeholder="Contoh: 12810" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div class="sm:col-span-3">
                    <label for="starting_price" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tarif Pengerjaan Mulai Dari (Rp)</label>
                    <div class="relative max-w-xs">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-xs font-semibold text-slate-400">Rp</span>
                        <input type="number" name="starting_price" id="starting_price" min="0" step="50000" value="{{ old('starting_price', $coverageArea->starting_price) }}" placeholder="400000" class="w-full pl-9 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">Kosongkan untuk memakai harga standar nasional (Rp 400.000). Ditampilkan di hero, card layanan, dan schema Google.</p>
                    @error('starting_price') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan / Konten Lokal (Opsional)</label>
                    <textarea name="content" id="content" rows="3" placeholder="Informasi tambahan khusus area ini..." class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('content', $coverageArea->content) }}</textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 2: FOTO HERO WILAYAH -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">2. Foto Hero Section Wilayah</h2>
                <p class="text-xs text-slate-500">Foto latar belakang khusus hero section wilayah ini. Mewarisi hierarki kota/provinsi jika dikosongkan.</p>
            </div>

            <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3" x-data="{ heroPreview: {{ Illuminate\Support\Js::from($coverageArea->hero_image) }} }">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                    <div class="w-full h-32 rounded-lg border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden relative shadow-2xs">
                        <template x-if="heroPreview">
                            <img :src="heroPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!heroPreview">
                            <div class="text-center p-2 text-slate-400">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-[11px] font-medium">Foto Standar Wilayah</span>
                            </div>
                        </template>
                    </div>

                    <div class="sm:col-span-2 space-y-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Berkas Gambar Baru</label>
                            <input type="file" name="hero_image" id="hero_image" accept="image/jpeg,image/png,image/webp"
                                   @change="const f = $event.target.files[0]; if (f) { heroPreview = URL.createObjectURL(f); }"
                                   class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                            @error('hero_image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="hero_image_url" class="block text-xs font-bold text-slate-700 mb-1">Atau Link URL Gambar Eksternal</label>
                            <input type="url" name="hero_image_url" id="hero_image_url" value="{{ old('hero_image_url') }}"
                                   placeholder="https://.../foto-wilayah.webp"
                                   @input="if ($event.target.value) { heroPreview = $event.target.value; }"
                                   class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                        </div>

                        @if($coverageArea->hero_image)
                            <div class="pt-1">
                                <label class="inline-flex items-center gap-1.5 text-xs text-rose-700 font-medium cursor-pointer">
                                    <input type="checkbox" name="remove_hero_image" value="1" @change="if($event.target.checked) heroPreview = null" class="w-3.5 h-3.5 rounded text-rose-600 border-slate-300 focus:ring-rose-500">
                                    <span>Hapus foto kustom (kembali ke foto bawaan hierarki)</span>
                                </label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: CTA & WHATSAPP WILAYAH -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">3. Diferensiasi CTA &amp; WhatsApp</h2>
                <p class="text-xs text-slate-500">Kustomisasi judul ajakan bertindak dan parameter pesan otomatis WhatsApp khusus area ini.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="cta_headline" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul CTA Banner</label>
                    <input type="text" name="cta_headline" id="cta_headline" value="{{ old('cta_headline', $coverageArea->cta_headline) }}" placeholder="Saluran Air di {{ $coverageArea->district }} Tersumbat Hari Ini?" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div>
                    <label for="cta_button_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Teks Tombol CTA</label>
                    <input type="text" name="cta_button_text" id="cta_button_text" value="{{ old('cta_button_text', $coverageArea->cta_button_text) }}" placeholder="Panggil Teknisi di {{ $coverageArea->district }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div class="sm:col-span-2">
                    <label for="cta_whatsapp_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Format Teks Pesan WhatsApp</label>
                    <textarea name="cta_whatsapp_text" id="cta_whatsapp_text" rows="2" placeholder="Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area {{ $coverageArea->district }}, {{ $coverageArea->city }}..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('cta_whatsapp_text', $coverageArea->cta_whatsapp_text) }}</textarea>
                    <p class="text-[11px] text-slate-500 mt-1">Jika dikosongkan, sistem memakai format dinamis otomatis yang sudah mencantumkan nama kecamatan dan kota.</p>
                </div>
            </div>
        </div>

        <!-- SECTION 4: SEO GEO TERSEMBUNYI (BACKEND ONLY) -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <div class="flex items-center gap-2">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">4. SEO Geo &amp; Meta Tags (Tersembunyi)</h2>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">Backend Only</span>
                </div>
                <p class="text-xs text-slate-500">Data ini HANYA disuntikkan ke tag &lt;head&gt; dan Schema JSON-LD Plumber Google tanpa terlihat mengotori visual frontend.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label for="meta_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">SEO Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $coverageArea->meta_title) }}" placeholder="Jasa Saluran Mampet di {{ $coverageArea->district }}, {{ $coverageArea->city }} - Drainusantara Bergaransi" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div class="sm:col-span-2">
                    <label for="meta_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">SEO Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('meta_description', $coverageArea->meta_description) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label for="geo_keywords" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Geo Keywords Lokal (Pisahkan dengan koma)</label>
                    <textarea name="geo_keywords" id="geo_keywords" rows="2" placeholder="saluran mampet {{ $coverageArea->district }}, sedot wc {{ $coverageArea->district }}, pelancar wastafel {{ $coverageArea->district }}, tukang pipa {{ $coverageArea->district }}" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('geo_keywords', $coverageArea->geo_keywords) }}</textarea>
                    <p class="text-[11px] text-slate-500 mt-1">Disematkan langsung ke meta keywords dan Schema hasOfferCatalog.</p>
                </div>

                <div>
                    <label for="latitude" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Latitude (Lintang)</label>
                    <input type="number" step="0.0000001" name="latitude" id="latitude" value="{{ old('latitude', $coverageArea->latitude) }}" placeholder="-6.2297465" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div>
                    <label for="longitude" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Longitude (Bujur)</label>
                    <input type="number" step="0.0000001" name="longitude" id="longitude" value="{{ old('longitude', $coverageArea->longitude) }}" placeholder="106.8553214" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>
            </div>
        </div>

        <!-- SECTION 5: POSKO & POOL ARMADA -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">5. Posko &amp; Pool Armada Wilayah</h2>
                <p class="text-xs text-slate-500">Lokasi siaga armada teknisi, jangkauan respon, dan alamat titik kumpul di kecamatan/kota ini.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="posko_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Posko Siaga</label>
                    <input type="text" name="posko_name" id="posko_name" value="{{ old('posko_name', $coverageArea->posko_name) }}" placeholder="Posko Siaga Drainusantara Unit {{ $coverageArea->district }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div>
                    <label for="posko_coverage_radius" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Radius &amp; Waktu Respon</label>
                    <input type="text" name="posko_coverage_radius" id="posko_coverage_radius" value="{{ old('posko_coverage_radius', $coverageArea->posko_coverage_radius) }}" placeholder="Radius 15-20 KM • Teknisi Menuju ke Lokasi Anda Secepatnya" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div class="sm:col-span-2">
                    <label for="posko_address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Operasional Armada</label>
                    <textarea name="posko_address" id="posko_address" rows="2" placeholder="Pusat Operasional Armada Siaga Drainusantara Area {{ $coverageArea->city }} (Melayani seluruh kelurahan di {{ $coverageArea->district }})..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('posko_address', $coverageArea->posko_address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 6: KEUNGGULAN LOKAL (REPEATER) -->
        @php
            $rawAdvantages = old('advantages', $coverageArea->advantages ?? []);
            if (!is_array($rawAdvantages) || empty($rawAdvantages)) {
                $rawAdvantages = [];
            }
        @endphp
        <div class="space-y-4" x-data="{
            advantages: {{ Illuminate\Support\Js::from($rawAdvantages) }},
            addAdvantage() {
                this.advantages.push({ title: '', description: '', icon: 'check' });
            },
            removeAdvantage(idx) {
                this.advantages.splice(idx, 1);
            },
            loadDefaultAdvantages() {
                const district = '{{ addslashes($coverageArea->district) }}' || 'Wilayah';
                this.advantages = [
                    { title: `Teknisi Siaga di Area ${district}`, description: 'Posko armada terdekat bergerak cepat, teknisi menuju ke lokasi anda secepatnya.', icon: 'truck' },
                    { title: 'Rotary Spiral Tempered Tanpa Kimia', description: 'Meliuk fleksibel membersihkan lemak dan endapan tanpa risiko pipa PVC meleleh atau keramik terbongkar.', icon: 'tool' },
                    { title: 'Garansi Resmi 30 Hari Kalender', description: 'Dilindungi nota garansi digital. Apabila terjadi kendala berulang di titik yang sama, kami perbaiki gratis.', icon: 'shield' },
                    { title: 'Transparansi Biaya No Cure No Pay', description: 'Kepastian biaya sejak awal. Bebas biaya jasa jika saluran air gagal kami lancarkan secara tuntas.', icon: 'currency' }
                ];
            }
        }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-2">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">6. Keunggulan Wilayah (Diferensiasi Khusus)</h2>
                    <p class="text-xs text-slate-500">Poin keunggulan armada &amp; SOP penanganan lokal. Kosongkan untuk memakai paket standar kontekstual.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="loadDefaultAdvantages()" class="px-2.5 py-1 text-xs font-semibold rounded-md border border-sky-300 text-sky-700 bg-sky-50 hover:bg-sky-100 transition-colors cursor-pointer">
                        Isi Bawaan
                    </button>
                    <button type="button" @click="addAdvantage()" class="px-2.5 py-1 text-xs font-semibold rounded-md bg-sky-700 hover:bg-sky-800 text-white transition-colors cursor-pointer flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Poin</span>
                    </button>
                </div>
            </div>

            <template x-if="advantages.length === 0">
                <div class="p-4 rounded-lg bg-slate-50 border border-dashed border-slate-300 text-center text-xs text-slate-500">
                    Belum ada keunggulan kustom. Halaman publik akan menampilkan 4 keunggulan standar yang terlokalisasi dengan nama {{ $coverageArea->district }}.
                </div>
            </template>

            <div class="space-y-3">
                <template x-for="(item, idx) in advantages" :key="idx">
                    <div class="p-3.5 bg-slate-50/75 rounded-lg border border-slate-200 space-y-2 relative shadow-2xs">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-sky-700" x-text="`Keunggulan #${idx + 1}`"></span>
                            <button type="button" @click="removeAdvantage(idx)" class="text-slate-400 hover:text-rose-600 transition-colors p-1" title="Hapus">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Judul Keunggulan</label>
                                <input type="text" :name="`advantages[${idx}][title]`" x-model="item.title" placeholder="Contoh: Teknisi Siaga di Area {{ $coverageArea->district }}" class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Deskripsi Ringkas</label>
                                <input type="text" :name="`advantages[${idx}][description]`" x-model="item.description" placeholder="Penjelasan keunggulan..." class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- SECTION 7: MATRIKS PERBANDINGAN TUKANG VS DRAINUSANTARA -->
        @php
            $rawComparison = old('comparison_data', $coverageArea->comparison_data ?? []);
            if (!is_array($rawComparison) || empty($rawComparison)) {
                $rawComparison = [];
            }
        @endphp
        <div class="space-y-4" x-data="{
            comparisons: {{ Illuminate\Support\Js::from($rawComparison) }},
            addComparison() {
                this.comparisons.push({ aspect: '', tukang: '', drainusantara: '' });
            },
            removeComparison(idx) {
                this.comparisons.splice(idx, 1);
            },
            loadDefaultComparison() {
                this.comparisons = [
                    { aspect: 'Metode Pengerjaan', tukang: 'Sering kali menyarankan bongkar keramik lantai atau menuangkan cairan soda api keras yang merusak pipa PVC.', drainusantara: '100% mekanis menggunakan kabel spiral baja rotary Ridgid yang meliuk fleksibel tanpa merusak ubin lantai hunian.' },
                    { aspect: 'Peralatan & Teknologi', tukang: 'Kawat manual seadanya atau bambu yang rawan patah di dalam jalur pembuangan dan memperparah sumbatan.', drainusantara: 'Mesin Spiral Elektrik berdaya puntir tinggi plus inspeksi kamera CCTV 30M untuk diagnosa presisi.' },
                    { aspect: 'Jaminan & Garansi', tukang: 'Tanpa nota atau garansi tertulis. Jika mampet kembali keesokan harinya, Anda harus membayar jasa dari awal.', drainusantara: 'Garansi resmi 30 hari kalender dengan nota digital. Ada kendala berulang di titik sama, perbaikan tuntas gratis.' },
                    { aspect: 'Keamanan Pipa PVC', tukang: 'Zat kimia korosif dapat melunakkan sambungan fitting lem pipa di bawah cor semen dan memicu kebocoran tersembunyi.', drainusantara: 'Sangat aman untuk sambungan PVC standar perumahan, ruko, restoran, hingga pipa talang vertikal gedung.' },
                    { aspect: 'Kepastian Biaya', tukang: 'Biaya spekulasi borongan yang dapat membengkak di tengah proses pengerjaan.', drainusantara: 'Tarif jelas sejak awal dengan komitmen No Cure No Pay (tidak lancar, bebas tagihan biaya jasa pengerjaan).' }
                ];
            }
        }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-2">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">7. Matriks Perbandingan (Tukang Konvensional vs Drainusantara)</h2>
                    <p class="text-xs text-slate-500">Tabel komparasi transparan. Jika dikosongkan, menggunakan 5 aspek standar profesional.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="loadDefaultComparison()" class="px-2.5 py-1 text-xs font-semibold rounded-md border border-sky-300 text-sky-700 bg-sky-50 hover:bg-sky-100 transition-colors cursor-pointer">
                        Isi 5 Aspek Standar
                    </button>
                    <button type="button" @click="addComparison()" class="px-2.5 py-1 text-xs font-semibold rounded-md bg-sky-700 hover:bg-sky-800 text-white transition-colors cursor-pointer flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Aspek</span>
                    </button>
                </div>
            </div>

            <template x-if="comparisons.length === 0">
                <div class="p-4 rounded-lg bg-slate-50 border border-dashed border-slate-300 text-center text-xs text-slate-500">
                    Belum ada kustomisasi. Halaman publik otomatis menampilkan 5 aspek komparasi standar (Metode, Alat, Garansi, Keamanan Pipa, Biaya).
                </div>
            </template>

            <div class="space-y-3">
                <template x-for="(comp, idx) in comparisons" :key="idx">
                    <div class="p-3.5 bg-slate-50/75 rounded-lg border border-slate-200 space-y-2 relative shadow-2xs">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-sky-700" x-text="`Aspek Komparasi #${idx + 1}`"></span>
                            <button type="button" @click="removeComparison(idx)" class="text-slate-400 hover:text-rose-600 transition-colors p-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nama Aspek / Parameter</label>
                            <input type="text" :name="`comparison_data[${idx}][aspect]`" x-model="comp.aspect" placeholder="Contoh: Metode Pengerjaan" class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 outline-hidden">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-rose-700 mb-1">Tukang Konvensional</label>
                                <textarea :name="`comparison_data[${idx}][tukang]`" x-model="comp.tukang" rows="2" placeholder="Kelemahan cara konvensional..." class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 outline-hidden"></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-emerald-700 mb-1">Standar Drainusantara</label>
                                <textarea :name="`comparison_data[${idx}][drainusantara]`" x-model="comp.drainusantara" rows="2" placeholder="Keunggulan standar Drainusantara..." class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 outline-hidden"></textarea>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- SECTION 8: TAG PENDUKUNG / DAERAH SEKITAR (SECTION BAWAH) -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">8. Tag Pendukung &amp; Daerah Sekitar (Section Bawah)</h2>
                <p class="text-xs text-slate-500">Daftar kelurahan, jalan protokol, atau landmark spesifik yang diletakkan di section bawah halaman sebelum CTA penutup.</p>
            </div>

            @php
                $tagsString = is_array($coverageArea->supporting_tags) ? implode(', ', $coverageArea->supporting_tags) : ($coverageArea->supporting_tags ?? '');
            @endphp
            <div>
                <label for="supporting_tags" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tag Wilayah &amp; Kelurahan (Pisahkan dengan koma)</label>
                <textarea name="supporting_tags" id="supporting_tags" rows="2" placeholder="Kelurahan A, Kelurahan B, Jalan Protokol X, Kawasan Bisnis Y..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('supporting_tags', $tagsString) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Sistem juga otomatis menggabungkan kecamatan tetangga dalam satu kota.</p>
            </div>
        </div>

        <!-- SECTION 9: FAQ DINAMIS WILAYAH -->
        @php
            $existingFaqs = old('faqs', $coverageArea->faqs ?? []);
            if (!is_array($existingFaqs)) {
                $existingFaqs = [];
            }
        @endphp
        <div class="space-y-4" x-data="{
            faqs: {{ Illuminate\Support\Js::from($existingFaqs) }},
            addFaq(q = '', a = '') {
                this.faqs.push({ question: q, answer: a });
            },
            removeFaq(index) {
                this.faqs.splice(index, 1);
            },
            loadTemplate() {
                const district = '{{ addslashes($coverageArea->district) }}' || 'Wilayah';
                const city = '{{ addslashes($coverageArea->city) }}' || 'Sekitarnya';
                const price = 'Rp ' + Number({{ $coverageArea->resolved_price }}).toLocaleString('id-ID');
                this.faqs = [
                    { question: `Berapa lama estimasi teknisi Drainusantara tiba di area ${district}, ${city}?`, answer: `Armada siaga teknisi kami di posko ${city} umumnya dapat tiba di lokasi Anda di area ${district} dalam waktu 30 hingga 60 menit setelah konfirmasi pemesanan, menyesuaikan rute lalu lintas terdekat.` },
                    { question: `Apakah pengerjaan saluran mampet di ${district} membongkar lantai keramik?`, answer: `Sama sekali tidak (100% tanpa bongkar ubin/keramik). Kami menggunakan mesin spiral baja rotary berdaya puntir tinggi yang meliuk mengikuti alur pipa PVC hingga titik sumbatan terdalam tanpa merusak struktur lantai.` },
                    { question: `Jenis saluran apa saja yang dilayani di ${district}?`, answer: `Kami menangani pelancaran wastafel sink cuci piring, kloset toilet duduk/jongkok, floor drain kamar mandi, bak kontrol rumah, talang pipa atap, hingga pembersihan rutin grease trap restoran & ruko di seluruh area ${district}.` },
                    { question: `Berapa biaya jasa pelancaran pipa mampet di ${district}?`, answer: `Biaya jasa penanganan mulai dari ${price} dengan skema No Cure No Pay (jika saluran gagal mengalir lancar, Anda bebas dari biaya jasa pengerjaan).` },
                    { question: `Apakah ada garansi resmi untuk pengerjaan di ${district}?`, answer: `Ya, setiap pengerjaan yang dinyatakan tuntas dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi sumbatan ulang di titik yang sama dalam masa garansi, tim kami melancarkan ulang tanpa biaya tambahan.` }
                ];
            }
        }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-2">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">9. Tanya Jawab (FAQ) Wilayah</h2>
                    <p class="text-xs text-slate-500">Pertanyaan &amp; jawaban khusus untuk area ini. Otomatis memakai template kontekstual jika kosong.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="loadTemplate()" class="px-2.5 py-1 text-xs font-semibold rounded-md border border-sky-300 text-sky-700 bg-sky-50 hover:bg-sky-100 transition-colors cursor-pointer">
                        Gunakan Template Wilayah
                    </button>
                    <button type="button" @click="addFaq()" class="px-2.5 py-1 text-xs font-semibold rounded-md bg-sky-700 hover:bg-sky-800 text-white transition-colors cursor-pointer flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah FAQ</span>
                    </button>
                </div>
            </div>

            <template x-if="faqs.length === 0">
                <div class="p-4 rounded-lg bg-slate-50 border border-dashed border-slate-300 text-center text-xs text-slate-500">
                    Belum ada FAQ kustom. Halaman publik otomatis menampilkan template FAQ cerdas berbasis nama area &amp; harga lokal.
                </div>
            </template>

            <div class="space-y-3">
                <template x-for="(faq, index) in faqs" :key="index">
                    <div class="p-3.5 bg-slate-50/75 rounded-lg border border-slate-200 space-y-2 relative shadow-2xs">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[11px] font-bold text-sky-700" x-text="`FAQ #${index + 1}`"></span>
                            <button type="button" @click="removeFaq(index)" class="text-slate-400 hover:text-rose-600 transition-colors p-1" title="Hapus pertanyaan ini">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Pertanyaan</label>
                            <input type="text" :name="`faqs[${index}][question]`" x-model="faq.question" placeholder="Contoh: Berapa lama estimasi teknisi tiba?" class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 outline-hidden">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jawaban</label>
                            <textarea :name="`faqs[${index}][answer]`" x-model="faq.answer" rows="2" placeholder="Jawaban..." class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 outline-hidden"></textarea>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- SECTION 10: STATUS AKTIF & SIMPAN -->
        <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $coverageArea->is_active) ? 'checked' : '' }} class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_active" class="text-xs sm:text-sm font-semibold text-slate-800 cursor-pointer">Publikasikan halaman landing page area ini</label>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.coverage-areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold shadow-2xs transition-colors cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
