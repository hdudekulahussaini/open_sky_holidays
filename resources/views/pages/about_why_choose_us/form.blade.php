@php
    $isEdit = isset($aboutWhyChooseUs);

    $oldTitles = old(
        'features_title',
        $isEdit
            ? ($aboutWhyChooseUs->features_title ?? [])
            : ['']
    );

    $oldDescriptions = old(
        'features_description',
        $isEdit
            ? ($aboutWhyChooseUs->features_description ?? [])
            : ['']
    );

    $featureCount = max(
        count($oldTitles),
        count($oldDescriptions),
        1
    );
@endphp

<div class="row g-4">
    <div class="col-xl-8 col-lg-7">

        <div class="card border-0 shadow-sm mb-4">
            <div
                class="card-header bg-white
                       border-bottom py-3 px-4"
            >
                <h5 class="fw-semibold mb-0">
                    Section Information
                </h5>
            </div>

            <div class="card-body p-4">
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
                            $aboutWhyChooseUs->title ?? ''
                        ) }}"
                        class="form-control
                            @error('title')
                                is-invalid
                            @enderror"
                        placeholder="Setting Standard for Trust and Comfort."
                    >

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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
                        rows="6"
                        class="form-control
                            @error('description')
                                is-invalid
                            @enderror"
                        placeholder="Enter the section description"
                    >{{ old(
                        'description',
                        $aboutWhyChooseUs->description ?? ''
                    ) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div
                class="card-header bg-white
                       border-bottom py-3 px-4"
            >
                <div
                    class="d-flex flex-wrap
                           justify-content-between
                           align-items-center gap-3"
                >
                    <div>
                        <h5 class="fw-semibold mb-1">
                            Why Choose Us Features
                        </h5>

                        <p class="small text-muted mb-0">
                            Add or remove feature titles
                            and descriptions.
                        </p>
                    </div>

                    <button
                        type="button"
                        id="addFeatureButton"
                        class="btn btn-primary btn-sm"
                    >
                        <i class="fa-solid fa-plus me-1"></i>
                        Add Feature
                    </button>
                </div>
            </div>

            <div class="card-body p-4">
                <div id="featuresContainer">
                    @for (
                        $index = 0;
                        $index < $featureCount;
                        $index++
                    )
                        <div
                            class="feature-card border
                                   rounded-3 p-3 mb-3"
                        >
                            <div
                                class="d-flex justify-content-between
                                       align-items-center mb-3"
                            >
                                <h6
                                    class="feature-number
                                           fw-semibold mb-0"
                                >
                                    Feature {{ $index + 1 }}
                                </h6>

                                <button
                                    type="button"
                                    class="btn btn-sm
                                           btn-outline-danger
                                           remove-feature"
                                    title="Delete feature"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                            <div class="mb-3">
                                <label
                                    class="form-label fw-semibold"
                                >
                                    Feature Title
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="features_title[]"
                                    data-field="title"
                                    value="{{ $oldTitles[$index] ?? '' }}"
                                    class="form-control
                                        @error(
                                            'features_title.' .
                                            $index
                                        )
                                            is-invalid
                                        @enderror"
                                    placeholder="24/7 Expert Support"
                                >

                                @error(
                                    'features_title.' .
                                    $index
                                )
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="form-label fw-semibold"
                                >
                                    Feature Description
                                </label>

                                <textarea
                                    name="features_description[]"
                                    data-field="description"
                                    rows="3"
                                    class="form-control
                                        @error(
                                            'features_description.' .
                                            $index
                                        )
                                            is-invalid
                                        @enderror"
                                    placeholder="Enter feature description"
                                >{{ $oldDescriptions[$index] ?? '' }}</textarea>

                                @error(
                                    'features_description.' .
                                    $index
                                )
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endfor
                </div>

                @error('features_title')
                    <div class="text-danger small">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">

        <div class="card border-0 shadow-sm mb-4">
            <div
                class="card-header bg-white
                       border-bottom py-3 px-4"
            >
                <h5 class="fw-semibold mb-0">
                    Section Image
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
                    filled($aboutWhyChooseUs->image)
                )
                    <div id="currentImage" class="mt-3">
                        <p class="small text-muted mb-2">
                            Current image
                        </p>

                        <img
                            src="{{ asset(
                                'storage/' .
                                $aboutWhyChooseUs->image
                            ) }}"
                            alt="{{ $aboutWhyChooseUs->title }}"
                            class="section-preview-image"
                        >
                    </div>
                @endif

                <div
                    id="imagePreview"
                    class="mt-3"
                ></div>
            </div>
        </div>

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
                                    $aboutWhyChooseUs->status
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
                                    $aboutWhyChooseUs->status
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
                        ? 'Update Section'
                        : 'Save Section' }}
                </button>

                <a
                    href="{{ route(
                        'admin.about-why-choose-us.index'
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
    .section-preview-image {
        width: 100%;
        height: 230px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .feature-card {
        background: #f8fafc;
        border-color: #e2e8f0 !important;
    }
</style>

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {
            const container =
                document.getElementById(
                    'featuresContainer'
                );

            const addButton =
                document.getElementById(
                    'addFeatureButton'
                );

            function updateNumbers() {
                const cards =
                    container.querySelectorAll(
                        '.feature-card'
                    );

                cards.forEach(function (card, index) {
                    const number =
                        card.querySelector(
                            '.feature-number'
                        );

                    number.textContent =
                        `Feature ${index + 1}`;
                });
            }

            function createFeatureCard() {
                const card =
                    document.createElement('div');

                card.className =
                    'feature-card border rounded-3 p-3 mb-3';

                card.innerHTML = `
                    <div
                        class="d-flex
                               justify-content-between
                               align-items-center mb-3"
                    >
                        <h6
                            class="feature-number
                                   fw-semibold mb-0"
                        >
                            Feature
                        </h6>

                        <button
                            type="button"
                            class="btn btn-sm
                                   btn-outline-danger
                                   remove-feature"
                            title="Delete feature"
                        >
                            <i
                                class="fa-solid
                                       fa-trash"
                            ></i>
                        </button>
                    </div>

                    <div class="mb-3">
                        <label
                            class="form-label
                                   fw-semibold"
                        >
                            Feature Title
                            <span class="text-danger">
                                *
                            </span>
                        </label>

                        <input
                            type="text"
                            name="features_title[]"
                            class="form-control"
                            placeholder="24/7 Expert Support"
                        >
                    </div>

                    <div>
                        <label
                            class="form-label
                                   fw-semibold"
                        >
                            Feature Description
                        </label>

                        <textarea
                            name="features_description[]"
                            rows="3"
                            class="form-control"
                            placeholder="Enter feature description"
                        ></textarea>
                    </div>
                `;

                return card;
            }

            addButton.addEventListener(
                'click',
                function () {
                    const count =
                        container.querySelectorAll(
                            '.feature-card'
                        ).length;

                    if (count >= 10) {
                        alert(
                            'Maximum 10 features are allowed.'
                        );

                        return;
                    }

                    const card =
                        createFeatureCard();

                    container.appendChild(card);

                    updateNumbers();

                    card.querySelector(
                        'input[name="features_title[]"]'
                    ).focus();
                }
            );

            container.addEventListener(
                'click',
                function (event) {
                    const button =
                        event.target.closest(
                            '.remove-feature'
                        );

                    if (!button) {
                        return;
                    }

                    const cards =
                        container.querySelectorAll(
                            '.feature-card'
                        );

                    if (cards.length === 1) {
                        alert(
                            'At least one feature is required.'
                        );

                        return;
                    }

                    button
                        .closest('.feature-card')
                        .remove();

                    updateNumbers();
                }
            );

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

            if (imageInput && imagePreview) {
                imageInput.addEventListener(
                    'change',
                    function () {
                        imagePreview.innerHTML = '';

                        const file =
                            this.files[0];

                        if (
                            !file ||
                            !file.type.startsWith(
                                'image/'
                            )
                        ) {
                            return;
                        }

                        if (currentImage) {
                            currentImage.style.display =
                                'none';
                        }

                        const reader =
                            new FileReader();

                        reader.onload =
                            function (event) {
                                imagePreview.innerHTML = `
                                    <p
                                        class="small
                                               text-muted mb-2"
                                    >
                                        Selected image
                                    </p>

                                    <img
                                        src="${event.target.result}"
                                        alt="Selected image"
                                        class="section-preview-image"
                                    >
                                `;
                            };

                        reader.readAsDataURL(file);
                    }
                );
            }
        }
    );
</script>