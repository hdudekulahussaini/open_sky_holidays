<?php

namespace App\Http\Requests;

use App\Models\AdventureCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdventureCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('name')) {
            $slug = $this->filled('slug')
                ? $this->input('slug')
                : $this->input('name');

            $this->merge([
                'slug' => Str::slug($slug),
            ]);
        }
    }

    public function rules(): array
    {
        $category = $this->route('adventure_category');

        $categoryId = $category instanceof AdventureCategory
            ? $category->id
            : $category;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'adventure_categories',
                    'slug'
                )->ignore($categoryId),
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
            'name.required' =>
                'Please enter the category name.',

            'slug.required' =>
                'Please enter the category slug.',

            'slug.unique' =>
                'This category slug already exists.',

            'status.required' =>
                'Please select the category status.',

            'status.in' =>
                'Status must be active or inactive.',
        ];
    }
}