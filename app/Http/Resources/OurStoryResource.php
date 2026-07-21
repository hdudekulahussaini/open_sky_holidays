<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OurStoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'heading' => $this->heading,
            'description' => $this->description,

            'images' => collect($this->images ?? [])
                ->map(function (string $image) {
                    return [
                        'path' => $image,
                        'url' => Storage::disk('public')->url($image),
                    ];
                })
                ->values(),

            'features' => collect($this->features ?? [])
                ->map(function (array $feature) {
                    return [
                        'heading' => $feature['heading'] ?? null,
                        'sub_heading' => $feature['sub_heading'] ?? null,
                    ];
                })
                ->values(),

            'status' => $this->status,

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
