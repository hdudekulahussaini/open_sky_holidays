@php
    $isEdit = isset($aboutOurCoreValue);
    $currentIcon = old('icon', $aboutOurCoreValue->icon ?? 'fa-solid fa-heart');
@endphp

<div class="row justify-content-center">
    <div class="col-xl-9 col-lg-10">

        <div class="card border-0 shadow-sm">
            <div
                class="card-header bg-white
                       border-bottom py-3 px-4"
            >
                <div
                    class="d-flex align-items-center
                           justify-content-between"
                >
                    <div>
                        <h5 class="fw-bold mb-1">
                            Core Value Information
                        </h5>

                        <p class="text-muted small mb-0">
                            Enter the core value title, icon, and description.
                        </p>
                    </div>

                    <span
                        class="badge bg-primary-subtle
                               text-primary px-3 py-2"
                    >
                        {{ $isEdit
                            ? 'Edit Record'
                            : 'New Record' }}
                    </span>
                </div>
            </div>

            <div class="card-body p-4 p-lg-5">

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
                            $aboutOurCoreValue->title ?? ''
                        ) }}"
                        class="form-control form-control-lg
                            @error('title')
                                is-invalid
                            @enderror"
                        placeholder="Integrity"
                        autofocus
                    >

                    <div class="form-text">
                        Example: Integrity, Excellence,
                        Innovation or Care.
                    </div>

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Icon Field --}}
                <div class="mb-4">
                    <label
                        for="icon"
                        class="form-label fw-semibold"
                    >
                        <i class="fa-solid fa-icons text-warning me-1"></i>
                        Icon (FontAwesome Class)
                    </label>

                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 46px; height: 46px; border-radius: 8px; background: rgba(13,110,253,0.1); display: flex; align-items: center; justify-content: center; font-size: 1.35rem; color: #0d6efd; flex-shrink: 0;">
                            <i id="aboutCoreValueIconPreview" class="{{ $currentIcon ?: 'fa-solid fa-heart' }}"></i>
                        </div>
                        <input
                            type="text"
                            id="icon"
                            name="icon"
                            value="{{ $currentIcon }}"
                            class="form-control form-control-lg @error('icon') is-invalid @enderror"
                            placeholder="e.g. fa-solid fa-heart, fa-solid fa-gem, fa-solid fa-handshake"
                            oninput="updateAboutCoreValueIconPreview(this.value)"
                        >
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-handshake')"><i class="fa-solid fa-handshake text-warning me-1"></i> 🤝 Integrity (Handshake)</button>
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-star')"><i class="fa-solid fa-star text-warning me-1"></i> ⭐ Excellence (Star)</button>
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-lightbulb')"><i class="fa-solid fa-lightbulb text-warning me-1"></i> 💡 Innovation (Lightbulb)</button>
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-heart')"><i class="fa-solid fa-heart text-danger me-1"></i> ❤️ Care (Heart)</button>
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-gem')"><i class="fa-solid fa-gem text-primary me-1"></i> 💎 Gem / Quality</button>
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-shield-heart')"><i class="fa-solid fa-shield-heart text-danger me-1"></i> 🛡️ Safety & Security</button>
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-award')"><i class="fa-solid fa-award text-success me-1"></i> 🏆 Quality / Award</button>
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-compass')"><i class="fa-solid fa-compass text-info me-1"></i> 🧭 Guidance / Compass</button>
                        <button type="button" class="btn btn-sm btn-light border" style="font-size: 0.8rem; padding: 4px 10px;" onclick="pickAboutCoreValueIcon('fa-solid fa-earth-americas')"><i class="fa-solid fa-earth-americas text-primary me-1"></i> 🌍 Global Vision</button>
                    </div>

                    @error('icon')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        for="description"
                        class="form-label fw-semibold"
                    >
                        Description
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="7"
                        maxlength="3000"
                        class="form-control
                            @error('description')
                                is-invalid
                            @enderror"
                        placeholder="Enter the core value description"
                    >{{ old(
                        'description',
                        $aboutOurCoreValue->description ?? ''
                    ) }}</textarea>

                    <div
                        class="d-flex justify-content-between
                               mt-2"
                    >
                        <div class="form-text">
                            Explain this core value clearly.
                        </div>

                        <div
                            id="descriptionCounter"
                            class="small text-muted"
                        >
                            0 / 3000
                        </div>
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
</div>

<script>
    function updateAboutCoreValueIconPreview(iconClass) {
        const preview = document.getElementById('aboutCoreValueIconPreview');
        if (preview) {
            preview.className = (iconClass.trim() || 'fa-solid fa-heart');
        }
    }

    function pickAboutCoreValueIcon(iconClass) {
        const input = document.getElementById('icon');
        if (input) {
            input.value = iconClass;
            updateAboutCoreValueIconPreview(iconClass);
        }
    }

    document.addEventListener(
        'DOMContentLoaded',
        function () {
            const description =
                document.getElementById(
                    'description'
                );

            const counter =
                document.getElementById(
                    'descriptionCounter'
                );

            if (!description || !counter) {
                return;
            }

            function updateCounter() {
                counter.textContent =
                    `${description.value.length} / 3000`;
            }

            description.addEventListener(
                'input',
                updateCounter
            );

            updateCounter();
        }
    );
</script>