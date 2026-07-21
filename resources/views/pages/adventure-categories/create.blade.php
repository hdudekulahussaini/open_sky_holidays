@extends('admin.layouts.app')

@section('title', 'Create Adventure Category')

@section('content')
<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Create Adventure Category
            </h2>

            <p class="text-muted mb-0">
                Add a category such as Zip Lining, Paragliding or Rafting.
            </p>
        </div>

        <a
            href="{{ route('admin.adventure-categories.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fas fa-arrow-left me-2"></i>
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="fw-semibold mb-0">
                Category Information
            </h5>
        </div>

        <div class="card-body p-4">
            <form
                action="{{ route('admin.adventure-categories.store') }}"
                method="POST"
            >
                @csrf

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <label
                            for="name"
                            class="form-label fw-semibold"
                        >
                            Category Name
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control
                                @error('name') is-invalid @enderror"
                            placeholder="Zip Lining"
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label
                            for="slug"
                            class="form-label fw-semibold"
                        >
                            Slug
                        </label>

                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            value="{{ old('slug') }}"
                            class="form-control
                                @error('slug') is-invalid @enderror"
                            placeholder="zip-lining"
                        >

                        <small class="text-muted">
                            Leave empty to generate automatically from the name.
                        </small>

                        @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

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
                                old('status', 'active') === 'active'
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

                <div class="d-flex gap-2">
                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                    >
                        <i class="fas fa-save me-2"></i>
                        Save Category
                    </button>

                    <a
                        href="{{ route(
                            'admin.adventure-categories.index'
                        ) }}"
                        class="btn btn-light px-4"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection