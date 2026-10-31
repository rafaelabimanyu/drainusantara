@extends('layouts.admin')

@section('title', 'Edit Portofolio - ' . $portfolio->client_name)
@section('page-title', 'Edit Portofolio Restoran & Klien')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Portofolio: {{ $portfolio->client_name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui foto, nama tempat usaha/restoran, dan lokasi untuk kartu portofolio.</p>
        </div>
        <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Nama Restoran / Klien -->
            <div class="sm:col-span-2">
                <label for="client_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Restoran / Tempat Usaha *
                </label>
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $portfolio->client_name) }}" required
                       placeholder="Misal: D'Cost Seafood, Restoran Pagi Sore, The Alana Hotel"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('client_name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Lokasi / Cabang / Kota -->
            <div>
                <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Lokasi / Cabang / Kota
                </label>
                <input type="text" name="location" id="location" value="{{ old('location', $portfolio->location) }}"
                       placeholder="Misal: Mall Kelapa Gading, Jakarta Utara"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('location') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori / Sektor Usaha -->
            <div>
                <label for="client_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Kategori / Jenis Usaha
                </label>
                <input type="text" name="client_type" id="client_type" value="{{ old('client_type', $portfolio->client_type) }}"
                       placeholder="Misal: Restoran F&B, Kafe, Perhotelan"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('client_type') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Upload Foto Lokasi / Perusahaan -->
        <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3" x-data="{ preview: {{ Illuminate\Support\Js::from($portfolio->image) }} }">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Foto Restoran / Tempat Usaha</span>
                    <p class="text-[11px] text-slate-500 mt-0.5">Unggah foto baru jika ingin mengganti gambar saat ini.</p>
                </div>
                <span class="text-xs text-slate-500 font-medium">JPG, PNG, WEBP</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <div class="w-full h-32 rounded-lg border border-slate-300 bg-white flex items-center justify-center overflow-hidden relative shadow-2xs">
                    <template x-if="preview">
                        <img :src="preview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!preview">
                        <div class="text-center p-2 text-slate-400">
                            <svg class="w-6 h-6 mx-auto mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-[11px] font-medium">Belum ada foto</span>
                        </div>
                    </template>
                </div>

                <div class="sm:col-span-2 space-y-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Berkas Gambar (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                               @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                               class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        @error('image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="image_url" class="block text-xs font-bold text-slate-700 mb-1">Atau Ubah Link URL Foto Luar</label>
                        <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                               placeholder="https://domain.com/foto-restoran.webp atau URL gambar"
                               @input="if ($event.target.value) { preview = $event.target.value; }"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                        @error('image_url') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 14. Upload Logo Mitra / Perusahaan --}}
        <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3" x-data="{ logoPreview: {{ Illuminate\Support\Js::from($portfolio->logo) }} }">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Logo Mitra / Perusahaan</span>
                    <p class="text-[11px] text-slate-500 mt-0.5">Format file: JPG, PNG, atau WEBP transparan / rasio proporsional.</p>
                </div>
                <span class="text-xs text-slate-500 font-medium">Logo</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <div class="w-full h-28 rounded-lg border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden relative shadow-2xs">
                    <template x-if="logoPreview">
                        <img :src="logoPreview" class="max-h-24 max-w-full object-contain p-2">
                    </template>
                    <template x-if="!logoPreview">
                        <div class="text-center p-2 text-slate-400">
                            <svg class="w-6 h-6 mx-auto mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-[11px] font-medium">Pratinjau Logo</span>
                        </div>
                    </template>
                </div>

                <div class="sm:col-span-2 space-y-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Berkas Logo (Opsional)</label>
                        <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/webp"
                               @change="const f = $event.target.files[0]; if (f) { logoPreview = URL.createObjectURL(f); }"
                               class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        @error('logo') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="logo_url" class="block text-xs font-bold text-slate-700 mb-1">Atau Ubah Link URL Logo Luar</label>
                        <input type="url" name="logo_url" id="logo_url" value="{{ old('logo_url') }}"
                               placeholder="https://domain.com/logo.webp atau URL gambar"
                               @input="if ($event.target.value) { logoPreview = $event.target.value; }"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                        @error('logo_url') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            {{-- 15. Jenis Kemitraan --}}
            <div>
                <label for="partnership_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Jenis Kemitraan
                </label>
                <select name="partnership_type" id="partnership_type"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                    <option value="">-- Pilih Jenis Kemitraan --</option>
                    @php $currentType = old('partnership_type', $portfolio->partnership_type); @endphp
                    <option value="kontrak-maintenance" {{ $currentType === 'kontrak-maintenance' ? 'selected' : '' }}>Kontrak Maintenance</option>
                    <option value="kerjasama-proyek" {{ $currentType === 'kerjasama-proyek' ? 'selected' : '' }}>Kerjasama Proyek</option>
                    <option value="sewa-alat" {{ $currentType === 'sewa-alat' ? 'selected' : '' }}>Sewa Alat</option>
                    <option value="emergency" {{ $currentType === 'emergency' ? 'selected' : '' }}>Emergency Service</option>
                </select>
                @error('partnership_type') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- 16. Durasi --}}
            <div>
                <label for="duration" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Durasi Kerjasama
                </label>
                <input type="text" name="duration" id="duration" value="{{ old('duration', $portfolio->duration) }}"
                       placeholder="Jan 2025 - Sekarang"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('duration') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- 17. Layanan Diterapkan --}}
        @php
            $servicesList = $services ?? \App\Models\Service::where('is_active', true)->orderBy('name')->get();
            $defaultServiceIds = $portfolio->relationLoaded('services')
                ? $portfolio->services->pluck('id')->toArray()
                : $portfolio->services()->pluck('services.id')->toArray();
            $selectedServices = (array) old('service_ids', $defaultServiceIds);
        @endphp
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Layanan yang Diterapkan</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 bg-slate-50 border border-slate-200 rounded-lg p-3 max-h-56 overflow-y-auto">
                @forelse($servicesList as $svc)
                    <label class="flex items-center justify-between gap-2 text-xs sm:text-sm text-slate-700 cursor-pointer p-1.5 hover:bg-white rounded-md transition-colors">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="service_ids[]" value="{{ $svc->id }}" 
                                   {{ in_array($svc->id, $selectedServices) ? 'checked' : '' }}
                                   class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                            <span class="font-medium text-slate-800">{{ $svc->name }}</span>
                        </div>
                        @if($svc->price_starting_from)
                            <span class="text-xs font-medium text-slate-500 shrink-0">
                                Mulai Rp {{ number_format($svc->price_starting_from, 0, ',', '.') }}
                            </span>
                        @endif
                    </label>
                @empty
                    <p class="text-xs text-slate-400 col-span-2">Belum ada data layanan aktif.</p>
                @endforelse
            </div>
            @error('service_ids') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Judul Proyek & Deskripsi Ringkas --}}
        <div>
            <label for="project_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Judul Proyek / Tagline Kemitraan
            </label>
            <input type="text" name="project_title" id="project_title" value="{{ old('project_title', $portfolio->project_title) }}"
                   placeholder="Misal: Perawatan Rutin Grease Trap & Saluran Pipa Outlet Utama"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
            @error('project_title') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Deskripsi Ringkas Kemitraan
            </label>
            <textarea name="description" id="description" rows="3"
                      placeholder="Ringkasan singkat kerjasama pemeliharaan saluran untuk kartu profil mitra..."
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('description', $portfolio->description) }}</textarea>
            @error('description') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 18. Tentang Klien --}}
        <div>
            <label for="about_client" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Tentang Klien
            </label>
            <textarea name="about_client" id="about_client" rows="4"
                      placeholder="Profil lengkap mitra bisnis, skala operasional, dan latar belakang kebutuhan fasilitas..."
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('about_client', $portfolio->about_client) }}</textarea>
            @error('about_client') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 19. Lingkup Kerjasama --}}
        <div>
            <label for="scope_of_work" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Lingkup Kerjasama
            </label>
            <textarea name="scope_of_work" id="scope_of_work" rows="4"
                      placeholder="Rincian SLA, jadwal maintenance preventif berkala, armada mesin yang dialokasikan..."
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('scope_of_work', $portfolio->scope_of_work) }}</textarea>
            @error('scope_of_work') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 20. Hasil & Benefit --}}
        <div>
            <label for="results_benefit" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Hasil &amp; Benefit
            </label>
            <textarea name="results_benefit" id="results_benefit" rows="4"
                      placeholder="Dampak positif bagi operasional mitra: pencegahan downtime, penghematan biaya pipa, dsb..."
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('results_benefit', $portfolio->results_benefit) }}</textarea>
            @error('results_benefit') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 21. Testimoni Quote + Name + Title --}}
        <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">Kutipan Testimoni Klien</span>
            
            <div>
                <label for="testimoni_quote" class="block text-xs font-medium text-slate-600 mb-1">Kutipan Testimoni</label>
                <textarea name="testimoni_quote" id="testimoni_quote" rows="3"
                          placeholder="Pernyataan atau ulasan resmi dari pihak klien terkait kepuasan kerjasama..."
                          class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs bg-white">{{ old('testimoni_quote', $portfolio->testimoni_quote) }}</textarea>
                @error('testimoni_quote') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="testimoni_name" class="block text-xs font-medium text-slate-600 mb-1">Nama Pemberi Testimoni</label>
                    <input type="text" name="testimoni_name" id="testimoni_name" value="{{ old('testimoni_name', $portfolio->testimoni_name) }}"
                           placeholder="Nama pemberi testimoni"
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-xs outline-hidden transition shadow-2xs bg-white">
                    @error('testimoni_name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="testimoni_title" class="block text-xs font-medium text-slate-600 mb-1">Jabatan / Posisi</label>
                    <input type="text" name="testimoni_title" id="testimoni_title" value="{{ old('testimoni_title', $portfolio->testimoni_title) }}"
                           placeholder="Jabatan (misal: Facility Manager, Branch Head)"
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-xs outline-hidden transition shadow-2xs bg-white">
                    @error('testimoni_title') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- 22. Slug --}}
        <div>
            <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Slug URL
            </label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $portfolio->slug) }}"
                   placeholder="Auto dari nama klien"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-xs font-mono outline-hidden transition shadow-2xs">
            <p class="text-[11px] text-slate-500 mt-1">Digunakan untuk URL halaman detail mitra kemitraan (/kemitraan/{slug}).</p>
            @error('slug') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Pengaturan Urutan & Status -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-1">
            <div>
                <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Urutan Tampilan (Angka Kecil Tampil Lebih Dulu)
                </label>
                <input type="number" name="order" id="order" value="{{ old('order', $portfolio->order) }}" min="0"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('order') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center sm:pt-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $portfolio->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                    <span class="text-xs sm:text-sm font-medium text-slate-700">Tampilkan di Portofolio</span>
                </label>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.portfolios.index') }}" 
               class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-xs sm:text-sm transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition-colors cursor-pointer">
                Perbarui Portofolio
            </button>
        </div>
    </form>
</div>
@endsection
