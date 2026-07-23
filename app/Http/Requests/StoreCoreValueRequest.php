<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoreValueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'heading' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'status' => [
                'required',
                'in:active,inactive',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'heading.required' => 'The heading field is required.',
            'heading.string' => 'The heading must be valid text.',
            'heading.max' => 'The heading may not be greater than 255 characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be valid text.',

            'status.required' => 'The status field is required.',
            'status.in' => 'The selected status is invalid.',
        ];
    }
}