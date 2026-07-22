<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOurProcessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'small_heading' => [
                'nullable',
                'string',
                'max:255',
            ],

            'heading' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'promises' => [
                'nullable',
                'array',
                'max:20',
            ],

            'promises.*.text' => [
                'required',
                'string',
                'max:500',
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

            'promises.array' =>
                'The promises field must be an array.',

            'promises.max' =>
                'You can add a maximum of 20 promises.',

            'promises.*.text.required' =>
                'The promise text field is required.',

            'status.required' =>
                'Please select the status.',

            'status.in' =>
                'The selected status is invalid.',
        ];
    }
}