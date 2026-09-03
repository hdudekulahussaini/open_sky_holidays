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

                    {{-- Mission title & Icon --}}
                    <div class="admin-form-group">

                        <label for="mission_title">
                            <i class="fa-solid fa-bullseye text-danger me-1"></i>
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

                    <div class="admin-form-group">

                        <label for="mission_icon">
                            <i id="mission_icon_preview" class="{{ old('mission_icon', 'fa-solid fa-bullseye') }} text-danger me-1"></i>
                            Mission Icon (FontAwesome Class)
                        </label>

                        <div style="display: flex; gap: 8px; align-items: center;">
                            <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(220,53,69,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #dc3545; flex-shrink: 0;">
                                <i id="mission_icon_box" class="{{ old('mission_icon', 'fa-solid fa-bullseye') }}"></i>
                            </div>
                            <input type="text" id="mission_icon" name="mission_icon"
                                class="admin-form-control @error('mission_icon') is-invalid @enderror"
                                value="{{ old('mission_icon', 'fa-solid fa-bullseye') }}"
                                placeholder="e.g. fa-solid fa-bullseye"
                                oninput="document.getElementById('mission_icon_preview').className = this.value + ' text-danger me-1'; document.getElementById('mission_icon_box').className = this.value;">
                        </div>

                        <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 6px;">
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setMissionIcon('fa-solid fa-bullseye')"><i class="fa-solid fa-bullseye text-danger me-1"></i> Bullseye</button>
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setMissionIcon('fa-solid fa-rocket')"><i class="fa-solid fa-rocket text-primary me-1"></i> Rocket</button>
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setMissionIcon('fa-solid fa-flag')"><i class="fa-solid fa-flag text-success me-1"></i> Flag</button>
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setMissionIcon('fa-solid fa-compass')"><i class="fa-solid fa-compass text-info me-1"></i> Compass</button>
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setMissionIcon('fa-solid fa-trophy')"><i class="fa-solid fa-trophy text-warning me-1"></i> Trophy</button>
                        </div>

                        @error('mission_icon')
                            <span class="admin-form-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                    {{-- Focus title & Icon --}}
                    <div class="admin-form-group">

                        <label for="focus_title">
                            <i class="fa-solid fa-crosshairs text-success me-1"></i>
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

                    <div class="admin-form-group">

                        <label for="focus_icon">
                            <i id="focus_icon_preview" class="{{ old('focus_icon', 'fa-solid fa-crosshairs') }} text-success me-1"></i>
                            Focus Icon (FontAwesome Class)
                        </label>

                        <div style="display: flex; gap: 8px; align-items: center;">
                            <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(40,167,69,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #28a745; flex-shrink: 0;">
                                <i id="focus_icon_box" class="{{ old('focus_icon', 'fa-solid fa-crosshairs') }}"></i>
                            </div>
                            <input type="text" id="focus_icon" name="focus_icon"
                                class="admin-form-control @error('focus_icon') is-invalid @enderror"
                                value="{{ old('focus_icon', 'fa-solid fa-crosshairs') }}"
                                placeholder="e.g. fa-solid fa-crosshairs"
                                oninput="document.getElementById('focus_icon_preview').className = this.value + ' text-success me-1'; document.getElementById('focus_icon_box').className = this.value;">
                        </div>

                        <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 6px;">
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setFocusIcon('fa-solid fa-crosshairs')"><i class="fa-solid fa-crosshairs text-success me-1"></i> Crosshairs</button>
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setFocusIcon('fa-solid fa-eye')"><i class="fa-solid fa-eye text-primary me-1"></i> Eye</button>
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setFocusIcon('fa-solid fa-users')"><i class="fa-solid fa-users text-info me-1"></i> Users</button>
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setFocusIcon('fa-solid fa-heart')"><i class="fa-solid fa-heart text-danger me-1"></i> Heart</button>
                            <button type="button" class="btn btn-sm btn-light" style="padding: 2px 8px; font-size: 0.75rem;" onclick="setFocusIcon('fa-solid fa-handshake')"><i class="fa-solid fa-handshake text-warning me-1"></i> Handshake</button>
                        </div>

                        @error('focus_icon')
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
                    GLOBE LOCATIONS / DESTINATIONS
                ====================================================== --}}

                <div class="admin-form-section">

                    <div class="admin-form-section-header">

                        <div>
                            <h4>
                                <i class="fa-solid fa-earth-americas text-primary me-2"></i>
                                Explore Our Destinations
                            </h4>

                            <p>
                                Add and manage country locations for the interactive destinations globe.
                            </p>
                        </div>

                        <button type="button" class="btn btn-primary" id="add-location">
                            <i class="fa-solid fa-plus me-1"></i>
                            Add Location
                        </button>

                    </div>

                    {{-- Destinations Tagline / Subtitle Input --}}
                    <div class="admin-form-group" style="margin-bottom: 24px; padding: 16px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <label for="destinations_subtitle">
                            <i class="fa-solid fa-comment-dots text-info me-1"></i>
                            Destinations Tagline / Subtitle
                        </label>
                        <input type="text" id="destinations_subtitle" name="destinations_subtitle"
                            class="admin-form-control @error('destinations_subtitle') is-invalid @enderror"
                            value="{{ old('destinations_subtitle', 'Click any country to view tours') }}"
                            placeholder="Example: Click any country to view tours">
                        @error('destinations_subtitle')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div id="location-container">

                        @foreach ($locations as $index => $location)
                            <div class="location-item">

                                <div class="location-item-header">

                                    <h5>
                                        <i class="fa-solid fa-location-dot text-danger me-1"></i>
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
                                            <i class="fa-solid fa-map-pin text-primary me-1"></i>
                                            Country / Location Name
                                            <span class="required">*</span>
                                        </label>

                                        <input type="text" name="locations[{{ $index }}][location_name]"
                                            class="admin-form-control
                                                @error("locations.$index.location_name")
                                                    is-invalid
                                                @enderror"
                                            value="{{ old("locations.$index.location_name", $location['location_name'] ?? '') }}"
                                            placeholder="Example: India, UAE, Switzerland, Bali, Dubai" required>

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
                                Upload customer avatar images.
                            </p>
                        </div>

                    </div>

                    <div class="avatar-normal-upload-container">
                        <input
                            type="file"
                            name="avatar_images[]"
                            id="avatar_images_input"
                            class="admin-form-control"
                            multiple
                            accept=".jpg,.jpeg,.png,.webp,.avif,image/*"
                        >
                        <span class="admin-form-help mt-1 d-block">
                            You can select multiple images (JPG, JPEG, PNG, WEBP, AVIF). Max size: 5 MB per file.
                        </span>
                    </div>

                    {{-- Dynamic live preview of newly selected files --}}
                    <div id="new-avatars-preview-grid" class="avatar-preview-grid mt-3" style="display: none;"></div>

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
                                <i class="fa-solid fa-location-dot text-danger me-1"></i>
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
                                    <i class="fa-solid fa-map-pin text-primary me-1"></i>
                                    Country / Location Name
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="locations[${locationIndex}][location_name]"
                                    class="admin-form-control"
                                    placeholder="Example: India, UAE, Switzerland, Bali, Dubai"
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
            | Customer avatar live upload preview
            |--------------------------------------------------------------------------
            */

            const avatarInput = document.getElementById('avatar_images_input');
            const previewGrid = document.getElementById('new-avatars-preview-grid');

            if (avatarInput && previewGrid) {
                avatarInput.addEventListener('change', function () {
                    previewGrid.innerHTML = '';
                    const files = Array.from(this.files || []);

                    if (files.length === 0) {
                        previewGrid.style.display = 'none';
                        return;
                    }

                    previewGrid.style.display = 'grid';

                    files.forEach(function (file, index) {
                        if (!file.type.startsWith('image/')) return;

                        const card = document.createElement('div');
                        card.className = 'avatar-preview-card';
                        card.innerHTML = `
                            <div class="avatar-preview-media">
                                <img class="avatar-preview-image" src="" alt="New avatar ${index + 1}">
                                <span class="avatar-existing-badge" style="background: #10b981; color: #fff;">New</span>
                            </div>
                            <div style="font-size: 11px; color: #64748b; text-align: center; margin-top: 8px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 130px;">
                                ${file.name}
                            </div>
                        `;

                        const img = card.querySelector('img');
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);

                        previewGrid.appendChild(card);
                    });
                });
            }

        });

        function setMissionIcon(iconClass) {
            document.getElementById('mission_icon').value = iconClass;
            document.getElementById('mission_icon_preview').className = iconClass + ' text-danger me-1';
            document.getElementById('mission_icon_box').className = iconClass;
        }

        function setFocusIcon(iconClass) {
            document.getElementById('focus_icon').value = iconClass;
            document.getElementById('focus_icon_preview').className = iconClass + ' text-success me-1';
            document.getElementById('focus_icon_box').className = iconClass;
        }
    </script>
@endpush
