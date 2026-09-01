@php
    $storyFeatures = old(
        'features',
        isset($ourStory) && !empty($ourStory->features)
            ? $ourStory->features
            : [
                [
                    'heading' => '',
                    'sub_heading' => '',
                ],
            ],
    );

    $existingImages = $ourStory->images ?? [];
@endphp

<div class="ts-form-grid">
    <div class="ts-form-main">



        {{-- Main Heading --}}
        <div class="ts-form-group">
            <label for="heading" class="ts-label">
                Main Heading
                <span class="ts-required">*</span>
            </label>

            <input type="text" name="heading" id="heading"
                class="ts-input @error('heading') ts-input-error @enderror"
                value="{{ old('heading', $ourStory->heading ?? '') }}"
                placeholder="Example: Crafted Experiences, Unforgettable Memories" required>

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
                class="ts-textarea @error('description') ts-input-error @enderror" placeholder="Enter story description">{{ old('description', $ourStory->description ?? '') }}</textarea>

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
                        Add one or more feature headings and sub headings.
                    </p>
                </div>

                <button type="button" class="ts-add-feature-btn" id="addFeatureButton">
                    <span>+</span>
                    Add Feature
                </button>
            </div>

                        <div id="featuresContainer" class="ts-features-container mt-3">
                @foreach ($storyFeatures as $index => $feature)
                    <div class="feature-card border rounded-3 p-3 mb-3" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="feature-number fw-semibold mb-0">
                                Feature {{ $loop->iteration }}
                            </h6>

                            <button type="button" class="btn btn-sm btn-outline-danger remove-feature-button" aria-label="Remove feature" title="Delete feature">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>

                        <div class="feature-fields">
                            <div class="ts-form-group mb-3">
                                <label class="ts-label form-label fw-semibold">Feature Heading</label>
                                <input type="text" name="features[{{ $index }}][heading]"
                                    value="{{ $feature['heading'] ?? '' }}" class="ts-input form-control"
                                    placeholder="Enter feature heading">
                            </div>

                            <div class="ts-form-group mb-0">
                                <label class="ts-label form-label fw-semibold">Feature Sub Heading</label>
                                <input type="text" name="features[{{ $index }}][sub_heading]"
                                    value="{{ $feature['sub_heading'] ?? '' }}" class="ts-input form-control"
                                    placeholder="Enter feature sub heading">
                            </div>
                        </div>
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

        {{-- Images --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Story Images</h3>
                <p>Upload up to 3 images (JPG, PNG, WebP, AVIF).</p>
            </div>

            <div class="ts-image-preview-box" style="padding: 1.5rem; text-align: center; border: 1px dashed #cbd5e1; border-radius: 12px; background-color: #f8fafc; margin-bottom: 1rem; height: auto; min-height: 205px; overflow: visible;">
                <div id="storyImagePreview" class="d-flex flex-wrap gap-2 justify-content-center">
                    @foreach ($existingImages as $image)
                        <div class="story-preview-item existing-image position-relative" data-existing-image="{{ $image }}">
                            <img src="{{ asset('storage/' . $image) }}" alt="Story image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <button type="button" class="story-image-remove remove-existing-image position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border-0" aria-label="Remove image">&times;</button>
                        </div>
                    @endforeach
                </div>

                <div id="imagePlaceholder" class="ts-image-placeholder {{ count($existingImages) > 0 ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">?</span>
                    <strong>No image selected</strong>
                    <small>JPG, PNG, WEBP or AVIF &middot; Max 5 MB</small>
                </div>
            </div>

            <label for="storyImages" class="ts-upload-label">
                Choose Images (Max 3)
            </label>

            <input type="file" name="images[]" id="storyImages" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp,.avif,image/*" multiple>

            @error('images')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror

            @error('images.*')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror

            <div id="removedImagesContainer"></div>
        </div>

        {{-- Status --}}
        <div class="admin-form-group">
            <label for="status">
                Status
                <span class="required">*</span>
            </label>

            <select id="status" name="status" class="admin-form-control @error('status') is-invalid @enderror" required>
                <option value="1" @selected(old('status', $ourStory->status ?? true) == true)>
                    Active
                </option>
                <option value="0" @selected(old('status', $ourStory->status ?? true) == false)>
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
    const maxImages = 3;
    const imageInput = document.getElementById('storyImages');
    const previewContainer = document.getElementById('storyImagePreview');
    const removedImagesContainer = document.getElementById('removedImagesContainer');

            let selectedFiles = [];

    function getExistingImageCount() {
        return previewContainer.querySelectorAll('.existing-image').length;
    }

    function checkPlaceholder() {
        const placeholder = document.getElementById('imagePlaceholder');
        if (placeholder) {
            if (getExistingImageCount() + selectedFiles.length === 0) {
                placeholder.classList.remove('ts-hidden');
            } else {
                placeholder.classList.add('ts-hidden');
            }
        }
    }

    function renderSelectedImages() {
        previewContainer.querySelectorAll('.new-image').forEach(item => item.remove());

                selectedFiles.forEach(function(file, index) {
                    const reader = new FileReader();

            reader.onload = function (event) {
                const item = document.createElement('div');
                item.className = 'story-preview-item new-image position-relative';
                item.innerHTML = `
                    <img src="${event.target.result}" alt="Selected image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <button type="button" class="story-image-remove remove-new-image position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border-0" data-index="${index}" aria-label="Remove image">&times;</button>
                `;
                previewContainer.appendChild(item);
                checkPlaceholder();
            };

                    reader.readAsDataURL(file);
                });

                updateFileInput();
                checkPlaceholder();
            }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }

    imageInput.addEventListener('change', function () {
        const incomingFiles = Array.from(imageInput.files);
        const availableSlots = maxImages - getExistingImageCount() - selectedFiles.length;

                if (availableSlots <= 0) {
                    alert('You can upload a maximum of 3 images.');
                    imageInput.value = '';
                    return;
                }

        if (incomingFiles.length > availableSlots) {
            alert(`You can select only ${availableSlots} more image(s).`);
        }

        incomingFiles.slice(0, availableSlots).forEach(function (file) {
            const alreadySelected = selectedFiles.some(selectedFile => 
                selectedFile.name === file.name && selectedFile.size === file.size && selectedFile.lastModified === file.lastModified
            );
            if (!alreadySelected) {
                selectedFiles.push(file);
            }
        });

                renderSelectedImages();
            });

    previewContainer.addEventListener('click', function (event) {
        const newImageRemoveButton = event.target.closest('.remove-new-image');
        if (newImageRemoveButton) {
            const index = Number(newImageRemoveButton.dataset.index);
            selectedFiles.splice(index, 1);
            renderSelectedImages();
            checkPlaceholder();
            return;
        }

        const existingImageRemoveButton = event.target.closest('.remove-existing-image');
        if (existingImageRemoveButton) {
            const item = existingImageRemoveButton.closest('.existing-image');
            const imagePath = item.dataset.existingImage;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'removed_images[]';
            hiddenInput.value = imagePath;
            removedImagesContainer.appendChild(hiddenInput);
            item.remove();
            checkPlaceholder();
        }
    });

    /* Features Repeater */
    const featuresContainer = document.getElementById('featuresContainer');
    const addFeatureButton = document.getElementById('addFeatureButton');

    function updateFeatureIndexes() {
        const featureItems = featuresContainer.querySelectorAll('.feature-card');
        featureItems.forEach(function (item, index) {
            const number = item.querySelector('.feature-number');
            if (number) {
                number.textContent = `Feature ${index + 1}`;
            }

            const headingInput = item.querySelector('input[name*="[heading]"]');
            const subHeadingInput = item.querySelector('input[name*="[sub_heading]"]');

            if (headingInput) headingInput.name = `features[${index}][heading]`;
            if (subHeadingInput) subHeadingInput.name = `features[${index}][sub_heading]`;
        });
    }

    addFeatureButton.addEventListener('click', function () {
        const featureIndex = featuresContainer.querySelectorAll('.feature-card').length;
                const featureItem = document.createElement('div');
        featureItem.className = 'feature-card border rounded-3 p-3 mb-3';
        featureItem.style.cssText = 'background: #f8fafc; border-color: #e2e8f0 !important;';

                featureItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="feature-number fw-semibold mb-0">Feature ${featureIndex + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger remove-feature-button" aria-label="Remove feature" title="Delete feature">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>

            <div class="feature-fields">
                <div class="ts-form-group mb-3">
                    <label class="ts-label form-label fw-semibold">Feature Heading</label>
                    <input type="text" name="features[${featureIndex}][heading]" class="ts-input form-control" placeholder="Enter feature heading">
                </div>

                <div class="ts-form-group mb-0">
                    <label class="ts-label form-label fw-semibold">Feature Sub Heading</label>
                    <input type="text" name="features[${featureIndex}][sub_heading]" class="ts-input form-control" placeholder="Enter feature sub heading">
                </div>
            </div>
        `;

                featuresContainer.appendChild(featureItem);
            });

    featuresContainer.addEventListener('click', function (event) {
        const removeButton = event.target.closest('.remove-feature-button');
        if (!removeButton) return;

        const featureItems = featuresContainer.querySelectorAll('.feature-card');
        if (featureItems.length === 1) {
            featureItems[0].querySelectorAll('input').forEach(input => input.value = '');
            return;
        }

        removeButton.closest('.feature-card').remove();
        updateFeatureIndexes();
    });

            updateFeatureIndexes();
        });
    </script>
@endpush




