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

    protected $fillable = [
        'title',
        'slug',
        'category',
        'location',
        'property_type',
        'problem_type',
        'severity',
        'duration',
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
        return $this->category === 'b2b' ? 'B2B Komersial' : 'Rumahan Residensial';
    }

    public function isB2b(): bool
    {
        return $this->category === 'b2b';
    }

    public function isRumahan(): bool
    {
        return $this->category !== 'b2b';
    }
}
