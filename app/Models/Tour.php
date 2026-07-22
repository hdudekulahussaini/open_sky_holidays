<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_type_id',
        'title',
        'slug',
        'country',
        'duration',
        'thumbnail',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * A tour belongs to one tour type.
     */
    public function tourType(): BelongsTo
    {
        return $this->belongsTo(TourType::class);
    }

    /**
     * A tour has one tour detail.
     */
    public function detail(): HasOne
    {
        return $this->hasOne(TourDetail::class, 'tour_id', 'id');
    }
}