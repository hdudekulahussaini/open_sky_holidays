<div class="admin-form-grid">

    {{-- Platform --}}
    <div class="admin-form-group">
        <label for="platform">
            Platform
            <span class="required">*</span>
        </label>

        <input type="text" name="platform" id="platform"
            class="admin-form-control @error('platform') is-invalid @enderror"
            value="{{ old('platform', $testimonial->platform ?? '') }}" placeholder="Example: Google" required>

        @error('platform')
            <span class="admin-form-error">{{ $message }}</span>
        @enderror
    </div>

    {{-- Customer Name --}}
    <div class="admin-form-group">
        <label for="customer_name">
            Customer Name
            <span class="required">*</span>
        </label>

        <input type="text" name="customer_name" id="customer_name"
            class="admin-form-control @error('customer_name') is-invalid @enderror"
            value="{{ old('customer_name', $testimonial->customer_name ?? '') }}" placeholder="Enter customer name"
            required>

        @error('customer_name')
            <span class="admin-form-error">{{ $message }}</span>
        @enderror
    </div>

    {{-- Location --}}
    <div class="admin-form-group">
        <label for="location">Location</label>

        <input type="text" name="location" id="location"
            class="admin-form-control @error('location') is-invalid @enderror"
            value="{{ old('location', $testimonial->location ?? '') }}" placeholder="Example: Bengaluru">

        @error('location')
            <span class="admin-form-error">{{ $message }}</span>
        @enderror
    </div>

    {{-- Rating --}}
    <div class="admin-form-group">
        <label for="rating">
            Rating
            <span class="required">*</span>
        </label>

        <select name="rating" id="rating" class="admin-form-control @error('rating') is-invalid @enderror" required>
            <option value="">Select Rating</option>
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}"
                    {{ old('rating', $testimonial->rating ?? '') == $i ? 'selected' : '' }}>
                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                </option>
            @endfor
        </select>

        @error('rating')
            <span class="admin-form-error">{{ $message }}</span>
        @enderror
    </div>

    {{-- Review Date --}}
    <div class="admin-form-group">
        <label for="reviewed_at">
            Review Date
            <span class="required">*</span>
        </label>

        <input type="datetime-local" name="reviewed_at" id="reviewed_at"
            class="admin-form-control @error('reviewed_at') is-invalid @enderror"
            value="{{ old('reviewed_at', isset($testimonial->reviewed_at) ? \Carbon\Carbon::parse($testimonial->reviewed_at)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
            required>

        @error('reviewed_at')
            <span class="admin-form-error">{{ $message }}</span>
        @enderror
    </div>

    {{-- Customer Image --}}
    <div class="admin-form-group">
        <label for="customer_image">Customer Image</label>

        <input type="file" name="customer_image" id="customer_image"
            class="admin-form-control @error('customer_image') is-invalid @enderror image-preview-input"
            accept="image/*" data-preview="#customerImagePreview">

        @error('customer_image')
            <span class="admin-form-error">{{ $message }}</span>
        @enderror

        <div class="mt-2">
            <img id="customerImagePreview"
                src="{{ isset($testimonial) && $testimonial->customer_image ? asset('storage/' . $testimonial->customer_image) : '' }}"
                class="image-preview {{ isset($testimonial) && $testimonial->customer_image ? 'show' : '' }}"
                alt="Preview">
        </div>
    </div>
    {{-- Review --}}
    <div class="admin-form-group full-width">
        <label for="review">
            Review
            <span class="required">*</span>
        </label>

        <textarea name="review" id="review" rows="5" class="admin-form-control @error('review') is-invalid @enderror"
            placeholder="Write customer review..." required>{{ old('review', $testimonial->review ?? '') }}</textarea>

        @error('review')
            <span class="admin-form-error">{{ $message }}</span>
        @enderror
    </div>
    {{-- Status --}}
    <div class="admin-form-group">
        <label for="status">
            Status
            <span class="required">*</span>
        </label>

        <select name="status" id="status" class="admin-form-control" required>
            <option value="1" {{ old('status', $testimonial->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0" {{ old('status', $testimonial->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

</div>

<div class="admin-form-actions">
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">
        Cancel
    </a>

    <button type="submit" class="btn btn-primary">
        {{ $buttonText ?? 'Save Testimonial' }}
    </button>
</div>
