<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutGlobeLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_section_id',
        'location_name',
        'latitude',
        'longitude',
        'destination_url',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function aboutSection(): BelongsTo
    {
        return $this->belongsTo(AboutSection::class);
    }
}