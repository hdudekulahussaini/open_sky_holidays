<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'email',
        'address',
        'map_link',
        'whatsapp_number',
        'map_embed_url',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}
