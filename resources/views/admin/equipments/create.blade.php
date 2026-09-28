@extends('layouts.admin')

@section('title', 'Tambah Peralatan Baru')
@section('page-title', 'Tambah Peralatan / Mesin Baru')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.equipments.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-sky-600 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Peralatan
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.equipments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Nama Peralatan -->
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Peralatan / Mesin <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" 
                       placeholder="Contoh: Mesin Drain Rooter Spiral Baja Rotary Ridgid K-50"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-sm outline-none transition @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Kategori & Badge -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Kategori Unit</label>
                    <select name="category" id="category" 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-sm outline-none transition">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Mesin Utama" {{ old('category') == 'Mesin Utama' ? 'selected' : '' }}>Mesin Utama</option>
                        <option value="Diagnosis Visual" {{ old('category') == 'Diagnosis Visual' ? 'selected' : '' }}>Diagnosis Visual</option>
                        <option value="Hydro Jetting" {{ old('category') == 'Hydro Jetting' ? 'selected' : '' }}>Hydro Jetting</option>
                        <option value="Mata Cutter" {{ old('category') == 'Mata Cutter' ? 'selected' : '' }}>Mata Cutter</option>
                        <option value="Unit Pendukung" {{ old('category') == 'Unit Pendukung' ? 'selected' : '' }}>Unit Pendukung</option>
                    </select>
                </div>

                <div>
                    <label for="badge" class="block text-sm font-bold text-slate-700 mb-2">Badge / Keunggulan Utama</label>
                    <input type="text" name="badge" id="badge" value="{{ old('badge') }}" 
                           placeholder="Contoh: 100% Mekanis, IP68 Waterproof, 200 Bar"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-sm outline-none transition">
                </div>
            </div>

            <!-- 3. Upload File Gambar Peralatan -->
            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-1">
                        Foto Peralatan
                    </label>
                    <p class="text-xs text-slate-500 mb-3">
                        File akan disimpan utuh ke direktori <code class="text-sky-700 font-mono font-bold bg-white px-1.5 py-0.5 rounded border border-slate-200">public/assets/TOOLKIT/</code> tanpa dikompres.
                    </p>
                    
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml"
                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition cursor-pointer">
                    @error('image')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-3 border-t border-slate-200/80">
                    <label for="image_url" class="block text-xs font-semibold text-slate-600 mb-1">Atau Gunakan Path / URL Gambar</label>
                    <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}" 
                           placeholder="/assets/TOOLKIT/mesin-spiral-rotary.webp"
                           class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-xs outline-none focus:border-sky-500">
                </div>
            </div>

            <!-- 4. Deskripsi Singkat -->
            <div>
                <label for="short_description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat Cara Kerja</label>
                <textarea name="short_description" id="short_description" rows="3" 
                          placeholder="Jelaskan cara kerja alat, fleksibilitas kabel, dan kemampuan mengatasi sumbatan tanpa merusak pipa..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-sm outline-none transition">{{ old('short_description') }}</textarea>
            </div>

            <!-- 5. Spesifikasi Teknis (1 baris per poin) -->
            <div>
                <label for="specs" class="block text-sm font-bold text-slate-700 mb-2">
                    Spesifikasi Teknis <span class="text-xs font-normal text-slate-500">(1 baris untuk setiap poin)</span>
                </label>
                <textarea name="specs" id="specs" rows="4" 
                          placeholder="Contoh:&#10;Jangkauan: Hingga 30 Meter modular&#10;Diameter Pipa: 1.5 sampai 6 Inci&#10;Tenaga: Motor Listrik 220V 400 RPM"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-sm font-mono outline-none transition">{{ old('specs') }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Setiap baris baru akan ditampilkan sebagai poin spesifikasi tersendiri di website publik.</p>
            </div>

            <!-- 6. Urutan & Status Aktif -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                <div>
                    <label for="order" class="block text-sm font-bold text-slate-700 mb-2">Nomor Urutan Tampil</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-sm outline-none transition">
                    <p class="text-[11px] text-slate-400 mt-1">Angka lebih kecil (0, 1, 2) tampil lebih awal di urutan depan.</p>
                </div>

                <div class="flex items-center pt-8">
                    <label class="relative flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded text-sky-600 focus:ring-sky-500 border-slate-300">
                        <span class="text-sm font-bold text-slate-800">Tampilkan di Publik Website</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.equipments.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm transition shadow-sm shadow-sky-600/20 cursor-pointer">
                    Simpan Peralatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
