@php
    $counterItems = old('counters', isset($counter) ? [
        [
            'id' => $counter->id,
            'value' => $counter->value,
            'name' => $counter->name,
            'icon' => $counter->icon ?? 'fa-solid fa-users',
        ]
    ] : [
        [
            'value' => '',
            'name' => '',
            'icon' => 'fa-solid fa-users',
        ]
    ]);
@endphp

<div id="countersContainer">
    @foreach ($counterItems as $index => $item)
        @php
            $currentIcon = $item['icon'] ?? 'fa-solid fa-users';
        @endphp
        <div class="counter-item card mb-4 p-3 border rounded shadow-sm bg-light" data-index="{{ $index }}">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h5 class="mb-0 fw-bold text-secondary">
                    <i class="counter-header-icon {{ $currentIcon }} text-primary me-2"></i>
                    Counter #{{ $loop->iteration }}
                </h5>
                @if(!isset($counter))
                    <button type="button" class="btn btn-danger btn-sm remove-counter-btn">
                        <i class="fa-solid fa-trash me-1"></i> Remove
                    </button>
                @endif
            </div>

            @if(isset($item['id']))
                <input type="hidden" name="counters[{{ $index }}][id]" value="{{ $item['id'] }}">
            @endif

            <div class="admin-form-grid">
                {{-- Counter Value --}}
                <div class="admin-form-group">
                    <label>
                        <i class="fa-solid fa-hashtag text-primary me-1"></i>
                        Counter Value
                        <span class="required text-danger">*</span>
                    </label>

                    <input type="text" name="counters[{{ $index }}][value]" 
                        class="admin-form-control @error("counters.$index.value") is-invalid @enderror"
                        value="{{ $item['value'] ?? '' }}" placeholder="Example: 25+, 10K+, 99%" maxlength="100"
                        required>

                    @error("counters.$index.value")
                        <span class="admin-form-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Counter Name --}}
                <div class="admin-form-group">
                    <label>
                        <i class="fa-solid fa-tag text-info me-1"></i>
                        Counter Name
                        <span class="required text-danger">*</span>
                    </label>

                    <input type="text" name="counters[{{ $index }}][name]"
                        class="admin-form-control @error("counters.$index.name") is-invalid @enderror"
                        value="{{ $item['name'] ?? '' }}" placeholder="Example: Happy Customers" maxlength="255"
                        required>

                    @error("counters.$index.name")
                        <span class="admin-form-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Counter Icon --}}
                <div class="admin-form-group full-width">
                    <label>
                        <i class="fa-solid fa-icons text-warning me-1"></i>
                        Counter Icon (FontAwesome Class)
                    </label>

                    <div style="display: flex; gap: 10px; align-items: center;">
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(13,110,253,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #0d6efd; flex-shrink: 0;">
                            <i class="icon-preview-box {{ $currentIcon }}"></i>
                        </div>
                        <input type="text" name="counters[{{ $index }}][icon]"
                            class="admin-form-control icon-input @error("counters.$index.icon") is-invalid @enderror"
                            value="{{ $currentIcon }}"
                            placeholder="e.g. fa-solid fa-users"
                            oninput="updateItemIconPreview(this)">
                    </div>

                    <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px;">
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-plane-departure')"><i class="fa-solid fa-plane-departure text-primary me-1"></i> Plane / Customers</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-umbrella-beach')"><i class="fa-solid fa-umbrella-beach text-warning me-1"></i> Palm Tree / Destinations</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-earth-americas')"><i class="fa-solid fa-earth-americas text-info me-1"></i> Globe / Tours</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-bus')"><i class="fa-solid fa-bus text-success me-1"></i> Bus / Tour Types</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-users')"><i class="fa-solid fa-users text-secondary me-1"></i> Users</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-trophy')"><i class="fa-solid fa-trophy text-warning me-1"></i> Trophy</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-route')"><i class="fa-solid fa-route text-danger me-1"></i> Route</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-star')"><i class="fa-solid fa-star text-warning me-1"></i> Star</button>
                    </div>

                    @error("counters.$index.icon")
                        <span class="admin-form-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    @endforeach
</div>

@if(!isset($counter))
<div class="mb-4">
    <button type="button" id="addCounterBtn" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-plus me-1"></i> + Add Counter
    </button>
</div>
@endif

<div class="admin-form-grid mt-4">
    {{-- Status --}}
    <div class="admin-form-group">
        <label for="status">
            <i class="fa-solid fa-toggle-on text-success me-1"></i>
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

@push('scripts')
<script>
function updateItemIconPreview(input) {
    const item = input.closest('.counter-item');
    if (!item) return;
    const box = item.querySelector('.icon-preview-box');
    const headerIcon = item.querySelector('.counter-header-icon');
    const iconClass = input.value.trim() || 'fa-solid fa-users';
    if (box) box.className = 'icon-preview-box ' + iconClass;
    if (headerIcon) headerIcon.className = 'counter-header-icon ' + iconClass + ' text-primary me-2';
}

function pickCounterIcon(button, iconClass) {
    const item = button.closest('.counter-item');
    if (!item) return;
    const input = item.querySelector('.icon-input');
    if (input) {
        input.value = iconClass;
        updateItemIconPreview(input);
    }
}

@if(!isset($counter))
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('countersContainer');
    const addButton = document.getElementById('addCounterBtn');

    if (!container || !addButton) {
        return;
    }

    let nextIndex = container.querySelectorAll('.counter-item').length;

    function reindexCounters() {
        const items = container.querySelectorAll('.counter-item');
        items.forEach((item, index) => {
            const heading = item.querySelector('h5');
            if (heading) {
                const headerIcon = item.querySelector('.counter-header-icon');
                const iconClass = headerIcon ? headerIcon.className : 'counter-header-icon fa-solid fa-users text-primary me-2';
                heading.innerHTML = `<i class="${iconClass}"></i> Counter #${index + 1}`;
            }

            const valueInput = item.querySelector('input[name*="[value]"]');
            if (valueInput) {
                valueInput.name = 'counters[' + index + '][value]';
            }

            const nameInput = item.querySelector('input[name*="[name]"]');
            if (nameInput) {
                nameInput.name = 'counters[' + index + '][name]';
            }

            const iconInput = item.querySelector('input[name*="[icon]"]');
            if (iconInput) {
                iconInput.name = 'counters[' + index + '][icon]';
            }

            const idInput = item.querySelector('input[name*="[id]"]');
            if (idInput) {
                idInput.name = 'counters[' + index + '][id]';
            }
        });

        const removeButtons = container.querySelectorAll('.remove-counter-btn');
        removeButtons.forEach(btn => {
            btn.disabled = items.length === 1;
        });
    }

    addButton.addEventListener('click', function() {
        const index = nextIndex++;
        const item = document.createElement('div');
        item.className = 'counter-item card mb-4 p-3 border rounded shadow-sm bg-light';
        item.dataset.index = index;

        item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h5 class="mb-0 fw-bold text-secondary">
                    <i class="counter-header-icon fa-solid fa-users text-primary me-2"></i>
                    Counter #${container.querySelectorAll('.counter-item').length + 1}
                </h5>
                <button type="button" class="btn btn-danger btn-sm remove-counter-btn">
                    <i class="fa-solid fa-trash me-1"></i> Remove
                </button>
            </div>
            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label>
                        <i class="fa-solid fa-hashtag text-primary me-1"></i>
                        Counter Value
                        <span class="required text-danger">*</span>
                    </label>
                    <input type="text" name="counters[` + index + `][value]" class="admin-form-control" placeholder="Example: 25+, 10K+, 99%" maxlength="100" required>
                </div>
                <div class="admin-form-group">
                    <label>
                        <i class="fa-solid fa-tag text-info me-1"></i>
                        Counter Name
                        <span class="required text-danger">*</span>
                    </label>
                    <input type="text" name="counters[` + index + `][name]" class="admin-form-control" placeholder="Example: Happy Customers" maxlength="255" required>
                </div>
                <div class="admin-form-group full-width">
                    <label>
                        <i class="fa-solid fa-icons text-warning me-1"></i>
                        Counter Icon (FontAwesome Class)
                    </label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <div style="width: 40px; height: 40px; border-radius: 8px; background: rgba(13,110,253,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #0d6efd; flex-shrink: 0;">
                            <i class="icon-preview-box fa-solid fa-users"></i>
                        </div>
                        <input type="text" name="counters[` + index + `][icon]"
                            class="admin-form-control icon-input"
                            value="fa-solid fa-users"
                            placeholder="e.g. fa-solid fa-users"
                            oninput="updateItemIconPreview(this)">
                    </div>
                    <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px;">
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-plane-departure')"><i class="fa-solid fa-plane-departure text-primary me-1"></i> Plane / Customers</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-umbrella-beach')"><i class="fa-solid fa-umbrella-beach text-warning me-1"></i> Palm Tree / Destinations</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-earth-americas')"><i class="fa-solid fa-earth-americas text-info me-1"></i> Globe / Tours</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-bus')"><i class="fa-solid fa-bus text-success me-1"></i> Bus / Tour Types</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-users')"><i class="fa-solid fa-users text-secondary me-1"></i> Users</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-trophy')"><i class="fa-solid fa-trophy text-warning me-1"></i> Trophy</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-route')"><i class="fa-solid fa-route text-danger me-1"></i> Route</button>
                        <button type="button" class="btn btn-sm btn-light border" style="padding: 3px 10px; font-size: 0.8rem;" onclick="pickCounterIcon(this, 'fa-solid fa-star')"><i class="fa-solid fa-star text-warning me-1"></i> Star</button>
                    </div>
                </div>
            </div>
        `;

        container.appendChild(item);
        reindexCounters();
    });

    container.addEventListener('click', function(event) {
        const removeBtn = event.target.closest('.remove-counter-btn');
        if (!removeBtn) return;

        const items = container.querySelectorAll('.counter-item');
        if (items.length === 1) {
            alert('At least one counter entry is required.');
            return;
        }

        const item = removeBtn.closest('.counter-item');
        item.remove();
        reindexCounters();
    });

    reindexCounters();
});
@endif
</script>
@endpush

