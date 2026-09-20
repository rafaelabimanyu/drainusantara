@extends('layouts.admin')

@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Edit Layanan: {{ $service->name }}</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui rincian harga, foto pengerjaan, atau keunggulan.</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6 shadow-2xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Nama Layanan -->
            <div class="sm:col-span-2">
                <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nama Layanan *</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $service->name) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Gambar Layanan -->
            <div class="sm:col-span-2" x-data="{ previewUrl: '{{ $service->image }}' }">
                <label class="block text-sm font-bold text-slate-700 mb-2">Foto / Gambar Layanan</label>
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center p-4 bg-slate-50 rounded-2xl border border-slate-200/80">
                    <div class="w-28 h-20 rounded-xl border border-slate-300 bg-white flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            <div class="text-center p-2 text-slate-400">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px]">Pratinjau</span>
                            </div>
                        </template>
                    </div>
                    <div class="flex-1 w-full space-y-1.5">
                        <input type="file" name="image" id="image" accept="image/*"
                               @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        <p class="text-[11px] text-slate-400">Pilih file baru untuk mengganti gambar saat ini. Format: JPG, PNG, WEBP, SVG (Maks. 5MB).</p>
                        @error('image') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Harga Mulai Dari -->
            <div>
                <label for="price_starting_from" class="block text-sm font-bold text-slate-700 mb-1">Harga Mulai Dari (Rp)</label>
                <input type="number" name="price_starting_from" id="price_starting_from" value="{{ old('price_starting_from', $service->price_starting_from) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">
                @error('price_starting_from') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Urutan Tampilan -->
            <div>
                <label for="order" class="block text-sm font-bold text-slate-700 mb-1">Urutan Prioritas</label>
                <input type="number" name="order" id="order" value="{{ old('order', $service->order) }}" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">
            </div>

            <!-- Deskripsi Singkat -->
            <div class="sm:col-span-2">
                <label for="short_description" class="block text-sm font-bold text-slate-700 mb-1">Deskripsi Singkat (Ringkasan Card)</label>
                <textarea name="short_description" id="short_description" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">{{ old('short_description', $service->short_description) }}</textarea>
            </div>

            <!-- Fitur Utama (Per Baris) -->
            <div class="sm:col-span-2">
                <label for="features_text" class="block text-sm font-bold text-slate-700 mb-1">Daftar Fitur / Poin Keunggulan (Satu baris per poin)</label>
                @php
                    $featuresString = !empty($service->features) && is_array($service->features) ? implode("\n", $service->features) : '';
                @endphp
                <textarea name="features_text" id="features_text" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm font-mono text-xs focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-hidden">{{ old('features_text', $featuresString) }}</textarea>
            </div>

            <!-- Status Aktif Checkbox -->
            <div class="sm:col-span-2 flex items-center gap-3 pt-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="w-4 h-4 text-sky-600 rounded-sm border-slate-300 focus:ring-sky-500">
                <label for="is_active" class="text-sm font-semibold text-slate-700">Tampilkan layanan ini secara publik di website</label>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md shadow-sky-600/20 transition-colors">
                Perbarui Layanan
            </button>
        </div>
    </form>
</div>
@endsection
