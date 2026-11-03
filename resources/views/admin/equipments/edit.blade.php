@extends('layouts.admin')

@section('title', 'Edit Peralatan')
@section('page-title', 'Edit Peralatan: ' . $equipment->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Peralatan: {{ $equipment->name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui spesifikasi mesin, foto peralatan, atau nomor prioritas urutan.</p>
        </div>
        <div class="flex items-center gap-2">
            @if($equipment->slug)
            <a href="{{ route('equipment.show', $equipment->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-700 hover:text-sky-800 px-3 py-1.5 rounded-lg border border-sky-300 bg-sky-50 hover:bg-sky-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span>Lihat di Web</span>
            </a>
            @endif
            <a href="{{ route('admin.equipments.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 shadow-2xs">
        <form action="{{ route('admin.equipments.update', $equipment) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- 1. Nama Peralatan & Slug URL -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Peralatan / Mesin *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $equipment->name) }}" 
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-sm outline-hidden transition shadow-2xs @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Slug URL Halaman Detail</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $equipment->slug) }}" 
                           placeholder="otomatis dari nama jika kosong"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-sm font-mono outline-hidden transition shadow-2xs @error('slug') border-rose-500 @enderror">
                    @error('slug')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 2. Kategori & Badge -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kategori Unit</label>
                    <select name="category" id="category" 
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-sm outline-hidden transition bg-white shadow-2xs">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Mesin Utama" {{ old('category', $equipment->category) == 'Mesin Utama' ? 'selected' : '' }}>Mesin Utama</option>
                        <option value="Diagnosis Visual" {{ old('category', $equipment->category) == 'Diagnosis Visual' ? 'selected' : '' }}>Diagnosis Visual</option>
                        <option value="Hydro Jetting" {{ old('category', $equipment->category) == 'Hydro Jetting' ? 'selected' : '' }}>Hydro Jetting</option>
                        <option value="Mata Cutter" {{ old('category', $equipment->category) == 'Mata Cutter' ? 'selected' : '' }}>Mata Cutter</option>
                        <option value="Unit Pendukung" {{ old('category', $equipment->category) == 'Unit Pendukung' ? 'selected' : '' }}>Unit Pendukung</option>
                    </select>
                </div>

                <div>
                    <label for="badge" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Badge Keunggulan Utama</label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge', $equipment->badge) }}" 
                           placeholder="Contoh: 100% Mekanis, IP68 Waterproof"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-sm outline-hidden transition shadow-2xs">
                </div>
            </div>

            <!-- 3. Upload File Gambar Peralatan -->
            <x-form.image-upload 
                name="image" 
                label="Foto Peralatan" 
                :current="$equipment->image"
                allowUrl="true" 
                urlName="image_url" 
                :urlValue="old('image_url', $equipment->image)"
                help="Tarik atau unggah berkas baru untuk mengganti foto. Format JPG, PNG, atau WEBP. Gambar otomatis dikompresi & dikonversi ke WebP." 
            />

            <!-- 4. Deskripsi Singkat & Deskripsi Lengkap Halaman Detail -->
            <div>
                <label for="short_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Singkat (Ringkasan Katalog &amp; Card)</label>
                <textarea name="short_description" id="short_description" rows="2" 
                          class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">{{ old('short_description', $equipment->short_description) }}</textarea>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Lengkap &amp; Prinsip Kerja (Halaman Detail)</label>
                <textarea name="description" id="description" rows="5" 
                          placeholder="Uraikan prinsip kerja mekanis, keunggulan dibanding metode konvensional/soda api, dan performa di lapangan..."
                          class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">{{ old('description', $equipment->description) }}</textarea>
            </div>

            <!-- 5. Spesifikasi Teknis, Fitur Utama & Skenario Aplikasi -->
            @php
                $specsText = is_array($equipment->specs) ? implode("\n", $equipment->specs) : (string) $equipment->specs;
                $featuresText = is_array($equipment->features) ? implode("\n", $equipment->features) : (string) $equipment->features;
                $applicationsText = is_array($equipment->applications) ? implode("\n", $equipment->applications) : (string) $equipment->applications;
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


                <div>
                    <label for="features" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Fitur &amp; Keunggulan Utama (1 baris per poin)
                    </label>
                    <textarea name="features" id="features" rows="4" 
                              class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-xs font-mono outline-hidden transition shadow-2xs">{{ old('features', $featuresText) }}</textarea>
                    <p class="text-[11px] text-slate-500 mt-1">Ditampilkan pada grid fitur halaman detail.</p>
                </div>
            </div>

            <!-- 6. Aplikasi Titik Saluran & Standar SOP K3 -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="applications" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Aplikasi Titik Saluran (1 baris per poin)
                    </label>
                    <textarea name="applications" id="applications" rows="3" 
                              class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-xs font-mono outline-hidden transition shadow-2xs">{{ old('applications', $applicationsText) }}</textarea>
                </div>

                <div>
                    <label for="safety_k3" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Standar Keselamatan &amp; SOP K3
                    </label>
                    <textarea name="safety_k3" id="safety_k3" rows="3" 
                              class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-xs outline-hidden transition shadow-2xs">{{ old('safety_k3', $equipment->safety_k3) }}</textarea>
                </div>
            </div>

            <!-- 6. Urutan & Status Aktif -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-1">
                <div>
                    <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor Urutan Tampil</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $equipment->order) }}" min="0" 
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                </div>

                <div class="flex items-center sm:pt-6">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $equipment->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 rounded-sm text-sky-700 focus:ring-sky-700 border-slate-300">
                        <span class="text-xs sm:text-sm font-medium text-slate-700">Tampilkan di Publik Website</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-5 border-t border-slate-200 flex items-center justify-between">
                <div>
                    <button type="button" 
                            onclick="if(confirm('Hapus peralatan ini?')) { document.getElementById('delete-form-{{ $equipment->id }}').submit(); }"
                            class="px-3.5 py-2 rounded-lg text-rose-700 hover:bg-rose-50 border border-rose-200 text-xs font-semibold transition-colors cursor-pointer">
                        Hapus Peralatan
                    </button>
                </div>

                <div class="flex items-center gap-2.5">
                    <a href="{{ route('admin.equipments.index') }}" 
                       class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-xs sm:text-sm transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-5 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm shadow-2xs transition-colors cursor-pointer">
                        Perbarui Peralatan
                    </button>
                </div>
            </div>
        </form>

        <form id="delete-form-{{ $equipment->id }}" action="{{ route('admin.equipments.destroy', $equipment) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
