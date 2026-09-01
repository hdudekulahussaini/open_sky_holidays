<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourDetailRequest extends FormRequest
{
    /**
     * Determine whether the user can make this request.
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
        return [
            'tour_id' => [
                'required',
                'integer',
                'exists:tours,id',
                'unique:tour_details,tour_id',
            ],

            'heading' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

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

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'tour_id.required' => 'Please select a tour.',
            'tour_id.unique' => 'Details already exist for this tour.',
            'heading.required' => 'The heading field is required.',
            'description.required' => 'The description field is required.',
            'gallery.max' => 'You can upload a maximum of 10 images.',
            'gallery.*.file' => 'Every gallery file must be a valid file.',
            'gallery.*.mimes' => 'Gallery images must be JPG, JPEG, PNG, WEBP, or AVIF.',
            'gallery.*.max' => 'Each gallery image may not exceed 5 MB.',
            'status.required' => 'Please select a status.',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('gallery') && is_array($this->gallery)) {
            $filteredGallery = array_filter($this->gallery, fn ($item) => ! empty($item));
            if (empty($filteredGallery)) {
                $this->request->remove('gallery');
            }
        }
    }
}
