<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTourTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tourType = $this->route('tour_type');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tour_types', 'name')
                    ->ignore($tourType?->id),
            ],

            'slug' => [
                'nullable',
                'string',
                'max:120',
                Rule::unique('tour_types', 'slug')
                    ->ignore($tourType?->id),
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
