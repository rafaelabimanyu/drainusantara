@extends('layouts.admin')

@section('title', 'Tambah Area Jangkauan')
@section('page-title', 'Tambah Area')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Area Jangkauan Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftarkan kecamatan &amp; kota baru untuk halaman pendaratan SEO lokal.</p>
        </div>
        <a href="{{ route('admin.coverage-areas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.coverage-areas.store') }}" method="POST" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Kota / Wilayah -->
            <div>
                <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kota / Wilayah *</label>
                <select name="city" id="city" required class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden bg-white transition shadow-2xs">
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

            <!-- Nama Kecamatan -->
            <div>
                <label for="district" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Kecamatan *</label>
                <input type="text" name="district" id="district" required value="{{ old('district') }}" placeholder="Contoh: Tebet, Sukarame, dll" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                @error('district') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kode Pos -->
            <div class="sm:col-span-2">
                <label for="postal_code" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kode Pos (Opsional)</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" placeholder="Contoh: 12810" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
            </div>

            <!-- Custom SEO Title -->
            <div class="sm:col-span-2">
                <label for="meta_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Custom SEO Meta Title (Opsional)</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" placeholder="Biarkan kosong untuk judul SEO otomatis" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                <p class="text-[11px] text-slate-500 mt-1">Default otomatis: Jasa Saluran Mampet di {Kecamatan}, {Kota} - Drainusantara Bergaransi</p>
            </div>

            <!-- Custom SEO Meta Description -->
            <div class="sm:col-span-2">
                <label for="meta_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">SEO Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="2" placeholder="Deskripsi meta untuk mesin pencarian Google..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('meta_description') }}</textarea>
            </div>

            <!-- Status Aktif Checkbox -->
            <div class="sm:col-span-2 flex items-center gap-2.5 pt-1">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_active" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Publikasikan halaman SEO kecamatan ini</label>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.coverage-areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold shadow-2xs transition-colors cursor-pointer">
                Simpan Area
            </button>
        </div>
    </form>
</div>
@endsection
