@extends('layouts.admin')

@section('title', 'Edit Area Jangkauan')
@section('page-title', 'Edit Area')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            @php
                $headerTitle = match($coverageArea->type) {
                    'province' => 'Provinsi ' . ($coverageArea->province_name ?: $coverageArea->city),
                    'city' => 'Kota ' . $coverageArea->city,
                    default => 'Area ' . $coverageArea->district,
                };
                $badgeInfo = match($coverageArea->type) {
                    'province' => ['label' => 'PROVINSI', 'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
                    'city' => ['label' => 'KOTA / KAB', 'class' => 'bg-sky-50 text-sky-700 border-sky-200'],
                    default => ['label' => 'AREA', 'class' => 'bg-slate-100 text-slate-700 border-slate-200'],
                };
            @endphp
            <div class="flex items-center gap-2.5 flex-wrap">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Area: {{ $headerTitle }}</h1>
                <span class="px-2.5 py-0.5 rounded text-xs font-bold border {{ $badgeInfo['class'] }}">
                    {{ $badgeInfo['label'] }}
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola diferensiasi landing page (level hierarki, harga, gambar hero, foto kehadiran lokal, posko, FAQ, dan SEO).</p>
        </div>
        <div class="flex items-center gap-2">
            @if($coverageArea->publicUrl())
                <a href="{{ $coverageArea->publicUrl() }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-700 hover:text-sky-900 px-3 py-1.5 rounded-lg border border-sky-300 bg-sky-50 hover:bg-sky-100 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Halaman Publik</span>
                </a>
            @endif
            <a href="{{ route('admin.coverage-areas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <form action="{{ route('admin.coverage-areas.update', $coverageArea) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-8 shadow-2xs">
        @csrf
        @method('PUT')

        <!-- SECTION 1: LEVEL HIERARKI & WILAYAH -->
        <div class="space-y-4" x-data="{
            areaType: '{{ old('type', $coverageArea->type ?: 'district') }}'
        }">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">1. Level Wilayah &amp; Tarif Layanan</h2>
                <p class="text-xs text-slate-500">Pilih level hierarki (Provinsi, Kota, atau Kecamatan) dan atur cakupan landing page.</p>
            </div>

            <!-- Area Type Selector -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tingkat / Level Area *</label>
                <div class="grid grid-cols-3 gap-3 max-w-lg">
                    <label class="flex items-center gap-2.5 p-3 rounded-lg border cursor-pointer transition-all"
                           :class="areaType === 'province' ? 'bg-indigo-50 border-indigo-500 text-indigo-900 font-bold shadow-2xs' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'">
                        <input type="radio" name="type" value="province" x-model="areaType" class="text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs">Provinsi</span>
                    </label>
                    <label class="flex items-center gap-2.5 p-3 rounded-lg border cursor-pointer transition-all"
                           :class="areaType === 'city' ? 'bg-sky-50 border-sky-500 text-sky-900 font-bold shadow-2xs' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'">
                        <input type="radio" name="type" value="city" x-model="areaType" class="text-sky-600 focus:ring-sky-500">
                        <span class="text-xs">Kota / Kab</span>
                    </label>
                    <label class="flex items-center gap-2.5 p-3 rounded-lg border cursor-pointer transition-all"
                           :class="areaType === 'district' ? 'bg-slate-100 border-slate-500 text-slate-900 font-bold shadow-2xs' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100'">
                        <input type="radio" name="type" value="district" x-model="areaType" class="text-slate-600 focus:ring-slate-500">
                        <span class="text-xs">Kecamatan</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-1">
                <div x-show="areaType === 'province'">
                    <label for="province_name_input" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Provinsi *</label>
                    <input type="text" name="province_name" id="province_name_input" value="{{ old('province_name', $coverageArea->province_name ?: $coverageArea->city) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-700 focus:ring-2 focus:ring-indigo-700/20 outline-hidden transition shadow-2xs">
                    <p class="text-[11px] text-slate-500 mt-1">Landing page publik: <code>/area/provinsi/{slug}</code></p>
                </div>

                <div x-show="areaType !== 'province'">
                    <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kota / Kabupaten *</label>
                    <input type="text" name="city" id="city" required value="{{ old('city', $coverageArea->city) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                    @error('city') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div x-show="areaType === 'district'">
                    <label for="district" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kecamatan / Area *</label>
                    <input type="text" name="district" id="district" required value="{{ old('district', $coverageArea->district) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                    @error('district') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div x-show="areaType === 'city'">
                    <label for="city_province_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Provinsi Induk (Opsional)</label>
                    <input type="text" name="province_name" id="city_province_name" value="{{ old('province_name', $coverageArea->province_name) }}" placeholder="Contoh: DKI Jakarta, Jawa Barat" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                    <p class="text-[11px] text-slate-500 mt-1">Landing page publik: <code>/area/{slug}</code></p>
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

            <x-form.image-upload 
                name="hero_image" 
                label="Unggah Foto Hero Wilayah" 
                :current="$coverageArea->hero_image"
                :allowUrl="true" 
                urlName="hero_image_url" 
                :urlValue="old('hero_image_url')"
                removeName="remove_hero_image"
                removeLabel="Hapus foto kustom (kembali ke foto bawaan hierarki)"
                aspect="video"
                help="Format WebP, JPG, PNG (Maks. 20MB). Otomatis dikompresi &amp; dikonversi ke WebP teroptimasi." />
        </div>

        <!-- SECTION 2.5: KEHADIRAN LOKAL (DRAINTUSANTARA HADIR DI WILAYAH/KOTA) -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <div class="flex items-center gap-2">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">2.5. Kehadiran Lokal ("Drainusantara Hadir di [Kota/Wilayah]")</h2>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-50 text-sky-800 border border-sky-200">Landing Kota &amp; Provinsi</span>
                </div>
                <p class="text-xs text-slate-500">Foto dokumentasi posko/armada kota dan narasi kehadiran teknisi yang tampil pada landing page kota (/area/{kota}).</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                <x-form.image-upload 
                    name="presence_image" 
                    label="Unggah Foto Kehadiran / Posko Armada Kota" 
                    :current="$coverageArea->presence_image"
                    removeName="remove_presence_image"
                    removeLabel="Hapus foto kehadiran kustom"
                    aspect="video"
                    help="Format WebP, JPG, PNG (Maks. 20MB). Dikonversi otomatis menjadi WebP teroptimasi." />

                <div>
                    <label for="presence_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Kehadiran Drainusantara di Wilayah Ini</label>
                    <textarea name="presence_description" id="presence_description" rows="4" placeholder="Jaringan armada siaga Drainusantara hadir melayani seluruh penjuru wilayah..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('presence_description', $coverageArea->presence_description) }}</textarea>
                    <p class="text-[11px] text-slate-500 mt-1">Ditampilkan pada section 'Drainusantara Hadir di [Kota]' di landing page kota.</p>
                </div>
            </div>
        </div>

        <!-- SECTION PILIHAN GALERI HASIL PENGERJAAN -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <div class="flex items-center gap-2">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">Pilihan Galeri Hasil Pengerjaan (Dokumentasi Lapangan)</h2>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-50 text-sky-800 border border-sky-200">Provinsi, Kota &amp; Kecamatan</span>
                </div>
                <p class="text-xs text-slate-500">Pilih hasil pengerjaan dari database dokumentasi teknisi yang ingin ditampilkan pada section 'Hasil Pengerjaan Teknisi di Lapangan'. Jika tidak ada yang dipilih, sistem otomatis memilih secara cerdas berdasarkan kecocokan wilayah / order terbaru.</p>
            </div>

            @php
                $selectedGalleryIds = old('gallery_ids', $coverageArea->gallery_ids ?? []);
                if (!is_array($selectedGalleryIds)) {
                    $selectedGalleryIds = [];
                }
            @endphp

            <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3"
                 x-data="{
                     search: '',
                     selectedCount: {{ count($selectedGalleryIds) }},
                     updateCount() {
                         this.selectedCount = document.querySelectorAll('input[name=\'gallery_ids[]\']:checked').length;
                     }
                 }">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="relative flex-1 max-w-sm">
                        <input type="text"
                               x-model="search"
                               placeholder="Cari dokumentasi (judul, lokasi, kategori)..."
                               class="w-full rounded-lg border border-slate-300 pl-8 pr-3 py-1.5 text-xs focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden bg-white">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <span class="font-bold text-sky-800 bg-sky-100 px-2.5 py-1 rounded border border-sky-200">
                            <span x-text="selectedCount"></span> Terpilih
                        </span>
                        <span class="text-slate-500 text-[11px]">(Default otomatis jika 0 terpilih)</span>
                    </div>
                </div>

                @if(isset($availableGalleries) && $availableGalleries->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto pr-1">
                        @foreach($availableGalleries as $g)
                            @php
                                $isChecked = in_array($g->id, $selectedGalleryIds);
                                $thumb = !empty($g->image) ? asset($g->image) : (!empty($g->after_image) ? asset($g->after_image) : asset('assets/placeholders/service.svg'));
                                $keywords = strtolower($g->title . ' ' . $g->location . ' ' . $g->category_label);
                            @endphp
                            <label class="flex items-start gap-3 p-2.5 rounded-lg border border-slate-200 bg-white hover:border-sky-400 transition-colors cursor-pointer select-none"
                                   x-show="!search || {{ json_encode($keywords) }}.includes(search.toLowerCase())">
                                <input type="checkbox"
                                       name="gallery_ids[]"
                                       value="{{ $g->id }}"
                                       {{ $isChecked ? 'checked' : '' }}
                                       @change="updateCount()"
                                       class="mt-1 w-4 h-4 rounded text-sky-700 border-slate-300 focus:ring-sky-600 shrink-0">
                                <div class="w-14 h-14 rounded overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                    <img src="{{ $thumb }}" alt="{{ $g->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-slate-800 line-clamp-1 leading-snug">{{ $g->title }}</p>
                                    <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            {{ $g->category_label }}
                                        </span>
                                        @if($g->location)
                                            <span class="text-[10px] text-slate-500 truncate max-w-[120px]">{{ $g->location }}</span>
                                        @endif
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-500 italic py-2">Belum ada dokumentasi hasil pengerjaan di database galeri.</p>
                @endif
                @error('gallery_ids') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
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
                const areaType = '{{ $coverageArea->type }}';
                const provinceName = '{{ addslashes($coverageArea->province_name ?: $coverageArea->city) }}';
                const city = '{{ addslashes($coverageArea->city) }}';
                const district = '{{ addslashes($coverageArea->district) }}';
                const price = 'Rp ' + Number({{ $coverageArea->resolved_price }}).toLocaleString('id-ID');

                if (areaType === 'province') {
                    this.faqs = [
                        { question: `Berapa lama estimasi armada teknisi tiba di kota/kabupaten dalam Provinsi ${provinceName}?`, answer: `Dengan posko armada terdistribusi di setiap kota strategis di Provinsi ${provinceName}, teknisi kami dapat tiba di lokasi dalam rentang waktu 30 hingga 60 menit setelah konfirmasi pesanan.` },
                        { question: `Apakah pengerjaan di seluruh Provinsi ${provinceName} dilindungi garansi resmi?`, answer: `Ya, seluruh penanganan pipa mampet di Provinsi ${provinceName} dilindungi garansi tertulis 30 hari kalender. Jika terjadi kendala berulang pada titik yang sama, perbaikan ulang dilakukan tanpa biaya tambahan.` },
                        { question: `Mengapa metode rotary spiral mekanis tanpa bongkar lebih aman dibanding bahan kimia?`, answer: `Zat kimia keras dapat melarutkan fitting sambungan pipa PVC dan memicu kebocoran di bawah struktur semen. Metode spiral baja rotary 100% mekanis dan aman untuk pipa segala usia.` },
                        { question: `Bagaimana sistem pembayaran No Cure No Pay di Provinsi ${provinceName}?`, answer: `Jika tim teknisi kami tidak berhasil melancarkan sumbatan saluran pipa Anda, Anda tidak dikenakan biaya jasa pengerjaan sepeser pun.` },
                        { question: `Layanan saluran pipa apa saja yang dilayani di Provinsi ${provinceName}?`, answer: `Kami melayani kloset WC, wastafel cuci piring, floor drain kamar mandi, bak kontrol, talang air hujan, hingga pembersihan rutin grease trap ruko dan resto di seluruh wilayah ${provinceName}.` }
                    ];
                } else if (areaType === 'city') {
                    this.faqs = [
                        { question: `Berapa lama estimasi kedatangan teknisi di ${city}?`, answer: `Armada siaga teknisi kami di posko ${city} umumnya tiba di lokasi alamat Anda dalam waktu 30 hingga 45 menit tergantung kondisi rute jalan terdekat.` },
                        { question: `Apakah pengerjaan pipa mampet di ${city} membutuhkan pembongkaran lantai keramik?`, answer: `Tidak ada pembongkaran keramik sama sekali (100% non-destruktif). Kami memakai mesin spiral rotary berdaya puntir tinggi yang meliuk fleksibel hingga titik mampet terdalam.` },
                        { question: `Kategori properti apa saja yang dilayani di ${city}?`, answer: `Kami melayani hunian rumah tinggal, ruko, restoran, kafe F&B, gedung kantor, hingga fasilitas pergudangan dan pabrik di seluruh kecamatan di ${city}.` },
                        { question: `Berapa tarif jasa pengerjaan pipa mampet di ${city}?`, answer: `Tarif penanganan mulai dari ${price} dengan jaminan No Cure No Pay (tidak lancar plong, gratis biaya jasa pengerjaan).` },
                        { question: `Bagaimana prosedur klaim garansi 30 hari di ${city}?`, answer: `Cukup tunjukkan nota invoice digital atau konfirmasi nomor WhatsApp pemesanan Anda. Teknisi posko ${city} akan segera dijadwalkan ulang untuk inspeksi dan pelancaran gratis.` }
                    ];
                } else {
                    this.faqs = [
                        { question: `Berapa lama estimasi teknisi Drainusantara tiba di area ${district}, ${city}?`, answer: `Armada siaga teknisi kami di posko ${city} umumnya dapat tiba di lokasi Anda di area ${district} dalam waktu 30 hingga 60 menit setelah konfirmasi pemesanan, menyesuaikan rute lalu lintas terdekat.` },
                        { question: `Apakah pengerjaan saluran mampet di ${district} membongkar lantai keramik?`, answer: `Sama sekali tidak (100% tanpa bongkar ubin/keramik). Kami menggunakan mesin spiral baja rotary berdaya puntir tinggi yang meliuk mengikuti alur pipa PVC hingga titik sumbatan terdalam tanpa merusak struktur lantai.` },
                        { question: `Jenis saluran apa saja yang dilayani di ${district}?`, answer: `Kami menangani pelancaran wastafel sink cuci piring, kloset toilet duduk/jongkok, floor drain kamar mandi, bak kontrol rumah, talang pipa atap, hingga pembersihan rutin grease trap restoran & ruko di seluruh area ${district}.` },
                        { question: `Berapa biaya jasa pelancaran pipa mampet di ${district}?`, answer: `Biaya jasa penanganan mulai dari ${price} dengan skema No Cure No Pay (jika saluran gagal mengalir lancar, Anda bebas dari biaya jasa pengerjaan).` },
                        { question: `Apakah ada garansi resmi untuk pengerjaan di ${district}?`, answer: `Ya, setiap pengerjaan yang dinyatakan tuntas dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi sumbatan ulang di titik yang sama dalam masa garansi, tim kami melancarkan ulang tanpa biaya tambahan.` }
                    ];
                }
            }
        }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-2">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">9. Tanya Jawab (FAQ) Dinamis Wilayah</h2>
                    <p class="text-xs text-slate-500">FAQ yang tampil di landing page provinsi, kota, atau kecamatan. Otomatis memakai template kontekstual jika kosong.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="loadTemplate()" class="px-2.5 py-1 text-xs font-semibold rounded-md border border-sky-300 text-sky-700 bg-sky-50 hover:bg-sky-100 transition-colors cursor-pointer">
                        Gunakan Template {{ $coverageArea->type === 'province' ? 'Provinsi' : ($coverageArea->type === 'city' ? 'Kota' : 'Kecamatan') }}
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
