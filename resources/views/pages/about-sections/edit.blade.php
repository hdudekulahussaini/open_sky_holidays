@extends('admin.layouts.app')

@section('title', 'Edit About Section')
@section('page-title', 'Edit About Section')

@section('content')

    @php
        $locations = old(
            'locations',
            $aboutSection->globeLocations
                ->map(function ($location) {
                    return [
                        'id' => $location->id,
                        'location_name' => $location->location_name,
                        'latitude' => $location->latitude,
                        'longitude' => $location->longitude,
                    ];
                })
                ->toArray()
        );

        if (empty($locations)) {
            $locations = [
                [
                    'id' => null,
                    'location_name' => '',
                    'latitude' => '',
                    'longitude' => '',
                ],
            ];
        }

        $selectedAvatarIds = collect(
            old('remove_avatar_ids', [])
        )
            ->map(fn ($id) => (int) $id)
            ->toArray();
    @endphp

    <div class="admin-form-card">

        {{-- =========================================================
            FORM HEADER
        ========================================================== --}}
        <div class="admin-form-header">

            <div class="admin-form-header-content">
                <h3>Edit About Section</h3>

                <p>
                    Update the About Section content, globe locations
                    and customer avatar images.
                </p>
            </div>

            <a
                href="{{ route('admin.about-sections.index') }}"
                class="btn btn-light"
            >
                Back
            </a>

        </div>

        {{-- Session error --}}
        @if (session('error'))
            <div class="alert alert-error admin-form-alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation summary --}}
        @if ($errors->any())
            <div class="alert alert-error admin-form-alert">
                Please correct the validation errors below.
            </div>
        @endif

        <div class="admin-form-body">

            <form
                action="{{ route('admin.about-sections.update', $aboutSection) }}"
                method="POST"
                enctype="multipart/form-data"
                class="admin-form"
                id="about-section-edit-form"
            >
                @csrf
                @method('PUT')

                {{-- =====================================================
                    MAIN ABOUT SECTION FIELDS
                ====================================================== --}}

                <div class="admin-form-grid">

                    {{-- Main heading --}}
                    <div class="admin-form-group full-width">

                        <label for="main_heading">
                            Main Heading
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="main_heading"
                            name="main_heading"
                            class="admin-form-control
                                @error('main_heading') is-invalid @enderror"
                            value="{{ old(
                                'main_heading',
                                $aboutSection->main_heading
                            ) }}"
                            placeholder="Enter the About Section main heading"
                            required
                        >

                        @error('main_heading')
                            <span class="admin-form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    {{-- Mission title --}}
                    <div class="admin-form-group">

                        <label for="mission_title">
                            Mission Title
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="mission_title"
                            name="mission_title"
                            class="admin-form-control
                                @error('mission_title') is-invalid @enderror"
                            value="{{ old(
                                'mission_title',
                                $aboutSection->mission_title
                            ) }}"
                            placeholder="Example: Mission & Vision"
                            required
                        >

                        @error('mission_title')
                            <span class="admin-form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    {{-- Focus title --}}
                    <div class="admin-form-group">

                        <label for="focus_title">
                            Focus Title
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="focus_title"
                            name="focus_title"
                            class="admin-form-control
                                @error('focus_title') is-invalid @enderror"
                            value="{{ old(
                                'focus_title',
                                $aboutSection->focus_title
                            ) }}"
                            placeholder="Example: Focus On Customer"
                            required
                        >

                        @error('focus_title')
                            <span class="admin-form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    {{-- Description --}}
                    <div class="admin-form-group full-width">

                        <label for="description">
                            Description
                            <span class="required">*</span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            class="admin-form-control
                                @error('description') is-invalid @enderror"
                            placeholder="Enter the About Section description"
                            required
                        >{{ old(
                            'description',
                            $aboutSection->description
                        ) }}</textarea>

                        @error('description')
                            <span class="admin-form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    {{-- Customer count --}}
                    <div class="admin-form-group">

                        <label for="customer_count">
                            Customer Count
                            <span class="required">*</span>
                        </label>

                        <input
                            type="number"
                            id="customer_count"
                            name="customer_count"
                            min="0"
                            class="admin-form-control
                                @error('customer_count') is-invalid @enderror"
                            value="{{ old(
                                'customer_count',
                                $aboutSection->customer_count
                            ) }}"
                            placeholder="Example: 10200"
                            required
                        >

                        <span class="admin-form-help">
                            Enter the customer count displayed on the website.
                        </span>

                        @error('customer_count')
                            <span class="admin-form-error">
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

                        <select
                            id="status"
                            name="status"
                            class="admin-form-control
                                @error('status') is-invalid @enderror"
                            required
                        >
                            <option
                                value="1"
                                @selected(
                                    old(
                                        'status',
                                        $aboutSection->status
                                    ) == 1
                                )
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                @selected(
                                    old(
                                        'status',
                                        $aboutSection->status
                                    ) == 0
                                )
                            >
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

                {{-- =====================================================
                    GLOBE LOCATIONS
                ====================================================== --}}

                <div class="admin-form-section">

                    <div class="admin-form-section-header">

                        <div>
                            <h4>Globe Locations</h4>

                            <p>
                                Update location names and coordinates for the interactive globe.
                            </p>
                        </div>

                        <button
                            type="button"
                            class="btn btn-primary"
                            id="add-location"
                        >
                            Add Location
                        </button>

                    </div>

                    <div id="location-container">

                        @foreach ($locations as $index => $location)

                            <div class="location-item">

                                @if (!empty($location['id']))
                                    <input
                                        type="hidden"
                                        name="locations[{{ $index }}][id]"
                                        value="{{ $location['id'] }}"
                                    >
                                @endif

                                <div class="location-item-header">

                                    <h5>
                                        Location
                                        <span class="location-number">
                                            {{ $loop->iteration }}
                                        </span>
                                    </h5>

                                    <button
                                        type="button"
                                        class="remove-location-button remove-location"
                                        aria-label="Remove location"
                                    >
                                        Remove
                                    </button>

                                </div>

                                <div class="location-grid">

                                    {{-- Location name --}}
                                    <div class="admin-form-group">

                                        <label>
                                            Location Name
                                            <span class="required">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            name="locations[{{ $index }}][location_name]"
                                            class="admin-form-control
                                                @error("locations.$index.location_name")
                                                    is-invalid
                                                @enderror"
                                            value="{{ old(
                                                "locations.$index.location_name",
                                                $location['location_name'] ?? ''
                                            ) }}"
                                            placeholder="Example: UAE"
                                            required
                                        >

                                        @error("locations.$index.location_name")
                                            <span class="admin-form-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                    {{-- Latitude --}}
                                    <div class="admin-form-group">

                                        <label>
                                            Latitude
                                            <span class="required">*</span>
                                        </label>

                                        <input
                                            type="number"
                                            step="0.0000001"
                                            min="-90"
                                            max="90"
                                            name="locations[{{ $index }}][latitude]"
                                            class="admin-form-control
                                                @error("locations.$index.latitude")
                                                    is-invalid
                                                @enderror"
                                            value="{{ old(
                                                "locations.$index.latitude",
                                                $location['latitude'] ?? ''
                                            ) }}"
                                            placeholder="Example: 23.4241"
                                            required
                                        >

                                        @error("locations.$index.latitude")
                                            <span class="admin-form-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                    {{-- Longitude --}}
                                    <div class="admin-form-group">

                                        <label>
                                            Longitude
                                            <span class="required">*</span>
                                        </label>

                                        <input
                                            type="number"
                                            step="0.0000001"
                                            min="-180"
                                            max="180"
                                            name="locations[{{ $index }}][longitude]"
                                            class="admin-form-control
                                                @error("locations.$index.longitude")
                                                    is-invalid
                                                @enderror"
                                            value="{{ old(
                                                "locations.$index.longitude",
                                                $location['longitude'] ?? ''
                                            ) }}"
                                            placeholder="Example: 53.8478"
                                            required
                                        >

                                        @error("locations.$index.longitude")
                                            <span class="admin-form-error">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>



                                </div>

                            </div>

                        @endforeach

                    </div>

                    @error('locations')
                        <span class="admin-form-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- =====================================================
                    CUSTOMER AVATARS
                ====================================================== --}}

                <div
                    class="admin-form-section"
                    id="customer-avatars"
                    data-existing-avatar-count="{{ $aboutSection->customerAvatars->count() }}"
                >

                    <div class="admin-form-section-header">

                        <div>
                            <h4>Customer Avatar Images</h4>

                            <p>
                                Keep, remove or upload customer avatar images.
                                A maximum of three active avatars is allowed.
                            </p>
                        </div>

                        <button
                            type="button"
                            class="btn btn-primary"
                            id="add-avatar"
                        >
                            Add Avatar
                        </button>

                    </div>

                    {{-- Existing avatars --}}
                    @if ($aboutSection->customerAvatars->isNotEmpty())

                        <div class="existing-avatar-section">

                            <div class="existing-avatar-header">

                                <div>
                                    <h5>Existing Avatar Images</h5>

                                    <p>
                                        Select “Remove image” to delete an
                                        existing avatar after updating.
                                    </p>
                                </div>

                                <span class="existing-avatar-count">
                                    {{ $aboutSection->customerAvatars->count() }}
                                    {{ Str::plural(
                                        'image',
                                        $aboutSection->customerAvatars->count()
                                    ) }}
                                </span>

                            </div>

                            <div class="avatar-preview-grid">

                                @foreach (
                                    $aboutSection->customerAvatars as $avatar
                                )

                                    <label
                                        class="avatar-preview-card
                                            {{ in_array(
                                                $avatar->id,
                                                $selectedAvatarIds
                                            ) ? 'marked-for-removal' : '' }}"
                                        data-existing-avatar-card
                                    >

                                        <div class="avatar-preview-media">

                                            <img
                                                src="{{ Storage::url($avatar->image) }}"
                                                alt="Customer avatar"
                                                class="avatar-preview-image"
                                            >

                                            <span class="avatar-existing-badge">
                                                Existing
                                            </span>

                                        </div>

                                        <span class="avatar-remove-option">

                                            <input
                                                type="checkbox"
                                                name="remove_avatar_ids[]"
                                                value="{{ $avatar->id }}"
                                                class="existing-avatar-remove-checkbox"
                                                @checked(
                                                    in_array(
                                                        $avatar->id,
                                                        $selectedAvatarIds
                                                    )
                                                )
                                            >

                                            <span class="avatar-remove-checkmark"></span>

                                            <span class="avatar-remove-text">
                                                Remove image
                                            </span>

                                        </span>

                                    </label>

                                @endforeach

                            </div>

                            @error('remove_avatar_ids')
                                <span class="admin-form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                            @error('remove_avatar_ids.*')
                                <span class="admin-form-error">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    @else

                        <div class="empty-avatar-message">
                            No existing avatar images are available.
                        </div>

                    @endif

                    {{-- New avatar uploads --}}
                    <div class="new-avatar-section">

                        <div class="new-avatar-section-header">
                            <h5>Upload New Avatar Images</h5>

                            <p>
                                Add new images only when required.
                            </p>
                        </div>

                        <div
                            id="avatar-container"
                            class="avatar-upload-grid"
                        >

                            {{-- Initial upload card --}}
                            <div class="avatar-upload-item">

                                <div class="avatar-upload-header">

                                    <h5>
                                        New Avatar
                                        <span class="avatar-number">1</span>
                                    </h5>

                                    <button
                                        type="button"
                                        class="remove-avatar-button remove-avatar"
                                        aria-label="Remove new avatar"
                                    >
                                        Remove
                                    </button>

                                </div>

                                <label class="avatar-upload-box">

                                    <input
                                        type="file"
                                        name="avatar_images[]"
                                        class="avatar-file-input"
                                        accept=".jpg,.jpeg,.png,.webp"
                                    >

                                    <img
                                        src=""
                                        alt="New customer avatar preview"
                                        class="avatar-local-preview"
                                    >

                                    <span class="avatar-upload-placeholder">

                                        <span class="avatar-upload-icon">
                                            +
                                        </span>

                                        <strong>Select an image</strong>

                                        <small>
                                            JPG, JPEG, PNG or WEBP
                                        </small>

                                    </span>

                                </label>

                            </div>

                        </div>

                        <span class="admin-form-help">
                            Maximum three active avatar images in total.
                            Maximum file size: 2 MB per image.
                        </span>

                        <div
                            id="avatar-limit-message"
                            class="avatar-limit-message"
                            hidden
                        >
                            You already have three active avatars. Remove an
                            existing avatar before uploading another image.
                        </div>

                        @error('avatar_images')
                            <span class="admin-form-error">
                                {{ $message }}
                            </span>
                        @enderror

                        @error('avatar_images.*')
                            <span class="admin-form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

                {{-- =====================================================
                    FORM ACTIONS
                ====================================================== --}}

                <div class="admin-form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update About Section
                    </button>

                    <a
                        href="{{ route('admin.about-sections.index') }}"
                        class="btn btn-light"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | Globe locations
        |--------------------------------------------------------------------------
        */

        const locationContainer =
            document.getElementById('location-container');

        const addLocationButton =
            document.getElementById('add-location');

        let locationIndex = locationContainer
            ? locationContainer.querySelectorAll('.location-item').length
            : 0;

        function updateLocationNumbers() {
            if (!locationContainer) {
                return;
            }

            const items =
                locationContainer.querySelectorAll('.location-item');

            items.forEach(function (item, index) {
                const number =
                    item.querySelector('.location-number');

                const removeButton =
                    item.querySelector('.remove-location');

                if (number) {
                    number.textContent = index + 1;
                }

                if (removeButton) {
                    removeButton.disabled = items.length === 1;
                }
            });
        }

        if (locationContainer && addLocationButton) {

            addLocationButton.addEventListener('click', function () {

                const html = `
                    <div class="location-item">

                        <div class="location-item-header">

                            <h5>
                                Location
                                <span class="location-number">
                                    ${locationIndex + 1}
                                </span>
                            </h5>

                            <button
                                type="button"
                                class="remove-location-button remove-location"
                                aria-label="Remove location"
                            >
                                Remove
                            </button>

                        </div>

                        <div class="location-grid">

                            <div class="admin-form-group">

                                <label>
                                    Location Name
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="locations[${locationIndex}][location_name]"
                                    class="admin-form-control"
                                    placeholder="Example: UAE"
                                    required
                                >

                            </div>

                            <div class="admin-form-group">

                                <label>
                                    Latitude
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="number"
                                    step="0.0000001"
                                    min="-90"
                                    max="90"
                                    name="locations[${locationIndex}][latitude]"
                                    class="admin-form-control"
                                    placeholder="Example: 23.4241"
                                    required
                                >

                            </div>

                            <div class="admin-form-group">

                                <label>
                                    Longitude
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="number"
                                    step="0.0000001"
                                    min="-180"
                                    max="180"
                                    name="locations[${locationIndex}][longitude]"
                                    class="admin-form-control"
                                    placeholder="Example: 53.8478"
                                    required
                                >

                            </div>



                        </div>

                    </div>
                `;

                locationContainer.insertAdjacentHTML(
                    'beforeend',
                    html
                );

                locationIndex++;

                updateLocationNumbers();
            });

            locationContainer.addEventListener(
                'click',
                function (event) {

                    const removeButton =
                        event.target.closest('.remove-location');

                    if (!removeButton) {
                        return;
                    }

                    const items =
                        locationContainer.querySelectorAll(
                            '.location-item'
                        );

                    if (items.length <= 1) {
                        alert(
                            'At least one globe location is required.'
                        );

                        return;
                    }

                    removeButton
                        .closest('.location-item')
                        .remove();

                    updateLocationNumbers();
                }
            );

            updateLocationNumbers();
        }

        /*
        |--------------------------------------------------------------------------
        | Customer avatar uploads
        |--------------------------------------------------------------------------
        */

        const avatarSection =
            document.getElementById('customer-avatars');

        const avatarContainer =
            document.getElementById('avatar-container');

        const addAvatarButton =
            document.getElementById('add-avatar');

        const avatarLimitMessage =
            document.getElementById('avatar-limit-message');

        const maximumAvatars = 3;
        const maximumFileSize = 2 * 1024 * 1024;

        const allowedImageTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        function getExistingAvatarCards() {
            return document.querySelectorAll(
                '[data-existing-avatar-card]'
            );
        }

        function getActiveExistingAvatarCount() {
            let count = 0;

            getExistingAvatarCards().forEach(function (card) {
                const checkbox = card.querySelector(
                    '.existing-avatar-remove-checkbox'
                );

                if (checkbox && !checkbox.checked) {
                    count++;
                }
            });

            return count;
        }

        function getNewAvatarItems() {
            if (!avatarContainer) {
                return [];
            }

            return Array.from(
                avatarContainer.querySelectorAll(
                    '.avatar-upload-item'
                )
            );
        }

        function getSelectedNewAvatarCount() {
            return getNewAvatarItems().filter(function (item) {
                const input =
                    item.querySelector('.avatar-file-input');

                return input &&
                    input.files &&
                    input.files.length > 0;
            }).length;
        }

        function getTotalActiveAvatarCount() {
            return (
                getActiveExistingAvatarCount() +
                getSelectedNewAvatarCount()
            );
        }

        function getRemainingAvatarSlots() {
            return Math.max(
                maximumAvatars - getTotalActiveAvatarCount(),
                0
            );
        }

        function createAvatarItem() {
            return `
                <div class="avatar-upload-item">

                    <div class="avatar-upload-header">

                        <h5>
                            New Avatar
                            <span class="avatar-number"></span>
                        </h5>

                        <button
                            type="button"
                            class="remove-avatar-button remove-avatar"
                            aria-label="Remove new avatar"
                        >
                            Remove
                        </button>

                    </div>

                    <label class="avatar-upload-box">

                        <input
                            type="file"
                            name="avatar_images[]"
                            class="avatar-file-input"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <img
                            src=""
                            alt="New customer avatar preview"
                            class="avatar-local-preview"
                        >

                        <span class="avatar-upload-placeholder">

                            <span class="avatar-upload-icon">
                                +
                            </span>

                            <strong>Select an image</strong>

                            <small>
                                JPG, JPEG, PNG or WEBP
                            </small>

                        </span>

                    </label>

                </div>
            `;
        }

        function resetAvatarPreview(uploadItem) {
            const input =
                uploadItem.querySelector('.avatar-file-input');

            const preview =
                uploadItem.querySelector('.avatar-local-preview');

            const placeholder =
                uploadItem.querySelector(
                    '.avatar-upload-placeholder'
                );

            if (input) {
                input.value = '';
            }

            if (preview) {
                preview.src = '';
                preview.classList.remove('show');
            }

            if (placeholder) {
                placeholder.classList.remove('hide');
            }
        }

        function updateExistingAvatarCards() {
            getExistingAvatarCards().forEach(function (card) {
                const checkbox = card.querySelector(
                    '.existing-avatar-remove-checkbox'
                );

                if (!checkbox) {
                    return;
                }

                card.classList.toggle(
                    'marked-for-removal',
                    checkbox.checked
                );
            });
        }

        function updateAvatarItems() {
            if (!avatarContainer || !addAvatarButton) {
                return;
            }

            const items = getNewAvatarItems();

            items.forEach(function (item, index) {
                const number =
                    item.querySelector('.avatar-number');

                const removeButton =
                    item.querySelector('.remove-avatar');

                if (number) {
                    number.textContent = index + 1;
                }

                if (removeButton) {
                    removeButton.disabled = items.length === 1;
                }
            });

            const activeExistingCount =
                getActiveExistingAvatarCount();

            const selectedNewCount =
                getSelectedNewAvatarCount();

            const totalActiveCount =
                activeExistingCount + selectedNewCount;

            const maximumReached =
                totalActiveCount >= maximumAvatars;

            const canAddAnotherCard =
                items.length < maximumAvatars &&
                !maximumReached;

            addAvatarButton.disabled = !canAddAnotherCard;

            if (maximumReached) {
                addAvatarButton.textContent =
                    'Maximum 3 Avatars';
            } else {
                addAvatarButton.textContent =
                    'Add Avatar';
            }

            if (avatarLimitMessage) {
                avatarLimitMessage.hidden = !maximumReached;
            }

            items.forEach(function (item) {
                const input =
                    item.querySelector('.avatar-file-input');

                if (!input) {
                    return;
                }

                const hasSelectedFile =
                    input.files &&
                    input.files.length > 0;

                input.disabled =
                    maximumReached && !hasSelectedFile;
            });
        }

        if (
            avatarSection &&
            avatarContainer &&
            addAvatarButton
        ) {

            addAvatarButton.addEventListener(
                'click',
                function () {

                    if (getTotalActiveAvatarCount() >= maximumAvatars) {
                        return;
                    }

                    const items = getNewAvatarItems();

                    if (items.length >= maximumAvatars) {
                        return;
                    }

                    avatarContainer.insertAdjacentHTML(
                        'beforeend',
                        createAvatarItem()
                    );

                    updateAvatarItems();
                }
            );

            avatarContainer.addEventListener(
                'click',
                function (event) {

                    const removeButton =
                        event.target.closest('.remove-avatar');

                    if (!removeButton) {
                        return;
                    }

                    const items = getNewAvatarItems();

                    if (items.length <= 1) {
                        const uploadItem =
                            removeButton.closest(
                                '.avatar-upload-item'
                            );

                        resetAvatarPreview(uploadItem);
                        updateAvatarItems();

                        return;
                    }

                    removeButton
                        .closest('.avatar-upload-item')
                        .remove();

                    updateAvatarItems();
                }
            );

            avatarContainer.addEventListener(
                'change',
                function (event) {

                    const input =
                        event.target.closest('.avatar-file-input');

                    if (!input) {
                        return;
                    }

                    const uploadItem =
                        input.closest('.avatar-upload-item');

                    const preview =
                        uploadItem.querySelector(
                            '.avatar-local-preview'
                        );

                    const placeholder =
                        uploadItem.querySelector(
                            '.avatar-upload-placeholder'
                        );

                    const file = input.files[0];

                    if (!file) {
                        resetAvatarPreview(uploadItem);
                        updateAvatarItems();

                        return;
                    }

                    const otherSelectedImages =
                        getNewAvatarItems().filter(function (item) {
                            if (item === uploadItem) {
                                return false;
                            }

                            const itemInput =
                                item.querySelector(
                                    '.avatar-file-input'
                                );

                            return itemInput &&
                                itemInput.files &&
                                itemInput.files.length > 0;
                        }).length;

                    const totalAfterSelection =
                        getActiveExistingAvatarCount() +
                        otherSelectedImages +
                        1;

                    if (totalAfterSelection > maximumAvatars) {
                        alert(
                            'Only three active avatar images are allowed. Remove an existing avatar first.'
                        );

                        resetAvatarPreview(uploadItem);
                        updateAvatarItems();

                        return;
                    }

                    if (!allowedImageTypes.includes(file.type)) {
                        alert(
                            'Please select a JPG, JPEG, PNG or WEBP image.'
                        );

                        resetAvatarPreview(uploadItem);
                        updateAvatarItems();

                        return;
                    }

                    if (file.size > maximumFileSize) {
                        alert(
                            'Each avatar image must not exceed 2 MB.'
                        );

                        resetAvatarPreview(uploadItem);
                        updateAvatarItems();

                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function (loadEvent) {
                        preview.src = loadEvent.target.result;
                        preview.classList.add('show');
                        placeholder.classList.add('hide');

                        updateAvatarItems();
                    };

                    reader.readAsDataURL(file);
                }
            );

            document.addEventListener(
                'change',
                function (event) {

                    const checkbox =
                        event.target.closest(
                            '.existing-avatar-remove-checkbox'
                        );

                    if (!checkbox) {
                        return;
                    }

                    updateExistingAvatarCards();
                    updateAvatarItems();
                }
            );

            updateExistingAvatarCards();
            updateAvatarItems();
        }

    });
</script>

@endpush