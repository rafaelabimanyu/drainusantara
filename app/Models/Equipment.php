<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasAutoOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasAutoOrder, HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'category',
        'badge',
        'image',
        'short_description',
        'specs',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'specs' => 'array',
    ];

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

        // Jika string terpisah baris baru
        return array_values(array_filter(array_map('trim', explode("\n", (string) $this->specs))));
    }
}
