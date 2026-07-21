@extends('admin.layouts.app')

@section('title', 'Create Hero')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between
                   align-items-center mb-4"
        >
            <h2>Create Hero</h2>

            <a
                href="{{ route('admin.heroes.index') }}"
                class="btn btn-secondary"
            >
                Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form
                    action="{{ route('admin.heroes.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <div class="mb-3">
                        <label
                            for="title"
                            class="form-label"
                        >
                            Title
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-control
                                @error('title') is-invalid @enderror"
                            value="{{ old('title') }}"
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
                            rows="5"
                            class="form-control
                                @error('description') is-invalid @enderror"
                        >{{ old('description') }}</textarea>

                        @error('description')
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
                            Hero Image
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

                    <div class="mb-3">
                        <label
                            for="sort_order"
                            class="form-label"
                        >
                            Slider Order
                        </label>

                        <input
                            type="number"
                            id="sort_order"
                            name="sort_order"
                            min="0"
                            class="form-control
                                @error('sort_order') is-invalid @enderror"
                            value="{{ old('sort_order', 0) }}"
                        >

                        @error('sort_order')
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

                    <div class="form-check mb-3">
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

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save Hero
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection