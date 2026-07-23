<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WhatWeOfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'subtitle' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'image' => [
                $this->isMethod('post')
                    ? 'required'
                    : 'nullable',

                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            'status' => [
                'required',

                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' =>
                'Please enter the title.',

            'title.string' =>
                'The title must contain valid text.',

            'title.max' =>
                'The title must not exceed 255 characters.',

            'subtitle.string' =>
                'The subtitle must contain valid text.',

            'subtitle.max' =>
                'The subtitle must not exceed 255 characters.',

            'description.string' =>
                'The description must contain valid text.',

            'description.max' =>
                'The description must not exceed 3000 characters.',

            'image.required' =>
                'Please select an image.',

            'image.image' =>
                'The selected file must be a valid image.',

            'image.mimes' =>
                'The image must be JPG, JPEG, PNG or WEBP.',

            'image.max' =>
                'The image size must not exceed 5 MB.',

            'status.required' =>
                'Please select the status.',

            'status.in' =>
                'Status must be active or inactive.',
        ];
    }
}