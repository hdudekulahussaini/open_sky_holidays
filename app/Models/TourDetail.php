<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'heading',
        'description',
        'gallery',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'status' => 'boolean',
        ];
    }

    /**
     * Tour detail belongs to one tour.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}