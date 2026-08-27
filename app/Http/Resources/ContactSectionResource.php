<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'map_link' => $this->map_link,
            'whatsapp_number' => $this->whatsapp_number,
            'map_embed_url' => $this->map_embed_url,
            'status' => (bool) $this->status,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
