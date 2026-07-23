@php
    $gallery = old('existing_gallery', isset($tourDetail) ? $tourDetail->gallery ?? [] : []);

    $gallery = is_array($gallery) ? $gallery : [];

    $selectedTourId = old('tour_id', $tourDetail->tour_id ?? request('tour_id'));
@endphp

<div class="td-form-layout">

    {{-- =====================================================
        MAIN FORM
    ====================================================== --}}
    <div class="td-form-main">

        <div class="td-form-card">

            <div class="td-card-header">
                <div>
                    <h2>Tour Information</h2>

                    <p>
                        Select the tour and enter its detailed information.
                    </p>
                </div>
            </div>

            <div class="td-card-body">

                {{-- Tour --}}
                <div class="td-form-group">

                    <label for="tour_id" class="td-label">
                        Tour
                        <span class="td-required">*</span>
                    </label>

                    <select name="tour_id" id="tour_id"
                        class="td-control
                            @error('tour_id')
                                td-control-error
                            @enderror"
                        required>
                        <option value="">
                            Select Tour
                        </option>

                        @foreach ($tours as $tour)
                            <option value="{{ $tour->id }}" @selected((string) $selectedTourId === (string) $tour->id)>
                                {{ $tour->title }}

                                @if ($tour->tourType)
                                    — {{ $tour->tourType->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @error('tour_id')
                        <span class="td-error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- Heading --}}
                <div class="td-form-group">

                    <label for="heading" class="td-label">
                        Heading
                        <span class="td-required">*</span>
                    </label>

                    <input type="text" name="heading" id="heading"
                        class="td-control
                            @error('heading')
                                td-control-error
                            @enderror"
                        value="{{ old('heading', $tourDetail->heading ?? '') }}"
                        placeholder="Example: Discover the beauty of Dubai" required>

                    @error('heading')
                        <span class="td-error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- Description --}}
                <div class="td-form-group td-form-group-last">

                    <label for="description" class="td-label">
                        Description
                        <span class="td-required">*</span>
                    </label>

                    <textarea name="description" id="description" rows="10"
                        class="td-control td-textarea
                            @error('description')
                                td-control-error
                            @enderror"
                        placeholder="Enter the complete tour description" required>{{ old('description', $tourDetail->description ?? '') }}</textarea>

                    <div class="td-field-footer">

                        <span>
                            Explain the tour experience clearly.
                        </span>

                        <span id="descriptionCounter">
                            0 characters
                        </span>

                    </div>

                    @error('description')
                        <span class="td-error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>

    </div>

    {{-- =====================================================
        SIDEBAR
    ====================================================== --}}
    <div class="td-form-sidebar">

        {{-- Gallery --}}
        <div class="td-form-card">

            <div class="td-card-header td-gallery-card-header">

                <div>
                    <h2>Gallery Images</h2>

                    <p>
                        Add gallery images one by one.
                    </p>
                </div>

                <button type="button" id="addGalleryImage" class="td-add-image-btn">
                    <span class="td-add-icon">+</span>
                    Add Image
                </button>

            </div>

            <div class="td-card-body">

                {{-- Gallery total --}}
                <div class="td-gallery-summary">

                    <span>
                        Selected images
                    </span>

                    <strong id="totalGalleryCount">
                        {{ count($gallery) }} / 10
                    </strong>

                </div>

                {{-- Existing Images --}}
                @if (count($gallery) > 0)

                    <div class="td-gallery-section" id="existingGallerySection">

                        <div class="td-gallery-title">

                            <span>
                                Existing Images
                            </span>

                            <span id="existingGalleryCount">
                                {{ count($gallery) }}
                            </span>

                        </div>

                        <div class="td-existing-gallery-grid" id="existingGallery">

                            @foreach ($gallery as $image)
                                <div class="td-existing-gallery-item">

                                    <img src="{{ asset('storage/' . $image) }}"
                                        alt="Tour gallery image">

                                    <input type="hidden" name="existing_gallery[]" value="{{ $image }}">

                                    <button type="button" class="td-remove-existing-image"
                                        aria-label="Remove existing image">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round">
                                            <path d="M18 6L6 18"></path>
                                            <path d="M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                </div>
                            @endforeach

                        </div>

                    </div>

                @endif

                {{-- New Image Inputs --}}
                <div class="td-gallery-section">

                    <div class="td-gallery-title">

                        <span>
                            New Images
                        </span>

                        <span id="newGalleryCount">
                            0
                        </span>

                    </div>

                    <div id="galleryImageContainer" class="td-image-input-list"></div>

                    <div id="emptyGalleryMessage" class="td-empty-gallery">
                        <span class="td-empty-gallery-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="3"></rect>

                                <circle cx="8.5" cy="8.5" r="1.5"></circle>

                                <path d="M21 15l-5-5L5 21"></path>
                            </svg>
                        </span>

                        <strong>
                            No new images added
                        </strong>

                        <p>
                            Click the “Add Image” button to select an image.
                        </p>
                    </div>

                </div>
                @error('gallery')
                    <span class="td-error-message">
                        {{ $message }}
                    </span>
                @enderror

                {{-- @error('gallery.*')
                    <span class="td-error-message">
                        {{ $message }}
                    </span>
                @enderror --}}

            </div>

        </div>

        {{-- Publishing --}}
        <div class="td-form-card">

            <div class="td-card-header">
                <div>
                    <h2>Publishing</h2>

                    <p>
                        Control tour detail visibility.
                    </p>
                </div>
            </div>

            <div class="td-card-body">

                <div class="td-form-group td-form-group-last">

                    <label for="status" class="td-label">
                        Status
                    </label>

                    <select name="status" id="status"
                        class="td-control
                            @error('status')
                                td-control-error
                            @enderror">
                        <option value="active" @selected(old('status', $tourDetail->status ?? 'active') === 'active')>
                            Active
                        </option>

                        <option value="inactive" @selected(old('status', $tourDetail->status ?? '') === 'inactive')>
                            Inactive
                        </option>
                    </select>

                    @error('status')
                        <span class="td-error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>

    </div>

</div>

{{-- =====================================================
    FORM ACTIONS
====================================================== --}}
<div class="td-form-actions">

    <a href="{{ route('admin.tour-details.index') }}" class="td-btn td-btn-secondary">
        Cancel
    </a>

    <button type="submit" class="td-btn td-btn-primary">
        {{ isset($tourDetail) ? 'Update Tour Details' : 'Create Tour Details' }}
    </button>

</div>

@push('styles')
    <style>
        .td-form-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 390px;
            gap: 24px;
            align-items: start;
        }

        .td-form-main,
        .td-form-sidebar {
            min-width: 0;
        }

        .td-form-sidebar {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .td-form-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e4eaf1;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(15, 23, 42, 0.05);
        }

        .td-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            background: #ffffff;
            border-bottom: 1px solid #edf1f5;
        }

        .td-card-header h2 {
            margin: 0 0 5px;
            color: #172033;
            font-size: 17px;
            font-weight: 700;
            line-height: 1.3;
        }

        .td-card-header p {
            margin: 0;
            color: #7b8798;
            font-size: 13px;
            line-height: 1.5;
        }

        .td-card-body {
            padding: 22px;
        }

        .td-form-group {
            margin-bottom: 22px;
        }

        .td-form-group-last {
            margin-bottom: 0;
        }

        .td-label {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 8px;
            color: #273247;
            font-size: 14px;
            font-weight: 600;
        }

        .td-required {
            color: #dc2626;
        }

        .td-control {
            width: 100%;
            min-height: 48px;
            padding: 11px 14px;
            color: #1f2937;
            font-family: inherit;
            font-size: 14px;
            line-height: 1.5;
            background: #ffffff;
            border: 1px solid #d9e1ea;
            border-radius: 10px;
            outline: none;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .td-control::placeholder {
            color: #a2aab7;
        }

        .td-control:hover {
            border-color: #b9c4d1;
        }

        .td-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .td-textarea {
            min-height: 260px;
            resize: vertical;
        }

        .td-control-error {
            border-color: #dc2626;
        }

        .td-control-error:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        .td-error-message {
            display: block;
            margin-top: 7px;
            color: #dc2626;
            font-size: 12px;
            font-weight: 500;
        }

        .td-field-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 7px;
            color: #8a95a5;
            font-size: 12px;
        }

        /* =====================================================
            ADD IMAGE BUTTON
        ====================================================== */
        .td-add-image-btn {
            display: inline-flex;
            min-height: 39px;
            padding: 8px 13px;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex-shrink: 0;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            background: #2563eb;
            border: 1px solid #2563eb;
            border-radius: 9px;
            transition:
                background 0.2s ease,
                border-color 0.2s ease,
                transform 0.2s ease;
        }

        .td-add-image-btn:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .td-add-image-btn:disabled {
            cursor: not-allowed;
            opacity: 0.55;
            transform: none;
        }

        .td-add-icon {
            font-size: 19px;
            font-weight: 400;
            line-height: 1;
        }

        /* =====================================================
            GALLERY SUMMARY
        ====================================================== */
        .td-gallery-summary {
            display: flex;
            min-height: 44px;
            padding: 10px 13px;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            color: #566276;
            font-size: 13px;
            background: #f8fafc;
            border: 1px solid #e5eaf0;
            border-radius: 10px;
        }

        .td-gallery-summary strong {
            display: inline-flex;
            min-width: 54px;
            height: 27px;
            padding: 0 9px;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 12px;
            background: #eaf2ff;
            border-radius: 999px;
        }

        .td-gallery-section+.td-gallery-section {
            margin-top: 22px;
        }

        .td-gallery-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
            color: #465166;
            font-size: 13px;
            font-weight: 700;
        }

        .td-gallery-title>span:last-child {
            display: inline-flex;
            min-width: 25px;
            height: 25px;
            padding: 0 7px;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 11px;
            background: #eaf2ff;
            border-radius: 999px;
        }

        /* =====================================================
            EXISTING GALLERY
        ====================================================== */
        .td-existing-gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .td-existing-gallery-item {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            background: #eef2f6;
            border: 1px solid #e1e7ee;
            border-radius: 11px;
        }

        .td-existing-gallery-item img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.25s ease;
        }

        .td-existing-gallery-item:hover img {
            transform: scale(1.04);
        }

        .td-remove-existing-image {
            position: absolute;
            top: 7px;
            right: 7px;
            display: inline-flex;
            width: 29px;
            height: 29px;
            padding: 0;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            cursor: pointer;
            background: rgba(220, 38, 38, 0.95);
            border: 0;
            border-radius: 50%;
            box-shadow: 0 5px 12px rgba(15, 23, 42, 0.22);
            transition:
                background 0.2s ease,
                transform 0.2s ease;
        }

        .td-remove-existing-image:hover {
            background: #b91c1c;
            transform: scale(1.07);
        }

        .td-remove-existing-image svg {
            width: 15px;
            height: 15px;
            pointer-events: none;
        }

        /* =====================================================
            DYNAMIC NEW IMAGE INPUTS
        ====================================================== */
        .td-image-input-list {
            display: flex;
            flex-direction: column;
            gap: 13px;
        }

        .td-image-input-row {
            display: grid;
            grid-template-columns: 86px minmax(0, 1fr) 34px;
            gap: 11px;
            align-items: center;
            padding: 11px;
            background: #f8fafc;
            border: 1px solid #e1e7ee;
            border-radius: 12px;
        }

        .td-image-preview {
            display: flex;
            width: 86px;
            height: 72px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #94a3b8;
            font-size: 11px;
            text-align: center;
            background: #ffffff;
            border: 1px dashed #c7d1dd;
            border-radius: 9px;
        }

        .td-image-preview img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .td-image-file-wrap {
            min-width: 0;
        }

        .td-image-file-label {
            display: flex;
            min-height: 45px;
            padding: 9px 12px;
            align-items: center;
            justify-content: space-between;
            gap: 9px;
            color: #64748b;
            font-size: 12px;
            cursor: pointer;
            background: #ffffff;
            border: 1px solid #d6dee8;
            border-radius: 9px;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .td-image-file-label:hover {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
        }

        .td-image-file-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .td-image-file-label strong {
            flex-shrink: 0;
            color: #2563eb;
            font-size: 11px;
        }

        .td-gallery-file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            clip-path: inset(50%);
            white-space: nowrap;
        }

        .td-remove-new-image {
            display: inline-flex;
            width: 32px;
            height: 32px;
            padding: 0;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            cursor: pointer;
            background: #ef4444;
            border: 0;
            border-radius: 50%;
            transition:
                background 0.2s ease,
                transform 0.2s ease;
        }

        .td-remove-new-image:hover {
            background: #dc2626;
            transform: scale(1.06);
        }

        .td-remove-new-image svg {
            width: 15px;
            height: 15px;
            pointer-events: none;
        }

        /* =====================================================
            EMPTY STATE
        ====================================================== */
        .td-empty-gallery {
            display: flex;
            min-height: 150px;
            padding: 20px;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 7px;
            text-align: center;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
        }

        .td-empty-gallery.hidden {
            display: none;
        }

        .td-empty-gallery-icon {
            display: inline-flex;
            width: 42px;
            height: 42px;
            margin-bottom: 2px;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            background: #eaf2ff;
            border-radius: 11px;
        }

        .td-empty-gallery-icon svg {
            width: 21px;
            height: 21px;
        }

        .td-empty-gallery strong {
            color: #344054;
            font-size: 13px;
        }

        .td-empty-gallery p {
            max-width: 230px;
            margin: 0;
            color: #8a95a5;
            font-size: 11px;
            line-height: 1.5;
        }

        .td-gallery-limit-message {
            display: none;
            margin: 14px 0 0;
            padding: 10px 12px;
            color: #b91c1c;
            font-size: 12px;
            font-weight: 600;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
        }

        .td-gallery-limit-message.show {
            display: block;
        }

        /* =====================================================
            FORM ACTIONS
        ====================================================== */
        .td-form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
            padding: 20px 22px;
            background: #ffffff;
            border: 1px solid #e4eaf1;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(15, 23, 42, 0.05);
        }

        .td-btn {
            display: inline-flex;
            min-height: 44px;
            padding: 10px 18px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border-radius: 10px;
            transition:
                background 0.2s ease,
                border-color 0.2s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .td-btn-secondary {
            color: #475569;
            background: #ffffff;
            border: 1px solid #d7dee7;
        }

        .td-btn-secondary:hover {
            color: #1f2937;
            background: #f8fafc;
            border-color: #bac4d0;
        }

        .td-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
            box-shadow: 0 7px 16px rgba(37, 99, 235, 0.2);
        }

        .td-btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            transform: translateY(-1px);
        }

        /* =====================================================
            RESPONSIVE
        ====================================================== */
        @media (max-width: 1150px) {
            .td-form-layout {
                grid-template-columns: minmax(0, 1fr) 350px;
            }
        }

        @media (max-width: 920px) {
            .td-form-layout {
                grid-template-columns: 1fr;
            }

            .td-form-sidebar {
                display: grid;
                grid-template-columns:
                    minmax(0, 1fr) minmax(260px, 0.5fr);
                align-items: start;
            }
        }

        @media (max-width: 700px) {
            .td-form-sidebar {
                display: flex;
            }

            .td-card-header,
            .td-card-body {
                padding-right: 17px;
                padding-left: 17px;
            }

            .td-gallery-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .td-add-image-btn {
                width: 100%;
            }

            .td-field-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .td-form-actions {
                align-items: stretch;
                flex-direction: column-reverse;
                padding: 16px;
            }

            .td-btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .td-existing-gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .td-image-input-row {
                grid-template-columns: 72px minmax(0, 1fr) 32px;
                gap: 8px;
                padding: 9px;
            }

            .td-image-preview {
                width: 72px;
                height: 64px;
            }

            .td-image-file-label {
                min-height: 42px;
                padding: 8px 9px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.getElementById(
                'addGalleryImage'
            );

            const imageContainer = document.getElementById(
                'galleryImageContainer'
            );

            const existingGallery = document.getElementById(
                'existingGallery'
            );

            const existingGallerySection = document.getElementById(
                'existingGallerySection'
            );

            const existingCountElement = document.getElementById(
                'existingGalleryCount'
            );

            const newCountElement = document.getElementById(
                'newGalleryCount'
            );

            const totalCountElement = document.getElementById(
                'totalGalleryCount'
            );

            const emptyGalleryMessage = document.getElementById(
                'emptyGalleryMessage'
            );

          
            const description = document.getElementById(
                'description'
            );

            const descriptionCounter = document.getElementById(
                'descriptionCounter'
            );

            const maximumImages = 10;

            if (!addButton || !imageContainer) {
                return;
            }

            function getExistingImageCount() {
                if (!existingGallery) {
                    return 0;
                }

                return existingGallery.querySelectorAll(
                    '.td-existing-gallery-item'
                ).length;
            }

            function getNewImageCount() {
                return imageContainer.querySelectorAll(
                    '.td-image-input-row'
                ).length;
            }

            function getTotalImageCount() {
                return (
                    getExistingImageCount() +
                    getNewImageCount()
                );
            }

            function updateGalleryState() {
                const existingCount = getExistingImageCount();
                const newCount = getNewImageCount();
                const totalCount = existingCount + newCount;
                const limitReached = totalCount >= maximumImages;

                if (existingCountElement) {
                    existingCountElement.textContent =
                        existingCount;
                }

                if (newCountElement) {
                    newCountElement.textContent =
                        newCount;
                }

                if (totalCountElement) {
                    totalCountElement.textContent =
                        `${totalCount} / ${maximumImages}`;
                }

                if (emptyGalleryMessage) {
                    emptyGalleryMessage.classList.toggle(
                        'hidden',
                        newCount > 0
                    );
                }

                if (existingGallerySection) {
                    existingGallerySection.style.display =
                        existingCount > 0 ?
                        '' :
                        'none';
                }

                addButton.disabled = limitReached;

                if (limitMessage) {
                    limitMessage.classList.toggle(
                        'show',
                        limitReached
                    );
                }
            }

            function createImageInput() {
                if (
                    getTotalImageCount() >= maximumImages
                ) {
                    updateGalleryState();

                    return;
                }

                const uniqueId =
                    Date.now() +
                    '_' +
                    Math.floor(Math.random() * 100000);

                const inputId =
                    `gallery_image_${uniqueId}`;

                const row = document.createElement('div');

                row.className = 'td-image-input-row';

                row.innerHTML = `
                <div class="td-image-preview">
                    <span>No image</span>
                </div>

                <div class="td-image-file-wrap">

                    <label
                        for="${inputId}"
                        class="td-image-file-label"
                    >
                        <span class="td-image-file-name">
                            Select an image
                        </span>

                        <strong>
                            Browse
                        </strong>
                    </label>

                    <input
                        type="file"
                        id="${inputId}"
                        name="gallery[]"
                        class="td-gallery-file-input"
                        accept=".jpg,.jpeg,.png,.webp"
                        required
                    >

                </div>

                <button
                    type="button"
                    class="td-remove-new-image"
                    aria-label="Remove image field"
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                    >
                        <path d="M18 6L6 18"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            `;

                imageContainer.appendChild(row);

                updateGalleryState();
            }

            function updateDescriptionCounter() {
                if (
                    !description ||
                    !descriptionCounter
                ) {
                    return;
                }

                descriptionCounter.textContent =
                    `${description.value.length} characters`;
            }

            addButton.addEventListener(
                'click',
                function() {
                    createImageInput();
                }
            );

            imageContainer.addEventListener(
                'change',
                function(event) {
                    const input = event.target.closest(
                        '.td-gallery-file-input'
                    );

                    if (!input) {
                        return;
                    }

                    const row = input.closest(
                        '.td-image-input-row'
                    );

                    const preview = row.querySelector(
                        '.td-image-preview'
                    );

                    const fileName = row.querySelector(
                        '.td-image-file-name'
                    );

                    const file = input.files[0];

                    if (!file) {
                        preview.innerHTML =
                            '<span>No image</span>';

                        fileName.textContent =
                            'Select an image';

                        return;
                    }

                    if (!file.type.startsWith('image/')) {
                        input.value = '';

                        preview.innerHTML =
                            '<span>Invalid image</span>';

                        fileName.textContent =
                            'Select an image';

                        return;
                    }

                    fileName.textContent = file.name;

                    const reader = new FileReader();

                    reader.addEventListener(
                        'load',
                        function(readerEvent) {
                            preview.innerHTML = `
                            <img
                                src="${readerEvent.target.result}"
                                alt="Selected gallery image"
                            >
                        `;
                        }
                    );

                    reader.readAsDataURL(file);
                }
            );

            imageContainer.addEventListener(
                'click',
                function(event) {
                    const removeButton = event.target.closest(
                        '.td-remove-new-image'
                    );

                    if (!removeButton) {
                        return;
                    }

                    const row = removeButton.closest(
                        '.td-image-input-row'
                    );

                    row?.remove();

                    updateGalleryState();
                }
            );

            document.addEventListener(
                'click',
                function(event) {
                    const removeButton = event.target.closest(
                        '.td-remove-existing-image'
                    );

                    if (!removeButton) {
                        return;
                    }

                    const imageItem = removeButton.closest(
                        '.td-existing-gallery-item'
                    );

                    imageItem?.remove();

                    updateGalleryState();
                }
            );

            if (description) {
                description.addEventListener(
                    'input',
                    updateDescriptionCounter
                );
            }

            /*
             * On the create page, automatically show
             * the first image selection field.
             */
            if (
                getExistingImageCount() === 0 &&
                getNewImageCount() === 0
            ) {
                createImageInput();
            }

            updateDescriptionCounter();
            updateGalleryState();
        });
    </script>
@endpush
