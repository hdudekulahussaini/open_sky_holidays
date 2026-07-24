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
            'counters' => [
                'required',
                'array',
                'min:1',
            ],

            'counters.*.value' => [
                'required',
                'string',
                'max:100',
            ],

            'counters.*.name' => [
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
            'counters.required' => 'At least one counter entry is required.',
            'counters.*.value.required' => 'The counter value is required.',
            'counters.*.value.max' => 'The counter value may not be greater than 100 characters.',
            'counters.*.name.required' => 'The counter name is required.',
            'counters.*.name.max' => 'The counter name may not be greater than 255 characters.',
        ];
    }
}
