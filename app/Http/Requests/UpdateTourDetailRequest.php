<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTourDetailRequest extends FormRequest
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
        $tourDetail = $this->route('tour_detail');

        return [
            'tour_id' => [
                'required',
                'integer',
                'exists:tours,id',

                Rule::unique('tour_details', 'tour_id')
                    ->ignore($tourDetail?->id),
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
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'existing_gallery' => [
                'nullable',
                'array',
            ],

            'existing_gallery.*' => [
                'nullable',
                'string',
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
            'gallery.*.image' => 'Every gallery file must be an image.',
            'gallery.*.max' => 'Each image must not exceed 5 MB.',
            'status.required' => 'Please select a status.',
        ];
    }
}
