<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
        'name',
        'image',
        'description',
        'twitter_url',
        'facebook_url',
        'linkedin_url',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
}
