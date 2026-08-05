<div class="ts-form-grid">
    <div class="ts-form-main">

        <div class="row g-3">
            {{-- Title --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="title" class="ts-label">
                        Title
                        <span class="ts-required">*</span>
                    </label>

                    <input type="text" name="title" id="title"
                        class="ts-input @error('title') ts-input-error @enderror"
                        value="{{ old('title', $offerBanner->title ?? '') }}"
                        placeholder="Example: Savings Worldwide" required>

                    @error('title')
                        <span class="ts-error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Discount Text --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="discount_text" class="ts-label">
                        Discount Text
                        <span class="ts-required">*</span>
                    </label>

                    <input type="text" name="discount_text" id="discount_text"
                        class="ts-input @error('discount_text') ts-input-error @enderror"
                        value="{{ old('discount_text', $offerBanner->discount_text ?? '') }}"
                        placeholder="Example: 20% Off" required>

                    @error('discount_text')
                        <span class="ts-error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Subtitle --}}
        <div class="ts-form-group mt-3">
            <label for="subtitle" class="ts-label">
                Subtitle
                <span class="ts-required">*</span>
            </label>

            <input type="text" name="subtitle" id="subtitle"
                class="ts-input @error('subtitle') ts-input-error @enderror"
                value="{{ old('subtitle', $offerBanner->subtitle ?? '') }}"
                placeholder="Example: Discover Great Deals" required>

            @error('subtitle')
                <span class="ts-error-message">{{ $message }}</span>
            @enderror
        </div>

    </div>

    <div class="ts-form-sidebar">

        {{-- Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Offer Image</h3>
                <p>Upload the promotional banner image.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($offerBanner) && $offerBanner->image ? asset('storage/' . $offerBanner->image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview {{ isset($offerBanner) && $offerBanner->image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder"
                    class="ts-image-placeholder {{ isset($offerBanner) && $offerBanner->image ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">&#10022;</span>
                    <strong>No image selected</strong>
                    <small>JPG, PNG or WEBP &middot; Max 5 MB</small>
                </div>
            </div>

            <label for="image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="image" id="image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp">

            @error('image')
                <span class="ts-error-message">{{ $message }}</span>
            @enderror
        </div>

        {{-- Status --}}
        <div class="admin-form-group">
            <label for="status">
                Status
                <span class="required">*</span>
            </label>

            <select name="status" id="status"
                class="admin-form-control @error('status') is-invalid @enderror" required>
                <option value="1" @selected((string) old('status', $offerBanner->status ?? 1) === '1')>
                    Active
                </option>
                <option value="0" @selected((string) old('status', $offerBanner->status ?? 1) === '0')>
                    Inactive
                </option>
            </select>

            @error('status')
                <span class="admin-form-error">{{ $message }}</span>
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

        if (imageInput && imagePreview && imagePlaceholder) {
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;

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
