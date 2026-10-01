<?php

namespace App\Models;

use App\Traits\HasAutoOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasAutoOrder, HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'name',
        'role',
        'photo',
        'initials',
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

    /**
     * Get or compute initials from staff name.
     */
    public function getInitialsAttribute(?string $value): string
    {
        if (!empty($value)) {
            return strtoupper($value);
        }

        $words = preg_split('/\s+/', trim($this->name ?? ''));
        $initials = '';
        foreach (array_slice($words, 0, 2) as $w) {
            $initials .= mb_substr($w, 0, 1);
        }

        return strtoupper($initials ?: 'ST');
    }
}
