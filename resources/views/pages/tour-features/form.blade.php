@php
    $selectedTourId = old('tour_id', request('tour_id'));

    $selectedStatus = old('status', 'active');

    $packageInclusions = old('package_inclusions', [
        [
            'title' => '',
            'description' => '',
            'sort_order' => 0,
        ],
    ]);

    $placesCovered = old('places_covered', [
        [
            'title' => '',
            'description' => '',
            'sort_order' => 0,
        ],
    ]);

    $tourHighlights = old('tour_highlights', [
        [
            'title' => '',
            'description' => '',
            'sort_order' => 0,
        ],
    ]);
@endphp

<div class="tf-form-layout">

    {{-- Main content --}}
    <div class="tf-form-main">

        {{-- Basic information --}}
        <div class="tf-card">

            <div class="tf-card-header">
                <div>
                    <h2>Tour Information</h2>

                    <p>
                        Select the tour before adding its features.
                    </p>
                </div>
            </div>

            <div class="tf-card-body">

                {{-- Tour --}}
                <div class="tf-form-group tf-form-group-last">

                    <label for="tour_id" class="tf-label">
                        Tour

                        <span class="tf-required">*</span>
                    </label>

                    <select name="tour_id" id="tour_id"
                        class="tf-control
                            @error('tour_id')
                                tf-control-error
                            @enderror"
                        required>
                        <option value="">
                            Select Tour
                        </option>

                        @foreach ($tours as $tour)
                            <option value="{{ $tour->id }}" @selected((string) $selectedTourId === (string) $tour->id)>
                                {{ $tour->title }}

                                @if ($tour->tourType)
                                    — {{ $tour->tourType->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @error('tour_id')
                        <span class="tf-error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>

        {{-- Package Inclusions --}}
        <div class="tf-card">

            <div class="tf-card-header">

                <div>
                    <h2>Package Inclusions</h2>

                    <p>
                        Add all services included in the package.
                    </p>
                </div>

                <button type="button" class="tf-add-button" id="addPackageInclusion">
                    + Add Inclusion
                </button>

            </div>

            <div class="tf-card-body">

                <div class="tf-repeat-list" id="packageInclusionList">

                    @foreach ($packageInclusions as $index => $item)
                        <div class="tf-repeat-item" data-repeat-item>

                            <div class="tf-repeat-header">

                                <strong data-item-number>
                                    Inclusion {{ $loop->iteration }}
                                </strong>

                                <button type="button" class="tf-remove-button" data-remove-item>
                                    Remove
                                </button>

                            </div>

                            <div class="tf-form-grid">

                                {{-- Title --}}
                                <div class="tf-form-group">

                                    <label for="package_inclusions_{{ $index }}_title" class="tf-label">
                                        Title

                                        <span class="tf-required">*</span>
                                    </label>

                                    <input type="text" name="package_inclusions[{{ $index }}][title]"
                                        id="package_inclusions_{{ $index }}_title"
                                        class="tf-control
                                            @error("package_inclusions.$index.title")
                                                tf-control-error
                                            @enderror"
                                        value="{{ $item['title'] ?? '' }}" placeholder="Example: Hotel accommodation">

                                    @error("package_inclusions.$index.title")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                {{-- Sort order --}}
                                <div class="tf-form-group">

                                    <label for="package_inclusions_{{ $index }}_sort_order" class="tf-label">
                                        Sort Order
                                    </label>

                                    <input type="number" name="package_inclusions[{{ $index }}][sort_order]"
                                        id="package_inclusions_{{ $index }}_sort_order" min="0"
                                        class="tf-control
                                            @error("package_inclusions.$index.sort_order")
                                                tf-control-error
                                            @enderror"
                                        value="{{ $item['sort_order'] ?? $index }}">

                                    @error("package_inclusions.$index.sort_order")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                {{-- Description --}}
                                <div class="tf-form-group tf-form-group-full">

                                    <label for="package_inclusions_{{ $index }}_description" class="tf-label">
                                        Description
                                    </label>

                                    <textarea name="package_inclusions[{{ $index }}][description]"
                                        id="package_inclusions_{{ $index }}_description" rows="3"
                                        class="tf-control tf-textarea-small
                                            @error("package_inclusions.$index.description")
                                                tf-control-error
                                            @enderror"
                                        placeholder="Enter inclusion description">{{ $item['description'] ?? '' }}</textarea>

                                    @error("package_inclusions.$index.description")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

        {{-- Places Covered --}}
        <div class="tf-card">

            <div class="tf-card-header">

                <div>
                    <h2>Places Covered</h2>

                    <p>
                        Add all destinations included in the tour.
                    </p>
                </div>

                <button type="button" class="tf-add-button" id="addPlaceCovered">
                    + Add Place
                </button>

            </div>

            <div class="tf-card-body">

                <div class="tf-repeat-list" id="placeCoveredList">

                    @foreach ($placesCovered as $index => $item)
                        <div class="tf-repeat-item" data-repeat-item>

                            <div class="tf-repeat-header">

                                <strong data-item-number>
                                    Place {{ $loop->iteration }}
                                </strong>

                                <button type="button" class="tf-remove-button" data-remove-item>
                                    Remove
                                </button>

                            </div>

                            <div class="tf-form-grid">

                                {{-- Title --}}
                                <div class="tf-form-group">

                                    <label for="places_covered_{{ $index }}_title" class="tf-label">
                                        Place Name

                                        <span class="tf-required">*</span>
                                    </label>

                                    <input type="text" name="places_covered[{{ $index }}][title]"
                                        id="places_covered_{{ $index }}_title"
                                        class="tf-control
                                            @error("places_covered.$index.title")
                                                tf-control-error
                                            @enderror"
                                        value="{{ $item['title'] ?? '' }}" placeholder="Example: Munnar">

                                    @error("places_covered.$index.title")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                {{-- Sort order --}}
                                <div class="tf-form-group">

                                    <label for="places_covered_{{ $index }}_sort_order" class="tf-label">
                                        Sort Order
                                    </label>

                                    <input type="number" name="places_covered[{{ $index }}][sort_order]"
                                        id="places_covered_{{ $index }}_sort_order" min="0"
                                        class="tf-control
                                            @error("places_covered.$index.sort_order")
                                                tf-control-error
                                            @enderror"
                                        value="{{ $item['sort_order'] ?? $index }}">

                                    @error("places_covered.$index.sort_order")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                {{-- Description --}}
                                <div class="tf-form-group tf-form-group-full">

                                    <label for="places_covered_{{ $index }}_description" class="tf-label">
                                        Description
                                    </label>

                                    <textarea name="places_covered[{{ $index }}][description]" id="places_covered_{{ $index }}_description"
                                        rows="3"
                                        class="tf-control tf-textarea-small
                                            @error("places_covered.$index.description")
                                                tf-control-error
                                            @enderror"
                                        placeholder="Enter place description">{{ $item['description'] ?? '' }}</textarea>

                                    @error("places_covered.$index.description")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                {{-- Image --}}
                                <div class="tf-form-group tf-form-group-full">

                                    <label for="places_covered_{{ $index }}_image" class="tf-label">
                                        Place Image
                                    </label>

                                    <div class="tf-place-image-upload">

                                        <div class="tf-place-image-preview" data-image-preview>
                                            <span>
                                                No image selected
                                            </span>
                                        </div>

                                        <div class="tf-place-image-actions">

                                            <label for="places_covered_{{ $index }}_image"
                                                class="tf-image-select-button">
                                                Choose Image
                                            </label>

                                            <input type="file" name="places_covered[{{ $index }}][image]"
                                                id="places_covered_{{ $index }}_image" class="tf-file-input"
                                                accept=".jpg,.jpeg,.png,.webp" data-image-input>

                                            <span class="tf-file-name" data-file-name>
                                                No file selected
                                            </span>

                                        </div>

                                    </div>

                                    @error("places_covered.$index.image")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

        {{-- Tour Highlights --}}
        <div class="tf-card">

            <div class="tf-card-header">

                <div>
                    <h2>Tour Highlights</h2>

                    <p>
                        Add the main attractions and special experiences.
                    </p>
                </div>

                <button type="button" class="tf-add-button" id="addTourHighlight">
                    + Add Highlight
                </button>

            </div>

            <div class="tf-card-body">

                <div class="tf-repeat-list" id="tourHighlightList">

                    @foreach ($tourHighlights as $index => $item)
                        <div class="tf-repeat-item" data-repeat-item>

                            <div class="tf-repeat-header">

                                <strong data-item-number>
                                    Highlight {{ $loop->iteration }}
                                </strong>

                                <button type="button" class="tf-remove-button" data-remove-item>
                                    Remove
                                </button>

                            </div>

                            <div class="tf-form-grid">

                                {{-- Title --}}
                                <div class="tf-form-group">

                                    <label for="tour_highlights_{{ $index }}_title" class="tf-label">
                                        Title

                                        <span class="tf-required">*</span>
                                    </label>

                                    <input type="text" name="tour_highlights[{{ $index }}][title]"
                                        id="tour_highlights_{{ $index }}_title"
                                        class="tf-control
                                            @error("tour_highlights.$index.title")
                                                tf-control-error
                                            @enderror"
                                        value="{{ $item['title'] ?? '' }}"
                                        placeholder="Example: Sunrise mountain view">

                                    @error("tour_highlights.$index.title")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                {{-- Sort order --}}
                                <div class="tf-form-group">

                                    <label for="tour_highlights_{{ $index }}_sort_order" class="tf-label">
                                        Sort Order
                                    </label>

                                    <input type="number" name="tour_highlights[{{ $index }}][sort_order]"
                                        id="tour_highlights_{{ $index }}_sort_order" min="0"
                                        class="tf-control
                                            @error("tour_highlights.$index.sort_order")
                                                tf-control-error
                                            @enderror"
                                        value="{{ $item['sort_order'] ?? $index }}">

                                    @error("tour_highlights.$index.sort_order")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                                {{-- Description --}}
                                <div class="tf-form-group tf-form-group-full">

                                    <label for="tour_highlights_{{ $index }}_description" class="tf-label">
                                        Description
                                    </label>

                                    <textarea name="tour_highlights[{{ $index }}][description]"
                                        id="tour_highlights_{{ $index }}_description" rows="3"
                                        class="tf-control tf-textarea-small
                                            @error("tour_highlights.$index.description")
                                                tf-control-error
                                            @enderror"
                                        placeholder="Enter highlight description">{{ $item['description'] ?? '' }}</textarea>

                                    @error("tour_highlights.$index.description")
                                        <span class="tf-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </div>

    {{-- Sidebar --}}
    <div class="tf-form-sidebar">

        {{-- Settings --}}
        <div class="tf-card">

            <div class="tf-card-header">
                <div>
                    <h2>Settings</h2>

                    <p>
                        Apply one status to all submitted features.
                    </p>
                </div>
            </div>

            <div class="tf-card-body">

                <div class="tf-form-group tf-form-group-last">

                    <label for="status" class="tf-label">
                        Status
                    </label>

                    <select name="status" id="status"
                        class="tf-control
                            @error('status')
                                tf-control-error
                            @enderror"
                        required>
                        <option value="active" @selected($selectedStatus === 'active')>
                            Active
                        </option>

                        <option value="inactive" @selected($selectedStatus === 'inactive')>
                            Inactive
                        </option>
                    </select>

                    @error('status')
                        <span class="tf-error-message">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>

        {{-- Form guide --}}
        <div class="tf-card">

            <div class="tf-card-header">
                <div>
                    <h2>Feature Guide</h2>

                    <p>
                        You can add multiple records in each section.
                    </p>
                </div>
            </div>

            <div class="tf-card-body">

                <div class="tf-guide-list">

                    <div class="tf-guide-item">
                        <strong>Package Inclusions</strong>

                        <span>
                            Accommodation, transport, meals,
                            tickets and similar services.
                        </span>
                    </div>

                    <div class="tf-guide-item">
                        <strong>Places Covered</strong>

                        <span>
                            Destinations visited during the tour.
                            Each place can have an image.
                        </span>
                    </div>

                    <div class="tf-guide-item">
                        <strong>Tour Highlights</strong>

                        <span>
                            Special experiences and important attractions.
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- Actions --}}
<div class="tf-form-actions">

    <a href="{{ route('admin.tour-features.index') }}" class="tf-btn tf-btn-secondary">
        Cancel
    </a>

    <button type="submit" class="tf-btn tf-btn-primary">
        Save All Tour Features
    </button>

</div>

{{-- Dynamic templates --}}
<template id="packageInclusionTemplate">
    <div class="tf-repeat-item" data-repeat-item>

        <div class="tf-repeat-header">

            <strong data-item-number>
                Inclusion
            </strong>

            <button type="button" class="tf-remove-button" data-remove-item>
                Remove
            </button>

        </div>

        <div class="tf-form-grid">

            <div class="tf-form-group">

                <label class="tf-label">
                    Title
                    <span class="tf-required">*</span>
                </label>

                <input type="text" data-name="package_inclusions[__INDEX__][title]" class="tf-control"
                    placeholder="Example: Hotel accommodation">

            </div>

            <div class="tf-form-group">

                <label class="tf-label">
                    Sort Order
                </label>

                <input type="number" data-name="package_inclusions[__INDEX__][sort_order]" min="0"
                    class="tf-control" value="0">

            </div>

            <div class="tf-form-group tf-form-group-full">

                <label class="tf-label">
                    Description
                </label>

                <textarea data-name="package_inclusions[__INDEX__][description]" rows="3" class="tf-control tf-textarea-small"
                    placeholder="Enter inclusion description"></textarea>

            </div>

        </div>

    </div>
</template>

<template id="placeCoveredTemplate">
    <div class="tf-repeat-item" data-repeat-item>

        <div class="tf-repeat-header">

            <strong data-item-number>
                Place
            </strong>

            <button type="button" class="tf-remove-button" data-remove-item>
                Remove
            </button>

        </div>

        <div class="tf-form-grid">

            <div class="tf-form-group">

                <label class="tf-label">
                    Place Name
                    <span class="tf-required">*</span>
                </label>

                <input type="text" data-name="places_covered[__INDEX__][title]" class="tf-control"
                    placeholder="Example: Munnar">

            </div>

            <div class="tf-form-group">

                <label class="tf-label">
                    Sort Order
                </label>

                <input type="number" data-name="places_covered[__INDEX__][sort_order]" min="0"
                    class="tf-control" value="0">

            </div>

            <div class="tf-form-group tf-form-group-full">

                <label class="tf-label">
                    Description
                </label>

                <textarea data-name="places_covered[__INDEX__][description]" rows="3" class="tf-control tf-textarea-small"
                    placeholder="Enter place description"></textarea>

            </div>

            <div class="tf-form-group tf-form-group-full">

                <label class="tf-label">
                    Place Image
                </label>

                <div class="tf-place-image-upload">

                    <div class="tf-place-image-preview" data-image-preview>
                        <span>No image selected</span>
                    </div>

                    <div class="tf-place-image-actions">

                        <label class="tf-image-select-button" data-file-label>
                            Choose Image

                            <input type="file" data-name="places_covered[__INDEX__][image]" class="tf-file-input"
                                accept=".jpg,.jpeg,.png,.webp" data-image-input>
                        </label>

                        <span class="tf-file-name" data-file-name>
                            No file selected
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>

<template id="tourHighlightTemplate">
    <div class="tf-repeat-item" data-repeat-item>

        <div class="tf-repeat-header">

            <strong data-item-number>
                Highlight
            </strong>

            <button type="button" class="tf-remove-button" data-remove-item>
                Remove
            </button>

        </div>

        <div class="tf-form-grid">

            <div class="tf-form-group">

                <label class="tf-label">
                    Title
                    <span class="tf-required">*</span>
                </label>

                <input type="text" data-name="tour_highlights[__INDEX__][title]" class="tf-control"
                    placeholder="Example: Sunrise mountain view">

            </div>

            <div class="tf-form-group">

                <label class="tf-label">
                    Sort Order
                </label>

                <input type="number" data-name="tour_highlights[__INDEX__][sort_order]" min="0"
                    class="tf-control" value="0">

            </div>

            <div class="tf-form-group tf-form-group-full">

                <label class="tf-label">
                    Description
                </label>

                <textarea data-name="tour_highlights[__INDEX__][description]" rows="3" class="tf-control tf-textarea-small"
                    placeholder="Enter highlight description"></textarea>

            </div>

        </div>

    </div>
</template>

@push('styles')
    <style>
        .tf-form-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 350px;
            gap: 24px;
            align-items: start;
        }

        .tf-form-main,
        .tf-form-sidebar {
            min-width: 0;
        }

        .tf-form-main,
        .tf-form-sidebar {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .tf-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e4eaf1;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(15, 23, 42, 0.05);
        }

        .tf-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            border-bottom: 1px solid #edf1f5;
        }

        .tf-card-header h2 {
            margin: 0 0 5px;
            color: #172033;
            font-size: 17px;
            font-weight: 700;
        }

        .tf-card-header p {
            margin: 0;
            color: #7b8798;
            font-size: 13px;
            line-height: 1.5;
        }

        .tf-card-body {
            padding: 22px;
        }

        .tf-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 18px;
        }

        .tf-form-group {
            margin-bottom: 20px;
        }

        .tf-form-group-full {
            grid-column: 1 / -1;
        }

        .tf-form-group-last {
            margin-bottom: 0;
        }

        .tf-label {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 8px;
            color: #273247;
            font-size: 14px;
            font-weight: 600;
        }

        .tf-required {
            color: #dc2626;
        }

        .tf-control {
            width: 100%;
            min-height: 48px;
            padding: 11px 14px;
            color: #1f2937;
            font: inherit;
            font-size: 14px;
            background: #ffffff;
            border: 1px solid #d9e1ea;
            border-radius: 10px;
            outline: none;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .tf-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .tf-control-error {
            border-color: #dc2626;
        }

        .tf-textarea-small {
            min-height: 95px;
            resize: vertical;
        }

        .tf-error-message {
            display: block;
            margin-top: 7px;
            color: #dc2626;
            font-size: 12px;
            font-weight: 500;
        }

        .tf-add-button {
            display: inline-flex;
            min-height: 39px;
            padding: 8px 13px;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 9px;
        }

        .tf-repeat-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .tf-repeat-item {
            padding: 18px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 13px;
        }

        .tf-repeat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .tf-repeat-header strong {
            color: #273247;
            font-size: 14px;
        }

        .tf-remove-button {
            padding: 6px 9px;
            color: #dc2626;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            background: #ffffff;
            border: 1px solid #fecaca;
            border-radius: 7px;
        }

        .tf-place-image-upload {
            display: grid;
            grid-template-columns: 160px minmax(0, 1fr);
            gap: 16px;
            padding: 14px;
            background: #ffffff;
            border: 1px solid #e1e7ee;
            border-radius: 11px;
        }

        .tf-place-image-preview {
            display: flex;
            width: 160px;
            height: 115px;
            overflow: hidden;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 11px;
            background: #f8fafc;
            border: 1px dashed #c7d1dd;
            border-radius: 9px;
        }

        .tf-place-image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tf-place-image-actions {
            display: flex;
            min-width: 0;
            align-items: flex-start;
            justify-content: center;
            flex-direction: column;
            gap: 9px;
        }

        .tf-file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip-path: inset(50%);
        }

        .tf-image-select-button {
            display: inline-flex;
            min-height: 40px;
            padding: 9px 14px;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            background: #2563eb;
            border-radius: 8px;
        }

        .tf-file-name {
            display: block;
            max-width: 100%;
            overflow: hidden;
            color: #64748b;
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .tf-guide-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .tf-guide-item {
            padding: 12px;
            background: #f8fafc;
            border: 1px solid #e8edf3;
            border-radius: 10px;
        }

        .tf-guide-item strong,
        .tf-guide-item span {
            display: block;
        }

        .tf-guide-item strong {
            margin-bottom: 4px;
            color: #273247;
            font-size: 13px;
        }

        .tf-guide-item span {
            color: #7b8798;
            font-size: 11px;
            line-height: 1.5;
        }

        .tf-form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 24px;
            padding: 20px 22px;
            background: #ffffff;
            border: 1px solid #e4eaf1;
            border-radius: 16px;
        }

        .tf-btn {
            display: inline-flex;
            min-height: 44px;
            padding: 10px 18px;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border-radius: 10px;
        }

        .tf-btn-secondary {
            color: #475569;
            background: #ffffff;
            border: 1px solid #d7dee7;
        }

        .tf-btn-primary {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
        }

        @media (max-width: 1050px) {
            .tf-form-layout {
                grid-template-columns: 1fr;
            }

            .tf-form-sidebar {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 700px) {

            .tf-form-sidebar,
            .tf-form-grid {
                display: block;
            }

            .tf-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .tf-add-button {
                width: 100%;
            }

            .tf-place-image-upload {
                grid-template-columns: 1fr;
            }

            .tf-place-image-preview {
                width: 100%;
                height: 190px;
            }

            .tf-form-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .tf-btn {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initializeRepeater(config) {
                const list = document.getElementById(config.listId);
                const addButton = document.getElementById(config.buttonId);
                const template = document.getElementById(config.templateId);

                if (!list || !addButton || !template) {
                    return;
                }

                function updateNumbers() {
                    const items = list.querySelectorAll(
                        '[data-repeat-item]'
                    );

                    items.forEach(function(item, index) {
                        const number = item.querySelector(
                            '[data-item-number]'
                        );

                        if (number) {
                            number.textContent =
                                `${config.label} ${index + 1}`;
                        }
                    });
                }

                function bindItem(item) {
                    const removeButton = item.querySelector(
                        '[data-remove-item]'
                    );

                    removeButton?.addEventListener(
                        'click',
                        function() {
                            const items = list.querySelectorAll(
                                '[data-repeat-item]'
                            );

                            if (items.length === 1) {
                                item.querySelectorAll(
                                    'input, textarea'
                                ).forEach(function(field) {
                                    if (field.type === 'file') {
                                        field.value = '';
                                    } else if (
                                        field.type === 'number'
                                    ) {
                                        field.value = '0';
                                    } else {
                                        field.value = '';
                                    }
                                });

                                const preview = item.querySelector(
                                    '[data-image-preview]'
                                );

                                if (preview) {
                                    preview.innerHTML =
                                        '<span>No image selected</span>';
                                }

                                const fileName = item.querySelector(
                                    '[data-file-name]'
                                );

                                if (fileName) {
                                    fileName.textContent =
                                        'No file selected';
                                }

                                return;
                            }

                            item.remove();
                            updateNumbers();
                        }
                    );

                    const imageInput = item.querySelector(
                        '[data-image-input]'
                    );

                    imageInput?.addEventListener(
                        'change',
                        function() {
                            const file = this.files[0];

                            const preview = item.querySelector(
                                '[data-image-preview]'
                            );

                            const fileName = item.querySelector(
                                '[data-file-name]'
                            );

                            if (!file) {
                                if (preview) {
                                    preview.innerHTML =
                                        '<span>No image selected</span>';
                                }

                                if (fileName) {
                                    fileName.textContent =
                                        'No file selected';
                                }

                                return;
                            }

                            if (!file.type.startsWith('image/')) {
                                this.value = '';

                                if (fileName) {
                                    fileName.textContent =
                                        'Invalid image';
                                }

                                return;
                            }

                            if (fileName) {
                                fileName.textContent = file.name;
                            }

                            const reader = new FileReader();

                            reader.addEventListener(
                                'load',
                                function(event) {
                                    if (preview) {
                                        preview.innerHTML = `
                                            <img
                                                src="${event.target.result}"
                                                alt="Selected image"
                                            >
                                        `;
                                    }
                                }
                            );

                            reader.readAsDataURL(file);
                        }
                    );
                }

                list.querySelectorAll(
                    '[data-repeat-item]'
                ).forEach(bindItem);

                addButton.addEventListener(
                    'click',
                    function() {
                        const index =
                            Date.now().toString() +
                            Math.floor(
                                Math.random() * 1000
                            ).toString();

                        const fragment =
                            template.content.cloneNode(true);

                        fragment.querySelectorAll(
                            '[data-name]'
                        ).forEach(function(field) {
                            field.name = field.dataset.name.replace(
                                '__INDEX__',
                                index
                            );

                            field.removeAttribute('data-name');
                        });

                        const item = fragment.querySelector(
                            '[data-repeat-item]'
                        );

                        list.appendChild(fragment);

                        bindItem(item);
                        updateNumbers();

                        item.querySelector(
                            'input[type="text"]'
                        )?.focus();
                    }
                );

                updateNumbers();
            }

            initializeRepeater({
                listId: 'packageInclusionList',
                buttonId: 'addPackageInclusion',
                templateId: 'packageInclusionTemplate',
                label: 'Inclusion',
            });

            initializeRepeater({
                listId: 'placeCoveredList',
                buttonId: 'addPlaceCovered',
                templateId: 'placeCoveredTemplate',
                label: 'Place',
            });

            initializeRepeater({
                listId: 'tourHighlightList',
                buttonId: 'addTourHighlight',
                templateId: 'tourHighlightTemplate',
                label: 'Highlight',
            });
        });
    </script>
@endpush
