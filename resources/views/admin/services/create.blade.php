@extends('layouts.admin')

@section('title', 'Tambah Layanan Baru')
@section('page-title', 'Tambah Layanan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Layanan Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tambahkan katalog penanganan saluran pipa mampet ke website.</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Nama Layanan -->
            <div class="sm:col-span-2">
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Layanan *</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Contoh: Saluran Bak Cuci Piring Mampet" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                @error('name') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Gambar Layanan -->
            <div class="sm:col-span-2" x-data="{ previewUrl: null }">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Foto / Gambar Layanan</label>
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center p-4 bg-slate-50/75 rounded-lg border border-slate-200">
                    <div class="w-24 h-20 rounded-lg border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            <div class="text-center p-2 text-slate-400">
                                <svg class="w-5 h-5 mx-auto mb-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px]">Pratinjau</span>
                            </div>
                        </template>
                    </div>
                    <div class="flex-1 w-full space-y-1">
                        <input type="file" name="image" id="image" accept="image/*"
                               @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }"
                               class="block w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        <p class="text-[11px] text-slate-500">Format: JPG, PNG, WEBP, atau SVG (Maks. 5MB). Dikosongkan akan memakai ilustrasi default.</p>
                        @error('image') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Harga Mulai Dari -->
            <div>
                <label for="price_starting_from" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Harga Mulai Dari (Rp)</label>
                <input type="number" name="price_starting_from" id="price_starting_from" value="{{ old('price_starting_from', 400000) }}" placeholder="400000" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                @error('price_starting_from') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Urutan Tampilan -->
            <div>
                <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Urutan Prioritas</label>
                <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" min="1" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                <p class="text-[11px] text-slate-500 mt-1">Otomatis mengisi slot urutan berikutnya (#{{ $nextOrder }}). Dapat diubah manual jika perlu.</p>
                @error('order') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi Singkat -->
            <div class="sm:col-span-2">
                <label for="short_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Singkat (Ringkasan Card)</label>
                <textarea name="short_description" id="short_description" rows="2" placeholder="Pelancaran saluran bak cuci piring tersumbat lemak tanpa bongkar meja dapur..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('short_description') }}</textarea>
            </div>

            <!-- Fitur Utama (Per Baris) -->
            <div class="sm:col-span-2">
                <label for="features_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Daftar Fitur / Poin Keunggulan (Satu baris per poin)</label>
                <textarea name="features_text" id="features_text" rows="3" placeholder="Tanpa bongkar keramik&#10;Kabel spiral baja elastis&#10;Garansi 30 hari" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-xs font-mono focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('features_text') }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Tulis setiap fitur pada baris baru (otomatis menjadi bullet list).</p>
            </div>

            <!-- Status Aktif Checkbox -->
            <div class="sm:col-span-2 flex items-center gap-2.5 pt-1">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_active" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Tampilkan layanan ini secara publik di website</label>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.services.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold shadow-2xs transition-colors cursor-pointer">
                Simpan Layanan
            </button>
        </div>
    </form>
</div>
@endsection
