@extends('admin.layouts.app')

@section('title', 'Edit Hero')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between
                   align-items-center mb-4"
        >
            <h2>Edit Hero</h2>

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
                    action="{{ route('admin.heroes.update', $hero) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

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
                            value="{{ old('title', $hero->title) }}"
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
                        >{{ old('description', $hero->description) }}</textarea>

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
                            New Image
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

                        @if ($hero->image)
                            <img
                                src="{{ asset('storage/' . $hero->image) }}"
                                alt="{{ $hero->title }}"
                                width="280"
                                class="mt-3 rounded"
                            >
                        @endif
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
                            value="{{ old('sort_order', $hero->sort_order) }}"
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
                            @checked(old('status', $hero->status))
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
                            Update Hero
                        </button>

                        <a
                            href="{{ route('admin.heroes.index') }}"
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