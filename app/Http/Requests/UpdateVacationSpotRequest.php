<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVacationSpotRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,svg,avif', 'max:5120'],
            'link' => ['nullable', 'string', 'max:2000'],
            'order' => ['nullable', 'integer'],
            'status' => ['nullable', 'boolean'],
        ];
    }
}
