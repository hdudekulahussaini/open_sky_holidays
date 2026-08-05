@php
    $oldTitles = old('features_title', $aboutWhyChooseUs->features_title ?? ['']);
    $oldDescriptions = old('features_description', $aboutWhyChooseUs->features_description ?? ['']);
    // Ensure both arrays have the same length based on titles
    $featuresCount = max(count($oldTitles), 1);
@endphp

<div class="ts-form-grid">
    <div class="ts-form-main">

        {{-- Title --}}
        <div class="ts-form-group">
            <label for="title" class="ts-label">
                Title
                <span class="ts-required">*</span>
            </label>

            <input type="text" name="title" id="title"
                class="ts-input @error('title') ts-input-error @enderror"
                value="{{ old('title', $aboutWhyChooseUs->title ?? '') }}"
                placeholder="Example: Why Choose Open Sky">

            @error('title')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Subtitle --}}
        <div class="ts-form-group">
            <label for="subtitle" class="ts-label">
                Subtitle
            </label>

            <input type="text" name="subtitle" id="subtitle"
                class="ts-input @error('subtitle') ts-input-error @enderror"
                value="{{ old('subtitle', $aboutWhyChooseUs->subtitle ?? '') }}"
                placeholder="Example: The Best Agency">

            @error('subtitle')
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
                class="ts-textarea @error('description') ts-input-error @enderror" placeholder="Enter description">{{ old('description', $aboutWhyChooseUs->description ?? '') }}</textarea>

            @error('description')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Features Builder --}}
        <div class="ts-form-group">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">
                        Features
                    </label>

                    <p class="ts-field-note">
                        Add one or more features.
                    </p>
                </div>

                <button type="button" class="ts-add-feature-btn" id="addFeatureButton">
                    <span>+</span>
                    Add Feature
                </button>
            </div>

            <div id="featuresContainer" class="ts-features-container mt-3">
                @for ($index = 0; $index < $featuresCount; $index++)
                    <div class="feature-card border rounded-3 p-3 mb-3" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="feature-number fw-semibold mb-0">
                                Feature {{ $index + 1 }}
                            </h6>

                            <button type="button" class="btn btn-sm btn-outline-danger remove-feature" title="Delete feature">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>

                        <div class="feature-fields">
                            <div class="ts-form-group mb-3">
                                <label class="ts-label form-label fw-semibold">Feature Title <span class="ts-required">*</span></label>
                                <input type="text" name="features_title[]"
                                    value="{{ $oldTitles[$index] ?? '' }}" class="ts-input form-control @error('features_title.' . $index) ts-input-error @enderror"
                                    placeholder="24/7 Expert Support">
                                @error('features_title.' . $index)
                                    <span class="ts-error-message">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="ts-form-group mb-0">
                                <label class="ts-label form-label fw-semibold">Feature Description</label>
                                <textarea name="features_description[]" rows="3"
                                    class="ts-textarea form-control @error('features_description.' . $index) ts-input-error @enderror"
                                    placeholder="Enter feature description">{{ $oldDescriptions[$index] ?? '' }}</textarea>
                                @error('features_description.' . $index)
                                    <span class="ts-error-message">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            @error('features_title')
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
                <p>Upload the section image.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($aboutWhyChooseUs) && $aboutWhyChooseUs->image ? asset('storage/' . $aboutWhyChooseUs->image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview
                        {{ isset($aboutWhyChooseUs) && $aboutWhyChooseUs->image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder"
                    class="ts-image-placeholder
                        {{ isset($aboutWhyChooseUs) && $aboutWhyChooseUs->image ? 'ts-hidden' : '' }}">
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
                <option value="active" @selected(old('status', $aboutWhyChooseUs->status ?? 'active') == 'active')>
                    Active
                </option>

                <option value="inactive" @selected(old('status', $aboutWhyChooseUs->status ?? 'active') == 'inactive')>
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
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('featuresContainer');
        const addButton = document.getElementById('addFeatureButton');

        function updateNumbers() {
            const cards = container.querySelectorAll('.feature-card');
            cards.forEach(function (card, index) {
                const number = card.querySelector('.feature-number');
                if (number) {
                    number.textContent = `Feature ${index + 1}`;
                }
            });
        }

        addButton.addEventListener('click', function () {
            const count = container.querySelectorAll('.feature-card').length;
            if (count >= 10) {
                alert('Maximum 10 features are allowed.');
                return;
            }

            const card = document.createElement('div');
            card.className = 'feature-card border rounded-3 p-3 mb-3';
            card.style.cssText = 'background: #f8fafc; border-color: #e2e8f0 !important;';

            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="feature-number fw-semibold mb-0">Feature</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-feature" title="Delete feature">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
                <div class="feature-fields">
                    <div class="ts-form-group mb-3">
                        <label class="ts-label form-label fw-semibold">Feature Title <span class="ts-required">*</span></label>
                        <input type="text" name="features_title[]" class="ts-input form-control" placeholder="24/7 Expert Support">
                    </div>
                    <div class="ts-form-group mb-0">
                        <label class="ts-label form-label fw-semibold">Feature Description</label>
                        <textarea name="features_description[]" rows="3" class="ts-textarea form-control" placeholder="Enter feature description"></textarea>
                    </div>
                </div>
            `;

            container.appendChild(card);
            updateNumbers();
            card.querySelector('input[name="features_title[]"]').focus();
        });

        container.addEventListener('click', function (event) {
            const button = event.target.closest('.remove-feature');
            if (!button) return;

            const cards = container.querySelectorAll('.feature-card');
            if (cards.length === 1) {
                alert('At least one feature is required.');
                return;
            }

            button.closest('.feature-card').remove();
            updateNumbers();
        });

        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const imagePlaceholder = document.getElementById('imagePlaceholder');

        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function (event) {
                    imagePreview.src = event.target.result;
                    imagePreview.classList.remove('ts-hidden');
                    if (imagePlaceholder) imagePlaceholder.classList.add('ts-hidden');
                };
                reader.readAsDataURL(file);
            });
        }
    });
</script>
@endpush
