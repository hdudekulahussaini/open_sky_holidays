<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'small_heading',
        'heading',
        'description',
        'promises',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'promises' => 'array',
        ];
    }
}