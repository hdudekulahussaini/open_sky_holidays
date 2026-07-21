@csrf

<div class="admin-form-grid">

    {{-- Category Name --}}
    <div class="admin-form-group">
        <label for="name">
            Category Name
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name"
            class="admin-form-control
                @error('name') is-invalid @enderror"
            value="{{ old(
                'name',
                $category->name ?? ''
            ) }}"
            placeholder="Example: Travel Tips"
            required
        >

        @error('name')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Slug --}}
    <div class="admin-form-group">
        <label for="slug">
            Slug
        </label>

        <input
            type="text"
            name="slug"
            id="slug"
            class="admin-form-control
                @error('slug') is-invalid @enderror"
            value="{{ old(
                'slug',
                $category->slug ?? ''
            ) }}"
            placeholder="travel-tips"
        >

        <small>
            Leave empty to generate automatically.
        </small>

        @error('slug')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>

{{-- Form Actions --}}
<div class="admin-form-actions">
    <a
        href="{{ route('admin.categories.index') }}"
        class="btn btn-light"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="btn btn-primary"
    >
        {{ $buttonText ?? 'Save Category' }}
    </button>
</div>