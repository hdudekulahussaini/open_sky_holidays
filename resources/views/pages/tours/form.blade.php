<div class="admin-form-grid">

    {{-- Tour Type --}}
    <div class="admin-form-group">
        <label for="tour_type_id">
            Tour Type
            <span class="required">*</span>
        </label>

        <select name="tour_type_id" id="tour_type_id"
            class="admin-form-control @error('tour_type_id') is-invalid @enderror" required>
            <option value="">
                Select tour type
            </option>

            @foreach ($tourTypes as $tourType)
                <option value="{{ $tourType->id }}" @selected(old('tour_type_id', $tour->tour_type_id ?? '') == $tourType->id)>
                    {{ $tourType->name }}
                </option>
            @endforeach
        </select>

        @error('tour_type_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Tour Title --}}
    <div class="admin-form-group">
        <label for="title">
            Tour Title
            <span class="required">*</span>
        </label>

        <input type="text" name="title" id="title" value="{{ old('title', $tour->title ?? '') }}"
            class="admin-form-control @error('title') is-invalid @enderror" maxlength="255"
            placeholder="Example: Dubai Adventure" required>

        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Slug --}}
    <div class="admin-form-group">
        <label for="slug">
            Slug
        </label>

        <input type="text" name="slug" id="slug" value="{{ old('slug', $tour->slug ?? '') }}"
            class="admin-form-control @error('slug') is-invalid @enderror" maxlength="255"
            placeholder="Example: dubai-adventure">

        <p class="form-help-text">
            Leave empty to generate it automatically from the tour title.
        </p>

        @error('slug')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Country --}}
    <div class="admin-form-group">
        <label for="country">
            Country
            <span class="required">*</span>
        </label>

        <input type="text" name="country" id="country" value="{{ old('country', $tour->country ?? '') }}"
            class="admin-form-control @error('country') is-invalid @enderror" maxlength="150"
            placeholder="Example: United Arab Emirates" required>

        @error('country')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Duration --}}
    <div class="admin-form-group">
        <label for="duration">
            Duration
            <span class="required">*</span>
        </label>

        <input type="text" name="duration" id="duration" value="{{ old('duration', $tour->duration ?? '') }}"
            class="admin-form-control @error('duration') is-invalid @enderror" maxlength="100"
            placeholder="Example: 3 Nights / 4 Days" required>

        @error('duration')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Thumbnail --}}
    {{-- Thumbnail --}}
    <div class="admin-form-group admin-form-group-full">
        <label for="tourThumbnail">
            Tour Thumbnail

            @if (!isset($tour))
                <span class="required">*</span>
            @endif
        </label>

        <p class="form-help-text">
            Supported formats: JPG, JPEG, PNG and WebP.
        </p>

        <input type="file" name="thumbnail" id="tourThumbnail"
            class="admin-form-control @error('thumbnail') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" {{ isset($tour) ? '' : 'required' }}>

        @error('thumbnail')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

        <div id="tourThumbnailPreview" class="story-image-preview">
            @if (isset($tour) && $tour->thumbnail)
                <div class="story-preview-item">
                    <img src="{{ asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}">
                </div>
            @endif
        </div>
    </div>

    {{-- Status --}}
    <div class="admin-form-group">
        <label for="status">
            Status
        </label>

        <select name="status" id="status" class="admin-form-control @error('status') is-invalid @enderror">
            <option value="1" @selected((string) old('status', isset($counter) ? (int) $counter->status : 1) === '1')>
                Active
            </option>

            <option value="0" @selected((string) old('status', isset($counter) ? (int) $counter->status : 1) === '0')>
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

<div class="admin-form-actions">
    <a href="{{ route('admin.tours.index') }}" class="admin-cancel-button">
        Cancel
    </a>

    <button type="submit" class="admin-submit-button">
        {{ isset($tour) ? 'Update Tour' : 'Create Tour' }}
    </button>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput =
                document.getElementById('title');

            const slugInput =
                document.getElementById('slug');

            const thumbnailInput =
                document.getElementById('tourThumbnail');

            const thumbnailPreview =
                document.getElementById('tourThumbnailPreview');

            let slugWasManuallyChanged =
                slugInput && slugInput.value.trim() !== '';

            function createSlug(value) {
                return value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }

            if (slugInput) {
                slugInput.addEventListener('input', function() {
                    slugWasManuallyChanged =
                        slugInput.value.trim() !== '';
                });
            }

            if (titleInput && slugInput) {
                titleInput.addEventListener('input', function() {
                    if (!slugWasManuallyChanged) {
                        slugInput.value =
                            createSlug(titleInput.value);
                    }
                });
            }

            if (thumbnailInput && thumbnailPreview) {
                thumbnailInput.addEventListener(
                    'change',
                    function() {
                        const file =
                            thumbnailInput.files[0];

                        if (!file) {
                            return;
                        }

                        const allowedTypes = [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ];

                        if (!allowedTypes.includes(file.type)) {
                            alert(
                                'Please choose a JPG, JPEG, PNG or WebP image.'
                            );

                            thumbnailInput.value = '';

                            return;
                        }

                        const reader = new FileReader();

                        reader.onload = function(event) {
                            thumbnailPreview.innerHTML = `
                                <div class="story-preview-item">
                                    <img
                                        src="${event.target.result}"
                                        alt="Tour thumbnail preview"
                                    >
                                </div>
                            `;
                        };

                        reader.readAsDataURL(file);
                    }
                );
            }
        });
    </script>
@endpush
