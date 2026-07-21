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
        $this->merge([
            'status' => $this->boolean('status'),

            'author_id' => $this->filled('author_id')
                ? $this->input('author_id')
                : null,
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
                'nullable',
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
}
