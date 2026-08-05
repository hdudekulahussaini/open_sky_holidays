<div class="ts-form-grid">
    <div class="ts-form-main">

        {{-- Blog Title --}}
        <div class="ts-form-group">
            <label for="title" class="ts-label">
                Blog Title
                <span class="ts-required">*</span>
            </label>

            <input type="text" name="title" id="title"
                class="ts-input @error('title') ts-input-error @enderror"
                value="{{ old('title', $blog->title ?? '') }}"
                placeholder="Enter blog title"
                required>

            @error('title')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Slug --}}
        <div class="ts-form-group">
            <label for="slug" class="ts-label">
                Slug
            </label>

            <input type="text" name="slug" id="slug"
                class="ts-input @error('slug') ts-input-error @enderror"
                value="{{ old('slug', $blog->slug ?? '') }}"
                placeholder="Leave empty to generate automatically">

            @error('slug')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Complete Content --}}
        <div class="ts-form-group">
            <label for="content" class="ts-label">
                Complete Blog Content
                <span class="ts-required">*</span>
            </label>

            <textarea name="content" id="content" rows="15"
                class="ts-textarea @error('content') ts-input-error @enderror"
                placeholder="Enter complete blog content"
                required>{{ old('content', $blog->content ?? '') }}</textarea>

            @error('content')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Table of Contents --}}
        <div class="ts-form-group">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">
                        Table of Contents
                        <span class="ts-required">*</span>
                    </label>

                    <p class="ts-field-note">
                        Add the blog section titles. Numbers will be created automatically.
                    </p>
                </div>

                <button type="button" class="ts-add-feature-btn" id="addTocItem">
                    <span>+</span>
                    Add Section
                </button>
            </div>

            @php
                $tocItems = old('table_of_contents', $blog->table_of_contents ?? ['']);
                if (is_string($tocItems)) {
                    $tocItems = json_decode($tocItems, true) ?? [];
                }
                if (empty($tocItems)) {
                    $tocItems = [''];
                }
            @endphp

            <div id="tableOfContentsContainer" class="ts-features-container mt-3">
                @foreach ($tocItems as $index => $item)
                    <div class="feature-card border rounded-3 p-3 mb-3 toc-form-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3 flex-grow-1 me-3">
                                <span class="toc-number fw-bold text-primary fs-5" style="min-width: 30px;">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
                                </span>
                                
                                <div class="flex-grow-1">
                                    <input type="text" name="table_of_contents[]"
                                        value="{{ $item }}"
                                        class="ts-input w-100 m-0 @error("table_of_contents.$index") ts-input-error @enderror"
                                        placeholder="Example: Kerala – God's Own Country"
                                        required>
                                    @error("table_of_contents.$index")
                                        <span class="ts-error-message">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-danger remove-toc-item" title="Delete section">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            @error('table_of_contents')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

    </div>

    <div class="ts-form-sidebar">
        {{-- Featured Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Featured Image @if (!isset($blog)) <span class="required">*</span> @endif</h3>
                <p>Upload the blog featured image.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($blog) && $blog->featured_image ? asset('storage/' . $blog->featured_image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview {{ isset($blog) && $blog->featured_image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder" class="ts-image-placeholder {{ isset($blog) && $blog->featured_image ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">✦</span>
                    <strong>No image selected</strong>
                    <small>JPG, PNG or WEBP</small>
                </div>
            </div>

            <label for="featured_image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="featured_image" id="featured_image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp" @required(!isset($blog))>

            @error('featured_image')
                <span class="ts-error-message">
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

            <select name="category_id" id="category_id" class="admin-form-control @error('category_id') is-invalid @enderror" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $blog->category_id ?? '') == $category->id)>
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

            <select name="author_id" id="author_id" class="admin-form-control @error('author_id') is-invalid @enderror">
                <option value="">Open Sky Team</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" @selected(old('author_id', $blog->author_id ?? '') == $author->id)>
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

        {{-- Read Time --}}
        <div class="admin-form-group">
            <label for="read_time">
                Read Time in Minutes
                <span class="required">*</span>
            </label>

            <input type="number" name="read_time" id="read_time" min="1" max="120"
                class="admin-form-control @error('read_time') is-invalid @enderror"
                value="{{ old('read_time', $blog->read_time ?? 5) }}" required>

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

            <input type="datetime-local" name="published_at" id="published_at"
                class="admin-form-control @error('published_at') is-invalid @enderror"
                value="{{ old('published_at', isset($blog) && $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">

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

            <select name="status" id="status" class="admin-form-control @error('status') is-invalid @enderror" required>
                <option value="1" @selected(old('status', $blog->status ?? 0) == 1)>
                    Published
                </option>
                <option value="0" @selected(old('status', $blog->status ?? 0) == 0)>
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
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('tableOfContentsContainer');
        const addButton = document.getElementById('addTocItem');

        if (!container || !addButton) {
            return;
        }

        function updateNumbers() {
            const rows = container.querySelectorAll('.toc-form-row');
            rows.forEach(function (row, index) {
                const number = row.querySelector('.toc-number');
                if (number) {
                    number.textContent = String(index + 1).padStart(2, '0') + '.';
                }
            });
        }

        function addTableOfContentsRow() {
            const row = document.createElement('div');
            row.className = 'feature-card border rounded-3 p-3 mb-3 toc-form-row';
            row.style.cssText = 'background: #f8fafc; border-color: #e2e8f0 !important;';

            row.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3 flex-grow-1 me-3">
                        <span class="toc-number fw-bold text-primary fs-5" style="min-width: 30px;"></span>
                        <div class="flex-grow-1">
                            <input type="text" name="table_of_contents[]" class="ts-input w-100 m-0" placeholder="Enter section title" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-toc-item" title="Delete section">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;

            container.appendChild(row);
            updateNumbers();
            row.querySelector('input')?.focus();
        }

        addButton.addEventListener('click', addTableOfContentsRow);

        container.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.remove-toc-item');
            if (!removeButton) {
                return;
            }

            const rows = container.querySelectorAll('.toc-form-row');
            if (rows.length === 1) {
                const input = rows[0].querySelector('input');
                if (input) {
                    input.value = '';
                    input.focus();
                }
                return;
            }

            removeButton.closest('.toc-form-row')?.remove();
            updateNumbers();
        });

        updateNumbers();

        // Image Preview Logic
        const imageInput = document.getElementById('featured_image');
        const imagePreview = document.getElementById('imagePreview');
        const imagePlaceholder = document.getElementById('imagePlaceholder');

        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function (event) {
                    imagePreview.src = event.target.result;
                    imagePreview.classList.remove('ts-hidden');
                    if (imagePlaceholder) imagePlaceholder.classList.add('ts-hidden');
                };
                reader.readAsDataURL(file);
            });
        }
    });
</script>
@endpush
