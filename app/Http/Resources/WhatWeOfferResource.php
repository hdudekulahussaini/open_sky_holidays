<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WhatWeOfferResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'subtitle' => $this->subtitle,

            'description' => $this->description,

            'image' => $this->image,

            'image_url' => filled($this->image)
                ? asset(
                    'storage/' . $this->image
                )
                : null,

            'status' => $this->status,
        ];
    }
}
