@extends('layouts.admin')

@section('title', 'Tambah Portofolio')
@section('page-title', 'Tambah Portofolio Restoran & Klien')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Portofolio Restoran &amp; Klien</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Tambahkan foto dan nama tempat usaha/restoran untuk ditampilkan pada kartu portofolio.</p>
        </div>
        <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Nama Restoran / Klien -->
            <div class="sm:col-span-2">
                <label for="client_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Restoran / Tempat Usaha *
                </label>
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" required
                       placeholder="Misal: D'Cost Seafood, Restoran Pagi Sore, The Alana Hotel"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('client_name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Lokasi / Cabang / Kota -->
            <div>
                <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Lokasi / Cabang / Kota
                </label>
                <input type="text" name="location" id="location" value="{{ old('location') }}"
                       placeholder="Misal: Mall Kelapa Gading, Jakarta Utara"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('location') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori / Sektor Usaha -->
            <div>
                <label for="client_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Kategori / Jenis Usaha
                </label>
                <input type="text" name="client_type" id="client_type" value="{{ old('client_type', 'Restoran & F&B Komersial') }}"
                       placeholder="Misal: Restoran F&B, Kafe, Perhotelan"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('client_type') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Upload Foto Lokasi / Perusahaan -->
        <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3" x-data="{ preview: null }">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Foto Restoran / Tempat Usaha</span>
                <span class="text-[11px] text-sky-700 font-semibold bg-sky-50 px-2 py-0.5 rounded border border-sky-200">JPG, PNG, WEBP</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <div class="w-full h-32 rounded-lg border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden relative shadow-2xs">
                    <template x-if="preview">
                        <img :src="preview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!preview">
                        <div class="text-center p-2 text-slate-400">
                            <svg class="w-6 h-6 mx-auto mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-[11px] font-medium">Pratinjau Foto</span>
                        </div>
                    </template>
                </div>

                <div class="sm:col-span-2 space-y-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Berkas Gambar</label>
                        <input type="file" name="image" id="image" accept="image/*"
                               @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                               class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        @error('image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="image_url" class="block text-xs font-bold text-slate-700 mb-1">Atau Gunakan Link URL Foto Luar</label>
                        <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                               placeholder="https://domain.com/foto-restoran.webp atau URL gambar"
                               @input="if ($event.target.value) { preview = $event.target.value; }"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                        @error('image_url') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaturan Urutan & Status -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-1">
            <div>
                <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Urutan Tampilan (Angka Kecil Tampil Lebih Dulu)
                </label>
                <input type="number" name="order" id="order" value="{{ old('order', $nextOrder) }}" min="1"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                <p class="text-[11px] text-slate-500 mt-1">Otomatis mengisi slot urutan berikutnya (#{{ $nextOrder }}). Dapat diubah manual jika perlu.</p>
                @error('order') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center sm:pt-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
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
                Simpan Portofolio
            </button>
        </div>
    </form>
</div>
@endsection
