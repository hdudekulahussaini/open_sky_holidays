@php
    $isEdit = isset($whatWeOffer);
@endphp

<div class="row g-4">
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">
            <div
                class="card-header bg-white
                       border-bottom py-3 px-4"
            >
                <h5 class="fw-semibold mb-0">
                    What We Offer Information
                </h5>
            </div>

            <div class="card-body p-4">

                {{-- Title --}}
                <div class="mb-4">
                    <label
                        for="title"
                        class="form-label fw-semibold"
                    >
                        Title
                        <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old(
                            'title',
                            $whatWeOffer->title ?? ''
                        ) }}"
                        class="form-control
                            @error('title')
                                is-invalid
                            @enderror"
                        placeholder="Domestic Tours"
                    >

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Subtitle --}}
                <div class="mb-4">
                    <label
                        for="subtitle"
                        class="form-label fw-semibold"
                    >
                        Subtitle
                    </label>

                    <input
                        type="text"
                        id="subtitle"
                        name="subtitle"
                        value="{{ old(
                            'subtitle',
                            $whatWeOffer->subtitle ?? ''
                        ) }}"
                        class="form-control
                            @error('subtitle')
                                is-invalid
                            @enderror"
                        placeholder="Explore Service"
                    >

                    @error('subtitle')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label
                        for="description"
                        class="form-label fw-semibold"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="7"
                        class="form-control
                            @error('description')
                                is-invalid
                            @enderror"
                        placeholder="Enter the What We Offer description"
                    >{{ old(
                        'description',
                        $whatWeOffer->description ?? ''
                    ) }}</textarea>

                    <div class="form-text">
                        Maximum 3000 characters.
                    </div>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
        </div>

    </div>

    <div class="col-lg-4">

        {{-- Image --}}
        <div class="card border-0 shadow-sm mb-4">
            <div
                class="card-header bg-white
                       border-bottom py-3 px-4"
            >
                <h5 class="fw-semibold mb-0">
                    Offer Image
                </h5>
            </div>

            <div class="card-body p-4">
                <label
                    for="image"
                    class="form-label fw-semibold"
                >
                    Image

                    @unless ($isEdit)
                        <span class="text-danger">*</span>
                    @endunless
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="form-control
                        @error('image')
                            is-invalid
                        @enderror"
                >

                <div class="form-text">
                    JPG, JPEG, PNG or WEBP.
                    Maximum size 5 MB.
                </div>

                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @if (
                    $isEdit &&
                    filled($whatWeOffer->image)
                )
                    <div
                        id="currentImage"
                        class="mt-3"
                    >
                        <p class="small text-muted mb-2">
                            Current image
                        </p>

                        <img
                            src="{{ asset(
                                'storage/' .
                                $whatWeOffer->image
                            ) }}"
                            alt="{{ $whatWeOffer->title }}"
                            class="offer-preview-image"
                        >
                    </div>
                @endif

                <div
                    id="imagePreview"
                    class="mt-3"
                ></div>
            </div>
        </div>

        {{-- Status --}}
        <div class="card border-0 shadow-sm">
            <div
                class="card-header bg-white
                       border-bottom py-3 px-4"
            >
                <h5 class="fw-semibold mb-0">
                    Publish Settings
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="mb-4">
                    <label
                        for="status"
                        class="form-label fw-semibold"
                    >
                        Status
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select
                            @error('status')
                                is-invalid
                            @enderror"
                    >
                        <option
                            value="active"
                            @selected(
                                old(
                                    'status',
                                    $whatWeOffer->status
                                        ?? 'active'
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
                                    $whatWeOffer->status
                                        ?? 'active'
                                ) === 'inactive'
                            )
                        >
                            Inactive
                        </option>
                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >
                    <i
                        class="fa-solid
                               fa-floppy-disk me-2"
                    ></i>

                    {{ $isEdit
                        ? 'Update What We Offer'
                        : 'Save What We Offer' }}
                </button>

                <a
                    href="{{ route(
                        'admin.what-we-offers.index'
                    ) }}"
                    class="btn btn-light w-100 mt-2"
                >
                    Cancel
                </a>
            </div>
        </div>

    </div>
</div>

<style>
    .offer-preview-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }
</style>

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {
            const imageInput =
                document.getElementById('image');

            const imagePreview =
                document.getElementById(
                    'imagePreview'
                );

            const currentImage =
                document.getElementById(
                    'currentImage'
                );

            if (!imageInput || !imagePreview) {
                return;
            }

            imageInput.addEventListener(
                'change',
                function () {
                    imagePreview.innerHTML = '';

                    const file = this.files[0];

                    if (
                        !file ||
                        !file.type.startsWith('image/')
                    ) {
                        return;
                    }

                    if (currentImage) {
                        currentImage.style.display =
                            'none';
                    }

                    const reader =
                        new FileReader();

                    reader.onload = function (event) {
                        imagePreview.innerHTML = `
                            <p class="small text-muted mb-2">
                                Selected image
                            </p>

                            <img
                                src="${event.target.result}"
                                alt="What We Offer preview"
                                class="offer-preview-image"
                            >
                        `;
                    };

                    reader.readAsDataURL(file);
                }
            );
        }
    );
</script>