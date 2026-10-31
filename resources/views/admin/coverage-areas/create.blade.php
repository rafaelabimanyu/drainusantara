@extends('layouts.admin')

@section('title', 'Tambah Area Jangkauan')
@section('page-title', 'Tambah Area')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Tambah Area Jangkauan Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftarkan area &amp; kota untuk halaman pendaratan SEO lokal.</p>
        </div>
        <a href="{{ route('admin.coverage-areas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('admin.coverage-areas.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-200 p-5 sm:p-7 space-y-6 shadow-2xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Kota / Wilayah -->
            <div>
                <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kota / Wilayah *</label>
                <select name="city" id="city" required class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden bg-white transition shadow-2xs">
                    <option value="">-- Pilih Wilayah Operasional --</option>
                    <optgroup label="JABODETABEK">
                        <option value="Jakarta Selatan" {{ old('city') == 'Jakarta Selatan' ? 'selected' : '' }}>Jakarta Selatan</option>
                        <option value="Jakarta Timur" {{ old('city') == 'Jakarta Timur' ? 'selected' : '' }}>Jakarta Timur</option>
                        <option value="Jakarta Utara" {{ old('city') == 'Jakarta Utara' ? 'selected' : '' }}>Jakarta Utara</option>
                        <option value="Jakarta Pusat" {{ old('city') == 'Jakarta Pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                        <option value="Jakarta Barat" {{ old('city') == 'Jakarta Barat' ? 'selected' : '' }}>Jakarta Barat</option>
                        <option value="Bogor" {{ old('city') == 'Bogor' ? 'selected' : '' }}>Bogor</option>
                        <option value="Depok & Cinere" {{ old('city') == 'Depok & Cinere' ? 'selected' : '' }}>Depok & Cinere</option>
                        <option value="Tangerang Kota" {{ old('city') == 'Tangerang Kota' ? 'selected' : '' }}>Tangerang Kota</option>
                        <option value="Tangerang Selatan" {{ old('city') == 'Tangerang Selatan' ? 'selected' : '' }}>Tangerang Selatan</option>
                        <option value="Bekasi & Cikarang" {{ old('city') == 'Bekasi & Cikarang' ? 'selected' : '' }}>Bekasi & Cikarang</option>
                    </optgroup>
                    <optgroup label="SEMARANG & LAMPUNG">
                        <option value="Kota Semarang" {{ old('city') == 'Kota Semarang' ? 'selected' : '' }}>Kota Semarang</option>
                        <option value="Bandar Lampung" {{ old('city') == 'Bandar Lampung' ? 'selected' : '' }}>Bandar Lampung</option>
                    </optgroup>
                </select>
                @error('city') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Nama Area -->
            <div>
                <label for="district" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Area *</label>
                <input type="text" name="district" id="district" required value="{{ old('district') }}" placeholder="Contoh: Tebet, Sukarame, dll" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                @error('district') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kode Pos -->
            <div class="sm:col-span-2">
                <label for="postal_code" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kode Pos (Opsional)</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" placeholder="Contoh: 12810" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
            </div>

            <!-- Custom SEO Title -->
            <div class="sm:col-span-2">
                <label for="meta_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Custom SEO Meta Title (Opsional)</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" placeholder="Biarkan kosong untuk judul SEO otomatis" class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">
                <p class="text-[11px] text-slate-500 mt-1">Default otomatis: Jasa Saluran Mampet di {Area}, {Kota} - Drainusantara Bergaransi</p>
            </div>

            <!-- Custom SEO Meta Description -->
            <div class="sm:col-span-2">
                <label for="meta_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">SEO Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="2" placeholder="Deskripsi meta untuk mesin pencarian Google..." class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('meta_description') }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Konten Lokal (Teks Biasa)</label>
                <textarea name="content" id="content" rows="4" class="w-full rounded-lg border border-slate-300 px-3.5 py-2 text-sm focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 outline-hidden transition shadow-2xs">{{ old('content') }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Isi informasi layanan khusus area ini. HTML ditampilkan sebagai teks, bukan markup.</p>
                @error('content') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Foto Hero Section Wilayah -->
            <div class="sm:col-span-2 p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-3" x-data="{ heroPreview: null }">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">Foto Hero Section Wilayah (Opsional)</span>
                        <p class="text-[11px] text-slate-500 mt-0.5">Foto khusus latar belakang hero section untuk landing page area ini. Jika kosong, sistem mewarisi foto kota/provinsi.</p>
                    </div>
                    <span class="text-xs text-slate-500 font-medium">JPG, PNG, WEBP</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                    <div class="w-full h-32 rounded-lg border-2 border-dashed border-slate-300 bg-white flex items-center justify-center overflow-hidden relative shadow-2xs">
                        <template x-if="heroPreview">
                            <img :src="heroPreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!heroPreview">
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
                            <input type="file" name="hero_image" id="hero_image" accept="image/jpeg,image/png,image/webp"
                                   @change="const f = $event.target.files[0]; if (f) { heroPreview = URL.createObjectURL(f); }"
                                   class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                            @error('hero_image') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="hero_image_url" class="block text-xs font-bold text-slate-700 mb-1">Atau Gunakan Link URL Gambar Luar</label>
                            <input type="url" name="hero_image_url" id="hero_image_url" value="{{ old('hero_image_url') }}"
                                   placeholder="https://domain.com/foto-daerah.webp atau URL gambar"
                                   @input="if ($event.target.value) { heroPreview = $event.target.value; }"
                                   class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                            @error('hero_image_url') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Dinamis Wilayah (Repeater) -->
            @php
                $existingFaqs = old('faqs', []);
                if (!is_array($existingFaqs)) {
                    $existingFaqs = [];
                }
            @endphp
            <div class="sm:col-span-2 p-4 bg-slate-50/75 rounded-lg border border-slate-200 space-y-4"
                 x-data="{
                     faqs: {{ Illuminate\Support\Js::from($existingFaqs) }},
                     addFaq(q = '', a = '') {
                         this.faqs.push({ question: q, answer: a });
                     },
                     removeFaq(index) {
                         this.faqs.splice(index, 1);
                     },
                     loadTemplate() {
                         const district = document.getElementById('district')?.value || 'Wilayah';
                         const city = document.getElementById('city')?.value || 'Sekitarnya';
                         this.faqs = [
                             {
                                 question: `Berapa lama estimasi teknisi Drainusantara tiba di area ${district}, ${city}?`,
                                 answer: `Armada siaga teknisi kami di posko ${city} umumnya dapat tiba di lokasi Anda di area ${district} dalam waktu 30 hingga 60 menit setelah konfirmasi pemesanan, menyesuaikan rute lalu lintas terdekat.`
                             },
                             {
                                 question: `Apakah pengerjaan saluran mampet di ${district} membongkar lantai keramik?`,
                                 answer: `Sama sekali tidak (100% tanpa bongkar ubin/keramik). Kami menggunakan mesin spiral baja rotary berdaya puntir tinggi yang meliuk mengikuti alur pipa PVC hingga titik sumbatan terdalam tanpa merusak struktur lantai.`
                             },
                             {
                                 question: `Jenis saluran apa saja yang dilayani di ${district}?`,
                                 answer: `Kami menangani pelancaran wastafel sink cuci piring, kloset toilet duduk/jongkok, floor drain kamar mandi, bak kontrol rumah, talang pipa atap, hingga pembersihan rutin grease trap restoran & ruko di seluruh area ${district}.`
                             },
                             {
                                 question: `Berapa biaya jasa pelancaran pipa mampet di ${district}?`,
                                 answer: `Biaya jasa penanganan mulai dari Rp 400.000 dengan skema No Cure No Pay (jika saluran gagal mengalir lancar, Anda bebas dari biaya jasa pengerjaan).`
                             },
                             {
                                 question: `Apakah ada garansi resmi untuk pengerjaan di ${district}?`,
                                 answer: `Ya, setiap pengerjaan yang dinyatakan tuntas dilindungi nota digital garansi resmi 30 hari kalender. Jika terjadi sumbatan ulang di titik yang sama dalam masa garansi, tim kami melancarkan ulang tanpa biaya tambahan.`
                             }
                         ];
                     }
                 }">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-3">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-700 block">FAQ Dinamis Wilayah</span>
                        <p class="text-[11px] text-slate-500 mt-0.5">Pertanyaan &amp; jawaban khusus untuk area ini. Jika dikosongkan, sistem otomatis memakai template default kontekstual.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="loadTemplate()"
                                class="px-2.5 py-1 text-xs font-semibold rounded-md border border-sky-300 text-sky-700 bg-sky-50 hover:bg-sky-100 transition-colors cursor-pointer">
                            Gunakan Template Wilayah
                        </button>
                        <button type="button" @click="addFaq()"
                                class="px-2.5 py-1 text-xs font-semibold rounded-md bg-sky-700 hover:bg-sky-800 text-white transition-colors cursor-pointer flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Tambah FAQ</span>
                        </button>
                    </div>
                </div>

                <template x-if="faqs.length === 0">
                    <div class="p-4 rounded-lg bg-white border border-dashed border-slate-300 text-center text-xs text-slate-400">
                        Belum ada FAQ kustom yang ditambahkan. Halaman publik akan menampilkan template FAQ otomatis berbasis nama area &amp; kota. Klik <strong>Gunakan Template Wilayah</strong> jika ingin menyesuaikan.
                    </div>
                </template>

                <div class="space-y-3">
                    <template x-for="(faq, index) in faqs" :key="index">
                        <div class="p-3.5 bg-white rounded-lg border border-slate-200 space-y-2 relative shadow-2xs">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11px] font-bold text-sky-700" x-text="`FAQ #${index + 1}`"></span>
                                <button type="button" @click="removeFaq(index)" class="text-slate-400 hover:text-rose-600 transition-colors p-1" title="Hapus pertanyaan ini">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Pertanyaan</label>
                                <input type="text" :name="`faqs[${index}][question]`" x-model="faq.question" placeholder="Contoh: Berapa lama estimasi teknisi tiba di area ini?"
                                       class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jawaban</label>
                                <textarea :name="`faqs[${index}][answer]`" x-model="faq.answer" rows="2" placeholder="Jawaban detail dan jelas..."
                                          class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 focus:border-sky-700 focus:ring-1 focus:ring-sky-700 outline-hidden"></textarea>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Status Aktif Checkbox -->
            <div class="sm:col-span-2 flex items-center gap-2.5 pt-1">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_active" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Publikasikan halaman SEO area ini</label>
            </div>
        </div>

        <div class="pt-5 border-t border-slate-200 flex items-center justify-end gap-2.5">
            <a href="{{ route('admin.coverage-areas.index') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-xs sm:text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-sky-700 hover:bg-sky-800 text-white text-xs sm:text-sm font-semibold shadow-2xs transition-colors cursor-pointer">
                Simpan Area
            </button>
        </div>
    </form>
</div>
@endsection
