<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferBannerRequest extends FormRequest
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

            'discount_text' => [
                'required',
                'string',
                'max:100',
            ],

            'subtitle' => [
                'required',
                'string',
                'max:255',
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
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter the title.',
            'discount_text.required' => 'Please enter the discount text.',
            'subtitle.required' => 'Please enter the subtitle.',

            'image.image' => 'The selected file must be an image.',
            'image.mimes' => 'The image must be JPG, JPEG, PNG or WEBP.',
            'image.max' => 'The image size must not exceed 5 MB.',

            'status.required' => 'Please select the status.',
            'status.boolean' => 'The status must be active or inactive.',
        ];
    }
}