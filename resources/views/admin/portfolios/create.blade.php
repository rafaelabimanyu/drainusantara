@extends('layouts.admin')

@section('title', 'Tambah Klien B2B')
@section('page-title', 'Tambah Portofolio Klien B2B')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.portfolios.index') }}" class="text-sm font-semibold text-slate-500 hover:text-sky-600 transition flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Portofolio
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Nama Perusahaan / Klien -->
                <div class="sm:col-span-2">
                    <label for="client_name" class="block text-sm font-bold text-slate-700 mb-2">
                        Nama Perusahaan / Klien B2B <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" required
                           placeholder="Misal: D'Cost Seafood, The Alana Hotel, PT Indofood CBP"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">
                    @error('client_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Sektor / Jenis Bisnis -->
                <div>
                    <label for="client_type" class="block text-sm font-bold text-slate-700 mb-2">
                        Kategori / Sektor Usaha
                    </label>
                    <input type="text" name="client_type" id="client_type" value="{{ old('client_type', 'Restoran & F&B Komersial') }}"
                           placeholder="Misal: Perhotelan, Gedung Perkantoran, Restoran"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">
                    @error('client_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Lokasi Proyek -->
                <div>
                    <label for="location" class="block text-sm font-bold text-slate-700 mb-2">
                        Lokasi Proyek / Cabang
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                           placeholder="Misal: SCBD Jakarta Selatan / Cikarang Bekasi"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">
                    @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Judul Pengerjaan -->
            <div>
                <label for="project_title" class="block text-sm font-bold text-slate-700 mb-2">
                    Judul Pengerjaan / Proyek
                </label>
                <input type="text" name="project_title" id="project_title" value="{{ old('project_title') }}"
                       placeholder="Misal: De-Greasing Grease Trap 800 Liter & Pelancaran Manhole"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">
                @error('project_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi Singkat Penanganan -->
            <div>
                <label for="description" class="block text-sm font-bold text-slate-700 mb-2">
                    Deskripsi Ringkas Penanganan
                </label>
                <textarea name="description" id="description" rows="3"
                          placeholder="Jelaskan ringkas metode pengerjaan (misal: pengerukan kerak lemak pipa after-hours tanpa merusak lantai atau operasional)."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Foto Lokasi / Perusahaan -->
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-4" x-data="{ preview: null }">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Foto Lokasi / Bangunan B2B</span>
                        <p class="text-[11px] text-slate-500 mt-0.5">Foto akan dijadikan latar kartu dengan efek blur halus di landing page.</p>
                    </div>
                    <span class="text-[11px] text-sky-600 font-semibold bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200">JPG, PNG, WEBP</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                    <div class="w-full h-32 rounded-xl border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden relative shadow-2xs">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <div class="text-center p-3 text-slate-400">
                                <svg class="w-8 h-8 mx-auto mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-[11px] font-medium">Pratinjau Foto</span>
                            </div>
                        </template>
                    </div>

                    <div class="sm:col-span-2 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Berkas Gambar</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                   @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                                   class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="image_url" class="block text-xs font-bold text-slate-700 mb-1">Atau Gunakan Link URL Foto Luar</label>
                            <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                                   placeholder="https://images.unsplash.com/photo-..."
                                   @input="if ($event.target.value) { preview = $event.target.value; }"
                                   class="w-full px-3 py-1.5 rounded-lg border border-slate-200 text-xs text-slate-700 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none">
                            @error('image_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengaturan Urutan & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div>
                    <label for="order" class="block text-sm font-bold text-slate-700 mb-2">
                        Urutan Tampilan (Angka Kecil Tampil Lebih Dulu)
                    </label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-slate-800 text-sm outline-none transition">
                    @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center sm:pt-7">
                    <label class="relative flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-5 h-5 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                        <div>
                            <span class="text-sm font-bold text-slate-800 block">Tampilkan di Beranda</span>
                            <span class="text-xs text-slate-500 block">Klien akan langsung terlihat di carousel portofolio B2B.</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.portfolios.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-xl transition shadow-sm shadow-sky-600/20 cursor-pointer">
                    Simpan Portofolio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
