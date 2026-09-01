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

            'state' => $this->state,

            'duration' => $this->duration,

            'thumbnail' => $this->thumbnail,

            'thumbnail_url' => $this->thumbnail
                ? Storage::disk('public')
                    ->url($this->thumbnail)
                : null,

            'areas' => is_array($this->areas) ? $this->areas : (is_array($this->features) ? $this->features : []),

            'features' => is_array($this->features) ? $this->features : (is_array($this->areas) ? $this->areas : []),

            'highlights' => ! empty($this->areas) && is_array($this->areas)
                ? array_values(array_map(fn($a) => is_array($a) ? ($a['title'] ?? '') : (string)$a, $this->areas))
                : (! empty($this->features) && is_array($this->features)
                    ? array_values(array_map(fn($f) => is_array($f) ? ($f['title'] ?? '') : (string)$f, $this->features))
                    : ($this->relationLoaded('features')
                        ? $this->getRelation('features')
                            ->where('type', 'place_covered')
                            ->where('status', 'active')
                            ->sortBy('sort_order')
                            ->pluck('title')
                            ->values()
                            ->all()
                        : [])),

            'status' => (bool) $this->status,

            'detail' => $this->whenLoaded(
                'detail',
                function (): array {
                    return [
                        'heading' => $this->detail->heading,
                        'description' => $this->detail->description,
                        'status' => $this->detail->status,
                    ];
                }
            ),

            'gallery' => $this->whenLoaded(
                'gallery',
                function () {
                    return $this->gallery->map(function ($img) {
                        $ext = strtolower(pathinfo($img->image, PATHINFO_EXTENSION));
                        $isVideo = in_array($ext, ['mp4', 'webm', 'mov', 'avi', 'mkv', 'ogv']);
                        $url = Storage::disk('public')->url($img->image);

                        return [
                            'id' => $img->id,
                            'file' => $img->image,
                            'file_url' => $url,
                            'media_type' => $isVideo ? 'video' : 'image',
                            'image' => $img->image,
                            'image_url' => $url,
                        ];
                    });
                }
            ),

            'tour_features' => TourFeatureResource::collection(
                $this->whenLoaded('features')
            ),

            'package_inclusions' => $this->whenLoaded(
                'features',
                function () {
                    return TourFeatureResource::collection(
                        $this->getRelation('features')
                            ->where('type', 'package_inclusion')
                            ->where('status', 'active')
                            ->sortBy('sort_order')
                            ->values()
                    );
                }
            ),

            'places_covered' => $this->whenLoaded(
                'features',
                function () {
                    return TourFeatureResource::collection(
                        $this->getRelation('features')
                            ->where('type', 'place_covered')
                            ->where('status', 'active')
                            ->sortBy('sort_order')
                            ->values()
                    );
                }
            ),

            'created_at' => $this->created_at?->toISOString(),

            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
