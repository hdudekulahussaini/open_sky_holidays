<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AboutWhyChooseUsRequest extends FormRequest
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
                'max:5120',
            ],

            'features_title' => [
                'required',
                'array',
                'min:1',
                'max:10',
            ],

            'features_title.*' => [
                'required',
                'string',
                'max:255',
            ],

            'features_description' => [
                'nullable',
                'array',
                'max:10',
            ],

            'features_description.*' => [
                'nullable',
                'string',
                'max:1500',
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
                'Please enter the section title.',

            'title.string' =>
                'The title must be valid text.',

            'title.max' =>
                'The title must not exceed 255 characters.',

            'description.string' =>
                'The description must be valid text.',

            'description.max' =>
                'The description must not exceed 3000 characters.',

            'image.required' =>
                'Please select the section image.',

            'image.image' =>
                'The selected file must be a valid image.',

            'image.mimes' =>
                'The image must be JPG, JPEG, PNG or WEBP.',

            'image.max' =>
                'The image must not exceed 5 MB.',

            'features_title.required' =>
                'Please add at least one feature.',

            'features_title.array' =>
                'The feature titles are invalid.',

            'features_title.min' =>
                'Please add at least one feature.',

            'features_title.max' =>
                'You can add a maximum of 10 features.',

            'features_title.*.required' =>
                'Please enter every feature title.',

            'features_title.*.max' =>
                'Each feature title must not exceed 255 characters.',

            'features_description.array' =>
                'The feature descriptions are invalid.',

            'features_description.max' =>
                'You can add a maximum of 10 feature descriptions.',

            'features_description.*.max' =>
                'Each feature description must not exceed 1500 characters.',

            'status.required' =>
                'Please select the section status.',

            'status.in' =>
                'Status must be active or inactive.',
        ];
    }
}