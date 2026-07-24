<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'main_heading' => [
                'required',
                'string',
                'max:255',
            ],

            'mission_title' => [
                'required',
                'string',
                'max:255',
            ],

            'focus_title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'customer_count' => [
                'required',
                'integer',
                'min:0',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Globe locations
            |--------------------------------------------------------------------------
            */

            'locations' => [
                'required',
                'array',
                'min:1',
            ],

            'locations.*.id' => [
                'nullable',
                'integer',
                'exists:about_globe_locations,id',
            ],

            'locations.*.location_name' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Customer avatar images
            |--------------------------------------------------------------------------
            */

            'avatar_images' => [
                'nullable',
                'array',
                'max:3',
            ],

            'avatar_images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Remove existing avatars during update
            |--------------------------------------------------------------------------
            */

            'remove_avatar_ids' => [
                'nullable',
                'array',
            ],

            'remove_avatar_ids.*' => [
                'integer',
                'exists:about_customer_avatars,id',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('status')) {
            $this->merge([
                'status' => $this->boolean('status'),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'main_heading.required' => 'The main heading is required.',

            'mission_title.required' => 'The mission title is required.',

            'focus_title.required' => 'The focus title is required.',

            'description.required' => 'The description is required.',

            'customer_count.required' => 'The customer count is required.',

            'customer_count.integer' => 'The customer count must be a valid whole number.',

            'customer_count.min' => 'The customer count cannot be negative.',

            'status.required' => 'Please select a status.',

            'locations.required' => 'At least one globe location is required.',

            'locations.array' => 'The globe locations must be provided correctly.',

            'locations.min' => 'At least one globe location is required.',

            'locations.*.location_name.required' => 'Every globe location must have a location name.',

            'avatar_images.array' => 'Avatar images must be submitted as a valid image list.',

            'avatar_images.max' => 'You can upload a maximum of 3 avatar images.',

            'avatar_images.*.required' => 'Please select an image for every avatar field.',

            'avatar_images.*.image' => 'Every avatar file must be a valid image.',

            'avatar_images.*.mimes' => 'Avatar images must be JPG, JPEG, PNG or WEBP files.',

            'avatar_images.*.max' => 'Each avatar image must not be larger than 2 MB.',

            'remove_avatar_ids.array' => 'The selected avatars could not be processed.',

            'remove_avatar_ids.*.exists' => 'One of the selected avatar images does not exist.',
        ];
    }
}
