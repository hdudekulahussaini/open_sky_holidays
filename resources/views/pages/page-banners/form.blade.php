<div class="ts-form-grid">
    <div class="ts-form-main">
        
        @if(empty($availablePages) && !isset($pageBanner))
            <div class="alert alert-warning mb-4">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                All page banners for site pages have already been created. You can manage existing banners from the <a href="{{ route('admin.page-banners.index') }}" class="alert-link">Page Banners List</a>.
            </div>
        @endif

        <div class="row g-3">
            {{-- Page Name --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="page" class="ts-label">
                        Page Name <span class="ts-required">*</span>
                    </label>

                    <select id="page" name="page"
                        class="ts-input @error('page') ts-input-error @enderror"
                        @if(empty($availablePages) && !isset($pageBanner)) disabled @endif>
                        
                        <option value="">Select an option</option>
                        
                        {{-- In edit mode, the current page might not be in $availablePages if it's already used, so we need to ensure it shows up --}}
                        @if(isset($pageBanner) && !array_key_exists($pageBanner->page, $availablePages))
                            <option value="{{ $pageBanner->page }}" selected>
                                {{ ucfirst(str_replace('-', ' ', $pageBanner->page)) }}
                            </option>
                        @endif

                        @foreach ($availablePages as $slug => $label)
                            <option value="{{ $slug }}" @selected(old('page', $pageBanner->page ?? '') == $slug)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <div class="ts-field-note mt-1">
                        Pages with existing banners are automatically hidden from this list.
                    </div>

                    @error('page')
                        <span class="ts-error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Small Label --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="label" class="ts-label">
                        Small Label
                    </label>

                    <input type="text" name="label" id="label"
                        class="ts-input @error('label') ts-input-error @enderror"
                        value="{{ old('label', $pageBanner->label ?? '') }}"
                        placeholder="e.g. WHO WE ARE">

                    @error('label')
                        <span class="ts-error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Banner Title --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="title" class="ts-label">
                        Banner Title
                    </label>

                    <input type="text" name="title" id="title"
                        class="ts-input @error('title') ts-input-error @enderror"
                        value="{{ old('title', $pageBanner->title ?? '') }}"
                        placeholder="e.g. About Us">

                    @error('title')
                        <span class="ts-error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Breadcrumb Title --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="breadcrumb_title" class="ts-label">
                        Breadcrumb Title
                    </label>

                    <input type="text" name="breadcrumb_title" id="breadcrumb_title"
                        class="ts-input @error('breadcrumb_title') ts-input-error @enderror"
                        value="{{ old('breadcrumb_title', $pageBanner->breadcrumb_title ?? '') }}"
                        placeholder="e.g. About Us">

                    @error('breadcrumb_title')
                        <span class="ts-error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="ts-form-group mt-3">
            <label for="description" class="ts-label">
                Description
            </label>

            <textarea name="description" id="description" rows="5"
                class="ts-textarea @error('description') ts-input-error @enderror"
                placeholder="Enter banner description">{{ old('description', $pageBanner->description ?? '') }}</textarea>

            @error('description')
                <span class="ts-error-message">{{ $message }}</span>
            @enderror
        </div>

    </div>

    <div class="ts-form-sidebar">
        
        {{-- Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Banner Background</h3>
                <p>Upload the page banner image.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($pageBanner) && $pageBanner->image ? asset('storage/' . $pageBanner->image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview
                        {{ isset($pageBanner) && $pageBanner->image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder"
                    class="ts-image-placeholder
                        {{ isset($pageBanner) && $pageBanner->image ? 'ts-hidden' : '' }}">
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
                <option value="1" @selected(old('status', $pageBanner->status ?? 1) == 1)>
                    Active
                </option>
                <option value="0" @selected(old('status', $pageBanner->status ?? 1) == 0)>
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
