<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasAutoOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasAutoOrder, HasFactory;

    protected $fillable = [
        'client_name',
        'slug',
        'client_type',
        'partnership_type',
        'logo',
        'image',
        'project_title',
        'description',
        'location',
        'duration',
        'about_client',
        'scope_of_work',
        'results_benefit',
        'testimoni_quote',
        'testimoni_name',
        'testimoni_title',
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

    protected static function booted(): void
    {
        static::creating(function (Portfolio $portfolio): void {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->client_name);
            }
        });
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'partnership_service')->withTimestamps();
    }
}
