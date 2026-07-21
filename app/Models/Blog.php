<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'table_of_contents',
        'content',
        'featured_image',
        'read_time',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'table_of_contents' => 'array',
            'status' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
