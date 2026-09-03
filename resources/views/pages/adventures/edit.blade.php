@extends('admin.layouts.app')

@section('title', 'Edit Adventure')

@section('content')
<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Edit Adventure
            </h2>

            <p class="text-muted mb-0">
                Update adventure content, features, video and images.
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct these errors:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route(
            'admin.adventures.update',
            $adventure
        ) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-semibold mb-0">
                            Adventure Information
                        </h5>
                    </div>

                    <div class="card-body p-4">

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
                                    Select Category
                                </option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected(
                                            old(
                                                'adventure_category_id',
                                                $adventure
                                                    ->adventure_category_id
                                            ) == $category->id
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
                        </div>

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
                                value="{{ old(
                                    'title',
                                    $adventure->title
                                ) }}"
                                class="form-control
                                    @error('title') is-invalid @enderror"
                            >

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

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
                            >{{ old(
                                'description',
                                $adventure->description
                            ) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                <div>
                                    <label class="form-label fw-semibold mb-1">
                                        Adventure Features
                                    </label>

                                    <p class="small text-muted mb-0">
                                        Add and delete features one by one.
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
                                    $features = old(
                                        'features',
                                        $adventure->features ?? ['']
                                    );
                                    if (!is_array($features) || empty($features)) {
                                        $features = [''];
                                    }
                                @endphp

                                @foreach ($features as $index => $feature)
                                    <div class="feature-row row g-2 align-items-start mb-3">
                                        <div class="col">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-check"></i>
                                                </span>

                                                <input
                                                    type="text"
                                                    name="features[]"
                                                    value="{{ $feature }}"
                                                    class="form-control @error('features.' . $index) is-invalid @enderror"
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
                                                class="btn btn-danger remove-feature"
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
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

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
                                value="{{ old(
                                    'video_link',
                                    $adventure->video_link
                                ) }}"
                                class="form-control
                                    @error('video_link') is-invalid @enderror"
                            >

                            @error('video_link')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-lg-4">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-semibold mb-0">
                            Adventure Images
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        {{-- First Image --}}
                        <div class="mb-4">
                            <label
                                for="image_one"
                                class="form-label fw-semibold mb-2"
                            >
                                First Image (Cover)
                            </label>

                            <div class="ts-image-preview-box">
                                <img
                                    src="{{ $adventure->image_one ? asset('storage/' . $adventure->image_one) : '' }}"
                                    alt="First Image preview"
                                    id="imageOnePreview"
                                    class="ts-image-preview {{ $adventure->image_one ? '' : 'ts-hidden' }}"
                                >

                                <div
                                    id="imageOnePlaceholder"
                                    class="ts-image-placeholder {{ $adventure->image_one ? 'ts-hidden' : '' }}"
                                >
                                    <span class="ts-image-placeholder-icon">✦</span>
                                    <strong>No image selected</strong>
                                    <small>JPG, JPEG, PNG, WEBP or AVIF &middot; Max 5 MB</small>
                                </div>
                            </div>

                            <label for="image_one" class="ts-upload-label d-block text-center rounded-3 mb-1" style="cursor: pointer;">
                                <i class="fas fa-cloud-arrow-up me-1"></i> {{ $adventure->image_one ? 'Change First Image' : 'Choose First Image' }}
                            </label>

                            <input
                                type="file"
                                id="image_one"
                                name="image_one"
                                accept=".jpg,.jpeg,.png,.webp,.avif,image/*"
                                class="ts-file-input @error('image_one') is-invalid @enderror"
                            >

                            @if ($adventure->image_one)
                                <div id="imageOneCurrentInfo" class="small text-muted mt-1 text-truncate" title="{{ $adventure->image_one }}">
                                    <i class="fas fa-image me-1 text-primary"></i> Current: <strong>{{ basename($adventure->image_one) }}</strong>
                                </div>
                            @endif
                            <div id="imageOneFileName" class="small text-success mt-1 ts-hidden"></div>

                            @error('image_one')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Second Image --}}
                        <div>
                            <label
                                for="image_two"
                                class="form-label fw-semibold mb-2"
                            >
                                Second Image
                            </label>

                            <div class="ts-image-preview-box">
                                <img
                                    src="{{ $adventure->image_two ? asset('storage/' . $adventure->image_two) : '' }}"
                                    alt="Second Image preview"
                                    id="imageTwoPreview"
                                    class="ts-image-preview {{ $adventure->image_two ? '' : 'ts-hidden' }}"
                                >

                                <div
                                    id="imageTwoPlaceholder"
                                    class="ts-image-placeholder {{ $adventure->image_two ? 'ts-hidden' : '' }}"
                                >
                                    <span class="ts-image-placeholder-icon">✦</span>
                                    <strong>No image selected</strong>
                                    <small>JPG, JPEG, PNG, WEBP or AVIF &middot; Max 5 MB</small>
                                </div>
                            </div>

                            <label for="image_two" class="ts-upload-label d-block text-center rounded-3 mb-1" style="cursor: pointer;">
                                <i class="fas fa-cloud-arrow-up me-1"></i> {{ $adventure->image_two ? 'Change Second Image' : 'Choose Second Image' }}
                            </label>

                            <input
                                type="file"
                                id="image_two"
                                name="image_two"
                                accept=".jpg,.jpeg,.png,.webp,.avif,image/*"
                                class="ts-file-input @error('image_two') is-invalid @enderror"
                            >

                            @if ($adventure->image_two)
                                <div id="imageTwoCurrentInfo" class="small text-muted mt-1 text-truncate" title="{{ $adventure->image_two }}">
                                    <i class="fas fa-image me-1 text-primary"></i> Current: <strong>{{ basename($adventure->image_two) }}</strong>
                                </div>
                            @endif
                            <div id="imageTwoFileName" class="small text-success mt-1 ts-hidden"></div>

                            @error('image_two')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
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
                                        old(
                                            'status',
                                            $adventure->status
                                        ) === 'active'
                                    )
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    @selected(
                                        old(
                                            'status',
                                            $adventure->status
                                        ) === 'inactive'
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
                        >
                            <i class="fas fa-save me-2"></i>
                            Update Adventure
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const featureContainer = document.getElementById('featureContainer');
        const addFeatureButton = document.getElementById('addFeatureButton');

        function createFeatureRow() {
            const row = document.createElement('div');
            row.className = 'feature-row row g-2 align-items-start mb-3';
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
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;
            return row;
        }

        if (addFeatureButton && featureContainer) {
            addFeatureButton.addEventListener('click', function () {
                const rows = featureContainer.querySelectorAll('.feature-row');

                if (rows.length >= 10) {
                    alert('You can add a maximum of 10 features.');
                    return;
                }

                const newRow = createFeatureRow();
                featureContainer.appendChild(newRow);

                const newInput = newRow.querySelector('input[name="features[]"]');
                if (newInput) {
                    newInput.focus();
                }
            });

            featureContainer.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.remove-feature');
                if (!removeButton) {
                    return;
                }

                const rows = featureContainer.querySelectorAll('.feature-row');
                if (rows.length === 1) {
                    const input = rows[0].querySelector('input[name="features[]"]');
                    if (input) {
                        input.value = '';
                        input.focus();
                    }
                    return;
                }

                const currentRow = removeButton.closest('.feature-row');
                if (currentRow) {
                    currentRow.remove();
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Image preview setup
        |--------------------------------------------------------------------------
        */

        function setupImagePreview(inputId, previewId, placeholderId, fileNameId, currentInfoId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const fileName = fileNameId ? document.getElementById(fileNameId) : null;
            const currentInfo = currentInfoId ? document.getElementById(currentInfoId) : null;

            if (!input || !preview) {
                return;
            }

            input.addEventListener('change', function () {
                const file = this.files && this.files[0];

                if (!file) {
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file (JPG, PNG, WEBP, AVIF).');
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    preview.src = event.target.result;
                    preview.classList.remove('ts-hidden');

                    if (placeholder) {
                        placeholder.classList.add('ts-hidden');
                    }

                    if (fileName) {
                        fileName.innerHTML = `<i class="fas fa-check-circle me-1"></i> New: <strong>${file.name}</strong> (${(file.size / 1024).toFixed(1)} KB)`;
                        fileName.classList.remove('ts-hidden');
                    }

                    if (currentInfo) {
                        currentInfo.classList.add('ts-hidden');
                    }
                };

                reader.readAsDataURL(file);
            });
        }

        setupImagePreview('image_one', 'imageOnePreview', 'imageOnePlaceholder', 'imageOneFileName', 'imageOneCurrentInfo');
        setupImagePreview('image_two', 'imageTwoPreview', 'imageTwoPlaceholder', 'imageTwoFileName', 'imageTwoCurrentInfo');
    });
</script>
@endpush