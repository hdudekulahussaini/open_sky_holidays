@php
    $promiseItems = old('promises', $ourProcess->promises ?? [['text' => '']]);

    if (empty($promiseItems)) {
        $promiseItems = [['text' => '']];
    }
@endphp

<div class="ts-form-content">
    <div class="row g-3">
        {{-- Small Heading --}}
        <div class="col-md-6">
            <div class="ts-form-group mb-0">
                <label for="small_heading" class="ts-label">
                    Small Heading
                </label>

                <input type="text" name="small_heading" id="small_heading"
                    class="ts-input @error('small_heading') ts-input-error @enderror"
                    value="{{ old('small_heading', $ourProcess->small_heading ?? '') }}"
                    placeholder="Example: Our Process">

                @error('small_heading')
                    <span class="ts-error-message">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        {{-- Heading --}}
        <div class="col-md-6">
            <div class="ts-form-group mb-0">
                <label for="heading" class="ts-label">
                    Heading
                    <span class="ts-required">*</span>
                </label>

                <input type="text" name="heading" id="heading"
                    class="ts-input @error('heading') ts-input-error @enderror"
                    value="{{ old('heading', $ourProcess->heading ?? '') }}"
                    placeholder="Enter heading" required>

                @error('heading')
                    <span class="ts-error-message">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        {{-- Description --}}
        <div class="col-md-6">
            <div class="ts-form-group mb-0">
                <label for="description" class="ts-label">
                    Description
                </label>

                <textarea name="description" id="description" rows="5"
                    class="ts-textarea @error('description') ts-input-error @enderror"
                    placeholder="Enter description">{{ old('description', $ourProcess->description ?? '') }}</textarea>

                @error('description')
                    <span class="ts-error-message">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        {{-- Status --}}
        <div class="col-md-6">
            <div class="ts-form-group mb-0">
                <label for="status" class="ts-label">
                    Status
                    <span class="ts-required">*</span>
                </label>

                <select name="status" id="status" class="ts-input @error('status') ts-input-error @enderror" required>
                    <option value="active" @selected(old('status', $ourProcess->status ?? 'active') === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $ourProcess->status ?? '') === 'inactive')>Inactive</option>
                </select>

                @error('status')
                    <span class="ts-error-message">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    </div>

    {{-- Promises --}}
    <div class="ts-form-group">
        <div class="ts-feature-heading">
            <div>
                <label class="ts-label">
                    Promises
                </label>
                <p class="ts-field-note">
                    Add or delete each promise item separately.
                </p>
            </div>

            <button type="button" class="ts-add-feature-btn" id="addPromiseButton">
                <span>+</span>
                Add Promise
            </button>
        </div>

        <div id="promiseContainer" class="ts-features-container mt-3">
            @foreach ($promiseItems as $index => $promise)
                <div class="feature-card border rounded-3 p-3 mb-3 js-feature-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3 flex-grow-1 me-3">
                            <span class="ts-feature-number fw-bold text-primary fs-5" style="min-width: 30px;">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
                            </span>
                            
                            <div class="flex-grow-1">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check"></i></span>
                                    <input type="text" name="promises[{{ $index }}][text]"
                                        class="form-control ts-feature-input @error("promises.$index.text") is-invalid @enderror"
                                        value="{{ $promise['text'] ?? '' }}" placeholder="Enter promise text">
                                </div>
                                @error("promises.$index.text")
                                    <span class="admin-form-error mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-danger ts-remove-feature-btn" title="Delete promise">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        @error('promises')
            <span class="ts-error-message">
                {{ $message }}
            </span>
        @enderror
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('promiseContainer');
        const addButton = document.getElementById('addPromiseButton');

        if (!container || !addButton) {
            return;
        }

        let promiseIndex = container.querySelectorAll('.js-feature-row').length;

        function updateFeatureNumbers() {
            const rows = container.querySelectorAll('.js-feature-row');
            rows.forEach(function(row, index) {
                const number = row.querySelector('.ts-feature-number');
                if (number) {
                    number.textContent = String(index + 1).padStart(2, '0') + '.';
                }
            });
        }

        addButton.addEventListener('click', function() {
            const totalItems = container.querySelectorAll('.js-feature-row').length;

            if (totalItems >= 20) {
                alert('You can add a maximum of 20 promises.');
                return;
            }

            const item = document.createElement('div');
            item.className = 'feature-card border rounded-3 p-3 mb-3 js-feature-row';
            item.style.cssText = 'background: #f8fafc; border-color: #e2e8f0 !important;';
            item.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3 flex-grow-1 me-3">
                        <span class="ts-feature-number fw-bold text-primary fs-5" style="min-width: 30px;"></span>
                        
                        <div class="flex-grow-1">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-check"></i></span>
                                <input type="text" name="promises[${promiseIndex}][text]" class="form-control ts-feature-input" placeholder="Enter promise text">
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-danger ts-remove-feature-btn" title="Delete promise">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;

            container.appendChild(item);
            promiseIndex++;
            updateFeatureNumbers();
            item.querySelector('input').focus();
        });

        container.addEventListener('click', function(event) {
            const removeButton = event.target.closest('.ts-remove-feature-btn');
            if (!removeButton) return;

            const promiseItems = container.querySelectorAll('.js-feature-row');
            if (promiseItems.length === 1) {
                const input = promiseItems[0].querySelector('input');
                input.value = '';
                input.focus();
                return;
            }

            removeButton.closest('.js-feature-row').remove();
            updateFeatureNumbers();
        });
        
        updateFeatureNumbers();
    });
</script>
@endpush
