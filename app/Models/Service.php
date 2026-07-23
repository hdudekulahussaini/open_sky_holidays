<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'about_title',
        'about_description',
        'about_image',
        'features',
        'service_items',
        'process_steps',
        'documents',
        'why_choose_items',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'service_items' => 'array',
        'process_steps' => 'array',
        'documents' => 'array',
        'why_choose_items' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Find services using slug instead of ID.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
