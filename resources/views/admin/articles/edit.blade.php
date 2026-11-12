@extends('layouts.admin')

@section('title', 'Edit Artikel')
@section('page-title', 'Digital Content Studio - Edit Artikel')

@section('content')
@php
    $subCategoriesMap = \App\Models\Article::SUB_CATEGORIES;
    $currentSub = old('sub_category', $article->sub_category);
    $existingContentImages = is_array($article->content_images) ? array_values($article->content_images) : [];
@endphp

<div class="max-w-5xl mx-auto space-y-6"
     x-data="{
        title: @json(old('title', $article->title)),
        content: @json(old('content', $article->content)),
        metaTitle: @json(old('meta_title', $article->meta_title ?? '')),
        metaDescription: @json(old('meta_description', $article->meta_description ?? '')),
        focusKeyword: '',
        category: '{{ old('category', $article->category_label) }}',
        subCategory: '{{ $currentSub ?? '' }}',
        subMap: {{ json_encode($subCategoriesMap) }},
        selectedService: '{{ old('service_id', $article->service_id ?? '') }}',
        selectedCity: '{{ old('city', $article->city ?? '') }}',
        activeTab: 'editor',

        get availableSub() {
            return this.subMap[this.category] || [];
        },

        get wordCount() {
            const clean = (this.content || '').replace(/<[^>]*>/g, ' ').trim();
            return clean ? (clean.match(/\S+/g) || []).length : 0;
        },

        get readingTime() {
            return Math.max(1, Math.ceil(this.wordCount / 200));
        },

        get hasKeywordInTitle() {
            if (!this.focusKeyword.trim()) return false;
            return (this.title || '').toLowerCase().includes(this.focusKeyword.trim().toLowerCase());
        },

        get hasKeywordInFirstParagraph() {
            if (!this.focusKeyword.trim()) return false;
            const firstP = ((this.content || '').split(/\n\s*\n/)[0] || '').toLowerCase();
            return firstP.includes(this.focusKeyword.trim().toLowerCase());
        },

        get hasKeywordInHeadings() {
            if (!this.focusKeyword.trim()) return false;
            const kw = this.focusKeyword.trim().toLowerCase();
            const headings = (this.content || '').match(/^#{2,3}\s+.*$/gm) || [];
            return headings.some(h => h.toLowerCase().includes(kw));
        },

        get serpTitle() {
            const raw = (this.metaTitle || '').trim() || ((this.title || '').trim() ? ((this.title || '').trim() + ' - Drainusantara') : 'Judul Artikel - Drainusantara');
            return raw.length > 60 ? raw.substring(0, 57) + '...' : raw;
        },

        get serpDesc() {
            const raw = (this.metaDescription || '').trim() || (this.content || '').replace(/<[^>]*>/g, '').trim().substring(0, 155);
            return raw.length > 155 ? raw.substring(0, 152) + '...' : (raw || 'Deskripsi ringkasan artikel edukasi dan tips saluran pembuangan Drainusantara.');
        },

        get serpSlug() {
            const s = (this.title || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            return s ? s : '{{ $article->slug }}';
        },

        insertText(before, after = '') {
            const el = document.getElementById('content-textarea');
            if (!el) return;
            const start = el.selectionStart;
            const end = el.selectionEnd;
            const selected = el.value.substring(start, end);
            const replacement = before + (selected || 'teks') + after;
            el.value = el.value.substring(0, start) + replacement + el.value.substring(end);
            this.content = el.value;
            el.focus();
            el.selectionStart = start + before.length;
            el.selectionEnd = start + before.length + (selected ? selected.length : 4);
        },

        insertBlock(template) {
            const el = document.getElementById('content-textarea');
            if (!el) return;
            const start = el.selectionStart;
            const end = el.selectionEnd;
            const prefix = el.value.substring(0, start);
            const suffix = el.value.substring(end);
            const sep = (prefix && !prefix.endsWith('\n\n')) ? (prefix.endsWith('\n') ? '\n' : '\n\n') : '';
            el.value = prefix + sep + template + '\n\n' + suffix;
            this.content = el.value;
            el.focus();
        },

        insertVideoBlock() {
            const url = prompt('Masukkan URL Video YouTube atau URL file MP4:', 'https://www.youtube.com/watch?v=');
            if (url && url.trim()) {
                this.insertBlock(`[video: ${url.trim()}]`);
            }
        },

        insertInternalLink(type) {
            if (type === 'service' && this.selectedService) {
                const selectEl = document.getElementById('service_id');
                const serviceName = selectEl ? selectEl.options[selectEl.selectedIndex].text : 'Layanan Pipa';
                this.insertBlock(`[Jasa ${serviceName} Bergaransi Resmi 30 Hari](https://drainusantara.id/layanan)`);
            } else if (type === 'city' && this.selectedCity) {
                const slug = this.selectedCity.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
                this.insertBlock(`[Jasa Saluran Pipa Mampet ${this.selectedCity} (Siaga 24 Jam)](https://drainusantara.id/area/${slug})`);
            }
        },

        get parsedPreviewHtml() {
            let text = this.content || '';
            if (!text.trim()) {
                return '<p class=\"text-sm text-slate-400 italic py-8 text-center\">Konten artikel masih kosong. Tulis teks pada tab Editor Konten untuk melihat live preview.</p>';
            }

            text = text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            text = text.replace(/^### (.*$)/gim, '<h3 class=\"text-lg font-bold text-slate-900 mt-5 mb-2\">$1</h3>');
            text = text.replace(/^## (.*$)/gim, '<h2 class=\"text-xl font-extrabold text-slate-900 mt-6 mb-3 border-b border-slate-200 pb-1.5\">$1</h2>');
            text = text.replace(/\*\*(.*?)\*\*/g, '<strong class=\"font-bold text-slate-900\">$1</strong>');
            text = text.replace(/\*(.*?)\*/g, '<em class=\"italic\">$1</em>');
            text = text.replace(/^&gt; (.*$)/gim, '<blockquote class=\"border-l-4 border-sky-600 pl-4 py-1 my-3 italic text-slate-700 bg-slate-50 rounded-r\">$1</blockquote>');

            // Callouts
            text = text.replace(/\[(?:Info Penting|info)\]([\s\S]*?)\[\/(?:Info Penting|info)\]/gi, '<div class=\"my-4 p-4 rounded-lg bg-sky-50 border-l-4 border-sky-600 text-sky-950 border border-slate-200\"><strong class=\"block text-xs uppercase font-bold text-sky-800 mb-1\">Catatan Penting:</strong>$1</div>');
            text = text.replace(/\[(?:Peringatan Bahaya|danger|warning)\]([\s\S]*?)\[\/(?:Peringatan Bahaya|danger|warning)\]/gi, '<div class=\"my-4 p-4 rounded-lg bg-rose-50 border-l-4 border-rose-600 text-rose-950 border border-slate-200\"><strong class=\"block text-xs uppercase font-bold text-rose-800 mb-1\">Peringatan Bahaya:</strong>$1</div>');
            text = text.replace(/\[(?:Tips Hemat|tips|tip)\]([\s\S]*?)\[\/(?:Tips Hemat|tips|tip)\]/gi, '<div class=\"my-4 p-4 rounded-lg bg-emerald-50 border-l-4 border-emerald-600 text-emerald-950 border border-slate-200\"><strong class=\"block text-xs uppercase font-bold text-emerald-800 mb-1\">Tips Hemat:</strong>$1</div>');

            // CTAs
            text = text.replace(/\[cta-konsultasi\]/gi, '<div class=\"my-5 p-4 rounded-lg bg-slate-900 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3\"><div><div class=\"text-xs font-bold text-emerald-400 uppercase tracking-wider mb-0.5\">Siaga 24 Jam Nonstop</div><h4 class=\"font-bold text-sm text-white\">Saluran Pipa Mengalami Kendala Serupa?</h4><p class=\"text-xs text-slate-300\">Konsultasi bebas biaya, teknisi siap meluncur ke lokasi.</p></div><span class=\"px-3.5 py-2 rounded-lg bg-emerald-600 text-white text-xs font-bold shrink-0\">Chat Teknisi via WA</span></div>');
            text = text.replace(/\[cta-kalkulator\]/gi, '<div class=\"my-5 p-4 rounded-lg bg-sky-50 border border-sky-200 text-slate-900 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3\"><div><div class=\"text-xs font-bold text-sky-800 uppercase tracking-wider mb-0.5\">Estimasi Biaya Transparan</div><h4 class=\"font-bold text-sm text-slate-900\">Cek Estimasi Biaya Pelancaran Saluran</h4><p class=\"text-xs text-slate-600\">Hitung perkiraan biaya tanpa biaya tersembunyi.</p></div><span class=\"px-3.5 py-2 rounded-lg bg-sky-700 text-white text-xs font-bold shrink-0\">Lihat Estimasi Biaya</span></div>');

            // Photos & Videos
            text = text.replace(/\[foto-([1-3])\]/gi, '<div class=\"my-4 p-4 rounded-lg border-2 border-dashed border-sky-300 bg-sky-50/60 text-center text-xs font-bold text-sky-800\">[Preview Foto Tengah #$1 Ditampilkan di Sini]</div>');
            text = text.replace(/\[video:\s*(.*?)\]/gi, '<div class=\"my-4 p-4 rounded-lg border-2 border-dashed border-indigo-300 bg-indigo-50/60 text-center text-xs font-bold text-indigo-800\">[Preview Embed Video: $1]</div>');

            text = text.replace(/\n\s*\n/g, '</p><p class=\"text-sm text-slate-700 leading-relaxed my-3\">');
            return '<p class=\"text-sm text-slate-700 leading-relaxed my-3\">' + text + '</p>';
        }
     }">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold bg-sky-50 border border-sky-200 text-sky-800 mb-1">
                <span>DIGITAL CONTENT STUDIO</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Artikel &amp; Panduan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui konten edukasi, metadata E-E-A-T, dan interkoneksikan dengan silo wilayah &amp; layanan.</p>
        </div>
        <a href="{{ route('admin.articles.index') }}" class="self-start sm:self-auto inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-3.5 py-2 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 transition-colors shadow-2xs">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Main Form Container -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 sm:p-6 lg:p-7 shadow-2xs">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Metadata Utama: Judul & Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="md:col-span-1">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Judul Artikel *</label>
                    <input type="text" name="title" id="title" x-model="title" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs">
                    @error('title') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kategori Utama *</label>
                    <select name="category" id="category" x-model="category" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                        @foreach(\App\Models\Article::CATEGORIES as $catOption)
                            <option value="{{ $catOption }}" {{ old('category', $article->category_label) === $catOption ? 'selected' : '' }}>
                                {{ $catOption }}
                            </option>
                        @endforeach
                    </select>
                    @error('category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sub_category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Sub Kategori</label>
                    <select name="sub_category" id="sub_category" x-model="subCategory"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                        <option value="">-- Pilih Sub Kategori (Opsional) --</option>
                        <template x-for="sub in availableSub" :key="sub">
                            <option :value="sub" x-text="sub" :selected="sub === subCategory"></option>
                        </template>
                    </select>
                    @error('sub_category') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- 2. Internal Linking Topic Silo (Layanan & Wilayah) -->
            <div class="p-4 sm:p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Interkoneksi Internal Link (Topic Cluster &amp; Silo)</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Kaitkan artikel dengan halaman Layanan dan Wilayah terkait untuk memperkuat ranking Google.</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-sky-100 text-sky-800 border border-sky-200">SEO Silo</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="service_id" class="block text-xs font-semibold text-slate-700 mb-1">Layanan Spesialis Terkait</label>
                        <select name="service_id" id="service_id" x-model="selectedService" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-sky-700 text-xs bg-white">
                            <option value="">-- Tidak Terkait Layanan Tertentu --</option>
                            @foreach($services ?? [] as $svc)
                                <option value="{{ $svc->id }}" {{ old('service_id', $article->service_id) == $svc->id ? 'selected' : '' }}>{{ $svc->name }}</option>
                            @endforeach
                        </select>
                        <button type="button" @click="insertInternalLink('service')" :disabled="!selectedService"
                                class="mt-1.5 text-[11px] font-bold text-sky-700 hover:text-sky-900 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>+ Sisipkan Link Layanan ke Teks</span>
                        </button>
                    </div>

                    <div>
                        <label for="city" class="block text-xs font-semibold text-slate-700 mb-1">Wilayah / Kota Target Terkait</label>
                        <select name="city" id="city" x-model="selectedCity" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-sky-700 text-xs bg-white">
                            <option value="">-- Seluruh Indonesia / Nasional --</option>
                            @foreach($cities ?? [] as $c)
                                <option value="{{ $c['name'] }}" {{ old('city', $article->city) == $c['name'] ? 'selected' : '' }}>{{ $c['name'] }} ({{ $c['province_name'] }})</option>
                            @endforeach
                        </select>
                        <button type="button" @click="insertInternalLink('city')" :disabled="!selectedCity"
                                class="mt-1.5 text-[11px] font-bold text-sky-700 hover:text-sky-900 disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>+ Sisipkan Link Wilayah ke Teks</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- 3. Jadwal Publikasi & Posisi Gambar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="published_at" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tanggal Publikasi / Upload</label>
                    <input type="datetime-local" name="published_at" id="published_at" 
                           value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                    <p class="text-[11px] text-slate-500 mt-1">Tanggal upload resmi yang tampil di kartu dan detail artikel.</p>
                    @error('published_at') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image_placement" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Posisi Gambar di Halaman Detail</label>
                    <select name="image_placement" id="image_placement"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 text-sm outline-hidden transition shadow-2xs bg-white">
                        <option value="content" {{ old('image_placement', $article->image_placement ?? 'content') === 'content' ? 'selected' : '' }}>Di Tengah Konten (Kompak &amp; Rapi)</option>
                        <option value="hero" {{ old('image_placement', $article->image_placement) === 'hero' ? 'selected' : '' }}>Di Hero Section (Header Atas)</option>
                    </select>
                    <p class="text-[11px] text-slate-500 mt-1">Pilih apakah gambar tampil di header atas atau di dalam badan artikel.</p>
                    @error('image_placement') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <x-form.image-upload 
                name="thumbnail" 
                label="Gambar Thumbnail Artikel"
                :current="$article->thumbnail"
                help="Pilih file baru jika ingin mengganti gambar thumbnail artikel saat ini."
            />

            <!-- Foto Tambahan di Tengah Berita (Maksimal 3 Foto, Opsional) -->
            <div class="p-4 sm:p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Foto Konten Tambahan (Maksimal 3 Foto, Opsional)</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Dapat disematkan otomatis di sela paragraf atau gunakan penanda manual: <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-1]</code>, <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-2]</code>, <code class="px-1.5 py-0.5 bg-slate-200 text-slate-800 rounded font-mono text-[11px]">[foto-3]</code> di dalam teks.</p>
                    </div>
                    <span class="text-[11px] font-bold text-sky-800 bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md shrink-0">Auto-WebP</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @for($i = 1; $i <= 3; $i++)
                    @php
                        $curSlot = $existingContentImages[$i - 1] ?? null;
                        $curPath = is_array($curSlot) ? ($curSlot['path'] ?? null) : (is_string($curSlot) ? $curSlot : null);
                        $curCaption = is_array($curSlot) ? ($curSlot['caption'] ?? '') : '';
                    @endphp
                    <div class="p-3 bg-white rounded-lg border border-slate-200 space-y-3">
                        <x-form.image-upload 
                            name="content_image_{{ $i }}" 
                            label="Foto Tengah #{{ $i }}" 
                            :current="$curPath"
                            aspect="video"
                            help="Maks. 20MB. Otomatis dikonversi ke WebP." />

                        <div>
                            <label for="content_caption_{{ $i }}" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                                Keterangan Foto #{{ $i }}
                            </label>
                            <input type="text" name="content_caption_{{ $i }}" id="content_caption_{{ $i }}"
                                   value="{{ old('content_caption_' . $i, $curCaption) }}"
                                   placeholder="Contoh: Proses pengikisan kerak pipa"
                                   class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-300 focus:border-sky-700 focus:ring-1 focus:ring-sky-700/20 text-slate-900">
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- 4. Ringkasan & Tag -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="excerpt" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Ringkasan Singkat (Excerpt)</label>
                    <textarea name="excerpt" id="excerpt" rows="3"
                              placeholder="Ringkasan 1-2 kalimat pengantar artikel untuk kartu indeks..."
                              class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('excerpt', $article->excerpt) }}</textarea>
                    @error('excerpt') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tags" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Tag Pendukung</label>
                    <textarea name="tags" id="tags" rows="3"
                              placeholder="Misal: Pipa PVC, Wastafel Dapur, Soda Api, CCTV Drainase (pisahkan dengan koma)"
                              class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300 focus:border-sky-700 focus:ring-2 focus:ring-sky-700/20 text-slate-900 outline-hidden transition shadow-2xs">{{ old('tags', $article->tags) }}</textarea>
                    @error('tags') <p class="text-rose-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- 5. Digital Content Studio: Interactive Toolbar + Split / Tab Preview -->
            <div class="rounded-xl border border-slate-200 overflow-hidden shadow-2xs bg-white">
                <!-- Toolbar Header & Tabs -->
                <div class="bg-slate-50 border-b border-slate-200 p-2.5 sm:p-3 flex flex-wrap items-center justify-between gap-2.5">
                    <!-- Tab Buttons -->
                    <div class="inline-flex p-0.5 rounded-lg bg-slate-200/80 border border-slate-300 text-xs font-bold">
                        <button type="button" @click="activeTab = 'editor'"
                                :class="activeTab === 'editor' ? 'bg-white text-slate-900 shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                class="px-3 py-1.5 rounded-md transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span>Editor Konten</span>
                        </button>
                        <button type="button" @click="activeTab = 'preview'"
                                :class="activeTab === 'preview' ? 'bg-white text-sky-800 shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                class="px-3 py-1.5 rounded-md transition-colors flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Live Preview Interaktif</span>
                        </button>
                    </div>

                    <!-- Live Content Stats -->
                    <div class="flex items-center gap-3 text-xs text-slate-500 font-medium">
                        <span class="inline-flex items-center gap-1">
                            <strong class="font-bold text-slate-800" x-text="wordCount">0</strong> kata
                        </span>
                        <span>&bull;</span>
                        <span class="inline-flex items-center gap-1">
                            <strong class="font-bold text-slate-800" x-text="readingTime">1</strong> mnt baca
                        </span>
                    </div>
                </div>

                <!-- Rich Format Quick Buttons -->
                <div x-show="activeTab === 'editor'" class="bg-white border-b border-slate-200 p-2 sm:p-2.5 flex flex-wrap items-center gap-1.5 text-xs text-slate-700">
                    <!-- Standard Markdown -->
                    <button type="button" @click="insertText('## ', '')" title="Heading 2" class="px-2 py-1 rounded hover:bg-slate-100 font-bold border border-slate-200">H2</button>
                    <button type="button" @click="insertText('### ', '')" title="Heading 3" class="px-2 py-1 rounded hover:bg-slate-100 font-bold border border-slate-200">H3</button>
                    <span class="text-slate-300">|</span>
                    <button type="button" @click="insertText('**', '**')" title="Tebal" class="px-2 py-1 rounded hover:bg-slate-100 font-bold border border-slate-200">B</button>
                    <button type="button" @click="insertText('*', '*')" title="Miring" class="px-2 py-1 rounded hover:bg-slate-100 italic border border-slate-200 font-serif">I</button>
                    <button type="button" @click="insertText('- ', '')" title="Bullet List" class="px-2 py-1 rounded hover:bg-slate-100 border border-slate-200">&bull; List</button>
                    <button type="button" @click="insertText('1. ', '')" title="Numbered List" class="px-2 py-1 rounded hover:bg-slate-100 border border-slate-200">1. List</button>
                    <button type="button" @click="insertText('> ', '')" title="Blockquote" class="px-2 py-1 rounded hover:bg-slate-100 border border-slate-200">&ldquo; Kutip</button>
                    <button type="button" @click="insertBlock('| Fitur / Aspek | Tukang Biasa | Standar Drainusantara |\n|---|---|---|\n| Metode Pengerjaan | Bongkar Lantai | 100% Tanpa Bongkar |\n| Jaminan | Tanpa Garansi | Garansi 30 Hari Nota Resmi |')" title="Tabel Data Responsif" class="px-2 py-1 rounded hover:bg-slate-100 border border-slate-200 font-mono text-[11px]">+ Tabel</button>

                    <span class="text-slate-300">|</span>

                    <!-- Callout Boxes -->
                    <button type="button" @click="insertBlock('[Info Penting]\nTuliskan catatan penting teknis atau informasi wajib di sini.\n[/Info Penting]')"
                            class="px-2 py-1 rounded bg-sky-50 hover:bg-sky-100 text-sky-800 font-semibold border border-sky-200">
                        + Box Info
                    </button>
                    <button type="button" @click="insertBlock('[Peringatan Bahaya]\nJangan pernah mencampur soda api dengan cairan kimia asam keras di pipa PVC!\n[/Peringatan Bahaya]')"
                            class="px-2 py-1 rounded bg-rose-50 hover:bg-rose-100 text-rose-800 font-semibold border border-rose-200">
                        + Peringatan Bahaya
                    </button>
                    <button type="button" @click="insertBlock('[Tips Hemat]\nSiram leher angsa wastafel dengan air panas secara rutin seminggu sekali untuk mencegah penumpukan minyak jenuh.\n[/Tips Hemat]')"
                            class="px-2 py-1 rounded bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold border border-emerald-200">
                        + Tips Hemat
                    </button>

                    <span class="text-slate-300">|</span>

                    <!-- CTAs -->
                    <button type="button" @click="insertBlock('[cta-konsultasi]')"
                            class="px-2 py-1 rounded bg-slate-900 hover:bg-slate-800 text-white font-semibold shadow-2xs">
                        + CTA WhatsApp
                    </button>
                    <button type="button" @click="insertBlock('[cta-kalkulator]')"
                            class="px-2 py-1 rounded bg-sky-700 hover:bg-sky-800 text-white font-semibold shadow-2xs">
                        + CTA Kalkulator
                    </button>

                    <span class="text-slate-300">|</span>

                    <!-- Media Tags -->
                    <button type="button" @click="insertText('[foto-1]', '')" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 font-mono text-[11px] border border-slate-300">+ [foto-1]</button>
                    <button type="button" @click="insertText('[foto-2]', '')" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 font-mono text-[11px] border border-slate-300">+ [foto-2]</button>
                    <button type="button" @click="insertText('[foto-3]', '')" class="px-2 py-1 rounded bg-slate-100 hover:bg-slate-200 font-mono text-[11px] border border-slate-300">+ [foto-3]</button>
                    <button type="button" @click="insertVideoBlock()" class="px-2 py-1 rounded bg-indigo-50 hover:bg-indigo-100 text-indigo-800 font-semibold border border-indigo-200">+ Video Embed</button>
                </div>

                <!-- Textarea Editor -->
                <div x-show="activeTab === 'editor'">
                    <textarea name="content" id="content-textarea" x-model="content" rows="16" required
                              placeholder="Tuliskan isi artikel lengkap di sini (gunakan tombol format di atas untuk menyisipkan callout, tabel, CTA, dan foto)..."
                              class="w-full p-4 text-slate-900 text-sm outline-hidden font-mono border-0 focus:ring-0 leading-relaxed resize-y"></textarea>
                </div>

                <!-- Live Preview Tab -->
                <div x-show="activeTab === 'preview'" class="p-6 bg-white min-h-[380px] max-h-[600px] overflow-y-auto">
                    <div class="border-b border-slate-200 pb-4 mb-4">
                        <div class="text-[11px] font-bold text-sky-700 uppercase tracking-wider mb-1" x-text="category">Edukasi</div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight" x-text="title || 'Judul Artikel Belum Diisi'"></h1>
                        <div class="flex items-center gap-2 text-xs text-slate-500 mt-2">
                            <span>Ditulis oleh Tim Ahli Teknis Drainusantara</span>
                            <span>&bull;</span>
                            <span x-text="readingTime + ' menit baca'"></span>
                        </div>
                    </div>
                    <div class="prose prose-slate max-w-none text-slate-700" x-html="parsedPreviewHtml"></div>
                </div>
            </div>

            <!-- 6. Real-Time SEO Analyzer & Google Mobile SERP Preview -->
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 space-y-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-3">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Real-Time SEO Analyzer &amp; Google SERP Preview</h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Analisis skor keterbacaan, distribusi focus keyword, dan simulasi tampilan di Google Mobile Search.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="focus_kw" class="text-xs font-bold text-slate-700">Focus Keyword:</label>
                        <input type="text" id="focus_kw" x-model="focusKeyword" placeholder="Misal: soda api pipa mampet"
                               class="px-2.5 py-1.5 rounded-md border border-slate-300 text-xs text-slate-900 bg-white focus:border-sky-700 outline-hidden">
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    <!-- Checklist SEO -->
                    <div class="lg:col-span-5 space-y-2 text-xs">
                        <div class="font-bold text-slate-700 mb-1">Checklist Optimasi Konten:</div>
                        
                        <div class="flex items-center gap-2 p-2 rounded-md bg-white border border-slate-200">
                            <span :class="hasKeywordInTitle ? 'text-emerald-600' : 'text-slate-300'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                            <span :class="hasKeywordInTitle ? 'text-slate-800 font-semibold' : 'text-slate-500'">Keyword ada di Judul Artikel</span>
                        </div>

                        <div class="flex items-center gap-2 p-2 rounded-md bg-white border border-slate-200">
                            <span :class="hasKeywordInFirstParagraph ? 'text-emerald-600' : 'text-slate-300'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                            <span :class="hasKeywordInFirstParagraph ? 'text-slate-800 font-semibold' : 'text-slate-500'">Keyword ada di Paragraf Pertama</span>
                        </div>

                        <div class="flex items-center gap-2 p-2 rounded-md bg-white border border-slate-200">
                            <span :class="hasKeywordInHeadings ? 'text-emerald-600' : 'text-slate-300'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                            <span :class="hasKeywordInHeadings ? 'text-slate-800 font-semibold' : 'text-slate-500'">Keyword ada di Sub-heading (H2 / H3)</span>
                        </div>

                        <div class="flex items-center gap-2 p-2 rounded-md bg-white border border-slate-200">
                            <span :class="wordCount >= 300 ? 'text-emerald-600' : 'text-amber-500'">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </span>
                            <span :class="wordCount >= 300 ? 'text-slate-800 font-semibold' : 'text-slate-500'">
                                Panjang Konten (Minimal 300 kata, saat ini: <strong x-text="wordCount"></strong>)
                            </span>
                        </div>
                    </div>

                    <!-- Google Mobile SERP Card Preview -->
                    <div class="lg:col-span-7">
                        <div class="text-xs font-bold text-slate-700 mb-1.5">Simulasi Google SERP Snippet:</div>
                        <div class="p-4 rounded-lg bg-white border border-slate-200 shadow-2xs space-y-1">
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <div class="w-4 h-4 rounded-full bg-sky-600 text-white text-[9px] font-black flex items-center justify-center">D</div>
                                <span class="font-medium text-slate-800">Drainusantara</span>
                                <span class="text-slate-400">&bull;</span>
                                <span class="text-slate-500 font-mono text-[11px]" x-text="'https://drainusantara.id/pengetahuan/' + serpSlug"></span>
                            </div>
                            <div class="text-base font-medium text-sky-800 hover:underline cursor-pointer leading-snug line-clamp-2" x-text="serpTitle"></div>
                            <div class="text-xs text-slate-600 leading-relaxed line-clamp-2" x-text="serpDesc"></div>
                        </div>

                        <!-- Manual SEO Inputs -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                            <div>
                                <label for="meta_title" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Custom Meta Title</label>
                                <input type="text" name="meta_title" id="meta_title" x-model="metaTitle"
                                       placeholder="Otomatis dari judul jika kosong"
                                       class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs bg-white focus:border-sky-700 outline-hidden">
                            </div>
                            <div>
                                <label for="meta_description" class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Custom Meta Description</label>
                                <input type="text" name="meta_description" id="meta_description" x-model="metaDescription"
                                       placeholder="Otomatis dari excerpt jika kosong"
                                       class="w-full px-3 py-1.5 rounded-md border border-slate-300 text-xs bg-white focus:border-sky-700 outline-hidden">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publikasi & Submit -->
            <div class="flex items-center gap-2.5 pt-1">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', session()->hasOldInput() ? false : $article->is_published) ? 'checked' : '' }}
                       class="w-4 h-4 text-sky-700 rounded-sm border-slate-300 focus:ring-sky-700">
                <label for="is_published" class="text-xs sm:text-sm font-medium text-slate-700 cursor-pointer">Publikasikan Langsung ke Website</label>
            </div>

            <div class="pt-5 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5">
                <a href="{{ route('admin.articles.index') }}" 
                   class="w-full sm:w-auto text-center px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 font-semibold text-xs sm:text-sm rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="w-full sm:w-auto text-center px-5 py-2.5 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-2xs transition-colors cursor-pointer btn-press">
                    Simpan Perubahan Artikel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
