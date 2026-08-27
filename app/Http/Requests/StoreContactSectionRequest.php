<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'map_link' => ['nullable', 'string', 'max:2000'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'map_embed_url' => ['nullable', 'string', 'max:3000'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
