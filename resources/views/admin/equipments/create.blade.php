@extends('layouts.admin')

@section('title', 'Tambah Peralatan Baru')
@section('page-title', 'Tambah Peralatan / Mesin Baru')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Peralatan / Mesin</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftarkan unit mesin dan peralatan kerja armada teknisi lapangan.</p>
        </div>
        <a href="{{ route('admin.equipments.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.equipments.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf

        <!-- 1. Nama Peralatan -->
        <div>
            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Peralatan / Mesin *</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}" 
                   placeholder="Contoh: Mesin Drain Rooter Spiral Baja Rotary Ridgid K-50"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs @error('name') border-rose-500 @enderror">
            @error('name')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 2. Kategori & Badge -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kategori Unit</label>
                <select name="category" id="category" 
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition bg-white shadow-2xs">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Mesin Utama" {{ old('category') == 'Mesin Utama' ? 'selected' : '' }}>Mesin Utama</option>
                    <option value="Diagnosis Visual" {{ old('category') == 'Diagnosis Visual' ? 'selected' : '' }}>Diagnosis Visual</option>
                    <option value="Hydro Jetting" {{ old('category') == 'Hydro Jetting' ? 'selected' : '' }}>Hydro Jetting</option>
                    <option value="Mata Cutter" {{ old('category') == 'Mata Cutter' ? 'selected' : '' }}>Mata Cutter</option>
                    <option value="Unit Pendukung" {{ old('category') == 'Unit Pendukung' ? 'selected' : '' }}>Unit Pendukung</option>
                </select>
            </div>

            <div>
                <label for="badge" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Badge Keunggulan</label>
                <input type="text" name="badge" id="badge" value="{{ old('badge') }}" 
                       placeholder="Contoh: 100% Mekanis, IP68 Waterproof"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
            </div>
        </div>

        <!-- 3. Upload File Gambar Peralatan -->
        <div class="p-4 rounded-lg bg-slate-50/75 border border-slate-200 space-y-3">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Foto Peralatan
                </label>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml"
                       class="block w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition cursor-pointer">
                @error('image')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2 border-t border-slate-200">
                <label for="image_url" class="block text-xs font-bold text-slate-600 mb-1">Atau Gunakan Path / URL Gambar</label>
                <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}" 
                       placeholder="/assets/TOOLKIT/mesin-spiral-rotary.webp"
                       class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs outline-hidden focus:border-sky-700">
            </div>
        </div>

        <!-- 4. Deskripsi Singkat -->
        <div>
            <label for="short_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Singkat Cara Kerja</label>
            <textarea name="short_description" id="short_description" rows="2" 
                      placeholder="Jelaskan cara kerja alat, fleksibilitas kabel, dan kemampuan mengatasi sumbatan tanpa merusak pipa..."
                      class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">{{ old('short_description') }}</textarea>
        </div>

        <!-- 5. Spesifikasi Teknis -->
        <div>
            <label for="specs" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Spesifikasi Teknis (1 baris per poin)
            </label>
            <textarea name="specs" id="specs" rows="3" 
                      placeholder="Jangkauan: Hingga 30 Meter modular&#10;Diameter Pipa: 1.5 sampai 6 Inci&#10;Tenaga: Motor Listrik 220V 400 RPM"
                      class="w-full px-3.5 py-2 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-xs font-mono outline-hidden transition shadow-2xs">{{ old('specs') }}</textarea>
            <p class="text-[11px] text-slate-500 mt-1">Setiap baris baru akan ditampilkan sebagai poin spesifikasi tersendiri.</p>
        </div>

        <!-- 6. Urutan & Status Aktif -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-1">
            <div>
                <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor Urutan Tampil</label>
                <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" min="1" 
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                <p class="text-[11px] text-slate-500 mt-1">Otomatis mengisi slot urutan berikutnya (#{{ $nextOrder }}). Dapat diubah manual jika perlu.</p>
                @error('order') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center sm:pt-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded-sm text-sky-700 focus:ring-sky-700 border-slate-300">
                    <span class="text-xs sm:text-sm font-medium text-slate-700">Tampilkan di Publik Website</span>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.equipments.index') }}" 
               class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-xs sm:text-sm transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm shadow-2xs transition-colors cursor-pointer">
                Simpan Peralatan
            </button>
        </div>
    </form>
</div>
@endsection
