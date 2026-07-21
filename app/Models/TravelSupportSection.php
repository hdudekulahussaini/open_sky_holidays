<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelSupportSection extends Model
{
    protected $fillable = [
        'small_heading',
        'heading',
        'description',
        'image',
        'features',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'status' => 'boolean',
        ];
    }
}
