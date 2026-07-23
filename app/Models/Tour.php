<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * A tour has many gallery images.
     */
    public function gallery(): HasMany
    {
        return $this->hasMany(TourImage::class, 'tour_id', 'id');
    }

    /**
     * A tour has many features.
     */
    public function features(): HasMany
    {
        return $this->hasMany(TourFeature::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Package inclusions belonging to the tour.
     */
    public function packageInclusions(): HasMany
    {
        return $this->hasMany(TourFeature::class)
            ->where(
                'type',
                TourFeature::TYPE_PACKAGE_INCLUSION
            )
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Places covered by the tour.
     */
    public function placesCovered(): HasMany
    {
        return $this->hasMany(TourFeature::class)
            ->where(
                'type',
                TourFeature::TYPE_PLACE_COVERED
            )
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    /**
     * Highlights belonging to the tour.
     */
    public function tourHighlights(): HasMany
    {
        return $this->hasMany(TourFeature::class)
            ->where(
                'type',
                TourFeature::TYPE_TOUR_HIGHLIGHT
            )
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
