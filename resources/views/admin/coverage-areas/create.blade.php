@extends('layouts.admin')

@section('title', 'Tambah Area Jangkauan')
@section('page-title', 'Tambah Area')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Area Jangkauan Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftarkan area &amp; kota untuk halaman pendaratan SEO lokal.</p>
        </div>
        <a href="{{ route('admin.coverage-areas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.coverage-areas.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-8 shadow-2xs">
        @csrf

        <!-- SECTION 1: INFORMASI WILAYAH & HARGA -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">1. Wilayah &amp; Tarif Layanan</h2>
                <p class="text-xs text-slate-500">Pengaturan lokasi dasar dan diferensiasi harga mulai penanganan pipa.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kota / Wilayah *</label>
                    <select name="city" id="city" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden bg-white transition shadow-2xs">
                        <option value="">-- Pilih Wilayah Operasional --</option>
                        <optgroup label="JABODETABEK">
                            <option value="Jakarta Selatan" {{ old('city') == 'Jakarta Selatan' ? 'selected' : '' }}>Jakarta Selatan</option>
                            <option value="Jakarta Timur" {{ old('city') == 'Jakarta Timur' ? 'selected' : '' }}>Jakarta Timur</option>
                            <option value="Jakarta Utara" {{ old('city') == 'Jakarta Utara' ? 'selected' : '' }}>Jakarta Utara</option>
                            <option value="Jakarta Pusat" {{ old('city') == 'Jakarta Pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                            <option value="Jakarta Barat" {{ old('city') == 'Jakarta Barat' ? 'selected' : '' }}>Jakarta Barat</option>
                            <option value="Bogor" {{ old('city') == 'Bogor' ? 'selected' : '' }}>Bogor</option>
                            <option value="Depok & Cinere" {{ old('city') == 'Depok & Cinere' ? 'selected' : '' }}>Depok & Cinere</option>
                            <option value="Tangerang Kota" {{ old('city') == 'Tangerang Kota' ? 'selected' : '' }}>Tangerang Kota</option>
                            <option value="Tangerang Selatan" {{ old('city') == 'Tangerang Selatan' ? 'selected' : '' }}>Tangerang Selatan</option>
                            <option value="Bekasi & Cikarang" {{ old('city') == 'Bekasi & Cikarang' ? 'selected' : '' }}>Bekasi & Cikarang</option>
                        </optgroup>
                        <optgroup label="SEMARANG & LAMPUNG">
                            <option value="Kota Semarang" {{ old('city') == 'Kota Semarang' ? 'selected' : '' }}>Kota Semarang</option>
                            <option value="Bandar Lampung" {{ old('city') == 'Bandar Lampung' ? 'selected' : '' }}>Bandar Lampung</option>
                        </optgroup>
                    </select>
                    @error('city') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="district" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Area / Wilayah *</label>
                    <input type="text" name="district" id="district" required value="{{ old('district') }}" placeholder="Contoh: Tebet, Sukarame, dll" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                    @error('district') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="postal_code" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kode Pos (Opsional)</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" placeholder="Contoh: 12810" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div class="sm:col-span-3">
                    <label for="starting_price" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tarif Pengerjaan Mulai Dari (Rp)</label>
                    <div class="relative max-w-xs">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-xs font-semibold text-slate-400">Rp</span>
                        <input type="number" name="starting_price" id="starting_price" min="0" step="50000" value="{{ old('starting_price', 400000) }}" placeholder="400000" class="w-full pl-9 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">Kosongkan untuk memakai harga standar nasional (Rp 400.000). Ditampilkan di hero, card layanan, dan schema Google.</p>
                </div>

                <div class="sm:col-span-3">
                    <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan / Konten Lokal (Opsional)</label>
                    <textarea name="content" id="content" rows="3" placeholder="Informasi tambahan khusus area ini..." class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('content') }}</textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 2: FOTO HERO WILAYAH -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">2. Foto Hero Section Wilayah</h2>
                <p class="text-xs text-slate-500">Foto latar belakang hero section. Mewarisi hierarki kota/provinsi jika dikosongkan.</p>
            </div>

            <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3" x-data="{ heroPreview: null }">
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
                                <span class="text-[11px] font-medium">Pratinjau Foto</span>
                            </div>
                        </template>
                    </div>

                    <div class="sm:col-span-2 space-y-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Berkas Gambar</label>
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
                    <input type="text" name="cta_headline" id="cta_headline" value="{{ old('cta_headline') }}" placeholder="Saluran Air di Wilayah Anda Tersumbat Hari Ini?" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div>
                    <label for="cta_button_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Teks Tombol CTA</label>
                    <input type="text" name="cta_button_text" id="cta_button_text" value="{{ old('cta_button_text') }}" placeholder="Panggil Teknisi Sekarang" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div class="sm:col-span-2">
                    <label for="cta_whatsapp_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Format Teks Pesan WhatsApp</label>
                    <textarea name="cta_whatsapp_text" id="cta_whatsapp_text" rows="2" placeholder="Halo teknisi Drainusantara, saya butuh perbaikan saluran mampet di area ini..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('cta_whatsapp_text') }}</textarea>
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
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" placeholder="Jasa Saluran Mampet di [Area], [Kota] - Drainusantara Bergaransi" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div class="sm:col-span-2">
                    <label for="meta_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">SEO Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2" placeholder="Deskripsi ringkas untuk snippet hasil pencarian Google..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('meta_description') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label for="geo_keywords" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Geo Keywords Lokal (Pisahkan dengan koma)</label>
                    <textarea name="geo_keywords" id="geo_keywords" rows="2" placeholder="saluran mampet [area], sedot wc [area], pelancar wastafel [area], tukang pipa [area]" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('geo_keywords') }}</textarea>
                </div>

                <div>
                    <label for="latitude" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Latitude (Lintang)</label>
                    <input type="number" step="0.0000001" name="latitude" id="latitude" value="{{ old('latitude') }}" placeholder="-6.2297465" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div>
                    <label for="longitude" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Longitude (Bujur)</label>
                    <input type="number" step="0.0000001" name="longitude" id="longitude" value="{{ old('longitude') }}" placeholder="106.8553214" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>
            </div>
        </div>

        <!-- SECTION 5: POSKO & POOL ARMADA -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">5. Posko &amp; Pool Armada Wilayah</h2>
                <p class="text-xs text-slate-500">Lokasi siaga armada teknisi, jangkauan respon, dan alamat titik kumpul di wilayah/kota ini.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="posko_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Posko Siaga</label>
                    <input type="text" name="posko_name" id="posko_name" value="{{ old('posko_name') }}" placeholder="Posko Siaga Drainusantara Unit [Area]" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div>
                    <label for="posko_coverage_radius" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Radius &amp; Waktu Respon</label>
                    <input type="text" name="posko_coverage_radius" id="posko_coverage_radius" value="{{ old('posko_coverage_radius') }}" placeholder="Radius 15-20 KM • Teknisi Menuju ke Lokasi Anda Secepatnya" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                </div>

                <div class="sm:col-span-2">
                    <label for="posko_address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Operasional Armada</label>
                    <textarea name="posko_address" id="posko_address" rows="2" placeholder="Pusat Operasional Armada Siaga Drainusantara..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('posko_address') }}</textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 6: TAG PENDUKUNG / DAERAH SEKITAR (SECTION BAWAH) -->
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900">6. Tag Pendukung &amp; Daerah Sekitar (Section Bawah)</h2>
                <p class="text-xs text-slate-500">Daftar kelurahan, jalan protokol, atau landmark spesifik yang diletakkan di section bawah halaman sebelum CTA penutup.</p>
            </div>

            <div>
                <label for="supporting_tags" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tag Wilayah &amp; Kelurahan (Pisahkan dengan koma)</label>
                <textarea name="supporting_tags" id="supporting_tags" rows="2" placeholder="Kelurahan A, Kelurahan B, Jalan Protokol X, Kawasan Bisnis Y..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('supporting_tags') }}</textarea>
            </div>
        </div>

        <!-- SECTION 7: STATUS AKTIF & SIMPAN -->
        <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_active" class="text-xs sm:text-sm font-semibold text-slate-800 cursor-pointer">Publikasikan halaman landing page area ini</label>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.coverage-areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold shadow-2xs transition-colors cursor-pointer">
                    Simpan Area Baru
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
