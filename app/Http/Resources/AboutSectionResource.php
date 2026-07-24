<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AboutSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'main_heading' => $this->main_heading,
            'mission_title' => $this->mission_title,
            'focus_title' => $this->focus_title,
            'description' => $this->description,
            'customer_count' => $this->customer_count,
            'status' => $this->status,

            'globe_locations' => $this->whenLoaded(
                'globeLocations',
                fn () => $this->globeLocations->map(
                    fn ($location) => [
                        'id' => $location->id,
                        'location_name' => $location->location_name,
                    ]
                )
            ),

            'customer_avatars' => $this->whenLoaded(
                'customerAvatars',
                fn () => $this->customerAvatars->map(
                    fn ($avatar) => [
                        'id' => $avatar->id,
                        'image' => $avatar->image,
                        'image_url' => Storage::disk('public')
                            ->url($avatar->image),
                    ]
                )
            ),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
