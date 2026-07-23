<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourInquiryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tour_id' => $this->tour_id,
            'tour_title' => $this->whenLoaded('tour', fn () => $this->tour->title),
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'travel_date' => $this->travel_date?->format('Y-m-d'),
            'travelers' => $this->travelers,
            'status' => $this->status,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
