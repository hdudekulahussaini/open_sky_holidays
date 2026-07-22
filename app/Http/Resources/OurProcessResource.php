<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OurProcessResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'small_heading' => $this->small_heading,

            'heading' => $this->heading,

            'description' => $this->description,
            'promises' => collect($this->promises ?? [])
                ->map(function (array $promise): array {
                    return [
                        'text' => $promise['text'] ?? '',
                    ];
                })
                ->values(),

            'status' => $this->status,

            'created_at' => $this->created_at?->format(
                'Y-m-d H:i:s'
            ),

            'updated_at' => $this->updated_at?->format(
                'Y-m-d H:i:s'
            ),
        ];
    }
}
