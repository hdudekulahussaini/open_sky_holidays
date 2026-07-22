<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCounterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'string',
                'max:100',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'The counter value is required.',
            'value.max' => 'The counter value may not be greater than 100 characters.',

            'name.required' => 'The counter name is required.',
            'name.max' => 'The counter name may not be greater than 255 characters.',
        ];
    }
}