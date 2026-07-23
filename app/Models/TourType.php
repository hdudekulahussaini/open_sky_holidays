<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        static::deleting(function (TourType $tourType) {
            $tourType->tours->each(function (Tour $tour) {
                $tour->delete();
            });
        });
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
