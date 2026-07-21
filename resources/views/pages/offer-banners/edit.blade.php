@extends('admin.layouts.app')

@section('title', 'Edit Offer Banner')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="mb-1">
                Edit Offer Banner
            </h2>

            <p class="text-muted mb-0">
                Update this promotional offer.
            </p>
        </div>

        <a
            href="{{ route('admin.offer-banners.index') }}"
            class="btn btn-outline-secondary"
        >
            Back
        </a>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form
        action="{{ route(
            'admin.offer-banners.update',
            $offerBanner
        ) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            Offer Information
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-4">
                            <label
                                for="title"
                                class="form-label fw-semibold"
                            >
                                Title
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old(
                                    'title',
                                    $offerBanner->title
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
                                for="discount_text"
                                class="form-label fw-semibold"
                            >
                                Discount Text
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="discount_text"
                                id="discount_text"
                                value="{{ old(
                                    'discount_text',
                                    $offerBanner->discount_text
                                ) }}"
                                class="form-control
                                    @error('discount_text') is-invalid @enderror"
                            >

                            @error('discount_text')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label
                                for="subtitle"
                                class="form-label fw-semibold"
                            >
                                Subtitle
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="subtitle"
                                id="subtitle"
                                value="{{ old(
                                    'subtitle',
                                    $offerBanner->subtitle
                                ) }}"
                                class="form-control
                                    @error('subtitle') is-invalid @enderror"
                            >

                            @error('subtitle')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if ($offerBanner->image)
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Current Image
                                </label>

                                <div>
                                    <img
                                        src="{{ asset(
                                            'storage/' . $offerBanner->image
                                        ) }}"
                                        alt="{{ $offerBanner->title }}"
                                        class="rounded border"
                                        style="
                                            width: 100%;
                                            max-width: 450px;
                                            height: 260px;
                                            object-fit: cover;
                                        "
                                    >
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label
                                for="image"
                                class="form-label fw-semibold"
                            >
                                Replace Image
                            </label>

                            <input
                                type="file"
                                name="image"
                                id="image"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="form-control
                                    @error('image') is-invalid @enderror"
                            >

                            <div class="form-text">
                                Leave empty to keep the current image.
                                Maximum size: 5 MB.
                            </div>

                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            Publishing Settings
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="mb-4">
                            <label
                                for="status"
                                class="form-label fw-semibold"
                            >
                                Status
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select
                                    @error('status') is-invalid @enderror"
                            >
                                <option
                                    value="1"
                                    @selected(
                                        (string) old(
                                            'status',
                                            $offerBanner->status ? '1' : '0'
                                        ) === '1'
                                    )
                                >
                                    Active
                                </option>

                                <option
                                    value="0"
                                    @selected(
                                        (string) old(
                                            'status',
                                            $offerBanner->status ? '1' : '0'
                                        ) === '0'
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
                            Update Offer Banner
                        </button>

                        <a
                            href="{{ route(
                                'admin.offer-banners.index'
                            ) }}"
                            class="btn btn-light border w-100 mt-2"
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