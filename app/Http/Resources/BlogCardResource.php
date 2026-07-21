<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BlogCardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'slug' => $this->slug,

            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
                'slug' => $this->category?->slug,
            ],

            'author' => [
                'id' => $this->author?->id,
                'name' => $this->author?->name
                    ?? 'Open Sky Team',
            ],

            /*
             * Automatically create a short description
             * from the complete blog content.
             */
            'short_description' => Str::limit(
                Str::squish(
                    strip_tags($this->content ?? '')
                ),
                180
            ),

            'featured_image' => $this->featured_image
                ? asset(
                    'storage/' . $this->featured_image
                )
                : null,

            'read_time' => $this->read_time,

            'read_time_text' => $this->read_time
                . ' min read',

            'published_at' => $this->published_at
                ?->toISOString(),

            'published_date' => $this->published_at
                ?->format('F j, Y'),
        ];
    }
}