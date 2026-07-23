<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:tour_types,name',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:120',
                'unique:tour_types,slug',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The tour type name is required.',

            'name.string' => 'The tour type name must be valid text.',

            'name.max' => 'The tour type name may not exceed 100 characters.',

            'name.unique' => 'This tour type name already exists.',

            'slug.string' => 'The slug must be valid text.',

            'slug.max' => 'The slug may not exceed 120 characters.',

            'slug.unique' => 'This slug is already being used.',
        ];
    }
}
