<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'service_id',
        'before_image',
        'after_image',
        'image',
        'description',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
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
