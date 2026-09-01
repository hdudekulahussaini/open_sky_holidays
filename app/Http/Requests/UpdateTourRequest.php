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

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'duration' => [
                'required',
                'string',
                'max:100',
            ],

            'areas' => [
                'nullable',
                'array',
            ],

            'features' => [
                'nullable',
                'array',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,avif',
                'max:5120',
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
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,avif',
                'max:5120',
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
                'file',
                'mimes:jpg,jpeg,png,webp,avif',
                'max:5120',
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
            'thumbnail.mimes' => 'Only JPG, JPEG, PNG, WEBP, and AVIF images are allowed.',
            'thumbnail.max' => 'The image size may not exceed 5 MB.',
            'detail.heading.required' => 'The tour detail heading is required.',
            'detail.description.required' => 'The tour detail description is required.',
            'gallery.*.file' => 'Each uploaded gallery item must be a valid file.',
            'gallery.*.mimes' => 'Only JPG, JPEG, PNG, WEBP, and AVIF gallery images are allowed.',
            'gallery.*.max' => 'Each gallery image may not exceed 5 MB.',
            'package_inclusions.*.title.required' => 'The package inclusion title is required.',
            'places_covered.*.title.required' => 'The place covered title is required.',
            'places_covered.*.image.file' => 'The place covered upload must be a valid image file.',
            'places_covered.*.image.mimes' => 'Only JPG, JPEG, PNG, WEBP, and AVIF images are allowed.',
            'places_covered.*.image.max' => 'The place covered image may not exceed 5 MB.',
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

        if ($this->has('gallery') && is_array($this->gallery)) {
            $filteredGallery = array_filter($this->gallery, fn ($item) => ! empty($item));
            if (empty($filteredGallery)) {
                $this->request->remove('gallery');
            }
        }
    }
}
