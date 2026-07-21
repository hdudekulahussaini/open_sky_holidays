<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelSupportSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'small_heading' => [
                'nullable',
                'string',
                'max:255',
            ],

            'heading' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'remove_image' => [
                'nullable',
                'boolean',
            ],

            'features' => [
                'required',
                'array',
                'min:1',
            ],

            'features.*' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'heading.required' => 'The heading field is required.',

            'features.required' => 'Please add at least one feature.',
            'features.array' => 'The features must be an array.',
            'features.min' => 'Please add at least one feature.',

            'features.*.required' => 'Each feature field is required.',

            'image.image' => 'The selected file must be an image.',
            'image.mimes' => 'The image must be JPG, JPEG, PNG, or WEBP.',
            'image.max' => 'The image size must not exceed 2 MB.',
        ];
    }
}
