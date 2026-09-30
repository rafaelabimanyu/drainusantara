@extends('layouts.admin')

@section('title', 'Edit Foto Galeri')
@section('page-title', 'Edit Dokumentasi Galeri')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Dokumentasi Galeri</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui foto pengerjaan, kategori sektor, dan deskripsi hasil.</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Proyek / Pengerjaan *</label>
            <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" required
                   class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
            @error('title') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Sektor Kategori *</label>
                <select name="category" id="category" required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition bg-white shadow-2xs">
                    <option value="rumahan" {{ old('category', $gallery->category) == 'rumahan' ? 'selected' : '' }}>Rumahan (Residensial / Hunian / Apartemen)</option>
                    <option value="b2b" {{ old('category', $gallery->category) == 'b2b' ? 'selected' : '' }}>B2B (Komersial / Restoran F&amp;B / Ruko / Kantor)</option>
                </select>
                @error('category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="service_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kategori Layanan Terkait</label>
                <select name="service_id" id="service_id" 
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition bg-white shadow-2xs">
                    <option value="">-- Pilih Layanan (Opsional) --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id', $gallery->service_id) == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_id') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Upload Foto Sebelum & Sesudah (Before & After) -->
        <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Foto Komparasi: Sebelum &amp; Sesudah</span>
                <span class="text-[11px] text-slate-500">Unggah file baru untuk memperbarui foto komparasi</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Upload Sebelum (Before) -->
                <div x-data="{ preview: '{{ $gallery->before_image }}' }">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 inline-block"></span>
                        Foto Sebelum (Before)
                    </label>
                    <div class="w-full h-32 rounded-lg border border-slate-300 bg-white flex items-center justify-center overflow-hidden mb-2 relative shadow-2xs">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <span class="text-xs text-slate-400">Belum ada foto</span>
                        </template>
                    </div>
                    <input type="file" name="before_image" id="before_image" accept="image/*"
                           @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                           class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                    @error('before_image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Upload Sesudah (After) -->
                <div x-data="{ preview: '{{ $gallery->after_image }}' }">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                        Foto Sesudah (After)
                    </label>
                    <div class="w-full h-32 rounded-lg border border-slate-300 bg-white flex items-center justify-center overflow-hidden mb-2 relative shadow-2xs">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <span class="text-xs text-slate-400">Belum ada foto</span>
                        </template>
                    </div>
                    <input type="file" name="after_image" id="after_image" accept="image/*"
                           @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                           class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                    @error('after_image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Upload 1 Foto Utama Alternatif -->
        <div x-data="{ preview: '{{ $gallery->image }}' }">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Foto Utama Alternatif</label>
            <div class="flex items-center gap-3 p-3.5 bg-slate-50/75 rounded-lg border border-slate-200">
                <div class="w-16 h-14 rounded-md border border-slate-300 bg-white flex items-center justify-center overflow-hidden shrink-0">
                    <template x-if="preview">
                        <img :src="preview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!preview">
                        <span class="text-[10px] text-slate-400">Kosong</span>
                    </template>
                </div>
                <div class="flex-1">
                    <input type="file" name="image" id="image" accept="image/*"
                           @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                           class="block w-full text-xs text-slate-600 file:mr-2.5 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300 cursor-pointer">
                    <p class="text-[11px] text-slate-500 mt-0.5">Pilih file baru untuk memperbarui foto utama.</p>
                </div>
            </div>
            @error('image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Ringkas Hasil Pengerjaan</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('description', $gallery->description) }}</textarea>
            @error('description') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-2 pt-1">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}
                   class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
            <label for="is_active" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Tampilkan di Halaman Galeri Website</label>
        </div>

        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.galleries.index') }}" 
               class="px-4 py-2 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 font-semibold text-xs sm:text-sm rounded-lg transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition-colors cursor-pointer">
                Perbarui Foto Galeri
            </button>
        </div>
    </form>
</div>
@endsection
