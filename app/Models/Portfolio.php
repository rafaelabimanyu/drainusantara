<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasAutoOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasAutoOrder, HasFactory;

    protected $fillable = [
        'client_name',
        'client_type',
        'logo',
        'image',
        'project_title',
        'description',
        'location',
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
}
