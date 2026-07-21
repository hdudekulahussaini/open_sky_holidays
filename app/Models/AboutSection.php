<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_heading',
        'mission_title',
        'focus_title',
        'description',
        'customer_count',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'customer_count' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function globeLocations(): HasMany
    {
        return $this->hasMany(AboutGlobeLocation::class);
    }

    public function customerAvatars(): HasMany
    {
        return $this->hasMany(AboutCustomerAvatar::class);
    }
}