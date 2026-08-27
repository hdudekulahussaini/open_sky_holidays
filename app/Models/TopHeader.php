<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'tagline',
        'button_text',
        'button_url',
        'social_links',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'status' => 'boolean',
        ];
    }
}
