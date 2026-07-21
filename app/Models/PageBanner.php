<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBanner extends Model
{
    protected $fillable = [
        'page',
        'label',
        'title',
        'description',
        'breadcrumb_title',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
