@extends('layouts.admin')

@section('title', 'Edit Foto Galeri')
@section('page-title', 'Edit Dokumentasi Galeri')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.galleries.index') }}" class="text-sm font-semibold text-slate-500 hover:text-sky-600 transition flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Galeri
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Proyek / Pengerjaan <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Sektor Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition bg-white">
                        <option value="rumahan" {{ old('category', $gallery->category) == 'rumahan' ? 'selected' : '' }}>Rumahan (Residensial / Hunian / Apartemen)</option>
                        <option value="b2b" {{ old('category', $gallery->category) == 'b2b' ? 'selected' : '' }}>B2B (Komersial / Restoran F&amp;B / Ruko / Kantor / Gedung)</option>
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="service_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori Layanan Terkait</label>
                    <select name="service_id" id="service_id" 
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition bg-white">
                        <option value="">-- Pilih Layanan (Opsional) --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id', $gallery->service_id) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Upload Foto Sebelum & Sesudah (Before & After) -->
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Foto Komparasi: Sebelum & Sesudah</span>
                    <span class="text-[11px] text-sky-700 font-semibold bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200">Disimpan utuh di public/images/dokumentasi</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Upload Sebelum (Before) -->
                    <div x-data="{ preview: '{{ $gallery->before_image }}' }">
                        <label class="block text-xs font-bold text-slate-700 mb-2 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>
                            Foto Sebelum (Before)
                        </label>
                        <div class="w-full h-36 rounded-xl border border-slate-300 bg-white flex items-center justify-center overflow-hidden mb-2 relative group shadow-2xs">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!preview">
                                <span class="text-xs text-slate-400">Belum ada foto</span>
                            </template>
                        </div>
                        <input type="file" name="before_image" id="before_image" accept="image/*"
                               @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                               class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer">
                        @error('before_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Upload Sesudah (After) -->
                    <div x-data="{ preview: '{{ $gallery->after_image }}' }">
                        <label class="block text-xs font-bold text-slate-700 mb-2 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-sky-500 inline-block"></span>
                            Foto Sesudah (After)
                        </label>
                        <div class="w-full h-36 rounded-xl border border-slate-300 bg-white flex items-center justify-center overflow-hidden mb-2 relative group shadow-2xs">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!preview">
                                <span class="text-xs text-slate-400">Belum ada foto</span>
                            </template>
                        </div>
                        <input type="file" name="after_image" id="after_image" accept="image/*"
                               @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                               class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        @error('after_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Upload 1 Foto Utama Alternatif -->
            <div x-data="{ preview: '{{ $gallery->image }}' }">
                <label class="block text-sm font-bold text-slate-700 mb-2">Foto Utama Alternatif</label>
                <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200/80">
                    <div class="w-20 h-16 rounded-lg border border-slate-300 bg-white flex items-center justify-center overflow-hidden shrink-0">
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
                               class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-1">Pilih file baru untuk memperbarui foto utama.</p>
                    </div>
                </div>
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Ringkas Hasil Pengerjaan</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">{{ old('description', $gallery->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                <label for="is_active" class="text-sm font-semibold text-slate-700">Tampilkan di Halaman Galeri Website</label>
            </div>

            <div class="pt-4 flex items-center gap-3">
                <button type="submit" 
                        class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-xl transition shadow-sm">
                    Perbarui Foto Galeri
                </button>
                <a href="{{ route('admin.galleries.index') }}" 
                   class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
