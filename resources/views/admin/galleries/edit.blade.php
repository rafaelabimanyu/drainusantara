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
                    <option value="rumahan" {{ old('category', $gallery->category) === 'rumahan' ? 'selected' : '' }}>Rumahan (Residensial / Hunian)</option>
                    <option value="fnb" {{ old('category', $gallery->category) === 'fnb' ? 'selected' : '' }}>Restoran &amp; Kafe (FnB)</option>
                    <option value="gedung" {{ old('category', $gallery->category) === 'gedung' ? 'selected' : '' }}>Gedung &amp; Apartemen</option>
                    <option value="perkantoran" {{ old('category', $gallery->category) === 'perkantoran' ? 'selected' : '' }}>Perkantoran</option>
                    <option value="pabrik" {{ old('category', $gallery->category) === 'pabrik' ? 'selected' : '' }}>Pabrik &amp; Industri</option>
                    <option value="ruko" {{ old('category', $gallery->category) === 'ruko' ? 'selected' : '' }}>Ruko &amp; Komersial</option>
                    @if($gallery->category === 'b2b')
                        <option value="b2b" selected>Komersial / B2B (Legacy)</option>
                    @endif
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
        <div class="space-y-4">
            <div class="border-b border-slate-200 pb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Foto Komparasi: Sebelum &amp; Sesudah</span>
                <p class="text-[11px] text-slate-500 mt-0.5">Unggah foto baru untuk memperbarui foto komparasi (otomatis terkonversi ke WebP).</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-form.image-upload 
                    name="before_image" 
                    label="Foto Sebelum (Before / Kondisi Mampet)" 
                    :current="$gallery->before_image"
                    aspect="video"
                    help="Foto saat saluran tersumbat / kotor." />

                <x-form.image-upload 
                    name="after_image" 
                    label="Foto Sesudah (After / Kondisi Lancar)" 
                    :current="$gallery->after_image"
                    aspect="video"
                    help="Foto saat saluran bersih & lancar kembali." />
            </div>
        </div>

        <!-- 1 Foto Utama Alternatif -->
        <div class="space-y-2">
            <x-form.image-upload 
                name="image" 
                label="Atau Foto Utama Alternatif" 
                :current="$gallery->image"
                aspect="video"
                help="Gunakan jika hanya ada 1 foto dokumentasi pengerjaan teknisi (tanpa before-after)." />
        </div>

        <div>
            <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Ringkas Hasil Pengerjaan</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('description', $gallery->description) }}</textarea>
            @error('description') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Lokasi & Spesifikasi Pengerjaan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="location" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Lokasi Pengerjaan *</label>
                <input type="text" name="location" id="location" value="{{ old('location', $gallery->location) }}"
                       placeholder="Misal: Kelapa Gading, Jakarta Utara"
                       class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">
                @error('location') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="drain_type" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Saluran yang Dikerjakan</label>
                <input type="text" name="drain_type" id="drain_type" value="{{ old('drain_type', $gallery->drain_type) }}"
                       placeholder="Misal: Pipa Wastafel Cuci Piring 2 Inch"
                       class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">
                @error('drain_type') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="method" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Metode Perbaikan</label>
                <input type="text" name="method" id="method" value="{{ old('method', $gallery->method) }}"
                       placeholder="Misal: Spiral Rotary Ridgid K-50"
                       class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">
                @error('method') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Biaya / Harga Pengerjaan (Rp)</label>
                <input type="number" name="price" id="price" value="{{ old('price', $gallery->price) }}" min="0" step="10000"
                       placeholder="Misal: 350000"
                       class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">
                @error('price') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="duration" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Durasi Pengerjaan</label>
                <input type="text" name="duration" id="duration" value="{{ old('duration', $gallery->duration) }}"
                       placeholder="Misal: 45 Menit / 1.5 Jam"
                       class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">
                @error('duration') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Diagnosa Masalah Saluran --}}
        <div>
            <label for="diagnosis" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Diagnosa Masalah Saluran (Penyebab Sumbatan)</label>
            <textarea name="diagnosis" id="diagnosis" rows="2"
                      placeholder="Misal: Kerak minyak jenuh beku tebal setebal 3 cm dan gumpalan sisa makanan yang menempel di lekukan pipa..."
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('diagnosis', $gallery->diagnosis) }}</textarea>
            @error('diagnosis') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tipe Properti --}}
        @php
            $propertyOptions = ['Rumah Tinggal', 'Restoran & Kafe', 'Kantor', 'Apartemen', 'Hotel', 'Pabrik', 'Ruko', 'Sekolah'];
            $selectedProperties = (array) old('property_type', is_array($gallery->property_type) ? $gallery->property_type : (is_string($gallery->property_type) ? json_decode($gallery->property_type, true) ?? [] : []));
        @endphp
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tipe Properti</label>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 bg-slate-50 border border-slate-200 rounded-lg p-3">
                @foreach($propertyOptions as $opt)
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" name="property_type[]" value="{{ $opt }}" 
                               {{ in_array($opt, $selectedProperties) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                        <span>{{ $opt }}</span>
                    </label>
                @endforeach
            </div>
            @error('property_type') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tingkat Keparahan --}}
        <div>
            <label for="severity" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tingkat Keparahan</label>
            <select name="severity" id="severity" 
                    class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs bg-white">
                <option value="">-- Pilih Tingkat Keparahan --</option>
                <option value="ringan" {{ old('severity', strtolower((string)$gallery->severity)) === 'ringan' ? 'selected' : '' }}>Ringan</option>
                <option value="sedang" {{ old('severity', strtolower((string)$gallery->severity)) === 'sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="berat" {{ old('severity', strtolower((string)$gallery->severity)) === 'berat' ? 'selected' : '' }}>Berat</option>
            </select>
            @error('severity') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Konten Naratif --}}
        <div>
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan Teknis / Cerita Lengkap Pengerjaan</label>
            <textarea name="content" id="content" rows="6"
                      placeholder="Cerita lengkap pengerjaan: kondisi awal, proses, hasil, tips..."
                      class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('content', $gallery->content) }}</textarea>
            @error('content') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Alat / Mesin --}}
        @php
            $equipmentList = $equipments ?? \App\Models\Equipment::where('is_active', true)->orderBy('name')->get();
            $selectedEquipments = (array) old('equipment_ids', $gallery->relationLoaded('equipment') ? $gallery->equipment->pluck('id')->toArray() : $gallery->equipment()->pluck('equipments.id')->toArray());
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

        {{-- Slug --}}
        <div>
            <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Slug URL</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $gallery->slug) }}"
                   placeholder="Auto dari judul"
                   class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs font-mono text-xs">
            <p class="text-[11px] text-slate-500 mt-1">Slug URL studi kasus untuk halaman publik.</p>
            @error('slug') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
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
