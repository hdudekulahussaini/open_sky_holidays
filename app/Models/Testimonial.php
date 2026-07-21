<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'customer_name',
        'customer_image',
        'location',
        'rating',
        'review',
        'reviewed_at',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'reviewed_at' => 'datetime',
        'status' => 'boolean',
    ];


}