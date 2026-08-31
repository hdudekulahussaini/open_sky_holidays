<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'about_title' => $this->about_title,
            'about_description' => $this->about_description,
            'about_image' => $this->about_image,
            'about_image_url' => filled($this->about_image)
                ? asset('storage/' . $this->about_image)
                : null,
            'features' => $this->features ?? [],
            'service_items' => $this->service_items ?? [],
            'process_steps' => $this->process_steps ?? [],
            'documents' => $this->documents ?? [],
            'why_choose_items' => $this->why_choose_items ?? [],
            'cta_title' => $this->cta_title,
            'cta_description' => $this->cta_description,
            'cta_background_image' => $this->cta_background_image,
            'cta_background_image_url' => filled($this->cta_background_image)
                ? asset('storage/' . $this->cta_background_image)
                : null,
            'stats' => $this->stats ?? [],
            'status' => (bool) $this->status,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
