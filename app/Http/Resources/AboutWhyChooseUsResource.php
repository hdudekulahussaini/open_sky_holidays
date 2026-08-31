<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutWhyChooseUsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $titles = $this->features_title ?? [];
        $icons = $this->features_icon ?? [];
        $descriptions = $this->features_description ?? [];

        $features = [];
        foreach ($titles as $index => $title) {
            $features[] = [
                'title' => $title,
                'icon' => $icons[$index] ?? 'fa-solid fa-circle-check',
                'description' => $descriptions[$index] ?? null,
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'image' => $this->image,
            'image_url' => filled($this->image)
                ? asset('storage/' . $this->image)
                : null,
            'features' => $features,
            'features_icon' => $icons,
            'features_title' => $titles,
            'features_description' => $descriptions,
            'badge_title' => $this->badge_title ?? 'Trusted by 15,000+',
            'badge_subtitle' => $this->badge_subtitle ?? 'Happy travelers worldwide',
            'status' => $this->status,
        ];
    }
}
