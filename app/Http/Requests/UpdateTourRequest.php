<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        $tour = $this->route('tour');

        return [
            'tour_type_id' => [
                'required',
                'exists:tour_types,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tours', 'title')
                    ->ignore($tour?->id),
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('tours', 'slug')
                    ->ignore($tour?->id),
            ],

            'country' => [
                'required',
                'string',
                'max:100',
            ],

            'duration' => [
                'required',
                'string',
                'max:100',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            // Tour Detail Fields
            'detail' => [
                'required',
                'array',
            ],

            'detail.heading' => [
                'required',
                'string',
                'max:255',
            ],

            'detail.description' => [
                'required',
                'string',
            ],

            'detail.status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],

            // Gallery Fields (for new uploads)
            'gallery' => [
                'nullable',
                'array',
                'max:10',
            ],

            'gallery.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            // Existing Gallery Paths
            'existing_gallery' => [
                'nullable',
                'array',
            ],

            'existing_gallery.*' => [
                'required',
                'string',
            ],

            // Package Inclusions
            'package_inclusions' => [
                'nullable',
                'array',
            ],

            'package_inclusions.*.id' => [
                'nullable',
                'integer',
                'exists:tour_features,id',
            ],

            'package_inclusions.*.title' => [
                'required',
                'string',
                'max:255',
            ],

            'package_inclusions.*.description' => [
                'nullable',
                'string',
            ],

            'package_inclusions.*.sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            // Places Covered
            'places_covered' => [
                'nullable',
                'array',
            ],

            'places_covered.*.id' => [
                'nullable',
                'integer',
                'exists:tour_features,id',
            ],

            'places_covered.*.title' => [
                'required',
                'string',
                'max:255',
            ],

            'places_covered.*.description' => [
                'nullable',
                'string',
            ],

            'places_covered.*.sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'places_covered.*.image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            // Tour Highlights
            'tour_highlights' => [
                'nullable',
                'array',
            ],

            'tour_highlights.*.id' => [
                'nullable',
                'integer',
                'exists:tour_features,id',
            ],

            'tour_highlights.*.title' => [
                'required',
                'string',
                'max:255',
            ],

            'tour_highlights.*.description' => [
                'nullable',
                'string',
            ],

            'tour_highlights.*.sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'tour_type_id.required' => 'Please select a tour type.',
            'tour_type_id.exists' => 'The selected tour type is invalid.',
            'title.required' => 'The tour title is required.',
            'title.unique' => 'This tour title already exists.',
            'slug.unique' => 'This slug already exists.',
            'country.required' => 'Country is required.',
            'duration.required' => 'Duration is required.',
            'thumbnail.image' => 'The selected file must be an image.',
            'thumbnail.mimes' => 'Only JPG, JPEG, PNG and WEBP images are allowed.',
            'thumbnail.max' => 'The image size may not exceed 2 MB.',
            'detail.heading.required' => 'The tour detail heading is required.',
            'detail.description.required' => 'The tour detail description is required.',
            'gallery.*.image' => 'Each uploaded gallery item must be an image.',
            'gallery.*.mimes' => 'Only JPG, JPEG, PNG, and WEBP gallery images are allowed.',
            'package_inclusions.*.title.required' => 'The package inclusion title is required.',
            'places_covered.*.title.required' => 'The place covered title is required.',
            'places_covered.*.image.image' => 'The place covered upload must be an image.',
            'tour_highlights.*.title.required' => 'The tour highlight title is required.',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
        ]);
    }
}
