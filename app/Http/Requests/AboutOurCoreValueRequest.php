<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutOurCoreValueRequest extends FormRequest
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
                'required',
                'string',
                'max:3000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' =>
                'Please enter the core value title.',

            'title.string' =>
                'The title must contain valid text.',

            'title.max' =>
                'The title must not exceed 255 characters.',

            'description.required' =>
                'Please enter the core value description.',

            'description.string' =>
                'The description must contain valid text.',

            'description.max' =>
                'The description must not exceed 3000 characters.',
        ];
    }
}