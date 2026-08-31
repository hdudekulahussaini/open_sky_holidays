<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourFeature extends Model
{
    public const TYPE_PACKAGE_INCLUSION = 'package_inclusion';

    public const TYPE_PLACE_COVERED = 'place_covered';

    protected $fillable = [
        'tour_id',
        'type',
        'title',
        'description',
        'image',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Get feature types.
     */
    public static function types(): array
    {
        return [
            self::TYPE_PACKAGE_INCLUSION => 'Package Inclusion',
            self::TYPE_PLACE_COVERED => 'Place Covered',
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
