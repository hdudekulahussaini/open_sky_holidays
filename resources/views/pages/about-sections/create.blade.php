@extends('admin.layouts.app')

@section('title', 'Create About Section')
@section('page-title', 'Create About Section')

@section('content')

    @php
        $locations = old('locations', [
            [
                'location_name' => '',
            ],
        ]);
    @endphp

    <div class="admin-form-card">

        {{-- Form header --}}
        <div class="admin-form-header">

            <div class="admin-form-header-content">
                <h3>Create About Section</h3>

                <p>
                    Add the About Section content, globe locations
                    and customer avatar images.
                </p>
            </div>

            <a href="{{ route('admin.about-sections.index') }}" class="btn btn-light">
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

            <form action="{{ route('admin.about-sections.store') }}" method="POST" enctype="multipart/form-data"
                class="admin-form">
                @csrf

                {{-- =====================================================
                    BASIC ABOUT SECTION FIELDS
                ====================================================== --}}

                <div class="admin-form-grid">

                    {{-- Main heading --}}
                    <div class="admin-form-group full-width">

                        <label for="main_heading">
                            Main Heading
                            <span class="required">*</span>
                        </label>

                        <input type="text" id="main_heading" name="main_heading"
                            class="admin-form-control
                                @error('main_heading') is-invalid @enderror"
                            value="{{ old('main_heading') }}" placeholder="Enter the About Section main heading" required>

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

                        <input type="text" id="mission_title" name="mission_title"
                            class="admin-form-control
                                @error('mission_title') is-invalid @enderror"
                            value="{{ old('mission_title') }}" placeholder="Example: Mission & Vision" required>

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

                        <input type="text" id="focus_title" name="focus_title"
                            class="admin-form-control
                                @error('focus_title') is-invalid @enderror"
                            value="{{ old('focus_title') }}" placeholder="Example: Focus On Customer" required>

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

                        <textarea id="description" name="description" rows="6"
                            class="admin-form-control
                                @error('description') is-invalid @enderror"
                            placeholder="Enter the About Section description" required>{{ old('description') }}</textarea>

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

                        <input type="number" id="customer_count" name="customer_count" min="0"
                            class="admin-form-control
                                @error('customer_count') is-invalid @enderror"
                            value="{{ old('customer_count', 0) }}" placeholder="Example: 10200" required>

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

                {{-- =====================================================
                    GLOBE LOCATIONS
                ====================================================== --}}

                <div class="admin-form-section">

                    <div class="admin-form-section-header">

                        <div>
                            <h4>Globe Locations</h4>

                            <p>
                                Add location names for the interactive globe.
                            </p>
                        </div>

                        <button type="button" class="btn btn-primary" id="add-location">
                            Add Location
                        </button>

                    </div>

                    <div id="location-container">

                        @foreach ($locations as $index => $location)
                            <div class="location-item">

                                <div class="location-item-header">

                                    <h5>
                                        Location
                                        <span class="location-number">
                                            {{ $loop->iteration }}
                                        </span>
                                    </h5>

                                    <button type="button" class="remove-location-button remove-location"
                                        aria-label="Remove location">
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

                                        <input type="text" name="locations[{{ $index }}][location_name]"
                                            class="admin-form-control
                                                @error("locations.$index.location_name")
                                                    is-invalid
                                                @enderror"
                                            value="{{ old("locations.$index.location_name", $location['location_name'] ?? '') }}"
                                            placeholder="Example: UAE" required>

                                        @error("locations.$index.location_name")
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

                <div class="admin-form-section" id="customer-avatars">

                    <div class="admin-form-section-header">

                        <div>
                            <h4>Customer Avatar Images</h4>

                            <p>
                                Add up to three customer avatar images.
                                Each selected image will be previewed below.
                            </p>
                        </div>

                        <button type="button" class="btn btn-primary" id="add-avatar">
                            Add Avatar
                        </button>

                    </div>

                    <div id="avatar-container" class="avatar-upload-grid">

                        {{-- Initial avatar input --}}
                        <div class="avatar-upload-item">

                            <div class="avatar-upload-header">

                                <h5>
                                    Avatar
                                    <span class="avatar-number">1</span>
                                </h5>

                                <button type="button" class="remove-avatar-button remove-avatar"
                                    aria-label="Remove avatar">
                                    Remove
                                </button>

                            </div>

                            <label class="avatar-upload-box">

                                <input type="file" name="avatar_images[]" class="avatar-file-input"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <img src="" alt="Customer avatar preview" class="avatar-local-preview">

                                <span class="avatar-upload-placeholder">
                                    <strong>Select an image</strong>

                                    <small>
                                        JPG, JPEG, PNG or WEBP
                                    </small>
                                </span>

                            </label>

                        </div>

                    </div>

                    <span class="admin-form-help">
                        Maximum three avatar images. Maximum file size:
                        2 MB per image.
                    </span>

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

                {{-- =====================================================
                    FORM ACTIONS
                ====================================================== --}}

                <div class="admin-form-actions">

                    <button type="submit" class="btn btn-primary">
                        Create About Section
                    </button>

                    <a href="{{ route('admin.about-sections.index') }}" class="btn btn-light">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | Globe locations
            |--------------------------------------------------------------------------
            */

            const locationContainer =
                document.getElementById('location-container');

            const addLocationButton =
                document.getElementById('add-location');

            let locationIndex = locationContainer ?
                locationContainer.querySelectorAll('.location-item').length :
                0;

            function updateLocationNumbers() {
                if (!locationContainer) {
                    return;
                }

                const items =
                    locationContainer.querySelectorAll('.location-item');

                items.forEach(function(item, index) {
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

                addLocationButton.addEventListener('click', function() {

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
                    function(event) {

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

            const avatarContainer =
                document.getElementById('avatar-container');

            const addAvatarButton =
                document.getElementById('add-avatar');

            const maximumAvatars = 3;
            const maximumFileSize = 2 * 1024 * 1024;

            const allowedImageTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            function updateAvatarItems() {
                if (!avatarContainer || !addAvatarButton) {
                    return;
                }

                const items =
                    avatarContainer.querySelectorAll(
                        '.avatar-upload-item'
                    );

                items.forEach(function(item, index) {
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

                const maximumReached =
                    items.length >= maximumAvatars;

                addAvatarButton.disabled = maximumReached;

                addAvatarButton.textContent = maximumReached ?
                    'Maximum 3 Avatars' :
                    'Add Avatar';
            }

            function createAvatarItem() {
                return `
                <div class="avatar-upload-item">

                    <div class="avatar-upload-header">

                        <h5>
                            Avatar
                            <span class="avatar-number"></span>
                        </h5>

                        <button
                            type="button"
                            class="remove-avatar-button remove-avatar"
                            aria-label="Remove avatar"
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
                            alt="Customer avatar preview"
                            class="avatar-local-preview"
                        >

                        <span class="avatar-upload-placeholder">
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

            if (avatarContainer && addAvatarButton) {

                addAvatarButton.addEventListener(
                    'click',
                    function() {

                        const items =
                            avatarContainer.querySelectorAll(
                                '.avatar-upload-item'
                            );

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
                    function(event) {

                        const removeButton =
                            event.target.closest('.remove-avatar');

                        if (!removeButton) {
                            return;
                        }

                        const items =
                            avatarContainer.querySelectorAll(
                                '.avatar-upload-item'
                            );

                        if (items.length <= 1) {
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
                    function(event) {

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
                            return;
                        }

                        if (!allowedImageTypes.includes(file.type)) {
                            alert(
                                'Please select a JPG, JPEG, PNG or WEBP image.'
                            );

                            resetAvatarPreview(uploadItem);
                            return;
                        }

                        if (file.size > maximumFileSize) {
                            alert(
                                'Each avatar image must not exceed 2 MB.'
                            );

                            resetAvatarPreview(uploadItem);
                            return;
                        }

                        const reader = new FileReader();

                        reader.onload = function(loadEvent) {
                            preview.src = loadEvent.target.result;
                            preview.classList.add('show');
                            placeholder.classList.add('hide');
                        };

                        reader.readAsDataURL(file);
                    }
                );

                updateAvatarItems();
            }

        });
    </script>
@endpush
