<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TourFeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'tour_id' => $this->tour_id,

            'tour' => [
                'id' => $this->whenLoaded(
                    'tour',
                    fn () => $this->tour->id
                ),

                'title' => $this->whenLoaded(
                    'tour',
                    fn () => $this->tour->title
                ),

                'slug' => $this->whenLoaded(
                    'tour',
                    fn () => $this->tour->slug
                ),

                'tour_type' => $this->when(
                    $this->relationLoaded('tour')
                    && $this->tour->relationLoaded('tourType'),
                    fn () => [
                        'id' => $this->tour->tourType?->id,
                        'name' => $this->tour->tourType?->name,
                        'slug' => $this->tour->tourType?->slug,
                    ]
                ),
            ],

            'type' => $this->type,

            'type_label' => match ($this->type) {
                'package_inclusion' => 'Package Inclusion',
                'place_covered' => 'Place Covered',
                'tour_highlight' => 'Tour Highlight',
                default => $this->type,
            },

            'title' => $this->title,

            'description' => $this->description,

            'image' => $this->image,

            'image_url' => $this->image
                ? Storage::disk('public')->url($this->image)
                : null,

            'sort_order' => $this->sort_order,

            'status' => $this->status,

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
