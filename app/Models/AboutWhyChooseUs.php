<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutWhyChooseUs extends Model
{
    use HasFactory;

    protected $table = 'about_why_choose_us';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'features_icon',
        'features_title',
        'features_description',
        'badge_title',
        'badge_subtitle',
        'status',
    ];

    protected $casts = [
        'features_icon' => 'array',
        'features_title' => 'array',
        'features_description' => 'array',
    ];
}
