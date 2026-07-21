<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adventure extends Model
{
    protected $fillable = [
        'adventure_category_id',
        'title',
        'description',
        'features',
        'video_link',
        'image_one',
        'image_two',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            AdventureCategory::class,
            'adventure_category_id'
        );
    }
}
