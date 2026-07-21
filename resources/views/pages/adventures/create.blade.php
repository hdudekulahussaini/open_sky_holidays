@extends('admin.layouts.app')

@section('title', 'Create Adventure')

@section('content')
<div class="container-fluid">

    {{-- Page heading --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Create Adventure
            </h2>

            <p class="text-muted mb-0">
                Add adventure content, features, video and two images.
            </p>
        </div>

        <a
            href="{{ route('admin.adventures.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fas fa-arrow-left me-2"></i>
            Back
        </a>
    </div>

    {{-- All validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('admin.adventures.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="row g-4">

            {{-- Left content --}}
            <div class="col-xl-8 col-lg-7">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="fw-semibold mb-0">
                            Adventure Information
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        {{-- Category --}}
                        <div class="mb-4">
                            <label
                                for="adventure_category_id"
                                class="form-label fw-semibold"
                            >
                                Adventure Category
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                id="adventure_category_id"
                                name="adventure_category_id"
                                class="form-select
                                    @error('adventure_category_id')
                                        is-invalid
                                    @enderror"
                            >
                                <option value="">
                                    Select Adventure Category
                                </option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected(
                                            old('adventure_category_id')
                                            == $category->id
                                        )
                                    >
                                        {{ $category->name }}
                                        ({{ $category->slug }})
                                    </option>
                                @endforeach
                            </select>

                            @error('adventure_category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            @if ($categories->isEmpty())
                                <div class="alert alert-warning mt-3 mb-0">
                                    No available active category was found.

                                    <a
                                        href="{{ route(
                                            'admin.adventure-categories.create'
                                        ) }}"
                                        class="alert-link"
                                    >
                                        Create a category first.
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Title --}}
                        <div class="mb-4">
                            <label
                                for="title"
                                class="form-label fw-semibold"
                            >
                                Adventure Title
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                class="form-control
                                    @error('title') is-invalid @enderror"
                                placeholder="Thrill Above Ground: The Zip Line Adventure"
                            >

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label
                                for="description"
                                class="form-label fw-semibold"
                            >
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                class="form-control
                                    @error('description') is-invalid @enderror"
                                placeholder="Enter the adventure description"
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Dynamic features --}}
                        <div class="mb-4">
                            <div
                                class="d-flex flex-wrap
                                       justify-content-between
                                       align-items-center gap-3 mb-3"
                            >
                                <div>
                                    <label class="form-label fw-semibold mb-1">
                                        Adventure Features
                                    </label>

                                    <p class="small text-muted mb-0">
                                        Add or delete each feature separately.
                                    </p>
                                </div>

                                <button
                                    type="button"
                                    id="addFeatureButton"
                                    class="btn btn-sm btn-primary"
                                >
                                    <i class="fas fa-plus me-1"></i>
                                    Add Feature
                                </button>
                            </div>

                            <div id="featureContainer">
                                @php
                                    $features = old('features', ['']);
                                @endphp

                                @foreach ($features as $index => $feature)
                                    <div
                                        class="feature-row
                                               row g-2
                                               align-items-start
                                               mb-3"
                                    >
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-check"></i>
                                                </span>

                                                <input
                                                    type="text"
                                                    name="features[]"
                                                    value="{{ $feature }}"
                                                    class="form-control
                                                        @error(
                                                            'features.' .
                                                            $index
                                                        )
                                                            is-invalid
                                                        @enderror"
                                                    placeholder="Enter feature"
                                                >
                                            </div>

                                            @error('features.' . $index)
                                                <div class="text-danger small mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-auto">
                                            <button
                                                type="button"
                                                class="btn btn-danger
                                                       remove-feature"
                                                title="Delete feature"
                                                aria-label="Delete feature"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @error('features')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Video --}}
                        <div>
                            <label
                                for="video_link"
                                class="form-label fw-semibold"
                            >
                                Video Link
                            </label>

                            <input
                                type="url"
                                id="video_link"
                                name="video_link"
                                value="{{ old('video_link') }}"
                                class="form-control
                                    @error('video_link') is-invalid @enderror"
                                placeholder="https://www.youtube.com/watch?v=..."
                            >

                            <small class="text-muted">
                                Enter a valid YouTube, Vimeo or video URL.
                            </small>

                            @error('video_link')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            {{-- Right content --}}
            <div class="col-xl-4 col-lg-5">

                {{-- Images --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="fw-semibold mb-0">
                            Adventure Images
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        {{-- Image one --}}
                        <div class="mb-4">
                            <label
                                for="image_one"
                                class="form-label fw-semibold"
                            >
                                First Image
                            </label>

                            <input
                                type="file"
                                id="image_one"
                                name="image_one"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="form-control
                                    @error('image_one') is-invalid @enderror"
                            >

                            <small class="text-muted">
                                JPG, JPEG, PNG or WEBP. Maximum 5 MB.
                            </small>

                            @error('image_one')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div
                                id="imageOnePreview"
                                class="mt-3"
                            ></div>
                        </div>

                        {{-- Image two --}}
                        <div>
                            <label
                                for="image_two"
                                class="form-label fw-semibold"
                            >
                                Second Image
                            </label>

                            <input
                                type="file"
                                id="image_two"
                                name="image_two"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="form-control
                                    @error('image_two') is-invalid @enderror"
                            >

                            <small class="text-muted">
                                JPG, JPEG, PNG or WEBP. Maximum 5 MB.
                            </small>

                            @error('image_two')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div
                                id="imageTwoPreview"
                                class="mt-3"
                            ></div>
                        </div>

                    </div>
                </div>

                {{-- Publish --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="fw-semibold mb-0">
                            Publish Settings
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        <div class="mb-4">
                            <label
                                for="status"
                                class="form-label fw-semibold"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="form-select
                                    @error('status') is-invalid @enderror"
                            >
                                <option
                                    value="active"
                                    @selected(
                                        old('status', 'active')
                                        === 'active'
                                    )
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    @selected(
                                        old('status') === 'inactive'
                                    )
                                >
                                    Inactive
                                </option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                            @disabled($categories->isEmpty())
                        >
                            <i class="fas fa-save me-2"></i>
                            Save Adventure
                        </button>

                        <a
                            href="{{ route('admin.adventures.index') }}"
                            class="btn btn-light w-100 mt-2"
                        >
                            Cancel
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </form>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        const featureContainer =
            document.getElementById('featureContainer');

        const addFeatureButton =
            document.getElementById('addFeatureButton');

        /*
        |--------------------------------------------------------------------------
        | Create one feature row
        |--------------------------------------------------------------------------
        */

        function createFeatureRow() {
            const row = document.createElement('div');

            row.className =
                'feature-row row g-2 align-items-start mb-3';

            row.innerHTML = `
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-check"></i>
                        </span>

                        <input
                            type="text"
                            name="features[]"
                            class="form-control"
                            placeholder="Enter feature"
                        >
                    </div>
                </div>

                <div class="col-auto">
                    <button
                        type="button"
                        class="btn btn-danger remove-feature"
                        title="Delete feature"
                        aria-label="Delete feature"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

            return row;
        }

        /*
        |--------------------------------------------------------------------------
        | Add one feature
        |--------------------------------------------------------------------------
        */

        addFeatureButton.addEventListener('click', function () {
            const rows =
                featureContainer.querySelectorAll('.feature-row');

            if (rows.length >= 10) {
                alert('You can add a maximum of 10 features.');
                return;
            }

            const newRow = createFeatureRow();

            featureContainer.appendChild(newRow);

            const newInput = newRow.querySelector(
                'input[name="features[]"]'
            );

            newInput.focus();
        });

        /*
        |--------------------------------------------------------------------------
        | Delete one feature
        |--------------------------------------------------------------------------
        */

        featureContainer.addEventListener('click', function (event) {
            const removeButton =
                event.target.closest('.remove-feature');

            if (!removeButton) {
                return;
            }

            const rows =
                featureContainer.querySelectorAll('.feature-row');

            if (rows.length === 1) {
                const input = rows[0].querySelector(
                    'input[name="features[]"]'
                );

                input.value = '';
                input.focus();

                return;
            }

            const currentRow =
                removeButton.closest('.feature-row');

            currentRow.remove();
        });

        /*
        |--------------------------------------------------------------------------
        | Image preview
        |--------------------------------------------------------------------------
        */

        function setupImagePreview(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            if (!input || !preview) {
                return;
            }

            input.addEventListener('change', function () {
                preview.innerHTML = '';

                const file = this.files[0];

                if (!file || !file.type.startsWith('image/')) {
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    const image = document.createElement('img');

                    image.src = event.target.result;
                    image.alt = 'Selected adventure image';
                    image.className = 'image-preview';

                    preview.appendChild(image);
                };

                reader.readAsDataURL(file);
            });
        }

        setupImagePreview(
            'image_one',
            'imageOnePreview'
        );

        setupImagePreview(
            'image_two',
            'imageTwoPreview'
        );
    });
</script>
@endsection