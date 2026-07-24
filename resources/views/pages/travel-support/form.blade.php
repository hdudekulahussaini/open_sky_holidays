@php
    $featureValues = old(
        'features',
        isset($travelSupport) && is_array($travelSupport->features) ? $travelSupport->features : [''],
    );
@endphp

<div class="ts-form-grid">
    <div class="ts-form-main">

        {{-- Small Heading --}}
        <div class="ts-form-group">
            <label for="small_heading" class="ts-label">
                Small Heading
            </label>

            <input type="text" name="small_heading" id="small_heading"
                class="ts-input @error('small_heading') ts-input-error @enderror"
                value="{{ old('small_heading', $travelSupport->small_heading ?? '') }}"
                placeholder="Example: Complete Assistance">

            @error('small_heading')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Main Heading --}}
        <div class="ts-form-group">
            <label for="heading" class="ts-label">
                Main Heading
                <span class="ts-required">*</span>
            </label>

            <input type="text" name="heading" id="heading"
                class="ts-input @error('heading') ts-input-error @enderror"
                value="{{ old('heading', $travelSupport->heading ?? '') }}"
                placeholder="Example: Travel Support At Every Step">

            @error('heading')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Description --}}
        <div class="ts-form-group">
            <label for="description" class="ts-label">
                Description
            </label>

            <textarea name="description" id="description" rows="6"
                class="ts-textarea @error('description') ts-input-error @enderror" placeholder="Enter travel support description">{{ old('description', $travelSupport->description ?? '') }}</textarea>

            @error('description')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Features --}}
        <div class="ts-form-group">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">
                        Features
                        <span class="ts-required">*</span>
                    </label>

                    <p class="ts-field-note">
                        Add any number of travel support features.
                    </p>
                </div>

                <button type="button" class="ts-add-feature-btn" id="addFeatureButton">
                    <span>+</span>
                    Add Feature
                </button>
            </div>

            <div id="featuresContainer" class="ts-features-container">
                @foreach ($featureValues as $index => $feature)
                    <div class="ts-feature-row">
                        <div class="ts-feature-number">
                            {{ $index + 1 }}
                        </div>

                        <input type="text" name="features[]"
                            class="ts-input ts-feature-input
                                @error('features.' . $index) ts-input-error @enderror"
                            value="{{ $feature }}" placeholder="Enter feature">

                        <button type="button" class="ts-remove-feature-btn" title="Remove feature">
                            ×
                        </button>

                        @error('features.' . $index)
                            <span class="ts-error-message ts-feature-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                @endforeach
            </div>

            @error('features')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="ts-form-sidebar">

        {{-- Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Section Image</h3>
                <p>Upload the travel support image.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($travelSupport) && $travelSupport->image ? asset('storage/' . $travelSupport->image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview
                        {{ isset($travelSupport) && $travelSupport->image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder"
                    class="ts-image-placeholder
                        {{ isset($travelSupport) && $travelSupport->image ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">✦</span>
                    <strong>No image selected</strong>
                    <small>JPG, PNG or WEBP</small>
                </div>
            </div>

            <label for="image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="image" id="image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp">

            @error('image')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror

            @if (isset($travelSupport) && $travelSupport->image)
                <label class="ts-remove-image-option">
                    <input type="checkbox" name="remove_image" value="1">

                    <span>Remove current image</span>
                </label>
            @endif
        </div>

        {{-- Status --}}
        <div class="admin-form-group">

            <label for="status">
                Status
                <span class="required">*</span>
            </label>

            <select id="status" name="status"
                class="admin-form-control
                                @error('status') is-invalid @enderror"
                required>
                <option value="1" @selected(old('status', 1) == 1)>
                    Active
                </option>

                <option value="0" @selected(old('status', 1) == 0)>
                    Inactive
                </option>
            </select>

            @error('status')
                <span class="admin-form-error">
                    {{ $message }}
                </span>
            @enderror

        </div>
    </div>
</div>



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('featuresContainer');
            const addButton = document.getElementById('addFeatureButton');
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePlaceholder = document.getElementById('imagePlaceholder');

            function updateFeatureNumbers() {
                const rows = container.querySelectorAll('.ts-feature-row');

                rows.forEach(function(row, index) {
                    const number = row.querySelector('.ts-feature-number');

                    if (number) {
                        number.textContent = index + 1;
                    }
                });
            }

            function createFeatureRow() {
                const row = document.createElement('div');

                row.className = 'ts-feature-row';

                row.innerHTML = `
            <div class="ts-feature-number"></div>

            <input
                type="text"
                name="features[]"
                class="ts-input ts-feature-input"
                placeholder="Enter feature"
            >

            <button
                type="button"
                class="ts-remove-feature-btn"
                title="Remove feature"
            >
                ×
            </button>
        `;

                container.appendChild(row);
                updateFeatureNumbers();

                row.querySelector('.ts-feature-input').focus();
            }

            addButton.addEventListener('click', createFeatureRow);

            container.addEventListener('click', function(event) {
                const removeButton = event.target.closest(
                    '.ts-remove-feature-btn'
                );

                if (!removeButton) {
                    return;
                }

                const rows = container.querySelectorAll('.ts-feature-row');

                if (rows.length === 1) {
                    const input = rows[0].querySelector('input');
                    input.value = '';
                    input.focus();
                    return;
                }

                removeButton.closest('.ts-feature-row').remove();
                updateFeatureNumbers();
            });

            imageInput.addEventListener('change', function() {
                const file = this.files[0];

                if (!file) {
                    return;
                }

                const reader = new FileReader();

                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    imagePreview.classList.remove('ts-hidden');
                    imagePlaceholder.classList.add('ts-hidden');
                };

                reader.readAsDataURL(file);
            });

            updateFeatureNumbers();
        });
    </script>
@endpush
