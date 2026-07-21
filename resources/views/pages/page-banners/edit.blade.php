@extends('admin.layouts.app')

@section('title', 'Edit Page Banner')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between
                   align-items-center mb-4"
        >
            <h2>Edit Page Banner</h2>

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
                        'admin.page-banners.update',
                        $pageBanner
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label
                            for="page"
                            class="form-label"
                        >
                            Page Name
                        </label>

                        <input
                            type="text"
                            id="page"
                            name="page"
                            class="form-control
                                @error('page') is-invalid @enderror"
                            value="{{ old(
                                'page',
                                $pageBanner->page
                            ) }}"
                        >

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
                            value="{{ old(
                                'label',
                                $pageBanner->label
                            ) }}"
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
                            value="{{ old(
                                'title',
                                $pageBanner->title
                            ) }}"
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
                        >{{ old(
                            'description',
                            $pageBanner->description
                        ) }}</textarea>

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
                            value="{{ old(
                                'breadcrumb_title',
                                $pageBanner->breadcrumb_title
                            ) }}"
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
                            New Banner Image
                        </label>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp"
                            class="form-control
                                @error('image') is-invalid @enderror"
                        >

                        <small class="text-muted">
                            Leave empty to keep the current image.
                        </small>

                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        @if ($pageBanner->image)
                            <div class="mt-3">
                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $pageBanner->image
                                    ) }}"
                                    alt="{{ $pageBanner->title }}"
                                    width="400"
                                    style="
                                        max-width: 100%;
                                        border-radius: 10px;
                                    "
                                >
                            </div>
                        @endif
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
                            @checked(
                                old(
                                    'status',
                                    $pageBanner->status
                                )
                            )
                        >

                        <label
                            for="status"
                            class="form-check-label"
                        >
                            Active
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Page Banner
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection