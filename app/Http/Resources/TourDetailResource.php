<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TourDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $gallery = is_array($this->gallery)
            ? $this->gallery
            : [];

        return [
            'id' => $this->id,

            'tour_id' => $this->tour_id,

            'tour' => $this->whenLoaded('tour', function () {
                return [
                    'id' => $this->tour->id,
                    'title' => $this->tour->title,
                    'slug' => $this->tour->slug,

                    'tour_type' => $this->tour->relationLoaded('tourType')
                        && $this->tour->tourType
                            ? [
                                'id' => $this->tour->tourType->id,
                                'name' => $this->tour->tourType->name,
                                'slug' => $this->tour->tourType->slug,
                            ]
                            : null,
                ];
            }),

            'heading' => $this->heading,

            'description' => $this->description,

            'gallery' => collect($gallery)
                ->map(function (string $image): array {
                    return [
                        'path' => $image,
                        'url' => Storage::disk('public')->url($image),
                    ];
                })
                ->values(),

            'gallery_count' => count($gallery),

            'status' => $this->status,

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
