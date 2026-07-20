<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'travel_date',
        'destination',
        'travelers',
        'tour_type',
        'message',
        'status',
    ];

    protected $casts = [
        'travel_date' => 'date',
    ];

    protected $attributes = [
        'status' => 'new',
    ];
}