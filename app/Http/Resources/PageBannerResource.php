<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageBannerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'page' => $this->page,
            'label' => $this->label,
            'title' => $this->title,
            'description' => $this->description,
            'breadcrumb_title' => $this->breadcrumb_title,

            'image' => $this->image,

            'image_url' => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'status' => (bool) $this->status,

            'created_at' => $this->created_at?->format(
                'Y-m-d H:i:s'
            ),

            'updated_at' => $this->updated_at?->format(
                'Y-m-d H:i:s'
            ),
        ];
    }
}
