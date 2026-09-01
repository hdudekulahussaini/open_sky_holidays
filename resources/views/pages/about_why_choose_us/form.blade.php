@php
    $oldTitles = old('features_title', $aboutWhyChooseUs->features_title ?? ['']);
    $oldIcons = old('features_icon', $aboutWhyChooseUs->features_icon ?? ['fa-solid fa-circle-check']);
    $oldDescriptions = old('features_description', $aboutWhyChooseUs->features_description ?? ['']);
    $featuresCount = max(count($oldTitles), 1);
@endphp

<div class="ts-form-grid">
    <div class="ts-form-main">

        {{-- Subtitle & Title Row --}}
        <div class="row g-3">
            <div class="col-md-4">
                <div class="ts-form-group">
                    <label for="subtitle" class="ts-label">
                        Subtitle / Eyebrow
                    </label>

                    <input type="text" name="subtitle" id="subtitle"
                        class="ts-input @error('subtitle') ts-input-error @enderror"
                        value="{{ old('subtitle', $aboutWhyChooseUs->subtitle ?? 'Why Choose Us') }}"
                        placeholder="e.g. Why Choose Us">

                    @error('subtitle')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-8">
                <div class="ts-form-group">
                    <label for="title" class="ts-label">
                        Main Heading
                        <span class="ts-required">*</span>
                    </label>

                    <input type="text" name="title" id="title"
                        class="ts-input @error('title') ts-input-error @enderror"
                        value="{{ old('title', $aboutWhyChooseUs->title ?? '') }}"
                        placeholder="e.g. Setting Standard for Trust and Comfort." required>

                    @error('title')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="ts-form-group">
            <label for="description" class="ts-label">
                Main Description
            </label>

            <textarea name="description" id="description" rows="4"
                class="ts-textarea @error('description') ts-input-error @enderror"
                placeholder="Enter description explaining trust and comfort...">{{ old('description', $aboutWhyChooseUs->description ?? '') }}</textarea>

            @error('description')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Features Builder with Icon, Title, Description --}}
        <div class="ts-form-group">
            <div class="ts-feature-heading d-flex justify-content-between align-items-center mb-3">
                <div>
                    <label class="ts-label mb-0">
                        Why Choose Us Features List
                    </label>
                    <p class="ts-field-note text-muted small mb-0">
                        Add benefits with custom FontAwesome icons, titles, and descriptions.
                    </p>
                </div>

                <button type="button" class="ts-add-feature-btn" id="addFeatureButton">
                    <span>+</span>
                    Add Feature
                </button>
            </div>

            <div id="featuresContainer" class="ts-features-container">
                @for ($index = 0; $index < $featuresCount; $index++)
                    @php
                        $curIcon = $oldIcons[$index] ?? 'fa-solid fa-circle-check';
                    @endphp
                    <div class="feature-card border rounded-3 p-3 mb-3 js-feature-card" style="background: #ffffff; border-color: #e2e8f0 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary-subtle text-primary fw-bold feature-number">
                                    Feature {{ $index + 1 }}
                                </span>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-danger remove-feature" title="Delete feature">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>

                        <div class="feature-fields">
                            <div class="row g-3 mb-3">
                                {{-- Feature Title --}}
                                <div class="col-md-7">
                                    <label class="ts-label form-label fw-semibold">
                                        Feature Title <span class="ts-required">*</span>
                                    </label>
                                    <input type="text" name="features_title[]"
                                        value="{{ $oldTitles[$index] ?? '' }}"
                                        class="ts-input form-control @error('features_title.' . $index) ts-input-error @enderror"
                                        placeholder="e.g. 24/7 Expert Support" required>
                                    @error('features_title.' . $index)
                                        <span class="ts-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                {{-- Feature Icon --}}
                                <div class="col-md-5">
                                    <label class="ts-label form-label fw-semibold">
                                        <i class="fa-solid fa-icons text-warning me-1"></i> Feature Icon
                                    </label>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="js-icon-preview" style="width: 38px; height: 38px; border-radius: 6px; background: rgba(13,110,253,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.15rem; color: #0d6efd; flex-shrink: 0;">
                                            <i class="{{ $curIcon ?: 'fa-solid fa-circle-check' }}"></i>
                                        </div>
                                        <input type="text" name="features_icon[]"
                                            value="{{ $curIcon }}"
                                            class="ts-input form-control js-icon-input @error('features_icon.' . $index) ts-input-error @enderror"
                                            placeholder="fa-solid fa-headset">
                                    </div>

                                    {{-- Quick icon suggestions --}}
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-headset" style="font-size: 0.72rem; padding: 2px 6px;" title="24/7 Support"><i class="fa-solid fa-headset text-primary"></i> Support</button>
                                        <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-hand-holding-dollar" style="font-size: 0.72rem; padding: 2px 6px;" title="Transparent Pricing"><i class="fa-solid fa-hand-holding-dollar text-success"></i> Pricing</button>
                                        <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-location-dot" style="font-size: 0.72rem; padding: 2px 6px;" title="Local Expertise"><i class="fa-solid fa-location-dot text-danger"></i> Local</button>
                                        <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-hotel" style="font-size: 0.72rem; padding: 2px 6px;" title="Accommodations"><i class="fa-solid fa-hotel text-warning"></i> Hotel</button>
                                        <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-shield-halved" style="font-size: 0.72rem; padding: 2px 6px;" title="Safety"><i class="fa-solid fa-shield-halved text-info"></i> Safety</button>
                                        <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-star" style="font-size: 0.72rem; padding: 2px 6px;" title="5-Star"><i class="fa-solid fa-star text-warning"></i> Star</button>
                                    </div>
                                    @error('features_icon.' . $index)
                                        <span class="ts-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Feature Description --}}
                            <div class="ts-form-group mb-0">
                                <label class="ts-label form-label fw-semibold">Feature Description</label>
                                <textarea name="features_description[]" rows="2"
                                    class="ts-textarea form-control @error('features_description.' . $index) ts-input-error @enderror"
                                    placeholder="Enter description explaining this benefit...">{{ $oldDescriptions[$index] ?? '' }}</textarea>
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

        {{-- Floating Trust Badge Card Section --}}
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0 !important;">
            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                <i class="fa-solid fa-certificate text-primary fs-5"></i>
                <div>
                    <h6 class="mb-0 fw-bold">Floating Image Trust Card (Badge)</h6>
                    <small class="text-muted">Displays the floating badge over the section image on the website.</small>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="badge_title" class="ts-label form-label fw-semibold">
                        Badge Title
                    </label>
                    <input type="text" name="badge_title" id="badge_title"
                        class="ts-input form-control @error('badge_title') ts-input-error @enderror"
                        value="{{ old('badge_title', $aboutWhyChooseUs->badge_title ?? 'Trusted by 15,000+') }}"
                        placeholder="e.g. Trusted by 15,000+">
                    @error('badge_title')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="badge_subtitle" class="ts-label form-label fw-semibold">
                        Badge Subtitle / Description
                    </label>
                    <input type="text" name="badge_subtitle" id="badge_subtitle"
                        class="ts-input form-control @error('badge_subtitle') ts-input-error @enderror"
                        value="{{ old('badge_subtitle', $aboutWhyChooseUs->badge_subtitle ?? 'Happy travelers worldwide') }}"
                        placeholder="e.g. Happy travelers worldwide">
                    @error('badge_subtitle')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

    </div>

    <div class="ts-form-sidebar">

        {{-- Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Section Image</h3>
                <p>Upload the Why Choose Us photo.</p>
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
                    <small>JPG, PNG, WEBP or AVIF &middot; Max 5 MB</small>
                </div>
            </div>

            <label for="image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="image" id="image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp,.avif,image/*">

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
                class="admin-form-control @error('status') is-invalid @enderror"
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
            const cards = container.querySelectorAll('.js-feature-card');
            cards.forEach(function (card, index) {
                const number = card.querySelector('.feature-number');
                if (number) {
                    number.textContent = `Feature ${index + 1}`;
                }
            });
        }

        function setupIconCard(card) {
            const iconInput = card.querySelector('.js-icon-input');
            const preview = card.querySelector('.js-icon-preview i');
            const presetButtons = card.querySelectorAll('.js-preset-icon-btn');

            if (iconInput && preview) {
                iconInput.addEventListener('input', function() {
                    preview.className = this.value.trim() || 'fa-solid fa-circle-check';
                });
            }

            presetButtons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const icon = this.getAttribute('data-icon');
                    if (iconInput && preview) {
                        iconInput.value = icon;
                        preview.className = icon;
                    }
                });
            });
        }

        // Initialize existing feature cards
        container.querySelectorAll('.js-feature-card').forEach(setupIconCard);

        addButton.addEventListener('click', function () {
            const count = container.querySelectorAll('.js-feature-card').length;
            if (count >= 10) {
                alert('Maximum 10 features are allowed.');
                return;
            }

            const card = document.createElement('div');
            card.className = 'feature-card border rounded-3 p-3 mb-3 js-feature-card';
            card.style.cssText = 'background: #ffffff; border-color: #e2e8f0 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.03);';

            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-subtle text-primary fw-bold feature-number">
                            Feature ${count + 1}
                        </span>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-danger remove-feature" title="Delete feature">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>

                <div class="feature-fields">
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label class="ts-label form-label fw-semibold">
                                Feature Title <span class="ts-required">*</span>
                            </label>
                            <input type="text" name="features_title[]" class="ts-input form-control" placeholder="e.g. 24/7 Expert Support" required>
                        </div>

                        <div class="col-md-5">
                            <label class="ts-label form-label fw-semibold">
                                <i class="fa-solid fa-icons text-warning me-1"></i> Feature Icon
                            </label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="js-icon-preview" style="width: 38px; height: 38px; border-radius: 6px; background: rgba(13,110,253,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.15rem; color: #0d6efd; flex-shrink: 0;">
                                    <i class="fa-solid fa-circle-check"></i>
                                </div>
                                <input type="text" name="features_icon[]" class="ts-input form-control js-icon-input" value="fa-solid fa-circle-check" placeholder="fa-solid fa-headset">
                            </div>

                            <div class="d-flex flex-wrap gap-1 mt-1">
                                <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-headset" style="font-size: 0.72rem; padding: 2px 6px;" title="24/7 Support"><i class="fa-solid fa-headset text-primary"></i> Support</button>
                                <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-hand-holding-dollar" style="font-size: 0.72rem; padding: 2px 6px;" title="Transparent Pricing"><i class="fa-solid fa-hand-holding-dollar text-success"></i> Pricing</button>
                                <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-location-dot" style="font-size: 0.72rem; padding: 2px 6px;" title="Local Expertise"><i class="fa-solid fa-location-dot text-danger"></i> Local</button>
                                <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-hotel" style="font-size: 0.72rem; padding: 2px 6px;" title="Accommodations"><i class="fa-solid fa-hotel text-warning"></i> Hotel</button>
                                <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-shield-halved" style="font-size: 0.72rem; padding: 2px 6px;" title="Safety"><i class="fa-solid fa-shield-halved text-info"></i> Safety</button>
                                <button type="button" class="btn btn-sm btn-light border js-preset-icon-btn" data-icon="fa-solid fa-star" style="font-size: 0.72rem; padding: 2px 6px;" title="5-Star"><i class="fa-solid fa-star text-warning"></i> Star</button>
                            </div>
                        </div>
                    </div>

                    <div class="ts-form-group mb-0">
                        <label class="ts-label form-label fw-semibold">Feature Description</label>
                        <textarea name="features_description[]" rows="2" class="ts-textarea form-control" placeholder="Enter description explaining this benefit..."></textarea>
                    </div>
                </div>
            `;

            container.appendChild(card);
            setupIconCard(card);
            updateNumbers();
            card.querySelector('input[name="features_title[]"]').focus();
        });

        container.addEventListener('click', function (event) {
            const button = event.target.closest('.remove-feature');
            if (!button) return;

            const cards = container.querySelectorAll('.js-feature-card');
            if (cards.length === 1) {
                alert('At least one feature is required.');
                return;
            }

            button.closest('.js-feature-card').remove();
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
