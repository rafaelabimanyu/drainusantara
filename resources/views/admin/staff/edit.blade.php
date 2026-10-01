@extends('layouts.admin')

@section('title', 'Edit Staff - ' . $staff->name)
@section('page-title', 'Edit Profil Staff')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Staff: {{ $staff->name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui data profil, foto, peran, dan status siaga aktif staf.</p>
        </div>
        <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.staff.update', $staff) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-5 shadow-2xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Nama Lengkap Staff -->
            <div class="sm:col-span-2">
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Lengkap Staff / Teknisi *
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $staff->name) }}" required
                       placeholder="Misal: Agus Santoso, Bambang Wijaya"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('name') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Peran / Spesialisasi -->
            <div>
                <label for="role" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Peran / Posisi / Spesialisasi
                </label>
                <input type="text" name="role" id="role" value="{{ old('role', $staff->role) }}"
                       placeholder="Misal: Teknisi Senior Rooter Spiral"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('role') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Inisial (Opsional) -->
            <div>
                <label for="initials" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Inisial Avatar (Opsional)
                </label>
                <input type="text" name="initials" id="initials" value="{{ old('initials', $staff->initials) }}" maxlength="5"
                       placeholder="Misal: AS"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm uppercase outline-hidden transition shadow-2xs">
                @error('initials') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Upload Foto Profil Staf -->
        <div class="p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3" x-data="{ preview: '{{ $staff->photo }}' }">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Foto Profil Staff</span>
                    <p class="text-[11px] text-slate-500 mt-0.5">Unggah foto baru jika ingin mengganti gambar saat ini.</p>
                </div>
                <span class="text-[11px] text-sky-700 font-semibold bg-sky-50 px-2 py-0.5 rounded border border-sky-200">JPG, PNG, WEBP</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <div class="w-full h-32 rounded-xl border border-slate-300 bg-white flex items-center justify-center overflow-hidden relative shadow-2xs">
                    <template x-if="preview">
                        <img :src="preview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!preview">
                        <div class="text-center p-2 text-slate-400">
                            <svg class="w-8 h-8 mx-auto mb-1 text-slate-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span class="text-[11px] font-medium">Avatar Default</span>
                        </div>
                    </template>
                </div>

                <div class="sm:col-span-2 space-y-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Berkas Foto (Opsional)</label>
                        <input type="file" name="photo" id="photo" accept="image/*"
                               @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); }"
                               class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        @error('photo') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="photo_url" class="block text-xs font-bold text-slate-700 mb-1">Atau Ubah Link URL Foto</label>
                        <input type="url" name="photo_url" id="photo_url" value="{{ old('photo_url') }}"
                               placeholder="https://images.unsplash.com/..."
                               @input="if ($event.target.value) { preview = $event.target.value; }"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                        @error('photo_url') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
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
                <input type="number" name="order" id="order" value="{{ old('order', $staff->order) }}" min="0"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                @error('order') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center sm:pt-6">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $staff->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                    <span class="text-xs sm:text-sm font-medium text-slate-700">Tampilkan di Halaman Profil (Siaga Aktif)</span>
                </label>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.staff.index') }}" 
               class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-xs sm:text-sm transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="px-5 py-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition-colors cursor-pointer">
                Perbarui Staff
            </button>
        </div>
    </form>
</div>
@endsection
