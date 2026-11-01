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

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'image_placement',
        'excerpt',
        'content',
        'category',
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
            'views_count' => 'integer',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Render Markdown and HTML content to safe HTML with auto-generated IDs on headings for TOC anchors.
     */
    public function getRenderedContentAttribute(): string
    {
        if (empty($this->content)) {
            return '';
        }

        $html = Str::markdown($this->content, [
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
            'disallowed_raw_html' => [
                'disallowed_tags' => ['script', 'style', 'textarea', 'noembed', 'noframes', 'plaintext'],
            ],
        ]);

        return (string) preg_replace_callback('/<(h[23])(?:\s+[^>]*)?>(.*?)<\/\1>/is', function (array $matches): string {
            $tag = $matches[1];
            $inner = $matches[2];
            $cleanTitle = trim(strip_tags($inner));
            $slug = Str::slug($cleanTitle);

            return "<{$tag} id=\"{$slug}\">{$inner}</{$tag}>";
        }, $html);
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
