@csrf

<div class="admin-form-grid">

    {{-- Blog Title --}}
    <div class="admin-form-group full-width">
        <label for="title">
            Blog Title
            <span class="required">*</span>
        </label>

        <input
            type="text"
            name="title"
            id="title"
            class="admin-form-control
                @error('title') is-invalid @enderror"
            value="{{ old('title', $blog->title ?? '') }}"
            placeholder="Enter blog title"
            required
        >

        @error('title')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Category --}}
    <div class="admin-form-group">
        <label for="category_id">
            Category
            <span class="required">*</span>
        </label>

        <select
            name="category_id"
            id="category_id"
            class="admin-form-control
                @error('category_id') is-invalid @enderror"
            required
        >
            <option value="">Select Category</option>

            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(
                        old(
                            'category_id',
                            $blog->category_id ?? ''
                        ) == $category->id
                    )
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Author --}}
    <div class="admin-form-group">
        <label for="author_id">
            Author
        </label>

        <select
            name="author_id"
            id="author_id"
            class="admin-form-control
                @error('author_id') is-invalid @enderror"
        >
            <option value="">Open Sky Team</option>

            @foreach ($authors as $author)
                <option
                    value="{{ $author->id }}"
                    @selected(
                        old(
                            'author_id',
                            $blog->author_id ?? ''
                        ) == $author->id
                    )
                >
                    {{ $author->name }}
                </option>
            @endforeach
        </select>

        @error('author_id')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Slug --}}
    <div class="admin-form-group full-width">
        <label for="slug">
            Slug
        </label>

        <input
            type="text"
            name="slug"
            id="slug"
            class="admin-form-control
                @error('slug') is-invalid @enderror"
            value="{{ old('slug', $blog->slug ?? '') }}"
            placeholder="Leave empty to generate automatically"
        >

        @error('slug')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Table of Contents --}}
    <div class="admin-form-group full-width">
        <label>
            Table of Contents
            <span class="required">*</span>
        </label>

        <p class="admin-form-help">
            Add the blog section titles. Numbers will be created
            automatically.
        </p>

        @php
            $tocItems = old(
                'table_of_contents',
                $blog->table_of_contents ?? ['']
            );

            if (is_string($tocItems)) {
                $tocItems = json_decode(
                    $tocItems,
                    true
                ) ?? [];
            }

            if (empty($tocItems)) {
                $tocItems = [''];
            }
        @endphp

        <div id="tableOfContentsContainer">

            @foreach ($tocItems as $index => $item)
                <div class="toc-form-row">

                    <span class="toc-number">
                        {{ str_pad(
                            $index + 1,
                            2,
                            '0',
                            STR_PAD_LEFT
                        ) }}.
                    </span>

                    <input
                        type="text"
                        name="table_of_contents[]"
                        value="{{ $item }}"
                        class="admin-form-control
                            @error("table_of_contents.$index")
                                is-invalid
                            @enderror"
                        placeholder="Example: Kerala – God's Own Country"
                        required
                    >

                    <button
                        type="button"
                        class="btn btn-danger remove-toc-item"
                    >
                        Remove
                    </button>

                    @error("table_of_contents.$index")
                        <span class="admin-form-error toc-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>
            @endforeach

        </div>

        @error('table_of_contents')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror

        <button
            type="button"
            id="addTocItem"
            class="btn btn-light"
        >
            + Add Section
        </button>
    </div>

    {{-- Complete Content --}}
    <div class="admin-form-group full-width">
        <label for="content">
            Complete Blog Content
            <span class="required">*</span>
        </label>

        <textarea
            name="content"
            id="content"
            rows="15"
            class="admin-form-control
                @error('content') is-invalid @enderror"
            placeholder="Enter complete blog content"
            required
        >{{ old('content', $blog->content ?? '') }}</textarea>

        @error('content')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Featured Image --}}
    <div class="admin-form-group">
        <label for="featured_image">
            Featured Image

            @if (!isset($blog))
                <span class="required">*</span>
            @endif
        </label>

        <input
            type="file"
            name="featured_image"
            id="featured_image"
            class="admin-form-control
                @error('featured_image') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp"
            @required(!isset($blog))
        >

        @error('featured_image')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror

        @isset($blog)
            @if ($blog->featured_image)
                <div class="admin-image-preview">
                    <img
                        src="{{ asset(
                            'storage/' . $blog->featured_image
                        ) }}"
                        alt="{{ $blog->title }}"
                        width="180"
                    >
                </div>
            @endif
        @endisset
    </div>

    {{-- Read Time --}}
    <div class="admin-form-group">
        <label for="read_time">
            Read Time in Minutes
            <span class="required">*</span>
        </label>

        <input
            type="number"
            name="read_time"
            id="read_time"
            min="1"
            max="120"
            class="admin-form-control
                @error('read_time') is-invalid @enderror"
            value="{{ old(
                'read_time',
                $blog->read_time ?? 5
            ) }}"
            required
        >

        @error('read_time')
            <span class="admin-form-error">
                {{ $message }}
            </span>
        @enderror
    </div>

    {{-- Published Date --}}
    <div class="admin-form-group">
        <label for="published_at">
            Published Date
        </label>

        <input
            type="datetime-local"
            name="published_at"
            id="published_at"
            class="admin-form-control
                @error('published_at') is-invalid @enderror"
            value="{{ old(
                'published_at',
                isset($blog) && $blog->published_at
                    ? $blog->published_at->format(
                        'Y-m-d\TH:i'
                    )
                    : ''
            ) }}"
        >

        @error('published_at')
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
            class="admin-form-control
                @error('status') is-invalid @enderror"
            required
        >
            <option
                value="1"
                @selected(
                    old(
                        'status',
                        $blog->status ?? 0
                    ) == 1
                )
            >
                Published
            </option>

            <option
                value="0"
                @selected(
                    old(
                        'status',
                        $blog->status ?? 0
                    ) == 0
                )
            >
                Draft
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
    <a
        href="{{ route('admin.blogs.index') }}"
        class="btn btn-light"
    >
        Cancel
    </a>

    <button
        type="submit"
        class="btn btn-primary"
    >
        {{ $buttonText ?? 'Save Blog' }}
    </button>
</div>

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {
            const container = document.getElementById(
                'tableOfContentsContainer'
            );

            const addButton = document.getElementById(
                'addTocItem'
            );

            if (!container || !addButton) {
                return;
            }

            function updateNumbers() {
                const rows = container.querySelectorAll(
                    '.toc-form-row'
                );

                rows.forEach(function (row, index) {
                    const number = row.querySelector(
                        '.toc-number'
                    );

                    if (number) {
                        number.textContent =
                            String(index + 1)
                                .padStart(2, '0') + '.';
                    }
                });
            }

            function addTableOfContentsRow() {
                const row = document.createElement('div');

                row.className = 'toc-form-row';

                row.innerHTML = `
                    <span class="toc-number"></span>

                    <input
                        type="text"
                        name="table_of_contents[]"
                        class="admin-form-control"
                        placeholder="Enter section title"
                        required
                    >

                    <button
                        type="button"
                        class="btn btn-danger remove-toc-item"
                    >
                        Remove
                    </button>
                `;

                container.appendChild(row);

                updateNumbers();

                row.querySelector('input')?.focus();
            }

            addButton.addEventListener(
                'click',
                addTableOfContentsRow
            );

            container.addEventListener(
                'click',
                function (event) {
                    const removeButton =
                        event.target.closest(
                            '.remove-toc-item'
                        );

                    if (!removeButton) {
                        return;
                    }

                    const rows = container.querySelectorAll(
                        '.toc-form-row'
                    );

                    if (rows.length === 1) {
                        const input =
                            rows[0].querySelector('input');

                        if (input) {
                            input.value = '';
                            input.focus();
                        }

                        return;
                    }

                    removeButton
                        .closest('.toc-form-row')
                        ?.remove();

                    updateNumbers();
                }
            );

            updateNumbers();
        }
    );
</script>