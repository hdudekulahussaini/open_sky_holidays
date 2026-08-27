<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopHeaderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:2000'],
            'social_links' => ['nullable', 'array'],
            'social_links.*.platform' => ['nullable', 'string', 'max:100'],
            'social_links.*.icon' => ['nullable', 'string', 'max:100'],
            'social_links.*.url' => ['nullable', 'string', 'max:2000'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
