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
        <div class="space-y-2">
            <x-form.image-upload 
                name="photo" 
                label="Foto Profil Staff / Teknisi" 
                :current="$staff->photo"
                :allowUrl="true"
                urlName="photo_url"
                :urlValue="old('photo_url')"
                aspect="square"
                help="Format JPG, PNG, WEBP. Kosongkan jika tetap ingin memakai foto saat ini." />
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
