<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TravelSupportSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'small_heading' => $this->small_heading,

            'heading' => $this->heading,

            'description' => $this->description,

            'image' => $this->image
                ? url(Storage::url($this->image))
                : null,

            'features' => $this->features ?? [],

            'status' => $this->status,

            'created_at' => $this->created_at?->format(
                'Y-m-d H:i:s'
            ),

            'updated_at' => $this->updated_at?->format(
                'Y-m-d H:i:s'
            ),
        ];
    }
}
