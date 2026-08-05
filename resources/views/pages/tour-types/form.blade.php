<div class="ts-form-grid">
    <div class="ts-form-main">

        <div class="row g-3">
            {{-- Tour Type Name --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="name" class="ts-label">
                        Tour Type Name
                        <span class="ts-required">*</span>
                    </label>

                    <input type="text" name="name" id="name"
                        class="ts-input @error('name') ts-input-error @enderror"
                        value="{{ old('name', $tourType->name ?? '') }}"
                        maxlength="100"
                        placeholder="Example: Domestic" required>

                    @error('name')
                        <span class="ts-error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Slug --}}
            <div class="col-md-6">
                <div class="ts-form-group mb-0">
                    <label for="slug" class="ts-label">
                        Slug
                    </label>

                    <input type="text" name="slug" id="slug"
                        class="ts-input @error('slug') ts-input-error @enderror"
                        value="{{ old('slug', $tourType->slug ?? '') }}"
                        maxlength="120"
                        placeholder="Example: domestic">

                    <div class="ts-field-note mt-1">
                        Leave empty to auto-generate from the tour type name.
                    </div>

                    @error('slug')
                        <span class="ts-error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

    </div>

    <div class="ts-form-sidebar">

        {{-- Status / Info card --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Tour Type</h3>
                <p>Define a new tour category such as Domestic or International.</p>
            </div>

            <div class="ts-field-note">
                The <strong>slug</strong> is used in URLs and filters. If left blank it will be generated automatically from the name you provide.
            </div>
        </div>

    </div>
</div>
