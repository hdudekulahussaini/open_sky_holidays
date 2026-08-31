@php
    $presetIcons = [
        ['class' => 'fa-solid fa-earth-americas', 'name' => 'Worldwide Coverage', 'cat' => 'travel'],
        ['class' => 'fa-solid fa-plane-departure', 'name' => 'Flight Bookings', 'cat' => 'travel'],
        ['class' => 'fa-solid fa-map-location-dot', 'name' => 'Custom Destinations', 'cat' => 'travel'],
        ['class' => 'fa-solid fa-person-hiking', 'name' => 'Customized Tours', 'cat' => 'travel'],
        ['class' => 'fa-solid fa-hotel', 'name' => 'Luxury Stays', 'cat' => 'travel'],
        ['class' => 'fa-solid fa-umbrella-beach', 'name' => 'Beach Holidays', 'cat' => 'travel'],
        ['class' => 'fa-solid fa-mountain-sun', 'name' => 'Scenic Treks', 'cat' => 'travel'],
        ['class' => 'fa-solid fa-passport', 'name' => 'Visa Support', 'cat' => 'travel'],
        ['class' => 'fa-solid fa-shield-halved', 'name' => 'Safe & Flexible', 'cat' => 'trust'],
        ['class' => 'fa-solid fa-award', 'name' => 'Certified Agency', 'cat' => 'trust'],
        ['class' => 'fa-solid fa-star', 'name' => '5-Star Experience', 'cat' => 'trust'],
        ['class' => 'fa-solid fa-thumbs-up', 'name' => '100% Satisfaction', 'cat' => 'trust'],
        ['class' => 'fa-solid fa-headset', 'name' => '24/7 Complete Support', 'cat' => 'support'],
        ['class' => 'fa-solid fa-clock-rotate-left', 'name' => 'Always Available', 'cat' => 'support'],
        ['class' => 'fa-solid fa-phone-volume', 'name' => 'Instant Helpline', 'cat' => 'support'],
        ['class' => 'fa-solid fa-hand-holding-dollar', 'name' => 'Best Price Guarantee', 'cat' => 'deals'],
        ['class' => 'fa-solid fa-bolt-lightning', 'name' => 'Fast Booking', 'cat' => 'deals'],
        ['class' => 'fa-solid fa-calendar-check', 'name' => 'Flexible Schedules', 'cat' => 'deals'],
        ['class' => 'fa-solid fa-tags', 'name' => 'Special Discounts', 'cat' => 'deals'],
        ['class' => 'fa-solid fa-lock', 'name' => 'Secure Payments', 'cat' => 'deals'],
    ];

    $currentIcon = old('icon', $whyChooseSection->icon ?? 'fa-solid fa-earth-americas');

    // Check if current icon matches any preset
    $isPreset = false;
    foreach ($presetIcons as $p) {
        if ($p['class'] === $currentIcon) {
            $isPreset = true;
            break;
        }
    }
@endphp

@push('styles')
<style>
/* Method: Visual Dual-Mode Segmented Icon Selector */
.wc-icon-mode-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Mode Switcher Tabs */
.wc-mode-nav {
    display: flex;
    background: #f1f5f9;
    padding: 4px;
    border-radius: 10px;
    gap: 4px;
}

.wc-mode-tab {
    flex: 1;
    border: none;
    background: transparent;
    padding: 0.5rem 0.75rem;
    border-radius: 7px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
}

.wc-mode-tab.is-active {
    background: #ffffff;
    color: #0284c7;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

/* Selected Icon Live Bar */
.wc-live-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 8px;
    padding: 0.6rem 0.9rem;
}

.wc-live-bar-info {
    display: flex;
    align-items: center;
    gap: 0.65rem;
}

.wc-live-bar-icon {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    background: #0284c7;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.wc-live-bar-code {
    font-family: monospace;
    font-size: 0.82rem;
    font-weight: 600;
    color: #0369a1;
}

/* Preset Mode: Tile Cards Grid */
.wc-preset-search {
    position: relative;
}

.wc-preset-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
}

.wc-preset-search input {
    width: 100%;
    height: 38px;
    padding-left: 2.2rem;
    padding-right: 0.75rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.85rem;
    outline: none;
    transition: border-color 0.2s ease;
}

.wc-preset-search input:focus {
    border-color: #0284c7;
}

.wc-tiles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 0.6rem;
    max-height: 220px;
    overflow-y: auto;
    padding: 0.3rem;
}

.wc-tiles-grid::-webkit-scrollbar {
    width: 5px;
}
.wc-tiles-grid::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 5px;
}

.wc-tile-item {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 9px;
    padding: 0.65rem 0.4rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    cursor: pointer;
    transition: all 0.15s ease;
    text-align: center;
    position: relative;
}

.wc-tile-item:hover {
    border-color: #0284c7;
    background: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(2, 132, 199, 0.1);
}

.wc-tile-item.is-selected {
    background: #f0f9ff;
    border-color: #0284c7;
    box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.2);
}

.wc-tile-icon {
    font-size: 1.25rem;
    color: #334155;
    transition: color 0.15s ease;
}

.wc-tile-item.is-selected .wc-tile-icon {
    color: #0284c7;
}

.wc-tile-name {
    font-size: 0.72rem;
    font-weight: 600;
    color: #475569;
    line-height: 1.2;
}

.wc-tile-item.is-selected .wc-tile-name {
    color: #0369a1;
    font-weight: 700;
}

/* Custom Mode: Direct Input */
.wc-custom-input-pane {
    display: none;
    flex-direction: column;
    gap: 0.75rem;
}

.wc-custom-input-pane.is-active {
    display: flex;
}

.wc-preset-pane {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.wc-preset-pane.is-hidden {
    display: none;
}
</style>
@endpush

<div class="admin-form-grid">

    {{-- Title --}}
    <div class="admin-form-group">
        <label for="title">
            Title
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="title"
            id="title"
            class="admin-form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $whyChooseSection->title ?? '') }}"
            placeholder="e.g. Worldwide Coverage"
            maxlength="255"
            required
        >

        @error('title')
            <span class="admin-form-error">
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

        <select
            name="status"
            id="status"
            class="admin-form-control @error('status') is-invalid @enderror"
            required
        >
            <option value="1" @selected((string) old('status', $whyChooseSection->status ?? 1) === '1' || old('status', $whyChooseSection->status ?? 1) === true || old('status', $whyChooseSection->status ?? 1) === 1)>
                Active
            </option>
            <option value="0" @selected((string) old('status', $whyChooseSection->status ?? 1) === '0' || old('status', $whyChooseSection->status ?? 1) === false || old('status', $whyChooseSection->status ?? 1) === 0)>
                Inactive
            </option>
        </select>

        @error('status')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Icon (Method: Dual-Mode Segmented Card) --}}
    <div class="admin-form-group admin-form-group-full">
        <label>
            Select Icon (FontAwesome)
            <span class="required">*</span>
        </label>

        {{-- The actual form input submitted to Laravel --}}
        <input type="hidden" name="icon" id="mainIconField" value="{{ $currentIcon }}">

        <div class="wc-icon-mode-card">
            
            {{-- Mode Switcher Tabs --}}
            <div class="wc-mode-nav">
                <button type="button" class="wc-mode-tab {{ $isPreset || empty($currentIcon) ? 'is-active' : '' }}" id="tabPreset">
                    <i class="fa-solid fa-shapes"></i>
                    Pick from Preset Travel Icons
                </button>
                <button type="button" class="wc-mode-tab {{ !$isPreset && !empty($currentIcon) ? 'is-active' : '' }}" id="tabCustom">
                    <i class="fa-solid fa-keyboard"></i>
                    Type Custom Icon Class
                </button>
            </div>

            {{-- Selected Icon Live Info Bar --}}
            <div class="wc-live-bar">
                <div class="wc-live-bar-info">
                    <div class="wc-live-bar-icon">
                        <i id="liveBarIcon" class="{{ $currentIcon ?: 'fa-solid fa-earth-americas' }}"></i>
                    </div>
                    <div>
                        <span class="small text-muted d-block" style="font-size: 0.72rem; text-transform: uppercase;">Active Icon</span>
                        <span class="wc-live-bar-code" id="liveBarCode">{{ $currentIcon ?: 'fa-solid fa-earth-americas' }}</span>
                    </div>
                </div>
                <span class="badge bg-success" style="font-size: 0.7rem;">Selected</span>
            </div>

            {{-- 1. Preset Icons View --}}
            <div class="wc-preset-pane {{ !$isPreset && !empty($currentIcon) ? 'is-hidden' : '' }}" id="panePreset">
                <div class="wc-preset-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="presetSearchInput" placeholder="Search preset icons (e.g. plane, hotel, shield, money)...">
                </div>

                <div class="wc-tiles-grid" id="presetTilesGrid">
                    @foreach($presetIcons as $item)
                        @php $isSelected = ($currentIcon === $item['class']); @endphp
                        <div class="wc-tile-item js-tile-btn {{ $isSelected ? 'is-selected' : '' }}"
                             data-class="{{ $item['class'] }}"
                             data-name="{{ $item['name'] }}">
                            <i class="{{ $item['class'] }} wc-tile-icon"></i>
                            <span class="wc-tile-name">{{ $item['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 2. Custom Icon Class View --}}
            <div class="wc-custom-input-pane {{ !$isPreset && !empty($currentIcon) ? 'is-active' : '' }}" id="paneCustom">
                <label for="customClassInput" class="small fw-bold text-muted">FontAwesome 6 Icon Class:</label>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="text" 
                           id="customClassInput" 
                           class="admin-form-control" 
                           value="{{ $currentIcon }}" 
                           placeholder="e.g. fa-solid fa-umbrella-beach">
                    <button type="button" class="btn btn-primary btn-sm px-3" id="btnApplyCustomClass">
                        Apply
                    </button>
                </div>
                <small class="text-muted">You can use any free icon class from <a href="https://fontawesome.com/icons" target="_blank" class="text-primary">FontAwesome 6</a>.</small>
            </div>

        </div>

        @error('icon')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Sort Order --}}
    <div class="admin-form-group">
        <label for="sort_order">
            Sort Order
        </label>

        <input
            type="number"
            name="sort_order"
            id="sort_order"
            class="admin-form-control @error('sort_order') is-invalid @enderror"
            value="{{ old('sort_order', $whyChooseSection->sort_order ?? 0) }}"
            placeholder="0"
            min="0"
        >

        <small class="text-muted d-block mt-1">
            Lower numbers appear first on the website.
        </small>

        @error('sort_order')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Description --}}
    <div class="admin-form-group admin-form-group-full">
        <label for="description">
            Description
            <span class="required">*</span>
        </label>

        <textarea
            name="description"
            id="description"
            rows="4"
            class="admin-form-control @error('description') is-invalid @enderror"
            placeholder="Enter description explaining this benefit..."
            required
        >{{ old('description', $whyChooseSection->description ?? '') }}</textarea>

        @error('description')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>

<div class="admin-form-actions mt-4">
    <a href="{{ route('admin.why-choose-sections.index') }}" class="btn btn-light">
        Cancel
    </a>

    <button type="submit" class="btn btn-primary">
        {{ $buttonText ?? (isset($whyChooseSection) && $whyChooseSection->exists ? 'Update Section' : 'Save Section') }}
    </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainIconField = document.getElementById('mainIconField');
    const liveBarIcon = document.getElementById('liveBarIcon');
    const liveBarCode = document.getElementById('liveBarCode');
    const tabPreset = document.getElementById('tabPreset');
    const tabCustom = document.getElementById('tabCustom');
    const panePreset = document.getElementById('panePreset');
    const paneCustom = document.getElementById('paneCustom');
    const tiles = document.querySelectorAll('.js-tile-btn');
    const presetSearchInput = document.getElementById('presetSearchInput');
    const customClassInput = document.getElementById('customClassInput');
    const btnApplyCustomClass = document.getElementById('btnApplyCustomClass');

    function applyIcon(cls) {
        if (!cls || cls.trim() === '') {
            cls = 'fa-solid fa-earth-americas';
        }

        mainIconField.value = cls;
        liveBarIcon.className = cls;
        liveBarCode.textContent = cls;
        if (customClassInput) customClassInput.value = cls;

        // Highlight matching tile
        tiles.forEach(tile => {
            if (tile.getAttribute('data-class') === cls) {
                tile.classList.add('is-selected');
            } else {
                tile.classList.remove('is-selected');
            }
        });
    }

    // Tab Switching
    if (tabPreset && tabCustom) {
        tabPreset.addEventListener('click', function () {
            tabPreset.classList.add('is-active');
            tabCustom.classList.remove('is-active');
            panePreset.classList.remove('is-hidden');
            paneCustom.classList.remove('is-active');
        });

        tabCustom.addEventListener('click', function () {
            tabCustom.classList.add('is-active');
            tabPreset.classList.remove('is-active');
            paneCustom.classList.add('is-active');
            panePreset.classList.add('is-hidden');
            setTimeout(() => {
                if (customClassInput) customClassInput.focus();
            }, 50);
        });
    }

    // Tile Click
    tiles.forEach(tile => {
        tile.addEventListener('click', function () {
            const cls = this.getAttribute('data-class');
            applyIcon(cls);
        });
    });

    // Preset Search Filtering
    if (presetSearchInput) {
        presetSearchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            tiles.forEach(tile => {
                const name = (tile.getAttribute('data-name') || '').toLowerCase();
                const cls = (tile.getAttribute('data-class') || '').toLowerCase();
                if (!q || name.includes(q) || cls.includes(q)) {
                    tile.style.display = 'flex';
                } else {
                    tile.style.display = 'none';
                }
            });
        });
    }

    // Apply custom class
    if (btnApplyCustomClass && customClassInput) {
        btnApplyCustomClass.addEventListener('click', function () {
            applyIcon(customClassInput.value.trim());
        });

        customClassInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyIcon(customClassInput.value.trim());
            }
        });
    }
});
</script>
@endpush
