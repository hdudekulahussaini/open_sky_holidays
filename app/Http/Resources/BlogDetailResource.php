<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailResource extends JsonResource
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

            'short_description' => $this->short_description,

            'content' => $this->content,

            'featured_image' => $this->featured_image
                ? asset('storage/'.$this->featured_image)
                : null,

            'author' => [
                'id' => $this->author?->id,

                'name' => $this->author?->name
                    ?? 'Open Sky Team',

                'image' => $this->author?->image
                    ? asset(
                        'storage/'.$this->author->image
                    )
                    : null,

                'description' => $this->author?->description,

                'twitter_url' => $this->author?->twitter_url,

                'facebook_url' => $this->author?->facebook_url,

                'linkedin_url' => $this->author?->linkedin_url,
            ],

            'read_time' => $this->read_time,

            'read_time_text' => $this->read_time.' min read',

            'published_at' => $this->published_at?->toISOString(),

            'published_date' => $this->published_at?->format('F j, Y'),

            'seo' => [
                'meta_title' => $this->meta_title ?: $this->title,

                'meta_description' => $this->meta_description
                    ?: $this->short_description,
            ],
        ];
    }
}
