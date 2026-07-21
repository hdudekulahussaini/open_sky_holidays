<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdventureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'category' => new AdventureCategoryResource(
                $this->whenLoaded('category')
            ),

            'title' => $this->title,
            'description' => $this->description,
            'features' => $this->features ?? [],
            'video_link' => $this->video_link,

            'image_one' => $this->image_one,

            'image_one_url' => $this->image_one
                ? asset('storage/' . $this->image_one)
                : null,

            'image_two' => $this->image_two,

            'image_two_url' => $this->image_two
                ? asset('storage/' . $this->image_two)
                : null,

            'status' => $this->status,
        ];
    }
}
