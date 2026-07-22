@php
    $promiseItems = old('promises', $ourProcess->promises ?? [['text' => '']]);

    if (empty($promiseItems)) {
        $promiseItems = [['text' => '']];
    }
@endphp

<div class="admin-form-grid">

    {{-- Small Heading --}}
    <div class="admin-form-group">
        <label for="small_heading">
            Small Heading
        </label>

        <input type="text" name="small_heading" id="small_heading"
            class="admin-form-control
                @error('small_heading') is-invalid @enderror"
            value="{{ old('small_heading', $ourProcess->small_heading ?? '') }}" placeholder="Example: Our Process">

        @error('small_heading')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Heading --}}
    <div class="admin-form-group">
        <label for="heading">
            Heading
            <span class="required">*</span>
        </label>

        <input type="text" name="heading" id="heading"
            class="admin-form-control
                @error('heading') is-invalid @enderror"
            value="{{ old('heading', $ourProcess->heading ?? '') }}" placeholder="Enter heading" required>

        @error('heading')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Description --}}
    <div class="admin-form-group admin-form-group-full">
        <label for="description">
            Description
        </label>

        <textarea name="description" id="description" rows="5"
            class="admin-form-control
                @error('description') is-invalid @enderror"
            placeholder="Enter description">{{ old('description', $ourProcess->description ?? '') }}</textarea>

        @error('description')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>
    {{-- Promises --}}
    <div class="admin-form-group admin-form-group-full">
        <div class="promise-header">
            <div>
                <label>Promises</label>

                <p class="admin-form-help">
                    Add multiple promise items.
                </p>
            </div>

            <button type="button" id="addPromiseButton" class="admin-secondary-button">
                + Add Promise
            </button>
        </div>

        <div id="promiseContainer">
            @foreach ($promiseItems as $index => $promise)
                <div class="promise-item">
                    <input type="text" name="promises[{{ $index }}][text]"
                        class="admin-form-control
                            @error("promises.$index.text")
                                is-invalid
                            @enderror"
                        value="{{ $promise['text'] ?? '' }}" placeholder="Enter promise text">

                    <button type="button" class="remove-promise-button" aria-label="Remove promise">
                        ×
                    </button>
                </div>

                @error("promises.$index.text")
                    <span class="admin-form-error">
                        {{ $message }}
                    </span>
                @enderror
            @endforeach
        </div>

        @error('promises')
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

        <select name="status" id="status"
            class="admin-form-control
                @error('status') is-invalid @enderror" required>
            <option value="active" @selected(old('status', $ourProcess->status ?? 'active') === 'active')>
                Active
            </option>

            <option value="inactive" @selected(old('status', $ourProcess->status ?? '') === 'inactive')>
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
    <a href="{{ route('admin.our-processes.index') }}" class="admin-secondary-button">
        Cancel
    </a>

    <button type="submit" class="admin-primary-button">
        {{ isset($ourProcess) ? 'Update Process' : 'Create Process' }}
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container =
            document.getElementById('promiseContainer');

        const addButton =
            document.getElementById('addPromiseButton');

        if (!container || !addButton) {
            return;
        }

        let promiseIndex =
            container.querySelectorAll('.promise-item').length;

        addButton.addEventListener('click', function() {
            const totalItems =
                container.querySelectorAll('.promise-item').length;

            if (totalItems >= 20) {
                alert('You can add a maximum of 20 promises.');
                return;
            }

            const item = document.createElement('div');

            item.className = 'promise-item';

            item.innerHTML = `
                <input
                    type="text"
                    name="promises[${promiseIndex}][text]"
                    class="admin-form-control"
                    placeholder="Enter promise text"
                >

                <button
                    type="button"
                    class="remove-promise-button"
                    aria-label="Remove promise"
                >
                    ×
                </button>
            `;

            container.appendChild(item);

            promiseIndex++;
        });

        container.addEventListener('click', function(event) {
            const removeButton = event.target.closest(
                '.remove-promise-button'
            );

            if (!removeButton) {
                return;
            }

            const promiseItems =
                container.querySelectorAll('.promise-item');

            if (promiseItems.length === 1) {
                const input =
                    promiseItems[0].querySelector('input');

                input.value = '';

                return;
            }

            removeButton
                .closest('.promise-item')
                .remove();
        });
    });
</script>
