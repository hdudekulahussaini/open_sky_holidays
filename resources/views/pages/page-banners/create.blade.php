@extends('admin.layouts.app')

@section('title', 'Create Page Banner')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between
                   align-items-center mb-4"
        >
            <h2>Create Page Banner</h2>

            <a
                href="{{ route('admin.page-banners.index') }}"
                class="btn btn-secondary"
            >
                Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                Please correct the errors below.
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form
                    action="{{ route(
                        'admin.page-banners.store'
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    @if(empty($availablePages))
                        <div class="alert alert-warning mb-4">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            All page banners for site pages have already been created. You can manage existing banners from the <a href="{{ route('admin.page-banners.index') }}" class="alert-link">Page Banners List</a>.
                        </div>
                    @endif

                    <div class="mb-3">
                        <label
                            for="page"
                            class="form-label"
                        >
                            Page Name <span class="text-danger">*</span>
                        </label>

                        <select
                            id="page"
                            name="page"
                            class="form-select
                                @error('page') is-invalid @enderror"
                            @if(empty($availablePages)) disabled @endif
                        >
                            <option value="">Select an option</option>
                            @foreach ($availablePages as $slug => $label)
                                <option
                                    value="{{ $slug }}"
                                    @selected(old('page') == $slug)
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted">
                            Pages with existing banners are automatically hidden from this list.
                        </small>

                        @error('page')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label
                            for="label"
                            class="form-label"
                        >
                            Small Label
                        </label>

                        <input
                            type="text"
                            id="label"
                            name="label"
                            class="form-control
                                @error('label') is-invalid @enderror"
                            value="{{ old('label') }}"
                            placeholder="WHO WE ARE"
                        >

                        @error('label')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label
                            for="title"
                            class="form-label"
                        >
                            Banner Title
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-control
                                @error('title') is-invalid @enderror"
                            value="{{ old('title') }}"
                            placeholder="About Us"
                        >

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label
                            for="description"
                            class="form-label"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="form-control
                                @error('description') is-invalid @enderror"
                            placeholder="Enter banner description"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label
                            for="breadcrumb_title"
                            class="form-label"
                        >
                            Breadcrumb Title
                        </label>

                        <input
                            type="text"
                            id="breadcrumb_title"
                            name="breadcrumb_title"
                            class="form-control
                                @error('breadcrumb_title') is-invalid @enderror"
                            value="{{ old('breadcrumb_title') }}"
                            placeholder="About Us"
                        >

                        @error('breadcrumb_title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label
                            for="image"
                            class="form-label"
                        >
                            Banner Background Image
                        </label>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="form-control
                                @error('image') is-invalid @enderror"
                        >

                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <input
                        type="hidden"
                        name="status"
                        value="0"
                    >

                    <div class="form-check mb-4">
                        <input
                            type="checkbox"
                            id="status"
                            name="status"
                            value="1"
                            class="form-check-input"
                            @checked(old('status', 1))
                        >

                        <label
                            for="status"
                            class="form-check-label"
                        >
                            Active
                        </label>
                    </div>

                    <div class="d-flex gap-2">
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Save Page Banner
                        </button>

                        <a
                            href="{{ route('admin.page-banners.index') }}"
                            class="btn btn-light"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection