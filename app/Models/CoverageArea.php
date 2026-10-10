<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\RegionService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CoverageArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'district',
        'slug',
        'postal_code',
        'meta_title',
        'meta_description',
        'content',
        'is_active',
    ];

    public function publicUrl(): ?string
    {
        if (! $this->is_active) {
            return null;
        }

        $city = collect(RegionService::all())
            ->flatMap(fn (array $province) => $province['cities'])
            ->first(fn (array $city) => $city['name'] === $this->city);

        if (! $city || ! in_array($this->district, $city['districts'], true)) {
            return null;
        }

        return route('area.detail', [
            'city' => $city['slug'],
            'district' => Str::slug($this->district),
        ]);
    }
}

