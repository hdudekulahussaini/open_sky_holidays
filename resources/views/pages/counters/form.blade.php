<div class="admin-form-grid">

    {{-- Counter Value --}}
    <div class="admin-form-group">
        <label for="value">
            Counter Value
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="value"
            id="value"
            class="admin-form-control @error('value') is-invalid @enderror"
            value="{{ old('value', $counter->value ?? '') }}"
            placeholder="Example: 25+, 10K+, 99%"
            maxlength="100"
            required
        >

        @error('value')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Counter Name --}}
    <div class="admin-form-group">
        <label for="name">
            Counter Name
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name"
            class="admin-form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $counter->name ?? '') }}"
            placeholder="Example: Happy Customers"
            maxlength="255"
            required
        >

        @error('name')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Status --}}
    <div class="admin-form-group">
        <label for="status">
            Status
        </label>

        <select
            name="status"
            id="status"
            class="admin-form-control @error('status') is-invalid @enderror"
        >
            <option
                value="1"
                @selected((string) old('status', isset($counter) ? (int) $counter->status : 1) === '1')
            >
                Active
            </option>

            <option
                value="0"
                @selected((string) old('status', isset($counter) ? (int) $counter->status : 1) === '0')
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

</div>