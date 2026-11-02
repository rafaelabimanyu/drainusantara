<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'city',
        'district',
        'service_type',
        'property_type',
        'message',
        'status',
        'admin_notes',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get clean normalized phone number for WhatsApp.
     */
    public function getCleanPhoneAttribute(): string
    {
        $clean = preg_replace('/[^0-9]/', '', (string) $this->phone);
        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        }
        return $clean;
    }

    /**
     * Build 1-click reply WhatsApp URL for admin.
     */
    public function getWhatsAppReplyUrlAttribute(): string
    {
        $text = "Halo {$this->name}, terima kasih telah menghubungi Drainusantara terkait permohonan layanan '{$this->service_type}' di area {$this->city}" . ($this->district ? ", {$this->district}" : '') . ". Ada yang bisa kami bantu jadwalkan kedatangan teknisi?";
        return "https://wa.me/{$this->clean_phone}?text=" . urlencode($text);
    }
}

