@php
    // Basic tour details status
    $status = old('status', isset($tour) ? ($tour->status ? 1 : 0) : 1);

    // Tour detail fields
    $detailHeading = old('detail.heading', $tour->detail->heading ?? '');
    $detailDescription = old('detail.description', $tour->detail->description ?? '');
    $detailStatus = old('detail.status', $tour->detail->status ?? 'active');

    // Gallery images
    $gallery = old('existing_gallery', $tour->detail->gallery ?? []);
    $gallery = is_array($gallery) ? $gallery : [];

    // Package Inclusions
    if (old('package_inclusions')) {
        $packageInclusions = old('package_inclusions');
    } elseif (isset($tour)) {
        $packageInclusions = $tour->packageInclusions->map(fn($item) => [
            'id' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
            'sort_order' => $item->sort_order,
        ])->toArray();
    } else {
        $packageInclusions = [];
    }

    // Places Covered
    if (old('places_covered')) {
        $placesCovered = old('places_covered');
    } elseif (isset($tour)) {
        $placesCovered = $tour->placesCovered->map(fn($item) => [
            'id' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
            'image' => $item->image,
            'sort_order' => $item->sort_order,
        ])->toArray();
    } else {
        $placesCovered = [];
    }

    // Tour Highlights
    if (old('tour_highlights')) {
        $tourHighlights = old('tour_highlights');
    } elseif (isset($tour)) {
        $tourHighlights = $tour->tourHighlights->map(fn($item) => [
            'id' => $item->id,
            'title' => $item->title,
            'description' => $item->description,
            'sort_order' => $item->sort_order,
        ])->toArray();
    } else {
        $tourHighlights = [];
    }

    // Pre-populate at least one default row if empty
    if (empty($packageInclusions)) {
        $packageInclusions = [['title' => '', 'description' => '', 'sort_order' => 0]];
    }
    if (empty($placesCovered)) {
        $placesCovered = [['title' => '', 'description' => '', 'sort_order' => 0, 'image' => null]];
    }
    if (empty($tourHighlights)) {
        $tourHighlights = [['title' => '', 'description' => '', 'sort_order' => 0]];
    }
@endphp

<div class="combined-tour-container">

    {{-- =====================================================
        BASIC TOUR CARD
    ====================================================== --}}
    <div class="admin-card mb-4">
        <div class="td-card-header">
            <div>
                <h2>Basic Tour Information</h2>
                <p>Set core tour card information shown on listings.</p>
            </div>
        </div>
        <div class="td-card-body">
            <div class="admin-form-grid">
                {{-- Tour Type --}}
                <div class="admin-form-group">
                    <label for="tour_type_id">Tour Type <span class="required">*</span></label>
                    <select name="tour_type_id" id="tour_type_id" class="admin-form-control @error('tour_type_id') is-invalid @enderror" required>
                        <option value="">Select tour type</option>
                        @foreach ($tourTypes as $tourType)
                            <option value="{{ $tourType->id }}" @selected(old('tour_type_id', $tour->tour_type_id ?? '') == $tourType->id)>
                                {{ $tourType->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tour_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tour Title --}}
                <div class="admin-form-group">
                    <label for="title">Tour Title <span class="required">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $tour->title ?? '') }}"
                        class="admin-form-control @error('title') is-invalid @enderror" maxlength="255"
                        placeholder="Example: Dubai Adventure" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Slug --}}
                <div class="admin-form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $tour->slug ?? '') }}"
                        class="admin-form-control @error('slug') is-invalid @enderror" maxlength="255"
                        placeholder="Example: dubai-adventure">
                    <p class="form-help-text">Leave empty to generate it automatically from the tour title.</p>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Country --}}
                <div class="admin-form-group">
                    <label for="country">Country <span class="required">*</span></label>
                    <input type="text" name="country" id="country" value="{{ old('country', $tour->country ?? '') }}"
                        class="admin-form-control @error('country') is-invalid @enderror" maxlength="150"
                        placeholder="Example: United Arab Emirates" required>
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Duration --}}
                <div class="admin-form-group">
                    <label for="duration">Duration <span class="required">*</span></label>
                    <input type="text" name="duration" id="duration" value="{{ old('duration', $tour->duration ?? '') }}"
                        class="admin-form-control @error('duration') is-invalid @enderror" maxlength="100"
                        placeholder="Example: 3 Nights / 4 Days" required>
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="admin-form-group">
                    <label for="status">Listing Status</label>
                    <select name="status" id="status" class="admin-form-control @error('status') is-invalid @enderror">
                        <option value="1" @selected((string)$status === '1')>Active</option>
                        <option value="0" @selected((string)$status === '0')>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Thumbnail --}}
                <div class="admin-form-group admin-form-group-full">
                    <label for="tourThumbnail">Tour Thumbnail @if (!isset($tour)) <span class="required">*</span> @endif</label>
                    <p class="form-help-text">Supported formats: JPG, JPEG, PNG and WebP.</p>
                    <input type="file" name="thumbnail" id="tourThumbnail"
                        class="admin-form-control @error('thumbnail') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" {{ isset($tour) ? '' : 'required' }}>
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="tourThumbnailPreview" class="story-image-preview mt-2">
                        @if (isset($tour) && $tour->thumbnail)
                            <div class="story-preview-item">
                                <img src="{{ asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}" style="max-height: 150px; border-radius: 8px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =====================================================
        TOUR DETAIL SECTION (Heading, Description, Gallery)
    ====================================================== --}}
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="admin-card h-100">
                <div class="td-card-header">
                    <div>
                        <h2>Detailed Information</h2>
                        <p>Write detailed introduction and description for this tour.</p>
                    </div>
                </div>
                <div class="td-card-body">
                    <div class="admin-form-group">
                        <label for="detail_heading">Intro Heading <span class="required">*</span></label>
                        <input type="text" name="detail[heading]" id="detail_heading" class="admin-form-control @error('detail.heading') is-invalid @enderror"
                            value="{{ $detailHeading }}" placeholder="Example: Discover the beauty of Dubai" required>
                        @error('detail.heading')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <label for="detail_description">Tour Description <span class="required">*</span></label>
                        <textarea name="detail[description]" id="detail_description" rows="10"
                            class="admin-form-control @error('detail.description') is-invalid @enderror"
                            placeholder="Enter the complete tour description" required>{{ $detailDescription }}</textarea>
                        @error('detail.description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="admin-form-group mb-0">
                        <label for="detail_status">Details Visibility Status</label>
                        <select name="detail[status]" id="detail_status" class="admin-form-control @error('detail.status') is-invalid @enderror">
                            <option value="active" @selected($detailStatus === 'active')>Active</option>
                            <option value="inactive" @selected($detailStatus === 'inactive')>Inactive</option>
                        </select>
                        @error('detail.status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card h-100">
                <div class="td-card-header td-gallery-card-header">
                    <div>
                        <h2>Gallery Images</h2>
                        <p>Add up to 10 gallery images.</p>
                    </div>
                    <button type="button" id="addGalleryImage" class="td-add-image-btn">
                        <span class="td-add-icon">+</span> Add
                    </button>
                </div>
                <div class="td-card-body">
                    <div class="td-gallery-summary mb-3">
                        <span>Selected images</span>
                        <strong id="totalGalleryCount">{{ count($gallery) }} / 10</strong>
                    </div>

                    {{-- Existing Images --}}
                    <div class="td-gallery-section" id="existingGallerySection" style="{{ count($gallery) > 0 ? '' : 'display:none;' }}">
                        <div class="td-gallery-title mb-2">
                            <span>Existing Images</span>
                            <span id="existingGalleryCount">{{ count($gallery) }}</span>
                        </div>
                        <div class="td-existing-gallery-grid" id="existingGallery">
                            @foreach ($gallery as $image)
                                <div class="td-existing-gallery-item">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Tour gallery image">
                                    <input type="hidden" name="existing_gallery[]" value="{{ $image }}">
                                    <button type="button" class="td-remove-existing-image" aria-label="Remove existing image">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                            <path d="M18 6L6 18"></path>
                                            <path d="M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- New Images --}}
                    <div class="td-gallery-section mt-3">
                        <div class="td-gallery-title mb-2">
                            <span>New Images</span>
                            <span id="newGalleryCount">0</span>
                        </div>
                        <div id="galleryImageContainer" class="td-image-input-list"></div>
                        <div id="emptyGalleryMessage" class="td-empty-gallery py-4 text-center border-dashed rounded bg-light mt-2 {{ count($gallery) > 0 ? 'hidden' : '' }}">
                            <span class="td-empty-gallery-icon fs-3 text-primary"><i class="fa-regular fa-image"></i></span>
                            <strong class="d-block mt-2">No new images added</strong>
                            <p class="text-muted small">Click the "Add" button to select files.</p>
                        </div>
                    </div>
                    @error('gallery')
                        <div class="text-danger small mt-2 d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- =====================================================
        TOUR FEATURES (Package Inclusions)
    ====================================================== --}}
    <div class="admin-card mb-4">
        <div class="td-card-header d-flex justify-content-between align-items-center">
            <div>
                <h2>Package Inclusions</h2>
                <p>Define items included in this tour package.</p>
            </div>
            <button type="button" class="tf-add-button btn btn-primary btn-sm" id="addPackageInclusion">+ Add Inclusion</button>
        </div>
        <div class="td-card-body">
            <div class="tf-repeat-list" id="packageInclusionList">
                @foreach ($packageInclusions as $index => $item)
                    <div class="tf-repeat-item mb-3 p-3 border rounded bg-light" data-repeat-item>
                        <div class="tf-repeat-header d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                            <strong data-item-number>Inclusion {{ $loop->iteration }}</strong>
                            <button type="button" class="btn btn-danger btn-sm px-2 py-1" data-remove-item>Remove</button>
                        </div>
                        @if (!empty($item['id']))
                            <input type="hidden" name="package_inclusions[{{ $index }}][id]" value="{{ $item['id'] }}">
                        @endif
                        <div class="row">
                            <div class="col-md-9 mb-2">
                                <label class="small fw-bold">Title *</label>
                                <input type="text" name="package_inclusions[{{ $index }}][title]" class="admin-form-control" value="{{ $item['title'] }}" placeholder="Example: Deluxe Hotel Stay" required>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="small fw-bold">Sort Order</label>
                                <input type="number" name="package_inclusions[{{ $index }}][sort_order]" class="admin-form-control" value="{{ $item['sort_order'] ?? $index }}" min="0">
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold">Description</label>
                                <textarea name="package_inclusions[{{ $index }}][description]" class="admin-form-control" rows="2" placeholder="Brief description (optional)">{{ $item['description'] }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- =====================================================
        TOUR FEATURES (Places Covered)
    ====================================================== --}}
    <div class="admin-card mb-4">
        <div class="td-card-header d-flex justify-content-between align-items-center">
            <div>
                <h2>Places Covered</h2>
                <p>Destinations or sightseeing points included, with optional images.</p>
            </div>
            <button type="button" class="tf-add-button btn btn-primary btn-sm" id="addPlaceCovered">+ Add Place</button>
        </div>
        <div class="td-card-body">
            <div class="tf-repeat-list" id="placeCoveredList">
                @foreach ($placesCovered as $index => $item)
                    <div class="tf-repeat-item mb-3 p-3 border rounded bg-light" data-repeat-item>
                        <div class="tf-repeat-header d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                            <strong data-item-number>Place {{ $loop->iteration }}</strong>
                            <button type="button" class="btn btn-danger btn-sm px-2 py-1" data-remove-item>Remove</button>
                        </div>
                        @if (!empty($item['id']))
                            <input type="hidden" name="places_covered[{{ $index }}][id]" value="{{ $item['id'] }}">
                        @endif
                        <div class="row">
                            <div class="col-md-9 mb-2">
                                <label class="small fw-bold">Place Name *</label>
                                <input type="text" name="places_covered[{{ $index }}][title]" class="admin-form-control" value="{{ $item['title'] }}" placeholder="Example: Burj Khalifa" required>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="small fw-bold">Sort Order</label>
                                <input type="number" name="places_covered[{{ $index }}][sort_order]" class="admin-form-control" value="{{ $item['sort_order'] ?? $index }}" min="0">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="small fw-bold">Description</label>
                                <textarea name="places_covered[{{ $index }}][description]" class="admin-form-control" rows="2" placeholder="Brief description (optional)">{{ $item['description'] }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold d-block">Place Image</label>
                                <div class="tf-place-image-upload d-flex align-items-center gap-3">
                                    <div class="tf-place-image-preview border rounded bg-white" data-image-preview style="width: 100px; height: 75px; display: flex; align-items: center; justify-content: center; overflow: hidden; font-size: 11px; text-align: center; color: #94a3b8;">
                                        @if (!empty($item['image']))
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <span>No image selected</span>
                                        @endif
                                    </div>
                                    <div class="tf-place-image-actions">
                                        <label for="places_covered_{{ $index }}_image" class="btn btn-outline-secondary btn-sm mb-0">Choose Image</label>
                                        <input type="file" name="places_covered[{{ $index }}][image]" id="places_covered_{{ $index }}_image" class="d-none" accept=".jpg,.jpeg,.png,.webp" data-image-input>
                                        <span class="small text-muted ms-2" data-file-name>
                                            @if (!empty($item['image']))
                                                {{ basename($item['image']) }}
                                            @else
                                                No file selected
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- =====================================================
        TOUR FEATURES (Tour Highlights)
    ====================================================== --}}
    <div class="admin-card mb-4">
        <div class="td-card-header d-flex justify-content-between align-items-center">
            <div>
                <h2>Tour Highlights</h2>
                <p>Key highlights or selling points of this tour.</p>
            </div>
            <button type="button" class="tf-add-button btn btn-primary btn-sm" id="addTourHighlight">+ Add Highlight</button>
        </div>
        <div class="td-card-body">
            <div class="tf-repeat-list" id="tourHighlightList">
                @foreach ($tourHighlights as $index => $item)
                    <div class="tf-repeat-item mb-3 p-3 border rounded bg-light" data-repeat-item>
                        <div class="tf-repeat-header d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                            <strong data-item-number>Highlight {{ $loop->iteration }}</strong>
                            <button type="button" class="btn btn-danger btn-sm px-2 py-1" data-remove-item>Remove</button>
                        </div>
                        @if (!empty($item['id']))
                            <input type="hidden" name="tour_highlights[{{ $index }}][id]" value="{{ $item['id'] }}">
                        @endif
                        <div class="row">
                            <div class="col-md-9 mb-2">
                                <label class="small fw-bold">Title *</label>
                                <input type="text" name="tour_highlights[{{ $index }}][title]" class="admin-form-control" value="{{ $item['title'] }}" placeholder="Example: Sunrise desert safari" required>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="small fw-bold">Sort Order</label>
                                <input type="number" name="tour_highlights[{{ $index }}][sort_order]" class="admin-form-control" value="{{ $item['sort_order'] ?? $index }}" min="0">
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold">Description</label>
                                <textarea name="tour_highlights[{{ $index }}][description]" class="admin-form-control" rows="2" placeholder="Brief description (optional)">{{ $item['description'] }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<div class="admin-form-actions mt-4">
    <a href="{{ route('admin.tours.index') }}" class="admin-cancel-button">
        Cancel
    </a>

    <button type="submit" class="admin-submit-button">
        {{ isset($tour) ? 'Update Tour' : 'Create Tour' }}
    </button>
</div>

{{-- =====================================================
    DYNAMIC TEMPLATES FOR JAVASCRIPT REPEATERS
====================================================== --}}
<template id="packageInclusionTemplate">
    <div class="tf-repeat-item mb-3 p-3 border rounded bg-light" data-repeat-item>
        <div class="tf-repeat-header d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <strong data-item-number>Inclusion</strong>
            <button type="button" class="btn btn-danger btn-sm px-2 py-1" data-remove-item>Remove</button>
        </div>
        <div class="row">
            <div class="col-md-9 mb-2">
                <label class="small fw-bold">Title *</label>
                <input type="text" data-name="package_inclusions[__INDEX__][title]" class="admin-form-control" placeholder="Example: Deluxe Hotel Stay" required>
            </div>
            <div class="col-md-3 mb-2">
                <label class="small fw-bold">Sort Order</label>
                <input type="number" data-name="package_inclusions[__INDEX__][sort_order]" class="admin-form-control" value="0" min="0">
            </div>
            <div class="col-12">
                <label class="small fw-bold">Description</label>
                <textarea data-name="package_inclusions[__INDEX__][description]" class="admin-form-control" rows="2" placeholder="Brief description (optional)"></textarea>
            </div>
        </div>
    </div>
</template>

<template id="placeCoveredTemplate">
    <div class="tf-repeat-item mb-3 p-3 border rounded bg-light" data-repeat-item>
        <div class="tf-repeat-header d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <strong data-item-number>Place</strong>
            <button type="button" class="btn btn-danger btn-sm px-2 py-1" data-remove-item>Remove</button>
        </div>
        <div class="row">
            <div class="col-md-9 mb-2">
                <label class="small fw-bold">Place Name *</label>
                <input type="text" data-name="places_covered[__INDEX__][title]" class="admin-form-control" placeholder="Example: Burj Khalifa" required>
            </div>
            <div class="col-md-3 mb-2">
                <label class="small fw-bold">Sort Order</label>
                <input type="number" data-name="places_covered[__INDEX__][sort_order]" class="admin-form-control" value="0" min="0">
            </div>
            <div class="col-12 mb-3">
                <label class="small fw-bold">Description</label>
                <textarea data-name="places_covered[__INDEX__][description]" class="admin-form-control" rows="2" placeholder="Brief description (optional)"></textarea>
            </div>
            <div class="col-12">
                <label class="small fw-bold d-block">Place Image</label>
                <div class="tf-place-image-upload d-flex align-items-center gap-3">
                    <div class="tf-place-image-preview border rounded bg-white" data-image-preview style="width: 100px; height: 75px; display: flex; align-items: center; justify-content: center; overflow: hidden; font-size: 11px; text-align: center; color: #94a3b8;">
                        <span>No image selected</span>
                    </div>
                    <div class="tf-place-image-actions">
                        <label data-file-label class="btn btn-outline-secondary btn-sm mb-0">Choose Image
                            <input type="file" data-name="places_covered[__INDEX__][image]" class="d-none" accept=".jpg,.jpeg,.png,.webp" data-image-input>
                        </label>
                        <span class="small text-muted ms-2" data-file-name>No file selected</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="tourHighlightTemplate">
    <div class="tf-repeat-item mb-3 p-3 border rounded bg-light" data-repeat-item>
        <div class="tf-repeat-header d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
            <strong data-item-number>Highlight</strong>
            <button type="button" class="btn btn-danger btn-sm px-2 py-1" data-remove-item>Remove</button>
        </div>
        <div class="row">
            <div class="col-md-9 mb-2">
                <label class="small fw-bold">Title *</label>
                <input type="text" data-name="tour_highlights[__INDEX__][title]" class="admin-form-control" placeholder="Example: Sunrise desert safari" required>
            </div>
            <div class="col-md-3 mb-2">
                <label class="small fw-bold">Sort Order</label>
                <input type="number" data-name="tour_highlights[__INDEX__][sort_order]" class="admin-form-control" value="0" min="0">
            </div>
            <div class="col-12">
                <label class="small fw-bold">Description</label>
                <textarea data-name="tour_highlights[__INDEX__][description]" class="admin-form-control" rows="2" placeholder="Brief description (optional)"></textarea>
            </div>
        </div>
    </div>
</template>

@push('styles')
    <style>
        .td-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            background: #ffffff;
            border-bottom: 1px solid #edf1f5;
        }
        .td-card-header h2 {
            margin: 0 0 5px;
            color: #172033;
            font-size: 17px;
            font-weight: 700;
            line-height: 1.3;
        }
        .td-card-header p {
            margin: 0;
            color: #7b8798;
            font-size: 13px;
            line-height: 1.5;
        }
        .td-card-body {
            padding: 22px;
        }
        .td-add-image-btn {
            display: inline-flex;
            min-height: 35px;
            padding: 4px 10px;
            align-items: center;
            justify-content: center;
            gap: 6px;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            background: #2563eb;
            border: 1px solid #2563eb;
            border-radius: 6px;
            transition: background 0.2s ease, border-color 0.2s ease;
        }
        .td-add-image-btn:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }
        .td-gallery-summary {
            display: flex;
            min-height: 40px;
            padding: 8px 12px;
            align-items: center;
            justify-content: space-between;
            color: #566276;
            font-size: 13px;
            background: #f8fafc;
            border: 1px solid #e5eaf0;
            border-radius: 8px;
        }
        .td-gallery-summary strong {
            color: #2563eb;
            background: #eaf2ff;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
        }
        .td-gallery-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
            color: #465166;
        }
        .td-gallery-title span:last-child {
            color: #2563eb;
            background: #eaf2ff;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 10px;
        }
        .td-existing-gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }
        .td-existing-gallery-item {
            position: relative;
            aspect-ratio: 1/1;
            border: 1px solid #e1e7ee;
            border-radius: 8px;
            overflow: hidden;
        }
        .td-existing-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .td-remove-existing-image {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 22px;
            height: 22px;
            background: rgba(220, 38, 38, 0.9);
            border: 0;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .td-remove-existing-image svg {
            width: 12px;
            height: 12px;
        }
        .td-image-input-row {
            display: grid;
            grid-template-columns: 60px minmax(0, 1fr) 28px;
            gap: 8px;
            align-items: center;
            padding: 8px;
            background: #f8fafc;
            border: 1px solid #e1e7ee;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .td-image-preview {
            width: 60px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-size: 9px;
            color: #94a3b8;
            background: #ffffff;
            border: 1px dashed #c7d1dd;
            border-radius: 6px;
        }
        .td-image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .td-image-file-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 10px;
            border: 1px solid #d6dee8;
            border-radius: 6px;
            background: white;
            font-size: 11px;
            cursor: pointer;
            margin-bottom: 0;
        }
        .td-image-file-name {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .td-gallery-file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
        }
        .td-remove-new-image {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #ef4444;
            border: 0;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .td-remove-new-image svg {
            width: 12px;
            height: 12px;
        }
        .td-empty-gallery.hidden {
            display: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Slug Auto-generation
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            let slugWasManuallyChanged = slugInput && slugInput.value.trim() !== '';

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
                    slugWasManuallyChanged = slugInput.value.trim() !== '';
                });
            }

            if (titleInput && slugInput) {
                titleInput.addEventListener('input', function() {
                    if (!slugWasManuallyChanged) {
                        slugInput.value = createSlug(titleInput.value);
                    }
                });
            }

            // Thumbnail Preview
            const thumbnailInput = document.getElementById('tourThumbnail');
            const thumbnailPreview = document.getElementById('tourThumbnailPreview');

            if (thumbnailInput && thumbnailPreview) {
                thumbnailInput.addEventListener('change', function() {
                    const file = thumbnailInput.files[0];
                    if (!file) return;

                    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Please choose a JPG, JPEG, PNG or WebP image.');
                        thumbnailInput.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        thumbnailPreview.innerHTML = `
                            <div class="story-preview-item">
                                <img src="${e.target.result}" alt="Thumbnail preview" style="max-height: 150px; border-radius: 8px;">
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Gallery Images logic
            const addGalleryBtn = document.getElementById('addGalleryImage');
            const galleryContainer = document.getElementById('galleryImageContainer');
            const existingGallery = document.getElementById('existingGallery');
            const existingGallerySection = document.getElementById('existingGallerySection');
            const totalCountEl = document.getElementById('totalGalleryCount');
            const newCountEl = document.getElementById('newGalleryCount');
            const existingCountEl = document.getElementById('existingGalleryCount');
            const emptyGalleryMessage = document.getElementById('emptyGalleryMessage');
            const maxGalleryImages = 10;

            function getExistingCount() {
                return existingGallery ? existingGallery.querySelectorAll('.td-existing-gallery-item').length : 0;
            }

            function getNewCount() {
                return galleryContainer.querySelectorAll('.td-image-input-row').length;
            }

            function updateGalleryStatus() {
                const existing = getExistingCount();
                const newC = getNewCount();
                const total = existing + newC;

                if (existingCountEl) existingCountEl.textContent = existing;
                if (newCountEl) newCountEl.textContent = newC;
                if (totalCountEl) totalCountEl.textContent = `${total} / ${maxGalleryImages}`;

                if (emptyGalleryMessage) {
                    if (newC > 0) {
                        emptyGalleryMessage.classList.add('hidden');
                    } else {
                        emptyGalleryMessage.classList.remove('hidden');
                    }
                }

                if (existingGallerySection) {
                    existingGallerySection.style.display = existing > 0 ? '' : 'none';
                }

                if (addGalleryBtn) {
                    addGalleryBtn.disabled = total >= maxGalleryImages;
                }
            }

            function createGalleryInput() {
                const currentTotal = getExistingCount() + getNewCount();
                if (currentTotal >= maxGalleryImages) return;

                const uniqueId = Date.now() + '_' + Math.floor(Math.random() * 100000);
                const inputId = `gallery_image_${uniqueId}`;

                const row = document.createElement('div');
                row.className = 'td-image-input-row';
                row.innerHTML = `
                    <div class="td-image-preview">
                        <span>No image</span>
                    </div>
                    <div class="td-image-file-wrap">
                        <label for="${inputId}" class="td-image-file-label">
                            <span class="td-image-file-name">Select image</span>
                            <strong>Browse</strong>
                        </label>
                        <input type="file" id="${inputId}" name="gallery[]" class="td-gallery-file-input" accept=".jpg,.jpeg,.png,.webp" required>
                    </div>
                    <button type="button" class="td-remove-new-image" aria-label="Remove image">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18"></path><path d="M6 6l12 12"></path></svg>
                    </button>
                `;

                galleryContainer.appendChild(row);
                updateGalleryStatus();
            }

            if (addGalleryBtn) {
                addGalleryBtn.addEventListener('click', createGalleryInput);
            }

            galleryContainer.addEventListener('change', function(e) {
                const input = e.target.closest('.td-gallery-file-input');
                if (!input) return;

                const row = input.closest('.td-image-input-row');
                const preview = row.querySelector('.td-image-preview');
                const fileName = row.querySelector('.td-image-file-name');
                const file = input.files[0];

                if (!file) {
                    preview.innerHTML = '<span>No image</span>';
                    fileName.textContent = 'Select image';
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    input.value = '';
                    preview.innerHTML = '<span>Invalid</span>';
                    fileName.textContent = 'Select image';
                    return;
                }

                fileName.textContent = file.name;
                const reader = new FileReader();
                reader.onload = function(readerEvent) {
                    preview.innerHTML = `<img src="${readerEvent.target.result}" alt="Selected gallery image">`;
                };
                reader.readAsDataURL(file);
            });

            galleryContainer.addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.td-remove-new-image');
                if (!removeBtn) return;

                removeBtn.closest('.td-image-input-row').remove();
                updateGalleryStatus();
            });

            document.addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.td-remove-existing-image');
                if (!removeBtn) return;

                removeBtn.closest('.td-existing-gallery-item').remove();
                updateGalleryStatus();
            });

            // Dynamic repeaters logic for Features
            function initializeRepeater(listId, addBtnId, templateId, inputPrefix) {
                const list = document.getElementById(listId);
                const addBtn = document.getElementById(addBtnId);
                const template = document.getElementById(templateId);

                if (!list || !addBtn || !template) return;

                function reindexItems() {
                    const items = list.querySelectorAll('[data-repeat-item]');
                    items.forEach((item, index) => {
                        // Update Header Text (e.g. Inclusion 1, Place 1, Highlight 1)
                        const header = item.querySelector('[data-item-number]');
                        if (header) {
                            const typeName = header.textContent.split(' ')[0];
                            header.textContent = `${typeName} ${index + 1}`;
                        }

                        // Update input/textarea names
                        item.querySelectorAll('[name], [data-name]').forEach(input => {
                            const nameAttr = input.hasAttribute('name') ? 'name' : 'data-name';
                            let namePattern = input.getAttribute(nameAttr);
                            
                            // Replace indices
                            namePattern = namePattern.replace(/\[\d+\]/, `[${index}]`);
                            input.setAttribute(nameAttr, namePattern);
                            
                            // Re-bind file upload IDs/labels for place images
                            if (input.type === 'file') {
                                const newId = `${inputPrefix}_${index}_image`;
                                input.id = newId;
                                const label = item.querySelector('label[for]');
                                if (label) {
                                    label.setAttribute('for', newId);
                                }
                            }
                        });
                    });
                }

                addBtn.addEventListener('click', function() {
                    const index = list.querySelectorAll('[data-repeat-item]').length;
                    const html = template.innerHTML.replace(/__INDEX__/g, index);
                    
                    // Create wrapper element
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html.trim();
                    const newItem = tempDiv.firstChild;

                    list.appendChild(newItem);
                    reindexItems();
                });

                list.addEventListener('click', function(e) {
                    const removeBtn = e.target.closest('[data-remove-item]');
                    if (!removeBtn) return;

                    const item = removeBtn.closest('[data-repeat-item]');
                    item.remove();
                    reindexItems();
                });

                // Change handler for place image preview/filename
                list.addEventListener('change', function(e) {
                    const fileInput = e.target.closest('[data-image-input]');
                    if (!fileInput) return;

                    const row = fileInput.closest('[data-repeat-item]');
                    const preview = row.querySelector('[data-image-preview]');
                    const label = row.querySelector('[data-file-name]');
                    const file = fileInput.files[0];

                    if (!file) {
                        preview.innerHTML = '<span>No image selected</span>';
                        label.textContent = 'No file selected';
                        return;
                    }

                    label.textContent = file.name;
                    const reader = new FileReader();
                    reader.onload = function(readerEvent) {
                        preview.innerHTML = `<img src="${readerEvent.target.result}" alt="Place preview" style="width: 100%; height: 100%; object-fit: cover;">`;
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Initialize all three repeaters
            initializeRepeater('packageInclusionList', 'addPackageInclusion', 'packageInclusionTemplate', 'package_inclusions');
            initializeRepeater('placeCoveredList', 'addPlaceCovered', 'placeCoveredTemplate', 'places_covered');
            initializeRepeater('tourHighlightList', 'addTourHighlight', 'tourHighlightTemplate', 'tour_highlights');

            // Initialize gallery count display
            updateGalleryStatus();
        });
    </script>
@endpush
