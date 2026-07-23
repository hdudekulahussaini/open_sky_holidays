<div class="admin-form-grid">

    {{-- Tour Type Name --}}
    <div class="admin-form-group">
        <label for="name">
            Tour Type Name
            <span class="required">*</span>
        </label>

        <input type="text" name="name" id="name" value="{{ old('name', $tourType->name ?? '') }}"
            class="admin-form-control @error('name') is-invalid @enderror" maxlength="100" placeholder="Example: Domestic"
            required>

        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Slug --}}
    <div class="admin-form-group">
        <label for="slug">
            Slug
        </label>

        <input type="text" name="slug" id="slug" value="{{ old('slug', $tourType->slug ?? '') }}"
            class="admin-form-control @error('slug') is-invalid @enderror" maxlength="120"
            placeholder="Example: domestic">

        <p class="form-help-text">
            Leave empty to generate automatically from the tour type name.
        </p>

        @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

</div>

<div class="admin-form-actions">
    <a href="{{ route('admin.tour-types.index') }}" class="admin-cancel-button">
        Cancel
    </a>

    <button type="submit" class="admin-submit-button">
        {{ isset($tourType) ? 'Update Tour Type' : 'Create Tour Type' }}
    </button>
</div>
