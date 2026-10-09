<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasAutoOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasAutoOrder, HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'icon',
        'image',
        'price_starting_from',
        'features',
        'is_active',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_active' => 'boolean',
            'price_starting_from' => 'integer',
            'order' => 'integer',
        ];
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
