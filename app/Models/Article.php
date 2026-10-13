<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'excerpt',
        'content',
        'category',
        'meta_title',
        'meta_description',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Render Markdown content to safe HTML with auto-generated IDs on headings for TOC anchors.
     */
    public function getRenderedContentAttribute(): string
    {
        if (empty($this->content)) {
            return '';
        }

        $html = Str::markdown($this->content, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return (string) preg_replace_callback('/<(h[23])>(.*?)<\/\1>/is', function (array $matches): string {
            $tag = $matches[1];
            $inner = $matches[2];
            $cleanTitle = trim(strip_tags($inner));
            $slug = Str::slug($cleanTitle);

            return "<{$tag} id=\"{$slug}\">{$inner}</{$tag}>";
        }, $html);
    }

    /**
     * Extract structured Table of Contents from Markdown headings (h2 and h3).
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

        return $items;
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
