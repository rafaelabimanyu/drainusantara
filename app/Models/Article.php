<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    public const CATEGORY_EDUKASI = 'Edukasi';
    public const CATEGORY_BRAND = 'Penguatan Brand';
    public const CATEGORY_PROMO = 'Promo Penawaran';

    public const CATEGORIES = [
        self::CATEGORY_EDUKASI,
        self::CATEGORY_BRAND,
        self::CATEGORY_PROMO,
    ];

    public const SUB_CATEGORIES = [
        self::CATEGORY_EDUKASI => [
            'Tips Wastafel & Kloset',
            'Penyebab & Bahaya Kimia',
            'Mesin & Teknologi Rooter',
        ],
        self::CATEGORY_BRAND => [
            'Profil & Keunggulan Layanan',
            'Garansi & Standar SOP K3',
            'Armada Siaga Lapangan',
        ],
        self::CATEGORY_PROMO => [
            'Paket Residensial',
            'Komersial & B2B Resto',
            'Penanganan Darurat 24 Jam',
        ],
    ];

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'image_placement',
        'content_images',
        'excerpt',
        'content',
        'category',
        'sub_category',
        'category_id',
        'subcategory_id',
        'service_id',
        'city',
        'tags',
        'meta_title',
        'meta_description',
        'views_count',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'content_images' => 'array',
            'category_id' => 'integer',
            'subcategory_id' => 'integer',
            'service_id' => 'integer',
            'views_count' => 'integer',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function categoryRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function subcategoryRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ArticleSubcategory::class, 'subcategory_id');
    }

    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Render Markdown and HTML content to safe HTML with auto-generated IDs on headings for TOC anchors
     * and auto-embedded optional content images.
     */
    public function getRenderedContentAttribute(): string
    {
        if (empty($this->content)) {
            return '';
        }

        $raw = $this->content;
        $raw = $this->renderVideos($raw);
        $raw = $this->renderCtas($raw);
        $raw = $this->renderCallouts($raw);

        try {
            $html = Str::markdown($raw, [
                'html_input' => 'allow',
                'allow_unsafe_links' => false,
                'disallowed_raw_html' => [
                    'disallowed_tags' => ['script', 'style', 'textarea', 'noembed', 'noframes', 'plaintext'],
                ],
            ]);
        } catch (\Throwable) {
            $html = nl2br(e($raw));
        }

        if (empty($html)) {
            $html = nl2br(e($raw));
        }

        // Safe regex without catastrophic backtracking, with fallback to original html
        $withIds = @preg_replace_callback('/<(h[23])(?:\s+[^>]*)?>(.*?)<\/\1>/i', function (array $matches): string {
            $tag = $matches[1];
            $inner = $matches[2];
            $cleanTitle = trim(strip_tags($inner));
            $slug = Str::slug($cleanTitle);

            return "<{$tag} id=\"{$slug}\">{$inner}</{$tag}>";
        }, $html);

        $rendered = !empty($withIds) ? $withIds : $html;

        return $this->embedContentImages($rendered);
    }

    /**
     * Render callout boxes: [Info Penting]...[/Info Penting], [Peringatan Bahaya]...[/Peringatan Bahaya], [Tips Hemat]...[/Tips Hemat]
     */
    public function renderCallouts(string $html): string
    {
        // Info Penting / Info Box
        $html = preg_replace_callback('/\[(?:Info Penting|info)\](.*?)\[\/(?:Info Penting|info)\]/si', function (array $m): string {
            $inner = trim($m[1]);
            return <<<HTML
<div class="my-6 p-4 sm:p-5 rounded-lg border-l-4 border-sky-600 bg-sky-50/80 border border-slate-200 not-prose">
    <div class="flex items-start gap-3">
        <div class="w-7 h-7 rounded-md bg-sky-100 text-sky-700 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="text-xs font-bold text-sky-900 uppercase tracking-wider mb-1">Catatan Penting</div>
            <div class="text-xs sm:text-sm text-slate-700 leading-relaxed">{$inner}</div>
        </div>
    </div>
</div>
HTML;
        }, $html);

        // Peringatan Bahaya / Danger Box
        $html = preg_replace_callback('/\[(?:Peringatan Bahaya|danger|warning)\](.*?)\[\/(?:Peringatan Bahaya|danger|warning)\]/si', function (array $m): string {
            $inner = trim($m[1]);
            return <<<HTML
<div class="my-6 p-4 sm:p-5 rounded-lg border-l-4 border-rose-600 bg-rose-50/80 border border-slate-200 not-prose">
    <div class="flex items-start gap-3">
        <div class="w-7 h-7 rounded-md bg-rose-100 text-rose-700 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <div class="text-xs font-bold text-rose-900 uppercase tracking-wider mb-1">Peringatan Bahaya</div>
            <div class="text-xs sm:text-sm text-slate-700 leading-relaxed">{$inner}</div>
        </div>
    </div>
</div>
HTML;
        }, $html);

        // Tips Hemat / Tips Box
        $html = preg_replace_callback('/\[(?:Tips Hemat|tips|tip)\](.*?)\[\/(?:Tips Hemat|tips|tip)\]/si', function (array $m): string {
            $inner = trim($m[1]);
            return <<<HTML
<div class="my-6 p-4 sm:p-5 rounded-lg border-l-4 border-emerald-600 bg-emerald-50/80 border border-slate-200 not-prose">
    <div class="flex items-start gap-3">
        <div class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
        </div>
        <div>
            <div class="text-xs font-bold text-emerald-900 uppercase tracking-wider mb-1">Tips Hemat &amp; Perawatan</div>
            <div class="text-xs sm:text-sm text-slate-700 leading-relaxed">{$inner}</div>
        </div>
    </div>
</div>
HTML;
        }, $html);

        return $html;
    }

    /**
     * Render inline CTA shortcodes: [cta-konsultasi], [cta-kalkulator]
     */
    public function renderCtas(string $html): string
    {
        $waNum = config('app.whatsapp_number') ?: '6285609009009';
        $waUrl = "https://wa.me/{$waNum}?text=" . urlencode("Halo Tim Drainusantara, saya membaca artikel '{$this->title}' dan ingin konsultasi mengenai penanganan saluran pipa mampet di lokasi saya.");

        $ctaConsultHtml = <<<HTML
<div class="my-8 p-5 sm:p-6 rounded-lg bg-slate-900 text-white border border-slate-800 shadow-md not-prose">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Siaga 24 Jam Nonstop
            </div>
            <h4 class="text-base sm:text-lg font-bold text-white tracking-tight">Saluran Pipa Anda Mengalami Masalah Serupa?</h4>
            <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">Konsultasikan langsung dengan tim teknisi Drainusantara. 100% tanpa bongkar keramik, transparan, No Cure No Pay, dan bergaransi resmi 30 hari.</p>
        </div>
        <a href="{$waUrl}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm transition-colors shadow-2xs shrink-0">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            <span>Konsultasi WA Teknisi</span>
        </a>
    </div>
</div>
HTML;

        $serviceUrl = url('/layanan');
        $ctaCalcHtml = <<<HTML
<div class="my-8 p-5 sm:p-6 rounded-lg bg-sky-50 border border-sky-200 text-slate-800 shadow-2xs not-prose">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold bg-sky-100 text-sky-800 mb-1.5">
                Kalkulator Biaya Transparan
            </div>
            <h4 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">Cek Estimasi Biaya Pelancaran Saluran</h4>
            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-xl leading-relaxed">Periksa estimasi biaya pengerjaan berdasarkan titik masalah (wastafel, kloset, talang, atau bak kontrol) tanpa biaya tersembunyi.</p>
        </div>
        <a href="{$serviceUrl}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-sky-700 hover:bg-sky-800 text-white font-bold text-xs sm:text-sm transition-colors shadow-2xs shrink-0">
            <span>Lihat Estimasi Tarif</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
</div>
HTML;

        $html = str_ireplace('[cta-konsultasi]', $ctaConsultHtml, $html);
        $html = str_ireplace('[cta-kalkulator]', $ctaCalcHtml, $html);

        return $html;
    }

    /**
     * Render responsive video embeds: [video: URL]
     */
    public function renderVideos(string $html): string
    {
        return preg_replace_callback('/\[video:\s*(?:<a[^>]*href=["\']([^"\']+)["\'][^>]*>.*?<\/a>|(https?:\/\/[^\s\]]+))\]/i', function (array $m): string {
            $url = trim(!empty($m[1]) ? $m[1] : ($m[2] ?? ''));
            $url = rtrim($url, ']');
            
            // YouTube detection
            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $yt)) {
                $ytId = $yt[1];
                return <<<HTML
<div class="my-8 aspect-video rounded-xl overflow-hidden border border-slate-200 shadow-2xs not-prose bg-slate-900">
    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{$ytId}" title="Video Penjelasan Drainusantara" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
</div>
HTML;
            }

            // Direct mp4 video detection
            if (preg_match('/\.mp4(\?.*)?$/i', $url)) {
                return <<<HTML
<div class="my-8 aspect-video rounded-xl overflow-hidden border border-slate-200 shadow-2xs not-prose bg-slate-900">
    <video controls class="w-full h-full" preload="metadata">
        <source src="{$url}" type="video/mp4">
        Browser Anda tidak mendukung tag video.
    </video>
</div>
HTML;
            }

            return "<a href=\"{$url}\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"text-sky-700 font-semibold underline\">Tonton Video Panduan: {$url}</a>";
        }, $html);
    }

    /**
     * Embed up to 3 optional content images inside the article body.
     */
    public function embedContentImages(string $html): string
    {
        $images = is_array($this->content_images) ? array_values(array_filter($this->content_images)) : [];
        if (empty($images)) {
            return $html;
        }

        $placedIndices = [];

        // 1. Process explicit shortcodes: [foto-1], [foto-2], [foto-3]
        foreach ($images as $index => $item) {
            $slot = $index + 1;
            $token = "[foto-{$slot}]";
            if (str_contains($html, $token)) {
                $figureHtml = $this->buildFigureHtml($item, $slot);
                $html = str_replace($token, $figureHtml, $html);
                $placedIndices[] = $index;
            }
        }

        // 2. Automatically distribute remaining images between paragraphs
        $remaining = array_values(array_filter($images, fn ($_, $i) => !in_array($i, $placedIndices, true), ARRAY_FILTER_USE_BOTH));
        if (empty($remaining)) {
            return $html;
        }

        $parts = explode('</p>', $html);
        $totalParagraphs = count($parts) - 1;

        if ($totalParagraphs <= 1) {
            // Append at the end if content has few paragraphs
            foreach ($remaining as $idx => $item) {
                $html .= $this->buildFigureHtml($item, $idx + 1);
            }
            return $html;
        }

        $insertPoints = [];
        $remCount = count($remaining);
        for ($i = 0; $i < $remCount; $i++) {
            $pos = (int) round(($totalParagraphs * ($i + 1)) / ($remCount + 1));
            $pos = max(1, min($totalParagraphs - 1, $pos));
            $insertPoints[$pos][] = $remaining[$i];
        }

        $reconstructed = '';
        foreach ($parts as $pIndex => $paragraph) {
            $reconstructed .= $paragraph;
            if ($pIndex < $totalParagraphs) {
                $reconstructed .= '</p>';
                if (isset($insertPoints[$pIndex + 1])) {
                    foreach ($insertPoints[$pIndex + 1] as $imgItem) {
                        $reconstructed .= $this->buildFigureHtml($imgItem, $pIndex + 1);
                    }
                }
            }
        }

        return $reconstructed;
    }

    /**
     * Build responsive editorial figure HTML for an embedded content image.
     */
    private function buildFigureHtml(array|string $item, int $slot): string
    {
        $path = is_array($item) ? ($item['path'] ?? '') : (string) $item;
        $caption = is_array($item) ? ($item['caption'] ?? '') : '';
        if (empty($path)) {
            return '';
        }

        $url = (filter_var($path, FILTER_VALIDATE_URL) || str_starts_with($path, '/')) ? $path : asset(ltrim($path, '/'));
        $safeCaption = !empty($caption) ? e($caption) : e("Dokumentasi Pelaksanaan & Standar Teknis Saluran Pipa (Foto {$slot})");
        $escapedJsUrl = addslashes($url);
        $escapedJsCaption = addslashes($safeCaption);

        return <<<HTML
<figure class="my-8 rounded-xl overflow-hidden border border-slate-200 bg-white shadow-2xs max-w-2xl mx-auto group">
    <div class="relative cursor-zoom-in overflow-hidden group/img"
         onclick="if(window.__openLightbox){window.__openLightbox('{$escapedJsUrl}', '{$escapedJsCaption}');}"
         title="Klik untuk melihat foto lebih besar">
        <img src="{$url}" alt="{$safeCaption}" width="800" height="450" loading="lazy" decoding="async" class="w-full max-h-[360px] object-cover group-hover/img:scale-[1.02] transition-transform duration-300">
        <div class="absolute bottom-3 right-3 bg-slate-900/80 hover:bg-slate-900 backdrop-blur-xs text-white text-[11px] font-semibold px-3 py-1.5 rounded-lg border border-white/20 flex items-center gap-1.5 shadow-md transition-colors pointer-events-none">
            <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
            <span>Lihat Gambar Penuh</span>
        </div>
    </div>
    <figcaption class="px-4 py-2.5 bg-slate-50 border-t border-slate-100 text-xs text-slate-600 flex items-center justify-between">
        <span class="font-medium text-slate-700">{$safeCaption}</span>
        <span class="text-[11px] text-slate-500 font-mono">Dokumentasi Lapangan</span>
    </figcaption>
</figure>
HTML;
    }

    /**
     * Extract structured Table of Contents from headings (Markdown and HTML h2/h3).
     *
     * @return array<int, array{id: string, title: string, level: int}>
     */
    public function getTableOfContentsAttribute(): array
    {
        if (empty($this->content)) {
            return [];
        }

        $items = [];
        if (preg_match_all('/^(#{2,3})\s+(.+)$/m', $this->content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $level = strlen($match[1]);
                $title = trim(strip_tags($match[2]));
                $items[] = [
                    'id' => Str::slug($title),
                    'title' => $title,
                    'level' => $level,
                ];
            }
        }

        if (empty($items) && preg_match_all('/<(h[23])(?:\s+[^>]*)?>(.*?)<\/\1>/is', $this->content, $htmlMatches, PREG_SET_ORDER)) {
            foreach ($htmlMatches as $match) {
                $level = (int) substr($match[1], 1);
                $title = trim(strip_tags($match[2]));
                $items[] = [
                    'id' => Str::slug($title),
                    'title' => $title,
                    'level' => $level,
                ];
            }
        }

        return $items;
    }

    /**
     * List of tags parsed from comma-separated string.
     *
     * @return array<int, string>
     */
    public function getTagsListAttribute(): array
    {
        if (empty($this->tags)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', (string) $this->tags))));
    }

    /**
     * Calculate estimated reading time based on Indonesian reading speed (~200 words/min).
     */
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags((string) $this->content));

        return max(1, (int) ceil($words / 200));
    }

    /**
     * Normalized category slug for filtering ('edukasi', 'penguatan-brand', 'promo-penawaran', etc.).
     */
    public function getCategorySlugAttribute(): string
    {
        if ($this->categoryRelation) {
            return $this->categoryRelation->slug;
        }

        $raw = strtolower((string) $this->category);

        if (str_contains($raw, 'promo') || str_contains($raw, 'penawaran') || str_contains($raw, 'diskon')) {
            return 'promo-penawaran';
        }

        if (str_contains($raw, 'brand') || str_contains($raw, 'teknologi') || str_contains($raw, 'alat') || str_contains($raw, 'holding') || str_contains($raw, 'k3') || str_contains($raw, 'sop')) {
            return 'penguatan-brand';
        }

        if (!empty($raw)) {
            $cat = ArticleCategory::where('name', $this->category)->orWhere('slug', $this->category)->first();
            if ($cat) {
                return $cat->slug;
            }
        }

        return 'edukasi';
    }

    /**
     * Normalized category label for presentation.
     */
    public function getCategoryLabelAttribute(): string
    {
        if ($this->categoryRelation) {
            return $this->categoryRelation->name;
        }

        if (!empty($this->category)) {
            $cat = ArticleCategory::where('name', $this->category)->orWhere('slug', $this->category)->first();
            if ($cat) {
                return $cat->name;
            }
        }

        return match ($this->category_slug) {
            'promo-penawaran' => self::CATEGORY_PROMO,
            'penguatan-brand' => self::CATEGORY_BRAND,
            default => self::CATEGORY_EDUKASI,
        };
    }

    /**
     * Normalized sub-category slug for URL Silo.
     */
    public function getSubcategorySlugAttribute(): string
    {
        if ($this->subcategoryRelation) {
            return $this->subcategoryRelation->slug;
        }

        if (!empty($this->sub_category)) {
            return Str::slug($this->sub_category);
        }

        return 'panduan';
    }

    /**
     * URL Silo SEO Friendly (e.g. /edukasi/{kategori}/{sub-kategori}/{slug-artikel}).
     */
    public function getSiloUrlAttribute(): string
    {
        return url("/edukasi/{$this->category_slug}/{$this->subcategory_slug}/{$this->slug}");
    }

    /**
     * Scope a query to only include published articles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Default author name.
     */
    public function getAuthorNameAttribute(): string
    {
        return 'Tim Ahli Drainusantara';
    }

    /**
     * Default author role.
     */
    public function getAuthorRoleAttribute(): string
    {
        return 'Senior Plumbing & Sanitation Specialist';
    }
}
