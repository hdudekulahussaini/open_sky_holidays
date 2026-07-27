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

    public static function getPageOptions(): array
    {
        return [
            'about' => 'About',
            'tours-domestic' => 'Domestic Tours',
            'tours-international' => 'International Tours',
            'services-visa' => 'Visa Services',
            'services-flight-tickets' => 'Flight Tickets',
            'services-passport' => 'Passport Services',
            'blogs' => 'Blogs',
            'contact' => 'Contact',
        ];
    }
}
