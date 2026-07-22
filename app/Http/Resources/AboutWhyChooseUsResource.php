<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutWhyChooseUsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,

            'description' => $this->description,

            'image' => $this->image,

            'image_url' => filled($this->image)
                ? asset(
                    'storage/' . $this->image
                )
                : null,

            'features_title' =>
                $this->features_title ?? [],

            'features_description' =>
                $this->features_description ?? [],

            'status' => $this->status,
        ];
    }
}
