<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasAutoOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Equipment extends Model
{
    use HasAutoOrder, HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'badge',
        'image',
        'short_description',
        'description',
        'specs',
        'features',
        'applications',
        'safety_k3',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'specs' => 'array',
        'features' => 'array',
        'applications' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Equipment $equipment): void {
            if (empty($equipment->slug)) {
                $equipment->slug = Str::slug($equipment->name);
            }
        });

        static::updating(function (Equipment $equipment): void {
            if (empty($equipment->slug)) {
                $equipment->slug = Str::slug($equipment->name);
            }
        });
    }

    /**
     * Helper to get specs as array if stored as string or array
     */
    public function getSpecsListAttribute(): array
    {
        if (is_array($this->specs)) {
            return $this->specs;
        }

        if (empty($this->specs)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode("\n", (string) $this->specs))));
    }

    /**
     * Helper to get features as array if stored as string or array
     */
    public function getFeaturesListAttribute(): array
    {
        if (is_array($this->features)) {
            return $this->features;
        }

        if (empty($this->features)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode("\n", (string) $this->features))));
    }

    /**
     * Helper to get applications as array if stored as string or array
     */
    public function getApplicationsListAttribute(): array
    {
        if (is_array($this->applications)) {
            return $this->applications;
        }

        if (empty($this->applications)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode("\n", (string) $this->applications))));
    }

    public function galleries(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class, 'gallery_equipment')->withTimestamps();
    }
}
