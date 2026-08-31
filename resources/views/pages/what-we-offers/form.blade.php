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
                placeholder="Example: Explore Service">

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
                    <small>JPG, PNG, WEBP or AVIF</small>
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
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const imagePlaceholder = document.getElementById('imagePlaceholder');

            imageInput.addEventListener('change', function() {
                const file = this.files[0];

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
        });
    </script>
@endpush
