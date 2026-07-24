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

            <div id="featuresContainer" class="ts-features-container">
                @foreach ($storyFeatures as $index => $feature)
                    <div class="feature-item">
                        <div class="feature-item-header">
                            <strong class="feature-number">
                                Feature {{ $loop->iteration }}
                            </strong>

                            <button type="button" class="remove-feature-button" aria-label="Remove feature">
                                ×
                            </button>
                        </div>

                        <div class="feature-fields">
                            <div class="ts-form-group">
                                <label class="ts-label">Feature Heading</label>
                                <input type="text" name="features[{{ $index }}][heading]"
                                    value="{{ $feature['heading'] ?? '' }}" class="ts-input"
                                    placeholder="Enter feature heading">
                            </div>

                            <div class="ts-form-group">
                                <label class="ts-label">Feature Sub Heading</label>
                                <input type="text" name="features[{{ $index }}][sub_heading]"
                                    value="{{ $feature['sub_heading'] ?? '' }}" class="ts-input"
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
                <p>Upload up to 3 images (JPG, PNG, WebP).</p>
            </div>

            <label for="storyImages" class="ts-upload-label">
                Choose Images (Max 3)
            </label>

            <input type="file" name="images[]" id="storyImages" class="ts-file-input"
                accept=".jpg,.jpeg,.png,.webp" multiple>

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

            <div id="storyImagePreview" class="story-image-preview">
                @foreach ($existingImages as $image)
                    <div class="story-preview-item existing-image" data-existing-image="{{ $image }}">
                        <img src="{{ asset('storage/' . $image) }}" alt="Story image">
                        <button type="button" class="story-image-remove remove-existing-image" aria-label="Remove image">&times;</button>
                    </div>
                @endforeach
            </div>

            <div id="removedImagesContainer"></div>
        </div>

        {{-- Status --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Publication Status</h3>
            </div>

            <div class="ts-form-group mb-0">
                <label for="status" class="ts-label">
                    Status
                    <span class="ts-required">*</span>
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
                    <span class="ts-error-message">
                        {{ $message }}
                    </span>
                @enderror
            </div>
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

    function renderSelectedImages() {
        previewContainer.querySelectorAll('.new-image').forEach(item => item.remove());

                selectedFiles.forEach(function(file, index) {
                    const reader = new FileReader();

            reader.onload = function (event) {
                const item = document.createElement('div');
                item.className = 'story-preview-item new-image';
                item.innerHTML = `
                    <img src="${event.target.result}" alt="Selected image">
                    <button type="button" class="story-image-remove remove-new-image" data-index="${index}" aria-label="Remove image">&times;</button>
                `;
                previewContainer.appendChild(item);
            };

                    reader.readAsDataURL(file);
                });

                updateFileInput();
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
        }
    });

    /* Features Repeater */
    const featuresContainer = document.getElementById('featuresContainer');
    const addFeatureButton = document.getElementById('addFeatureButton');

    function updateFeatureIndexes() {
        const featureItems = featuresContainer.querySelectorAll('.feature-item');
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
        const featureIndex = featuresContainer.querySelectorAll('.feature-item').length;
        const featureItem = document.createElement('div');
        featureItem.className = 'feature-item';

                featureItem.innerHTML = `
            <div class="feature-item-header">
                <strong class="feature-number">Feature ${featureIndex + 1}</strong>
                <button type="button" class="remove-feature-button" aria-label="Remove feature">&times;</button>
            </div>

            <div class="feature-fields">
                <div class="ts-form-group">
                    <label class="ts-label">Feature Heading</label>
                    <input type="text" name="features[${featureIndex}][heading]" class="ts-input" placeholder="Enter feature heading">
                </div>

                <div class="ts-form-group">
                    <label class="ts-label">Feature Sub Heading</label>
                    <input type="text" name="features[${featureIndex}][sub_heading]" class="ts-input" placeholder="Enter feature sub heading">
                </div>
            </div>
        `;

                featuresContainer.appendChild(featureItem);
            });

    featuresContainer.addEventListener('click', function (event) {
        const removeButton = event.target.closest('.remove-feature-button');
        if (!removeButton) return;

        const featureItems = featuresContainer.querySelectorAll('.feature-item');
        if (featureItems.length === 1) {
            featureItems[0].querySelectorAll('input').forEach(input => input.value = '');
            return;
        }

        removeButton.closest('.feature-item').remove();
        updateFeatureIndexes();
    });

            updateFeatureIndexes();
        });
    </script>
@endpush
