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
        'description',
        'image',
        'features_title',
        'features_description',
        'status',
    ];

    protected $casts = [
        'features_title' => 'array',
        'features_description' => 'array',
    ];
}
