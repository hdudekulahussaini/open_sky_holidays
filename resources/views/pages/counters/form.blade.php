@php
    $counterItems = old('counters', isset($counter) ? [
        [
            'id' => $counter->id,
            'value' => $counter->value,
            'name' => $counter->name,
        ]
    ] : [
        [
            'value' => '',
            'name' => '',
        ]
    ]);
@endphp

<div id="countersContainer">
    @foreach ($counterItems as $index => $item)
        <div class="counter-item card mb-4 p-3 border rounded shadow-sm bg-light" data-index="{{ $index }}">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h5 class="mb-0 fw-bold text-secondary">Counter #{{ $loop->iteration }}</h5>
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
            </div>
        </div>
    @endforeach
</div>

@if(!isset($counter))
<div class="mb-4">
    <button type="button" id="addCounterBtn" class="btn btn-secondary btn-sm">
        + Add Counter
    </button>
</div>
@endif

<div class="admin-form-grid mt-4">
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

@if(!isset($counter))
@push('scripts')
<script>
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
                heading.textContent = 'Counter #' + (index + 1);
            }

            const valueInput = item.querySelector('input[name*="[value]"]');
            if (valueInput) {
                valueInput.name = 'counters[' + index + '][value]';
            }

            const nameInput = item.querySelector('input[name*="[name]"]');
            if (nameInput) {
                nameInput.name = 'counters[' + index + '][name]';
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
                <h5 class="mb-0 fw-bold text-secondary">Counter #${container.querySelectorAll('.counter-item').length + 1}</h5>
                <button type="button" class="btn btn-danger btn-sm remove-counter-btn">
                    <i class="fa-solid fa-trash me-1"></i> Remove
                </button>
            </div>
            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label>
                        Counter Value
                        <span class="required text-danger">*</span>
                    </label>
                    <input type="text" name="counters[` + index + `][value]" class="admin-form-control" placeholder="Example: 25+, 10K+, 99%" maxlength="100" required>
                </div>
                <div class="admin-form-group">
                    <label>
                        Counter Name
                        <span class="required text-danger">*</span>
                    </label>
                    <input type="text" name="counters[` + index + `][name]" class="admin-form-control" placeholder="Example: Happy Customers" maxlength="255" required>
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
</script>
@endpush
@endif
