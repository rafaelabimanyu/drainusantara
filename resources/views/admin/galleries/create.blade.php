@extends('layouts.admin')

@section('title', 'Tambah Foto Galeri')
@section('page-title', 'Tambah Dokumentasi Galeri')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Dokumentasi Galeri</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Unggah dokumentasi pengerjaan sebelum dan sesudah pelancaran pipa.</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf

        <div>
            <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Proyek / Pengerjaan *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                   placeholder="Misal: Pelancaran Pipa Wastafel Dapur Restoran"
                   class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
            @error('title') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Sektor Kategori *</label>
                <select name="category" id="category" required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition bg-white shadow-2xs">
                    <option value="rumahan" {{ old('category') == 'rumahan' ? 'selected' : '' }}>Rumahan (Residensial / Hunian / Apartemen)</option>
                    <option value="b2b" {{ old('category') == 'b2b' ? 'selected' : '' }}>B2B (Komersial / Restoran F&amp;B / Ruko / Kantor)</option>
                </select>
                @error('category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="service_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kategori Layanan Terkait</label>
                <select name="service_id" id="service_id" 
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition bg-white shadow-2xs">
                    <option value="">-- Pilih Layanan (Opsional) --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
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
                <span class="text-xs text-slate-500 font-medium">JPG, PNG, WEBP</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Upload Sebelum (Before) -->
                <div x-data="{ preview: null }">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500 inline-block"></span>
                        Foto Sebelum (Before)
                    </label>
                    <div class="w-full h-32 rounded-lg border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden mb-2 relative shadow-2xs">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <div class="text-center p-2 text-slate-400">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-[11px] font-medium">Kondisi Mampet</span>
                            </div>
                        </template>
                    </div>
                    <input type="file" name="before_image" id="before_image" accept="image/jpeg,image/png,image/webp"
                           @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                           class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100 cursor-pointer">
                    @error('before_image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Upload Sesudah (After) -->
                <div x-data="{ preview: null }">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                        Foto Sesudah (After)
                    </label>
                    <div class="w-full h-32 rounded-lg border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden mb-2 relative shadow-2xs">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <div class="text-center p-2 text-slate-400">
                                <svg class="w-6 h-6 mx-auto mb-1 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-[11px] font-medium">Kondisi Lancar</span>
                            </div>
                        </template>
                    </div>
                    <input type="file" name="after_image" id="after_image" accept="image/jpeg,image/png,image/webp"
                           @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                           class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                    @error('after_image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- 1 Foto Utama Alternatif -->
        <div x-data="{ preview: null }">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Atau Upload 1 Foto Utama Dokumentasi</label>
            <div class="flex items-center gap-3 p-3.5 bg-slate-50/75 rounded-lg border border-slate-200">
                <div class="w-16 h-14 rounded-md border border-slate-300 bg-white flex items-center justify-center overflow-hidden shrink-0">
                    <template x-if="preview">
                        <img :src="preview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!preview">
                        <span class="text-[10px] text-slate-400">1 Foto</span>
                    </template>
                </div>
                <div class="flex-1">
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                           @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                           class="block w-full text-xs text-slate-600 file:mr-2.5 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300 cursor-pointer">
                    <p class="text-[11px] text-slate-500 mt-0.5">Digunakan jika memiliki 1 foto ringkas pengerjaan teknisi.</p>
                </div>
            </div>
            @error('image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Ringkas Hasil Pengerjaan</label>
            <textarea name="description" id="description" rows="3"
                      placeholder="Jelaskan kendala awal, metode pengerjaan rooter spiral, durasi pengerjaan, dan garansi..."
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('description') }}</textarea>
            @error('description') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 6. Lokasi Pengerjaan --}}
        <div>
            <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Lokasi Pengerjaan</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}"
                   placeholder="Jl. Merdeka No. 12, Kec. Serpong, Tangerang Selatan"
                   class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">
            @error('location') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 7. Tipe Properti --}}
        @php
            $propertyOptions = ['Rumah Tinggal', 'Restoran', 'Kantor', 'Apartemen', 'Hotel', 'Pabrik', 'Sekolah'];
            $selectedProperties = (array) old('property_type', []);
        @endphp
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tipe Properti</label>
            <div class="grid grid-cols-2 gap-2 bg-slate-50 border border-slate-200 rounded-lg p-3">
                @foreach($propertyOptions as $opt)
                    <label class="flex items-center gap-2 text-xs sm:text-sm text-slate-700 cursor-pointer">
                        <input type="checkbox" name="property_type[]" value="{{ $opt }}" 
                               {{ in_array($opt, $selectedProperties) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                        <span>{{ $opt }}</span>
                    </label>
                @endforeach
            </div>
            @error('property_type') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 8. Jenis Kendala --}}
        @php
            $problemOptions = ['Saluran Mampet', 'Grease Trap Penuh', 'Pipa Bocor', 'WC Mampet', 'Wastafel Mampet', 'Got Tersumbat'];
            $selectedProblems = (array) old('problem_type', []);
        @endphp
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Jenis Kendala</label>
            <div class="grid grid-cols-2 gap-2 bg-slate-50 border border-slate-200 rounded-lg p-3">
                @foreach($problemOptions as $opt)
                    <label class="flex items-center gap-2 text-xs sm:text-sm text-slate-700 cursor-pointer">
                        <input type="checkbox" name="problem_type[]" value="{{ $opt }}" 
                               {{ in_array($opt, $selectedProblems) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                        <span>{{ $opt }}</span>
                    </label>
                @endforeach
            </div>
            @error('problem_type') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 9. Tingkat Keparahan --}}
        <div>
            <label for="severity" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tingkat Keparahan</label>
            <select name="severity" id="severity" 
                    class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs bg-white">
                <option value="">-- Pilih Tingkat Keparahan --</option>
                <option value="ringan" {{ old('severity') === 'ringan' ? 'selected' : '' }}>Ringan</option>
                <option value="sedang" {{ old('severity', 'sedang') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="berat" {{ old('severity') === 'berat' ? 'selected' : '' }}>Berat</option>
            </select>
            @error('severity') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 10. Durasi --}}
        <div>
            <label for="duration" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Durasi Pengerjaan</label>
            <input type="text" name="duration" id="duration" value="{{ old('duration') }}"
                   placeholder="3 jam"
                   class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">
            @error('duration') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 11. Konten Naratif --}}
        <div>
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Konten Naratif Pengerjaan</label>
            <textarea name="content" id="content" rows="8"
                      placeholder="Cerita lengkap pengerjaan: kondisi awal, proses, hasil, tips..."
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('content') }}</textarea>
            @error('content') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 12. Alat / Mesin --}}
        @php
            $equipmentList = $equipments ?? \App\Models\Equipment::where('is_active', true)->orderBy('name')->get();
            $selectedEquipments = (array) old('equipment_ids', []);
        @endphp
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Peralatan / Mesin Digunakan</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 bg-slate-50 border border-slate-200 rounded-lg p-3 max-h-60 overflow-y-auto">
                @forelse($equipmentList as $eq)
                    <label class="flex items-center justify-between gap-2 text-xs sm:text-sm text-slate-700 cursor-pointer p-1.5 hover:bg-white rounded-md transition-colors">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="equipment_ids[]" value="{{ $eq->id }}" 
                                   {{ in_array($eq->id, $selectedEquipments) ? 'checked' : '' }}
                                   class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                            <span class="font-medium text-slate-800">{{ $eq->name }}</span>
                        </div>
                        @if(!empty($eq->category))
                            <span class="text-xs text-slate-500 font-medium shrink-0">
                                {{ $eq->category }}
                            </span>
                        @endif
                    </label>
                @empty
                    <p class="text-xs text-slate-400 col-span-2">Belum ada data peralatan aktif.</p>
                @endforelse
            </div>
            @error('equipment_ids') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- 13. Slug --}}
        <div>
            <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Slug URL (Opsional / Otomatis dari Judul)</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                   placeholder="Auto dari judul"
                   class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs font-mono text-xs">
            <p class="text-[11px] text-slate-500 mt-1">Kosongkan jika ingin dibuat otomatis dari judul.</p>
            @error('slug') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-2 pt-1">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
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
                Simpan Foto Galeri
            </button>
        </div>
    </form>
</div>
@endsection
