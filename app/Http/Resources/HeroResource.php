<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,

            'image' => $this->image,

            'image_url' => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'status' => (bool) $this->status,
            'sort_order' => (int) $this->sort_order,

            'created_at' => $this->created_at?->format(
                'Y-m-d H:i:s'
            ),

            'updated_at' => $this->updated_at?->format(
                'Y-m-d H:i:s'
            ),
        ];
    }
}
