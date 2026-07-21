<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),
        ]);
    }

    public function rules(): array
    {
        return [
            'platform' => [
                'required',
                'string',
                'max:100',
            ],

            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'customer_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'rating' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'review' => [
                'required',
                'string',
                'max:5000',
            ],

            'reviewed_at' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'platform.required' => 'Platform name is required.',
            'platform.string' => 'Platform must be valid text.',
            'platform.max' => 'Platform name must not exceed 100 characters.',

            'customer_name.required' => 'Customer name is required.',
            'customer_name.max' => 'Customer name must not exceed 255 characters.',

            'customer_image.image' => 'Customer image must be a valid image.',
            'customer_image.mimes' => 'Customer image must be JPG, JPEG, PNG, or WEBP.',
            'customer_image.max' => 'Customer image must not exceed 2 MB.',

            'location.max' => 'Location must not exceed 255 characters.',

            'rating.required' => 'Rating is required.',
            'rating.integer' => 'Rating must be a number.',
            'rating.between' => 'Rating must be between 1 and 5.',

            'review.required' => 'Review is required.',
            'review.max' => 'Review must not exceed 5000 characters.',

            'reviewed_at.required' => 'Review date and time are required.',
            'reviewed_at.date' => 'Please provide a valid review date and time.',

            'status.required' => 'Status is required.',
            'status.boolean' => 'Status must be active or inactive.',
        ];
    }
}