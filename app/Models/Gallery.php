<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'rumahan' => 'Rumahan Residensial',
        'fnb' => 'Restoran & Kafe (FnB)',
        'gedung' => 'Gedung & Apartemen',
        'perkantoran' => 'Perkantoran',
        'pabrik' => 'Pabrik & Industri',
        'ruko' => 'Ruko & Komersial',
        'b2b' => 'B2B Komersial',
    ];

    protected $fillable = [
        'title',
        'slug',
        'category',
        'location',
        'property_type',
        'problem_type',
        'severity',
        'duration',
        'price',
        'method',
        'drain_type',
        'diagnosis',
        'service_id',
        'before_image',
        'after_image',
        'image',
        'description',
        'content',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'is_active' => 'boolean',
            'property_type' => 'array',
            'problem_type' => 'array',
            'price' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Gallery $gallery): void {
            if (empty($gallery->slug)) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'gallery_equipment')->withTimestamps();
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? (ucfirst((string) $this->category) ?: 'Rumahan / Residensial');
    }

    public function getFormattedPriceAttribute(): ?string
    {
        if ($this->price !== null && $this->price > 0) {
            return 'Rp ' . number_format($this->price, 0, ',', '.');
        }

        return null;
    }

    public function hasBeforeAfter(): bool
    {
        return !empty($this->before_image) && !empty($this->after_image);
    }

    public function getMainImageAttribute(): ?string
    {
        return $this->image ?: ($this->after_image ?: $this->before_image);
    }

    public function isB2b(): bool
    {
        return in_array($this->category, ['b2b', 'fnb', 'gedung', 'perkantoran', 'pabrik', 'ruko'], true);
    }

    public function isRumahan(): bool
    {
        return $this->category === 'rumahan';
    }
}
