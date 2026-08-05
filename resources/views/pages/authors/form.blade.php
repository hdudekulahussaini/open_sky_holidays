<div class="ts-form-grid">
    <div class="ts-form-main">

        {{-- Author Name --}}
        <div class="ts-form-group">
            <label for="name" class="ts-label">
                Author Name
                <span class="ts-required">*</span>
            </label>

            <input type="text" name="name" id="name"
                class="ts-input @error('name') ts-input-error @enderror"
                value="{{ old('name', $author->name ?? '') }}"
                placeholder="Example: Sneha Patel"
                required>

            @error('name')
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

            <textarea name="description" id="description" rows="5"
                class="ts-textarea @error('description') ts-input-error @enderror"
                placeholder="Enter author description">{{ old('description', $author->description ?? '') }}</textarea>

            @error('description')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Social Links --}}
        <div class="ts-form-group mb-0">
            <label class="ts-label mb-3">Social Profiles</label>

            <div class="row g-3">
                {{-- Twitter --}}
                <div class="col-md-4">
                    <label for="twitter_url" class="form-label" style="font-size: 0.85rem; color: #64748b; font-weight: 600;">Twitter URL</label>
                    <input type="url" name="twitter_url" id="twitter_url"
                        class="ts-input @error('twitter_url') ts-input-error @enderror"
                        value="{{ old('twitter_url', $author->twitter_url ?? '') }}"
                        placeholder="https://twitter.com/username">

                    @error('twitter_url')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Facebook --}}
                <div class="col-md-4">
                    <label for="facebook_url" class="form-label" style="font-size: 0.85rem; color: #64748b; font-weight: 600;">Facebook URL</label>
                    <input type="url" name="facebook_url" id="facebook_url"
                        class="ts-input @error('facebook_url') ts-input-error @enderror"
                        value="{{ old('facebook_url', $author->facebook_url ?? '') }}"
                        placeholder="https://facebook.com/username">

                    @error('facebook_url')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- LinkedIn --}}
                <div class="col-md-4">
                    <label for="linkedin_url" class="form-label" style="font-size: 0.85rem; color: #64748b; font-weight: 600;">LinkedIn URL</label>
                    <input type="url" name="linkedin_url" id="linkedin_url"
                        class="ts-input @error('linkedin_url') ts-input-error @enderror"
                        value="{{ old('linkedin_url', $author->linkedin_url ?? '') }}"
                        placeholder="https://linkedin.com/in/username">

                    @error('linkedin_url')
                        <span class="ts-error-message">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

    </div>

    <div class="ts-form-sidebar">
        {{-- Author Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Author Image</h3>
                <p>Upload a profile picture for the author.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($author) && $author->image ? asset('storage/' . $author->image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview {{ isset($author) && $author->image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder" class="ts-image-placeholder {{ isset($author) && $author->image ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">✦</span>
                    <strong>No image selected</strong>
                    <small>JPG, PNG or WEBP</small>
                </div>
            </div>

            <label for="image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="image" id="image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp">

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
                <option value="1" @selected(old('status', $author->status ?? 1) == 1)>
                    Active
                </option>
                <option value="0" @selected(old('status', $author->status ?? 1) == 0)>
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
        // Image Preview Logic
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
