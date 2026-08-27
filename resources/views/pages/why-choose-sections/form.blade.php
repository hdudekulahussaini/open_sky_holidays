@php
    $curatedIcons = [
        'fa-solid fa-earth-americas' => 'Worldwide Coverage (Globe)',
        'fa-solid fa-globe' => 'Global Network (Globe Outline)',
        'fa-solid fa-bolt-lightning' => 'Value For Money (Lightning)',
        'fa-solid fa-bolt' => 'Fast / Energy (Bolt)',
        'fa-solid fa-calendar-check' => 'Fast Booking (Calendar Check)',
        'fa-solid fa-calendar-days' => 'Easy Scheduling (Calendar)',
        'fa-solid fa-person-hiking' => 'Customized Tours (Hiker)',
        'fa-solid fa-map-location-dot' => 'Customized Destinations (Map Pin)',
        'fa-solid fa-route' => 'Tailored Itineraries (Route)',
        'fa-solid fa-headset' => 'Complete Support 24/7 (Headset)',
        'fa-solid fa-clock-rotate-left' => '24/7 Round the Clock (Clock)',
        'fa-solid fa-phone-volume' => 'Instant Assistance (Phone)',
        'fa-solid fa-shield-halved' => 'Safe & Flexible Travel (Shield)',
        'fa-solid fa-plane-departure' => 'Flight & Tour Operations (Airplane)',
        'fa-solid fa-ticket' => 'Instant Tickets & Pass (Ticket)',
        'fa-solid fa-hand-holding-dollar' => 'Best Price Guarantee (Money in Hand)',
        'fa-solid fa-tag' => 'Exclusive Discounts (Tag)',
        'fa-solid fa-star' => 'Premium Experience (Star)',
        'fa-solid fa-award' => 'Trusted & Certified (Award)',
        'fa-solid fa-hotel' => 'Luxury Stays (Hotel)',
        'fa-solid fa-compass' => 'Expert Travel Guide (Compass)',
        'fa-solid fa-heart' => 'Customer Satisfaction (Heart)',
        'fa-solid fa-suitcase-rolling' => 'Hassle-Free Travel (Luggage)',
        'fa-solid fa-user-shield' => 'Verified Partners (User Shield)',
        'fa-solid fa-thumbs-up' => '100% Reliable (Thumbs Up)',
        'custom' => '✎ Custom Icon Class...',
    ];

    $currentIcon = old('icon', $whyChooseSection->icon ?? 'fa-solid fa-earth-americas');
    $isPreset = array_key_exists($currentIcon, $curatedIcons);
@endphp

<div class="admin-form-grid">

    {{-- Title --}}
    <div class="admin-form-group full-width">
        <label for="title">
            Title <span class="required">*</span>
        </label>

        <input type="text" name="title" id="title" class="admin-form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $whyChooseSection->title ?? '') }}" placeholder="Example: Worldwide Coverage"
            required>

        @error('title')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Description --}}
    <div class="admin-form-group full-width">
        <label for="description">
            Description <span class="required">*</span>
        </label>

        <textarea name="description" id="description" rows="4"
            class="admin-form-control @error('description') is-invalid @enderror"
            placeholder="Enter description (e.g. Explore domestic and international destinations with complete planning...)" required>{{ old('description', $whyChooseSection->description ?? '') }}</textarea>

        @error('description')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Icon Selection & Preview --}}
    <div class="admin-form-group full-width">
        <label for="icon_select">
            Choose Icon <span class="text-muted fw-normal">(Font Awesome Icon)</span>
        </label>

        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            {{-- Visual Icon Box Preview --}}
            <div id="iconPreviewContainer"
                 style="width: 56px; height: 56px; border-radius: 12px; background: #f0f7ff; border: 2px solid #0056b3; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: #0056b3; box-shadow: 0 4px 12px rgba(0, 86, 179, 0.15); flex-shrink: 0;">
                <i id="iconPreviewEl" class="{{ $currentIcon ?: 'fa-solid fa-earth-americas' }}"></i>
            </div>

            {{-- Icon Preset Dropdown --}}
            <div style="flex: 1; min-width: 240px;">
                <select id="iconSelect" class="admin-form-control">
                    <option value="">-- Select an Icon --</option>
                    @foreach($curatedIcons as $iconClass => $iconName)
                        <option value="{{ $iconClass }}" @selected($isPreset ? $currentIcon === $iconClass : $iconClass === 'custom')>
                            {{ $iconName }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Icon Class Input --}}
            <div style="flex: 1; min-width: 240px;">
                <input type="text" name="icon" id="iconInput"
                    class="admin-form-control @error('icon') is-invalid @enderror"
                    value="{{ $currentIcon }}"
                    placeholder="e.g. fa-solid fa-earth-americas">
            </div>
        </div>
        <small class="text-muted mt-1 d-block" style="font-size: 0.82rem; color: #64748b;">
            Select from the dropdown or type any FontAwesome icon class (e.g. <code>fa-solid fa-bolt-lightning</code>, <code>fa-solid fa-headset</code>).
        </small>

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
            <span class="required">*</span>
        </label>

        <input type="number" name="sort_order" id="sort_order" min="0"
            class="admin-form-control @error('sort_order') is-invalid @enderror"
            value="{{ old('sort_order', $whyChooseSection->sort_order ?? 0) }}" placeholder="Enter display order" required>

        @error('sort_order')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Publishing Status --}}
    <div class="admin-form-group">
        <label for="status">
            Status
            <span class="required">*</span>
        </label>

        <select id="status" name="status"
            class="admin-form-control @error('status') is-invalid @enderror" required>
            <option value="1" @selected(old('status', $whyChooseSection->status ?? 1) == 1)>
                Active
            </option>

            <option value="0" @selected(old('status', $whyChooseSection->status ?? 1) == 0)>
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
    <a href="{{ route('admin.why-choose-sections.index') }}" class="btn btn-light">
        Cancel
    </a>

    <button type="submit" class="btn btn-primary">
        {{ $buttonText ?? 'Save Section' }}
    </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const iconSelect = document.getElementById('iconSelect');
    const iconInput = document.getElementById('iconInput');
    const iconPreviewEl = document.getElementById('iconPreviewEl');

    function updateIconPreview(cls) {
        if (!cls || cls.trim() === '') {
            iconPreviewEl.className = 'fa-solid fa-question';
        } else {
            iconPreviewEl.className = cls;
        }
    }

    if (iconSelect && iconInput) {
        iconSelect.addEventListener('change', function () {
            if (this.value && this.value !== 'custom') {
                iconInput.value = this.value;
                updateIconPreview(this.value);
            } else if (this.value === 'custom') {
                iconInput.focus();
            }
        });

        iconInput.addEventListener('input', function () {
            const val = this.value.trim();
            updateIconPreview(val);

            // Match back to select if exists
            let found = false;
            for (let opt of iconSelect.options) {
                if (opt.value === val) {
                    iconSelect.value = val;
                    found = true;
                    break;
                }
            }
            if (!found && val !== '') {
                iconSelect.value = 'custom';
            }
        });
    }
});
</script>
@endpush
