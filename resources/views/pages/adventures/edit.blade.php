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
                                        $adventure->features ?: ['']
                                    );
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

                            @error('image_one')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            @if ($adventure->image_one)
                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $adventure->image_one
                                    ) }}"
                                    alt="{{ $adventure->title }}"
                                    class="mt-3"
                                    style="
                                        width: 100%;
                                        height: 170px;
                                        object-fit: cover;
                                        border-radius: 10px;
                                    "
                                >
                            @endif

                            <div
                                id="imageOnePreview"
                                class="mt-3"
                            ></div>
                        </div>

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

                            @error('image_two')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            @if ($adventure->image_two)
                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $adventure->image_two
                                    ) }}"
                                    alt="{{ $adventure->title }}"
                                    class="mt-3"
                                    style="
                                        width: 100%;
                                        height: 170px;
                                        object-fit: cover;
                                        border-radius: 10px;
                                    "
                                >
                            @endif

                            <div
                                id="imageTwoPreview"
                                class="mt-3"
                            ></div>
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