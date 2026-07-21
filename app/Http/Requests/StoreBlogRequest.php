<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->boolean('status'),

            'author_id' => $this->filled('author_id')
                ? $this->input('author_id')
                : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'author_id' => [
                'nullable',
                'integer',
                'exists:authors,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:blogs,slug',
            ],

            'short_description' => [
                'required',
                'string',
                'max:1000',
            ],

            'content' => [
                'required',
                'string',
            ],

            'featured_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'read_time' => [
                'required',
                'integer',
                'min:1',
                'max:120',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'title.required' => 'Blog title is required.',
            'short_description.required' => 'Short description is required.',
            'content.required' => 'Blog content is required.',
            'featured_image.required' => 'Featured image is required.',
            'featured_image.mimes' => 'Image must be JPG, JPEG, PNG or WEBP.',
            'read_time.required' => 'Reading time is required.',
        ];
    }
}
