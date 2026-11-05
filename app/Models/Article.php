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
            'views_count' => 'integer',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
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

        try {
            $html = Str::markdown($this->content, [
                'html_input' => 'allow',
                'allow_unsafe_links' => false,
                'disallowed_raw_html' => [
                    'disallowed_tags' => ['script', 'style', 'textarea', 'noembed', 'noframes', 'plaintext'],
                ],
            ]);
        } catch (\Throwable) {
            $html = nl2br(e($this->content));
        }

        if (empty($html)) {
            $html = nl2br(e($this->content));
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
     * Normalized category slug for filtering ('edukasi', 'penguatan-brand', 'promo-penawaran').
     */
    public function getCategorySlugAttribute(): string
    {
        $raw = strtolower((string) $this->category);

        if (str_contains($raw, 'promo') || str_contains($raw, 'penawaran') || str_contains($raw, 'diskon')) {
            return 'promo-penawaran';
        }

        if (str_contains($raw, 'brand') || str_contains($raw, 'teknologi') || str_contains($raw, 'alat') || str_contains($raw, 'holding') || str_contains($raw, 'k3') || str_contains($raw, 'sop')) {
            return 'penguatan-brand';
        }

        return 'edukasi';
    }

    /**
     * Normalized category label for presentation.
     */
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category_slug) {
            'promo-penawaran' => self::CATEGORY_PROMO,
            'penguatan-brand' => self::CATEGORY_BRAND,
            default => self::CATEGORY_EDUKASI,
        };
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
