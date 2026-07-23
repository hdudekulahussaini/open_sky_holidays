<?php

namespace App\Http\Requests;

use App\Models\TourFeature;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTourFeatureRequest extends FormRequest
{
    /**
     * Determine whether the user can make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'tour_id' => [
                'required',
                'integer',
                'exists:tours,id',
            ],

            'type' => [
                'required',
                Rule::in([
                    TourFeature::TYPE_PACKAGE_INCLUSION,
                    TourFeature::TYPE_PLACE_COVERED,
                    TourFeature::TYPE_TOUR_HIGHLIGHT,
                ]),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'image' => [
                Rule::requiredIf(
                    fn (): bool => $this->input('type') ===
                        TourFeature::TYPE_PLACE_COVERED
                ),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
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

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'tour_id.required' => 'Please select a tour.',

            'tour_id.exists' => 'The selected tour does not exist.',

            'type.required' => 'Please select a feature type.',

            'title.required' => 'The title field is required.',

            'image.required' => 'An image is required for a place covered.',
        ];
    }
}
