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

            /*
            |--------------------------------------------------------------------------
            | Table of Contents
            |--------------------------------------------------------------------------
            |
            | Database value:
            |
            | [
            |   "Kerala – God's Own Country",
            |   "Rajasthan – The Land of Kings"
            | ]
            |
            | API output:
            |
            | [
            |   {
            |       "number": "01",
            |       "title": "Kerala – God's Own Country"
            |   }
            | ]
            |
            */

            'table_of_contents' => collect(
                $this->table_of_contents ?? []
            )
                ->values()
                ->map(function ($title, $index) {
                    return [
                        'number' => str_pad(
                            $index + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ),

                        'title' => $title,
                    ];
                }),

            'content' => $this->content,

            'featured_image' => $this->featured_image
                ? asset(
                    'storage/' . $this->featured_image
                )
                : null,

            'author' => [
                'id' => $this->author?->id,

                'name' => $this->author?->name
                    ?? 'Open Sky Team',

                'image' => $this->author?->image
                    ? asset(
                        'storage/' . $this->author->image
                    )
                    : null,

                'description' =>
                    $this->author?->description,

                'twitter_url' =>
                    $this->author?->twitter_url,

                'facebook_url' =>
                    $this->author?->facebook_url,

                'linkedin_url' =>
                    $this->author?->linkedin_url,
            ],

            'read_time' => $this->read_time,

            'read_time_text' =>
                $this->read_time . ' min read',

            'published_at' => $this->published_at
                ?->toISOString(),

            'published_date' => $this->published_at
                ?->format('F j, Y'),
        ];
    }
}
