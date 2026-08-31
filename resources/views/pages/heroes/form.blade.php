<div class="ts-form-grid">
    <div class="ts-form-main">

        <div class="row g-3">
            {{-- Title --}}
            <div class="col-md-8">
                <div class="ts-form-group mb-0">
                    <label for="title" class="ts-label">
                        Title
                        <span class="ts-required">*</span>
                    </label>

                    <input type="text" name="title" id="title"
                        class="ts-input @error('title') ts-input-error @enderror"
                        value="{{ old('title', $hero->title ?? '') }}"
                        placeholder="Enter hero title" required>

                    @error('title')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            {{-- Slider Order --}}
            <div class="col-md-4">
                <div class="ts-form-group mb-0">
                    <label for="sort_order" class="ts-label">
                        Slider Order
                    </label>

                    <input type="number" name="sort_order" id="sort_order" min="0"
                        class="ts-input @error('sort_order') ts-input-error @enderror"
                        value="{{ old('sort_order', $hero->sort_order ?? 0) }}"
                        placeholder="e.g. 0">

                    @error('sort_order')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            {{-- Button Text --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="button_text" class="ts-label">
                        Button Text
                    </label>

                    <input type="text" name="button_text" id="button_text"
                        class="ts-input @error('button_text') ts-input-error @enderror"
                        value="{{ old('button_text', $hero->button_text ?? 'Explore More') }}"
                        placeholder="e.g. Explore More">

                    @error('button_text')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            {{-- Button Link --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="button_link" class="ts-label">
                        Button Link / URL
                    </label>

                    <input type="text" name="button_link" id="button_link"
                        class="ts-input @error('button_link') ts-input-error @enderror"
                        value="{{ old('button_link', $hero->button_link ?? '/tours') }}"
                        placeholder="e.g. /tours or https://example.com">

                    @error('button_link')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        
        {{-- Helper for links --}}
        <div class="ts-field-note mt-2">
            Common site page links: 
            <code>/tours</code>, <code>/about</code>, <code>/services</code>, 
            <code>/blogs</code>, <code>/contact</code>, <code>/adventures</code>, 
            or full external URL (e.g. <code>https://example.com</code>).
        </div>

        {{-- Description --}}
        <div class="ts-form-group mt-4">
            <label for="description" class="ts-label">
                Description
            </label>

            <textarea name="description" id="description" rows="5"
                class="ts-textarea @error('description') ts-input-error @enderror"
                placeholder="Enter hero description">{{ old('description', $hero->description ?? '') }}</textarea>

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
                <h3>Hero Image</h3>
                <p>Upload the hero banner image.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($hero) && $hero->image ? asset('storage/' . $hero->image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview
                        {{ isset($hero) && $hero->image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder"
                    class="ts-image-placeholder
                        {{ isset($hero) && $hero->image ? 'ts-hidden' : '' }}">
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

            <select id="status" name="status" class="admin-form-control @error('status') is-invalid @enderror" required>
                <option value="1" @selected(old('status', $hero->status ?? 1) == 1)>
                    Active
                </option>
                <option value="0" @selected(old('status', $hero->status ?? 1) == 0)>
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

        if (imageInput && imagePreview && imagePlaceholder) {
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
        }
    });
</script>
@endpush
