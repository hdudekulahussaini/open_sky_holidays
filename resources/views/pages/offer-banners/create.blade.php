@extends('admin.layouts.app')

@section('title', 'Create Offer Banner')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="mb-1">
                Create Offer Banner
            </h2>

            <p class="text-muted mb-0">
                Add a new promotional deal to the website.
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
        action="{{ route('admin.offer-banners.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

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
                                value="{{ old('title') }}"
                                class="form-control
                                    @error('title') is-invalid @enderror"
                                placeholder="Example: Savings Worldwide"
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
                                value="{{ old('discount_text') }}"
                                class="form-control
                                    @error('discount_text') is-invalid @enderror"
                                placeholder="Example: 20% Off"
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
                                value="{{ old('subtitle') }}"
                                class="form-control
                                    @error('subtitle') is-invalid @enderror"
                                placeholder="Example: Discover Great Deals"
                            >

                            @error('subtitle')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label
                                for="image"
                                class="form-label fw-semibold"
                            >
                                Offer Image
                                <span class="text-danger">*</span>
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
                                JPG, JPEG, PNG or WEBP. Maximum size: 5 MB.
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
                                    @selected(old('status', '1') === '1')
                                >
                                    Active
                                </option>

                                <option
                                    value="0"
                                    @selected(old('status') === '0')
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
                            Save Offer Banner
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