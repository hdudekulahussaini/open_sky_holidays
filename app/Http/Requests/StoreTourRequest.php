<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourRequest extends FormRequest
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
        return [
            'tour_type_id' => [
                'required',
                'exists:tour_types,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
                'unique:tours,title',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:tours,slug',
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
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                
            ],

            'status' => [
                'required',
                'boolean',
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

            'thumbnail.required' => 'Please upload a tour image.',

            'thumbnail.image' => 'The selected file must be an image.',

            'thumbnail.mimes' => 'Only JPG, JPEG, PNG and WEBP images are allowed.',

            'thumbnail.max' => 'The image size may not exceed 2 MB.',
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