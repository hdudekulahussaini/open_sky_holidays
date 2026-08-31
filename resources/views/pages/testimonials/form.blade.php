<div class="ts-form-grid">
    <div class="ts-form-main">

        {{-- Customer Name --}}
        <div class="ts-form-group">
            <label for="customer_name" class="ts-label">
                Customer Name
                <span class="ts-required">*</span>
            </label>

            <input type="text" name="customer_name" id="customer_name"
                class="ts-input @error('customer_name') ts-input-error @enderror"
                value="{{ old('customer_name', $testimonial->customer_name ?? '') }}"
                placeholder="Enter customer name"
                required>

            @error('customer_name')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Location --}}
        <div class="ts-form-group">
            <label for="location" class="ts-label">
                Location
            </label>

            <input type="text" name="location" id="location"
                class="ts-input @error('location') ts-input-error @enderror"
                value="{{ old('location', $testimonial->location ?? '') }}"
                placeholder="Example: Bengaluru">

            @error('location')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Review --}}
        <div class="ts-form-group">
            <label for="review" class="ts-label">
                Review
                <span class="ts-required">*</span>
            </label>

            <textarea name="review" id="review" rows="6"
                class="ts-textarea @error('review') ts-input-error @enderror"
                placeholder="Write customer review..."
                required>{{ old('review', $testimonial->review ?? '') }}</textarea>

            @error('review')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="row g-3">
            {{-- Platform --}}
            <div class="col-6">
                <div class="admin-form-group mb-0">
                    <label for="platform">Platform <span class="required">*</span></label>
                    <input type="text" name="platform" id="platform" class="admin-form-control @error('platform') is-invalid @enderror" value="{{ old('platform', $testimonial->platform ?? '') }}" placeholder="e.g. Google" required>
                    @error('platform')<span class="admin-form-error">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Rating --}}
            <div class="col-6">
                <div class="admin-form-group mb-0">
                    <label for="rating">Rating <span class="required">*</span></label>
                    <select name="rating" id="rating" class="admin-form-control @error('rating') is-invalid @enderror" required>
                        <option value="">Select Rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')<span class="admin-form-error">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Review Date --}}
            <div class="col-12">
                <div class="admin-form-group mb-0">
                    <label for="reviewed_at">Review Date <span class="required">*</span></label>
                    <input type="datetime-local" name="reviewed_at" id="reviewed_at" class="admin-form-control @error('reviewed_at') is-invalid @enderror" value="{{ old('reviewed_at', isset($testimonial->reviewed_at) ? \Carbon\Carbon::parse($testimonial->reviewed_at)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required>
                    @error('reviewed_at')<span class="admin-form-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

    </div>

    <div class="ts-form-sidebar">
        {{-- Customer Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Customer Image</h3>
                <p>Upload a profile picture of the customer.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($testimonial) && $testimonial->customer_image ? asset('storage/' . $testimonial->customer_image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview {{ isset($testimonial) && $testimonial->customer_image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder" class="ts-image-placeholder {{ isset($testimonial) && $testimonial->customer_image ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">✦</span>
                    <strong>No image selected</strong>
                    <small>JPG, PNG, WEBP or AVIF</small>
                </div>
            </div>

            <label for="customer_image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="customer_image" id="customer_image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp,.avif,image/*">

            @error('customer_image')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Status --}}
        <div class="admin-form-group">
            <label for="status">Status <span class="required">*</span></label>
            <select name="status" id="status" class="admin-form-control" required>
                <option value="1" {{ old('status', $testimonial->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $testimonial->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Image Preview Logic
        const imageInput = document.getElementById('customer_image');
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
