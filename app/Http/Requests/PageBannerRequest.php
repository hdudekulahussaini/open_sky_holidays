<?php

namespace App\Http\Requests;

use App\Models\PageBanner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('page')) {
            $this->merge([
                'page' => Str::slug($this->input('page')),
            ]);
        }

        if ($this->has('status')) {
            $status = filter_var(
                $this->input('status'),
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            );

            $this->merge([
                'status' => $status,
            ]);
        }
    }

    public function rules(): array
    {
        $pageBanner = $this->route('page_banner');

        $pageBannerId = $pageBanner instanceof PageBanner
            ? $pageBanner->id
            : $pageBanner;

        /*
         * Admin create requires an image.
         * Admin update image is optional.
         * API create/update image is optional.
         */
        $imageRequired = $this->routeIs(
            'admin.page-banners.store'
        );

        return [
            'page' => [
                'required',
                'string',
                'max:100',
                Rule::unique('page_banners', 'page')
                    ->ignore($pageBannerId),
            ],

            'label' => [
                'nullable',
                'string',
                'max:100',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'breadcrumb_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'file',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'page.required' => 'Please enter the page name.',

            'page.string' => 'The page name must be valid text.',

            'page.max' => 'The page name must not exceed 100 characters.',

            'page.unique' => 'A banner already exists for this page.',

            'label.string' => 'The small label must be valid text.',

            'label.max' => 'The small label must not exceed 100 characters.',

            'title.required' => 'Please enter the banner title.',

            'title.string' => 'The banner title must be valid text.',

            'title.max' => 'The banner title must not exceed 255 characters.',

            'description.string' => 'The description must be valid text.',

            'description.max' => 'The description must not exceed 2000 characters.',

            'breadcrumb_title.string' => 'The breadcrumb title must be valid text.',

            'breadcrumb_title.max' => 'The breadcrumb title must not exceed 255 characters.',

            'image.required' => 'Please select a banner image.',

            'image.image' => 'The selected file must be an image.',

            'image.mimes' => 'The image must be JPG, JPEG, PNG or WEBP.',

            'image.max' => 'The image size must not exceed 5 MB.',

            'status.required' => 'Please select the banner status.',

            'status.boolean' => 'The status must be 1 or 0.',
        ];
    }
}
