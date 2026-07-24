@php
    $isEdit = isset($aboutOurCoreValue);
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
                            Enter the core value title
                            and description.
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