<div class="admin-form-grid">

    {{-- Heading --}}
    <div class="admin-form-group">
        <label for="heading">
            Heading
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="heading"
            id="heading"
            class="admin-form-control @error('heading') is-invalid @enderror"
            value="{{ old('heading', $coreValue->heading ?? '') }}"
            placeholder="Enter core value heading"
            maxlength="255"
            required
        >

        @error('heading')
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
            <option value="">
                Select status
            </option>

            <option
                value="active"
                @selected(
                    old(
                        'status',
                        $coreValue->status ?? 'active'
                    ) === 'active'
                )
            >
                Active
            </option>

            <option
                value="inactive"
                @selected(
                    old(
                        'status',
                        $coreValue->status ?? 'active'
                    ) === 'inactive'
                )
            >
                Inactive
            </option>
        </select>

        @error('status')
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
            rows="6"
            class="admin-form-control @error('description') is-invalid @enderror"
            placeholder="Enter core value description"
            required
        >{{ old('description', $coreValue->description ?? '') }}</textarea>

        @error('description')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

</div>