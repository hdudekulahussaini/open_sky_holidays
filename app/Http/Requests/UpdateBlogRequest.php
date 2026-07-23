<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $tocItems = $this->input(
            'table_of_contents',
            []
        );

        if (!is_array($tocItems)) {
            $tocItems = [];
        }

        /*
         * Remove empty Table of Contents rows.
         */
        $tocItems = collect($tocItems)
            ->map(
                fn ($item) => trim((string) $item)
            )
            ->filter(
                fn ($item) => $item !== ''
            )
            ->values()
            ->all();

        $this->merge([
            'status' => $this->boolean('status'),

            'author_id' => $this->filled('author_id')
                ? $this->input('author_id')
                : null,

            'table_of_contents' => $tocItems,
        ]);
    }

    public function rules(): array
    {
        $blog = $this->route('blog');

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

                Rule::unique('blogs', 'slug')
                    ->ignore($blog?->id),
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

            /*
             * Image is optional while editing.
             * Existing image is retained when no new image is uploaded.
             */
            'featured_image' => [
                'nullable',
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

            'slug.unique' =>
                'This blog slug is already being used.',

            'table_of_contents.required' =>
                'Please add at least one Table of Contents section.',

            'table_of_contents.array' =>
                'Table of Contents must be a valid list.',

            'table_of_contents.min' =>
                'Please add at least one Table of Contents section.',

            'table_of_contents.*.required' =>
                'Each Table of Contents section is required.',

            'table_of_contents.*.max' =>
                'Each section title cannot exceed 255 characters.',

            'content.required' =>
                'Blog content is required.',

            'featured_image.image' =>
                'The selected file must be an image.',

            'featured_image.mimes' =>
                'Image must be JPG, JPEG, PNG or WEBP.',


            'read_time.required' =>
                'Reading time is required.',
        ];
    }
}