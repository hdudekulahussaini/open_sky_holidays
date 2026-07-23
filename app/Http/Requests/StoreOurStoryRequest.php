<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOurStoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $features = collect($this->input('features', []))
            ->filter(function ($feature) {
                return filled($feature['heading'] ?? null)
                    || filled($feature['sub_heading'] ?? null);
            })
            ->values()
            ->all();

        $this->merge([
            'features' => $features,
        ]);
    }

    public function rules(): array
    {
        return [
             'heading' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'images' => [
                'nullable',
                'array',
                'max:3',
            ],

            'images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            'features' => [
                'nullable',
                'array',
            ],

            'features.*.heading' => [
                'required_with:features.*.sub_heading',
                'nullable',
                'string',
                'max:255',
            ],

            'features.*.sub_heading' => [
                'required_with:features.*.heading',
                'nullable',
                'string',
                'max:500',
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
            'heading.required' => 'The main heading is required.',

            'images.max' => 'You can upload a maximum of 3 images.',
            'images.*.image' => 'Every uploaded file must be an image.',
            'images.*.mimes' => 'Images must be JPG, JPEG, PNG or WebP.',
            'images.*.max' => 'Each image must not exceed 5 MB.',

            'features.*.heading.required_with' =>
                'The feature heading is required when a sub heading is entered.',

            'features.*.sub_heading.required_with' =>
                'The feature sub heading is required when a heading is entered.',
        ];
    }
}