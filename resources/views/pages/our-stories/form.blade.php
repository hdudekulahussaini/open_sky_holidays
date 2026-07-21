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
            ]
    );

    $existingImages = $ourStory->images ?? [];
@endphp

<div class="admin-form-grid">
   {{-- Main Heading --}}
    <div class="admin-form-group">
        <label for="heading">
            Main Heading
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="heading"
            id="heading"
            value="{{ old('heading', $ourStory->heading ?? '') }}"
            class="admin-form-control @error('heading') is-invalid @enderror"
            maxlength="255"
            placeholder="Enter main heading"
            required
        >

        @error('heading')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Description --}}
    <div class="admin-form-group admin-form-group-full">
        <label for="description">
            Description
        </label>

        <textarea
            name="description"
            id="description"
            rows="6"
            class="admin-form-control @error('description') is-invalid @enderror"
            placeholder="Enter story description"
        >{{ old('description', $ourStory->description ?? '') }}</textarea>

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Images --}}
    <div class="admin-form-group admin-form-group-full">
        <label for="storyImages">
            Story Images
        </label>

        <p class="form-help-text">
            Select up to 3 images. Supported formats: JPG, PNG and WebP.
        </p>

        <input
            type="file"
            name="images[]"
            id="storyImages"
            class="admin-form-control @error('images') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
            multiple
        >

        @error('images')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        @error('images.*')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <div
            id="storyImagePreview"
            class="story-image-preview"
        >
            @foreach ($existingImages as $image)
                <div
                    class="story-preview-item existing-image"
                    data-existing-image="{{ $image }}"
                >
                    <img
                        src="{{ asset('storage/' . $image) }}"
                        alt="Our Story image"
                    >

                    <button
                        type="button"
                        class="story-image-remove remove-existing-image"
                        aria-label="Remove image"
                    >
                        &times;
                    </button>
                </div>
            @endforeach
        </div>

        <div id="removedImagesContainer"></div>
    </div>

    {{-- Features --}}
    <div class="admin-form-group admin-form-group-full">
        <div class="feature-header">
            <div>
                <label>Features</label>

                <p class="form-help-text">
                    Add one or more feature headings and sub headings.
                </p>
            </div>

            <button
                type="button"
                id="addFeatureButton"
                class="admin-secondary-button"
            >
                + Add Feature
            </button>
        </div>

        <div id="featuresContainer">
            @foreach ($storyFeatures as $index => $feature)
                <div class="feature-item">
                    <div class="feature-item-header">
                        <strong class="feature-number">
                            Feature {{ $loop->iteration }}
                        </strong>

                        <button
                            type="button"
                            class="remove-feature-button"
                            aria-label="Remove feature"
                        >
                            &times;
                        </button>
                    </div>

                    <div class="feature-fields">
                        <div class="admin-form-group">
                            <label>
                                Feature Heading
                            </label>

                            <input
                                type="text"
                                name="features[{{ $index }}][heading]"
                                value="{{ $feature['heading'] ?? '' }}"
                                class="admin-form-control"
                                maxlength="255"
                                placeholder="Enter feature heading"
                            >
                        </div>

                        <div class="admin-form-group">
                            <label>
                                Feature Sub Heading
                            </label>

                            <input
                                type="text"
                                name="features[{{ $index }}][sub_heading]"
                                value="{{ $feature['sub_heading'] ?? '' }}"
                                class="admin-form-control"
                                maxlength="500"
                                placeholder="Enter feature sub heading"
                            >
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @error('features')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

        @error('features.*.heading')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror

        @error('features.*.sub_heading')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Status --}}
    <div class="admin-form-group admin-form-group-full">
        <label class="status-switch">
            <input
                type="checkbox"
                name="status"
                value="1"
                @checked(old('status', $ourStory->status ?? true))
            >

            <span class="status-slider"></span>

            <span class="status-label">
                Active status
            </span>
        </label>

        @error('status')
            <div class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

</div>

<div class="admin-form-actions">
    <a
        href="{{ route('admin.our-stories.index') }}"
        class="admin-cancel-button"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="admin-submit-button"
    >
        {{ isset($ourStory) ? 'Update Story' : 'Create Story' }}
    </button>
</div>



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const maxImages = 3;

    const imageInput = document.getElementById('storyImages');
    const previewContainer = document.getElementById('storyImagePreview');
    const removedImagesContainer = document.getElementById(
        'removedImagesContainer'
    );

    let selectedFiles = [];

    function getExistingImageCount() {
        return previewContainer.querySelectorAll(
            '.existing-image'
        ).length;
    }

    function renderSelectedImages() {
        previewContainer
            .querySelectorAll('.new-image')
            .forEach(function (item) {
                item.remove();
            });

        selectedFiles.forEach(function (file, index) {
            const reader = new FileReader();

            reader.onload = function (event) {
                const item = document.createElement('div');
                item.className = 'story-preview-item new-image';

                item.innerHTML = `
                    <img src="${event.target.result}" alt="Selected image">

                    <button
                        type="button"
                        class="story-image-remove remove-new-image"
                        data-index="${index}"
                        aria-label="Remove image"
                    >
                        &times;
                    </button>
                `;

                previewContainer.appendChild(item);
            };

            reader.readAsDataURL(file);
        });

        updateFileInput();
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();

        selectedFiles.forEach(function (file) {
            dataTransfer.items.add(file);
        });

        imageInput.files = dataTransfer.files;
    }

    imageInput.addEventListener('change', function () {
        const incomingFiles = Array.from(imageInput.files);

        const availableSlots =
            maxImages -
            getExistingImageCount() -
            selectedFiles.length;

        if (availableSlots <= 0) {
            alert('You can upload a maximum of 3 images.');
            imageInput.value = '';
            return;
        }

        if (incomingFiles.length > availableSlots) {
            alert(
                `You can select only ${availableSlots} more image(s).`
            );
        }

        incomingFiles
            .slice(0, availableSlots)
            .forEach(function (file) {
                const alreadySelected = selectedFiles.some(
                    function (selectedFile) {
                        return (
                            selectedFile.name === file.name &&
                            selectedFile.size === file.size &&
                            selectedFile.lastModified === file.lastModified
                        );
                    }
                );

                if (!alreadySelected) {
                    selectedFiles.push(file);
                }
            });

        renderSelectedImages();
    });

    previewContainer.addEventListener('click', function (event) {
        const newImageRemoveButton = event.target.closest(
            '.remove-new-image'
        );

        if (newImageRemoveButton) {
            const index = Number(
                newImageRemoveButton.dataset.index
            );

            selectedFiles.splice(index, 1);
            renderSelectedImages();

            return;
        }

        const existingImageRemoveButton = event.target.closest(
            '.remove-existing-image'
        );

        if (existingImageRemoveButton) {
            const item = existingImageRemoveButton.closest(
                '.existing-image'
            );

            const imagePath = item.dataset.existingImage;

            const hiddenInput = document.createElement('input');

            hiddenInput.type = 'hidden';
            hiddenInput.name = 'removed_images[]';
            hiddenInput.value = imagePath;

            removedImagesContainer.appendChild(hiddenInput);

            item.remove();
        }
    });

    /*
     * Dynamic features
     */
    const featuresContainer = document.getElementById(
        'featuresContainer'
    );

    const addFeatureButton = document.getElementById(
        'addFeatureButton'
    );

    function updateFeatureIndexes() {
        const featureItems = featuresContainer.querySelectorAll(
            '.feature-item'
        );

        featureItems.forEach(function (item, index) {
            const number = item.querySelector('.feature-number');

            if (number) {
                number.textContent = `Feature ${index + 1}`;
            }

            const headingInput = item.querySelector(
                '[data-feature-heading]'
            ) || item.querySelector(
                'input[name*="[heading]"]'
            );

            const subHeadingInput = item.querySelector(
                '[data-feature-sub-heading]'
            ) || item.querySelector(
                'input[name*="[sub_heading]"]'
            );

            if (headingInput) {
                headingInput.name =
                    `features[${index}][heading]`;
            }

            if (subHeadingInput) {
                subHeadingInput.name =
                    `features[${index}][sub_heading]`;
            }
        });
    }

    addFeatureButton.addEventListener('click', function () {
        const featureIndex =
            featuresContainer.querySelectorAll(
                '.feature-item'
            ).length;

        const featureItem = document.createElement('div');

        featureItem.className = 'feature-item';

        featureItem.innerHTML = `
            <div class="feature-item-header">
                <strong class="feature-number">
                    Feature ${featureIndex + 1}
                </strong>

                <button
                    type="button"
                    class="remove-feature-button"
                    aria-label="Remove feature"
                >
                    &times;
                </button>
            </div>

            <div class="feature-fields">
                <div class="admin-form-group">
                    <label>Feature Heading</label>

                    <input
                        type="text"
                        name="features[${featureIndex}][heading]"
                        data-feature-heading
                        class="admin-form-control"
                        maxlength="255"
                        placeholder="Enter feature heading"
                    >
                </div>

                <div class="admin-form-group">
                    <label>Feature Sub Heading</label>

                    <input
                        type="text"
                        name="features[${featureIndex}][sub_heading]"
                        data-feature-sub-heading
                        class="admin-form-control"
                        maxlength="500"
                        placeholder="Enter feature sub heading"
                    >
                </div>
            </div>
        `;

        featuresContainer.appendChild(featureItem);
    });

    featuresContainer.addEventListener('click', function (event) {
        const removeButton = event.target.closest(
            '.remove-feature-button'
        );

        if (!removeButton) {
            return;
        }

        const featureItems = featuresContainer.querySelectorAll(
            '.feature-item'
        );

        if (featureItems.length === 1) {
            const currentItem = featureItems[0];

            currentItem
                .querySelectorAll('input')
                .forEach(function (input) {
                    input.value = '';
                });

            return;
        }

        removeButton.closest('.feature-item').remove();

        updateFeatureIndexes();
    });

    updateFeatureIndexes();
});
</script>
@endpush