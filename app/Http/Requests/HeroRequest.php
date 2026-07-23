<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
                'max:2000',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'sort_order' => [
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
            'title.required' => 'Please enter the hero title.',
            'title.string' => 'The hero title must be valid text.',
            'title.max' => 'The hero title must not exceed 255 characters.',

            'description.required' => 'Please enter the hero description.',
            'description.string' => 'The hero description must be valid text.',
            'description.max' => 'The hero description must not exceed 2000 characters.',

            'image.image' => 'The selected file must be an image.',
            'image.mimes' => 'The image must be JPG, JPEG, PNG or WEBP.',
            'image.max' => 'The image size must not exceed 5 MB.',

            'status.required' => 'Please select the hero status.',
            'status.boolean' => 'The hero status must be true/false or 1/0.',

            'sort_order.integer' => 'The sort order must be a number.',
            'sort_order.min' => 'The sort order cannot be less than 0.',
        ];
    }
}
