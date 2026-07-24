@csrf

<div class="admin-form-grid">

    {{-- Title --}}
    <div class="admin-form-group full-width">
        <label for="title">
            Title <span class="required">*</span>
        </label>

        <input type="text" name="title" id="title" class="admin-form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $whyChooseSection->title ?? '') }}" placeholder="Example: Why Choose Open Sky Holidays"
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

        <textarea name="description" id="description" rows="6"
            class="admin-form-control @error('description') is-invalid @enderror"
            placeholder="Enter the Why Choose Us description" required>{{ old('description', $whyChooseSection->description ?? '') }}</textarea>

        @error('description')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

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

</div>


{{-- Publishing Status --}}
<div class="admin-form-group">

    <label for="status">
        Status
        <span class="required">*</span>
    </label>

    <select id="status" name="status"
        class="admin-form-control
                                @error('status') is-invalid @enderror" required>
        <option value="1" @selected(old('status', 1) == 1)>
            Active
        </option>

        <option value="0" @selected(old('status', 1) == 0)>
            Inactive
        </option>
    </select>

    @error('status')
        <span class="admin-form-error">
            {{ $message }}
        </span>
    @enderror

</div>


