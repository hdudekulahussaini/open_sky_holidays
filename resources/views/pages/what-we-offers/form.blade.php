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
                value="{{ old('title', $whatWeOffer->title ?? '') }}"
                placeholder="Example: Domestic Tours">

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
                value="{{ old('subtitle', $whatWeOffer->subtitle ?? '') }}"
                placeholder="Example: DISCOVER INCREDIBLE INDIA">

            @error('subtitle')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Icon --}}
        <div class="ts-form-group">
            <label for="icon" class="ts-label">
                Badge Icon (FontAwesome Class)
            </label>

            <div style="display: flex; gap: 10px; align-items: center;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: #ffaa00; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #111; flex-shrink: 0; box-shadow: 0 2px 8px rgba(255, 170, 0, 0.35);">
                    <i id="offerIconPreview" class="{{ old('icon', $whatWeOffer->icon ?? 'fa-solid fa-location-dot') }}"></i>
                </div>
                <input type="text" name="icon" id="offerIconInput"
                    class="ts-input @error('icon') ts-input-error @enderror"
                    value="{{ old('icon', $whatWeOffer->icon ?? 'fa-solid fa-location-dot') }}"
                    placeholder="e.g. fa-solid fa-location-dot"
                    oninput="updateOfferIconPreview(this.value)">
            </div>

            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px;">
                <button type="button" class="btn btn-sm btn-light border" style="padding: 4px 12px; font-size: 0.82rem; font-weight: 500;" onclick="pickOfferIcon('fa-solid fa-location-dot')">
                    <i class="fa-solid fa-location-dot text-warning me-1"></i> Domestic Tours (Pin)
                </button>
                <button type="button" class="btn btn-sm btn-light border" style="padding: 4px 12px; font-size: 0.82rem; font-weight: 500;" onclick="pickOfferIcon('fa-solid fa-globe')">
                    <i class="fa-solid fa-globe text-primary me-1"></i> International Tours (Globe)
                </button>
                <button type="button" class="btn btn-sm btn-light border" style="padding: 4px 12px; font-size: 0.82rem; font-weight: 500;" onclick="pickOfferIcon('fa-regular fa-file-lines')">
                    <i class="fa-regular fa-file-lines text-info me-1"></i> Visa Services (Document)
                </button>
                <button type="button" class="btn btn-sm btn-light border" style="padding: 4px 12px; font-size: 0.82rem; font-weight: 500;" onclick="pickOfferIcon('fa-solid fa-plane-departure')">
                    <i class="fa-solid fa-plane-departure text-success me-1"></i> Flight Tickets (Plane)
                </button>
                <button type="button" class="btn btn-sm btn-light border" style="padding: 4px 12px; font-size: 0.82rem; font-weight: 500;" onclick="pickOfferIcon('fa-solid fa-passport')">
                    <i class="fa-solid fa-passport text-danger me-1"></i> Passport Services (Passport)
                </button>
            </div>

            @error('icon')
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

            <textarea name="description" id="description" rows="7"
                class="ts-textarea @error('description') ts-input-error @enderror" placeholder="Enter the What We Offer description">{{ old('description', $whatWeOffer->description ?? '') }}</textarea>

            <div class="ts-field-note">
                Maximum 3000 characters.
            </div>

            @error('description')
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
                <h3>Offer Image</h3>
                <p>Upload the what we offer image.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($whatWeOffer) && $whatWeOffer->image ? asset('storage/' . $whatWeOffer->image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview
                        {{ isset($whatWeOffer) && $whatWeOffer->image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder"
                    class="ts-image-placeholder
                        {{ isset($whatWeOffer) && $whatWeOffer->image ? 'ts-hidden' : '' }}">
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
                class="admin-form-control
                                @error('status') is-invalid @enderror"
                required>
                <option value="active" @selected(old('status', $whatWeOffer->status ?? 'active') == 'active')>
                    Active
                </option>

                <option value="inactive" @selected(old('status', $whatWeOffer->status ?? 'active') == 'inactive')>
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
        function updateOfferIconPreview(iconClass) {
            const preview = document.getElementById('offerIconPreview');
            if (preview) {
                preview.className = iconClass.trim() || 'fa-solid fa-location-dot';
            }
        }

        function pickOfferIcon(iconClass) {
            const input = document.getElementById('offerIconInput');
            if (input) {
                input.value = iconClass;
                updateOfferIconPreview(iconClass);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePlaceholder = document.getElementById('imagePlaceholder');

            if (imageInput && imagePreview && imagePlaceholder) {
                imageInput.addEventListener('change', function() {
                    const file = this.files && this.files[0];

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
            }
        });
    </script>
@endpush
