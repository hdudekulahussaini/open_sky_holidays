<?php

namespace App\Http\Requests;

use App\Models\Adventure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdventureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adventure = $this->route('adventure');

        $adventureId = $adventure instanceof Adventure
            ? $adventure->id
            : $adventure;

        return [
            'adventure_category_id' => [
                'required',
                'integer',
                'exists:adventure_categories,id',

                Rule::unique(
                    'adventures',
                    'adventure_category_id'
                )->ignore($adventureId),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],

            'features' => [
                'nullable',
                'array',
                'max:10',
            ],

            'features.*' => [
                'nullable',
                'string',
                'max:255',
            ],

            'video_link' => [
                'nullable',
                'url',
                'max:500',
            ],

            'image_one' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'image_two' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
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
            'adventure_category_id.required' =>
                'Please select an adventure category.',

            'adventure_category_id.exists' =>
                'The selected category does not exist.',

            'adventure_category_id.unique' =>
                'This category already has adventure content.',

            'title.required' =>
                'Please enter the adventure title.',

            'features.array' =>
                'Features must be submitted correctly.',

            'features.max' =>
                'You can add a maximum of 10 features.',

            'features.*.string' =>
                'Every feature must be valid text.',

            'features.*.max' =>
                'Each feature must not exceed 255 characters.',

            'video_link.url' =>
                'Please enter a valid video URL.',

            'image_one.image' =>
                'The first selected file must be an image.',

            'image_one.mimes' =>
                'The first image must be JPG, JPEG, PNG or WEBP.',

            'image_one.max' =>
                'The first image must not exceed 5 MB.',

            'image_two.image' =>
                'The second selected file must be an image.',

            'image_two.mimes' =>
                'The second image must be JPG, JPEG, PNG or WEBP.',

            'image_two.max' =>
                'The second image must not exceed 5 MB.',

            'status.required' =>
                'Please select the adventure status.',

            'status.in' =>
                'Status must be active or inactive.',
        ];
    }
}