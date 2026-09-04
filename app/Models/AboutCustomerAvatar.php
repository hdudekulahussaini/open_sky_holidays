<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutCustomerAvatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_section_id',
        'image',
    ];

    public function aboutSection(): BelongsTo
    {
        return $this->belongsTo(AboutSection::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return '';
        }

        return str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/' . $this->image);
    }
}