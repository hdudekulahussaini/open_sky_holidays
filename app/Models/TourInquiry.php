<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'name',
        'phone',
        'email',
        'travel_date',
        'travelers',
        'status',
    ];

    protected $casts = [
        'travel_date' => 'date',
    ];

    protected $attributes = [
        'status' => 'new',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
