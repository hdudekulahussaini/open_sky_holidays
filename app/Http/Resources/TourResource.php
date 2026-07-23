<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'tour_type_id' => $this->tour_type_id,

            'tour_type' => $this->whenLoaded(
                'tourType',
                function (): array {
                    return [
                        'id' => $this->tourType->id,
                        'name' => $this->tourType->name,
                        'slug' => $this->tourType->slug,
                    ];
                }
            ),

            'title' => $this->title,

            'slug' => $this->slug,

            'country' => $this->country,

            'duration' => $this->duration,

            'thumbnail' => $this->thumbnail,

            'thumbnail_url' => $this->thumbnail
                ? Storage::disk('public')
                    ->url($this->thumbnail)
                : null,

            'status' => (bool) $this->status,

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
