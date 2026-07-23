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

            /*
            |--------------------------------------------------------------------------
            | Table of Contents
            |--------------------------------------------------------------------------
            */

            'table_of_contents' => [
                'required',
                'array',
                'min:1',
            ],

            'table_of_contents.*' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Complete Blog Content
            |--------------------------------------------------------------------------
            */

            'content' => [
                'required',
                'string',
            ],

            'featured_image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
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
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' =>
                'Please select a category.',

            'category_id.exists' =>
                'Selected category does not exist.',

            'title.required' =>
                'Blog title is required.',

            'table_of_contents.required' =>
                'Please add at least one Table of Contents section.',

            'table_of_contents.array' =>
                'Table of Contents must be a valid list.',

            'table_of_contents.min' =>
                'Please add at least one Table of Contents section.',

            'table_of_contents.*.required' =>
                'Each Table of Contents section is required.',

            'table_of_contents.*.max' =>
                'Each Table of Contents section cannot exceed 255 characters.',

            'content.required' =>
                'Blog content is required.',

            'featured_image.required' =>
                'Featured image is required.',

            'featured_image.image' =>
                'The selected file must be an image.',

            'featured_image.mimes' =>
                'Image must be JPG, JPEG, PNG or WEBP.',


            'read_time.required' =>
                'Reading time is required.',
        ];
    }
}