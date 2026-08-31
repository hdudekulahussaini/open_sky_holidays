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
                placeholder="e.g. How to Plan a Budget-Friendly International Trip"
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
                placeholder="Leave empty to generate automatically from title">

            @error('slug')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Description / Short Summary --}}
        <div class="ts-form-group">
            <label for="description" class="ts-label">
                Short Description / Overview
            </label>

            <textarea name="description" id="description" rows="3"
                class="ts-textarea @error('description') ts-input-error @enderror"
                placeholder="Enter a brief overview or summary of this blog post...">{{ old('description', $blog->description ?? '') }}</textarea>
            <p class="ts-field-note text-muted small mb-0 mt-1">
                Short summary shown on blog cards and search listings.
            </p>

            @error('description')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Complete Blog Content Builder --}}
        <div class="ts-form-group">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <label class="ts-label mb-0">
                        Complete Blog Content
                        <span class="ts-required">*</span>
                    </label>
                    <p class="ts-field-note text-muted small mb-0">
                        Structure your article point-by-point or switch to full text.
                    </p>
                </div>

                {{-- Mode Switcher & Quick Buttons --}}
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-light border fw-semibold" id="btnToggleEditorMode" style="font-size: 0.78rem; padding: 4px 10px;">
                        <i class="fa-solid fa-code-compare text-primary me-1"></i> <span id="modeToggleText">Switch to Plain Text</span>
                    </button>
                    <button type="button" class="ts-add-feature-btn" id="btnAddPoint" style="font-size: 0.82rem;">
                        <span>+</span> Add Point
                    </button>
                </div>
            </div>

            {{-- Hidden / Synced Main Textarea submitted to Laravel backend --}}
            <textarea name="content" id="content" rows="12"
                class="ts-textarea @error('content') ts-input-error @enderror"
                style="display: none;"
                placeholder="Enter complete blog content"
                required>{{ old('content', $blog->content ?? '') }}</textarea>

            {{-- 1. STRUCTURED POINT-BY-POINT BUILDER UI --}}
            <div id="structuredPointsContainer" class="mt-3">
                {{-- Point Cards will be dynamically injected here --}}
            </div>

            {{-- 2. DIRECT PLAIN TEXTAREA CONTAINER (Toggleable) --}}
            <div id="plainTextContainer" class="mt-3" style="display: none;">
                <textarea id="rawContentTextarea" rows="14" class="ts-textarea w-100"
                    placeholder="Enter or paste your complete blog content here..."></textarea>
            </div>

            @error('content')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Table of Contents --}}
        <div class="ts-form-group">
            <div class="ts-feature-heading d-flex justify-content-between align-items-center mb-2">
                <div>
                    <label class="ts-label mb-0">
                        Table of Contents
                        <span class="ts-required">*</span>
                    </label>

                    <p class="ts-field-note text-muted small mb-0">
                        Add the blog section titles. Numbers will be created automatically.
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-light border fw-semibold" id="btnSyncToc" style="font-size: 0.78rem; padding: 4px 10px;" title="Automatically copy titles from content points above">
                        <i class="fa-solid fa-arrows-rotate text-primary me-1"></i> Sync from Points
                    </button>
                    <button type="button" class="ts-add-feature-btn" id="addTocItem">
                        <span>+</span>
                        Add Section
                    </button>
                </div>
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
                                        placeholder="Example: Book Your Flights in Advance"
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
                    <small>JPG, PNG, WEBP or AVIF</small>
                </div>
            </div>

            <label for="featured_image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="featured_image" id="featured_image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp,.avif,image/*" @required(!isset($blog))>

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
        const hiddenContentInput = document.getElementById('content');
        const pointsContainer = document.getElementById('structuredPointsContainer');
        const plainTextContainer = document.getElementById('plainTextContainer');
        const rawContentTextarea = document.getElementById('rawContentTextarea');
        const btnAddPoint = document.getElementById('btnAddPoint');
        const btnToggleMode = document.getElementById('btnToggleEditorMode');
        const modeToggleText = document.getElementById('modeToggleText');

        let isPlainTextMode = false;

        // Default travel budget sample points
        const defaultSamplePoints = [
            {
                title: "Book Your Flights in Advance",
                desc: "The golden rule for budget international travel is booking your flights early. Monitor prices using flight comparison tools and set up price alerts. Often, booking 3-4 months in advance can save you hundreds of dollars."
            },
            {
                title: "Be Flexible With Your Dates and Destinations",
                desc: "If you can be flexible with your travel dates, you can take advantage of shoulder season pricing. Sometimes flying on a Tuesday instead of a Friday can significantly drop your ticket price. Also, consider secondary airports or less popular but equally beautiful destinations."
            },
            {
                title: "Master the Art of Packing Light",
                desc: "Many budget airlines charge hefty fees for checked baggage. By packing light and traveling with just a carry-on, you avoid these extra fees and gain the mobility to navigate public transit easily."
            },
            {
                title: "Embrace Local Street Food and Public Transport",
                desc: "Eating where the locals eat is not only cheaper but often far more delicious and authentic than tourist trap restaurants. Similarly, utilizing local buses and trains instead of taxis will drastically reduce your daily expenditures."
            }
        ];

        // Function to create a point card
        function addPointCard(title = '', desc = '') {
            const currentCount = pointsContainer.querySelectorAll('.point-card').length;
            const index = currentCount + 1;

            const card = document.createElement('div');
            card.className = 'feature-card border rounded-3 p-3 mb-3 point-card';
            card.style.cssText = 'background: #ffffff; border-color: #e2e8f0 !important; box-shadow: 0 1px 3px rgba(0,0,0,0.02);';

            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary text-white fw-bold px-2 py-1 point-number" style="font-size: 0.85rem; border-radius: 6px;">
                            Point ${index}
                        </span>
                        <small class="text-muted fw-semibold point-title-preview">${title ? escapeHtml(title) : 'New Point'}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-point-btn" title="Remove point">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>

                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <label class="ts-label small fw-bold mb-1">Point Title / Heading <span class="ts-required">*</span></label>
                        <input type="text" class="ts-input w-100 m-0 point-title-input" value="${escapeHtml(title)}" placeholder="e.g. Book Your Flights in Advance" required>
                    </div>
                    <div class="col-12">
                        <label class="ts-label small fw-bold mb-1">Point Description <span class="ts-required">*</span></label>
                        <textarea rows="3" class="ts-textarea w-100 m-0 point-desc-input" placeholder="Explain this point in detail...">${escapeHtml(desc)}</textarea>
                    </div>
                </div>
            `;

            // Bind input changes to compile content
            const titleInput = card.querySelector('.point-title-input');
            const descInput = card.querySelector('.point-desc-input');
            const titlePreview = card.querySelector('.point-title-preview');

            titleInput.addEventListener('input', function () {
                titlePreview.textContent = this.value.trim() || 'New Point';
                compilePointsToContent();
            });

            descInput.addEventListener('input', compilePointsToContent);

            card.querySelector('.remove-point-btn').addEventListener('click', function () {
                const total = pointsContainer.querySelectorAll('.point-card').length;
                if (total === 1) {
                    titleInput.value = '';
                    descInput.value = '';
                    titlePreview.textContent = 'New Point';
                    compilePointsToContent();
                    return;
                }
                card.remove();
                updatePointNumbers();
                compilePointsToContent();
            });

            pointsContainer.appendChild(card);
            updatePointNumbers();
            return card;
        }

        function updatePointNumbers() {
            const cards = pointsContainer.querySelectorAll('.point-card');
            cards.forEach((c, i) => {
                const badge = c.querySelector('.point-number');
                if (badge) badge.textContent = `Point ${i + 1}`;
            });
        }

        // Compile points into content string
        function compilePointsToContent() {
            if (isPlainTextMode) {
                hiddenContentInput.value = rawContentTextarea.value;
                return;
            }

            const cards = pointsContainer.querySelectorAll('.point-card');
            let output = [];

            cards.forEach((c, idx) => {
                const title = c.querySelector('.point-title-input').value.trim();
                const desc = c.querySelector('.point-desc-input').value.trim();
                if (title || desc) {
                    let pointStr = `${idx + 1}. ${title}`;
                    if (desc) {
                        pointStr += `\n${desc}`;
                    }
                    output.push(pointStr);
                }
            });

            const finalContent = output.join('\n\n');
            hiddenContentInput.value = finalContent;
            rawContentTextarea.value = finalContent;
        }

        // Parse content string into Point cards
        function parseContentToPoints(contentStr) {
            pointsContainer.innerHTML = '';
            if (!contentStr || !contentStr.trim()) {
                defaultSamplePoints.forEach(p => addPointCard(p.title, p.desc));
                compilePointsToContent();
                return;
            }

            // Check if content matches numbered list e.g. "1. Title\nDescription..."
            const regex = /(?:^|\n+)(?:(\d+)[\.\)]\s+([^\n]+))\n*([\s\S]*?)(?=(?:\n+\d+[\.\)]\s+[^\n]+)|$)/g;
            let match;
            let count = 0;

            while ((match = regex.exec(contentStr)) !== null) {
                count++;
                const title = (match[2] || '').trim();
                const desc = (match[3] || '').trim();
                addPointCard(title, desc);
            }

            if (count === 0) {
                // If not formatted as numbered list, split by double newlines or add as single point
                const paragraphs = contentStr.split(/\n\s*\n/).filter(p => p.trim());
                if (paragraphs.length > 0) {
                    paragraphs.forEach((p, idx) => {
                        const lines = p.trim().split('\n');
                        const title = lines[0].replace(/^\d+[\.\-\)]\s*/, '').trim();
                        const desc = lines.slice(1).join('\n').trim();
                        addPointCard(title, desc);
                    });
                } else {
                    addPointCard('Introduction', contentStr.trim());
                }
            }

            compilePointsToContent();
        }

        // Initialize with existing or default content
        parseContentToPoints(hiddenContentInput.value);

        // Add Point Button
        if (btnAddPoint) {
            btnAddPoint.addEventListener('click', function () {
                if (isPlainTextMode) {
                    toggleMode();
                }
                const card = addPointCard('', '');
                card.querySelector('.point-title-input')?.focus();
                compilePointsToContent();
            });
        }

        // Toggle between Point-by-Point builder and Raw Textarea
        function toggleMode() {
            isPlainTextMode = !isPlainTextMode;
            if (isPlainTextMode) {
                pointsContainer.style.display = 'none';
                plainTextContainer.style.display = 'block';
                modeToggleText.textContent = 'Switch to Point Cards';
                rawContentTextarea.value = hiddenContentInput.value;
                rawContentTextarea.focus();
            } else {
                plainTextContainer.style.display = 'none';
                pointsContainer.style.display = 'block';
                modeToggleText.textContent = 'Switch to Plain Text';
                parseContentToPoints(rawContentTextarea.value);
            }
        }

        if (btnToggleMode) {
            btnToggleMode.addEventListener('click', toggleMode);
        }

        if (rawContentTextarea) {
            rawContentTextarea.addEventListener('input', function () {
                hiddenContentInput.value = this.value;
            });
        }

        // Table of Contents Builder & Sync Logic
        const tocContainer = document.getElementById('tableOfContentsContainer');
        const addTocBtn = document.getElementById('addTocItem');
        const btnSyncToc = document.getElementById('btnSyncToc');

        function updateTocNumbers() {
            const rows = tocContainer.querySelectorAll('.toc-form-row');
            rows.forEach(function (row, index) {
                const number = row.querySelector('.toc-number');
                if (number) {
                    number.textContent = String(index + 1).padStart(2, '0') + '.';
                }
            });
        }

        function addTocRow(value = '') {
            const row = document.createElement('div');
            row.className = 'feature-card border rounded-3 p-3 mb-3 toc-form-row';
            row.style.cssText = 'background: #f8fafc; border-color: #e2e8f0 !important;';

            row.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3 flex-grow-1 me-3">
                        <span class="toc-number fw-bold text-primary fs-5" style="min-width: 30px;"></span>
                        <div class="flex-grow-1">
                            <input type="text" name="table_of_contents[]" class="ts-input w-100 m-0" value="${escapeHtml(value)}" placeholder="Enter section title" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-toc-item" title="Delete section">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;

            tocContainer.appendChild(row);
            updateTocNumbers();
            row.querySelector('input')?.focus();
            return row;
        }

        if (addTocBtn) {
            addTocBtn.addEventListener('click', function () {
                addTocRow('');
            });
        }

        if (tocContainer) {
            tocContainer.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.remove-toc-item');
                if (!removeButton) return;

                const rows = tocContainer.querySelectorAll('.toc-form-row');
                if (rows.length === 1) {
                    const input = rows[0].querySelector('input');
                    if (input) {
                        input.value = '';
                        input.focus();
                    }
                    return;
                }

                removeButton.closest('.toc-form-row')?.remove();
                updateTocNumbers();
            });
        }

        // Sync TOC from Point Titles
        if (btnSyncToc) {
            btnSyncToc.addEventListener('click', function () {
                const titles = [];
                if (!isPlainTextMode) {
                    const pointTitles = pointsContainer.querySelectorAll('.point-title-input');
                    pointTitles.forEach(t => {
                        const val = t.value.trim();
                        if (val) titles.push(val);
                    });
                } else {
                    const lines = hiddenContentInput.value.split('\n');
                    lines.forEach(l => {
                        const match = l.match(/^\d+[\.\-\)]\s*(.+)/);
                        if (match && match[1]) {
                            titles.push(match[1].trim());
                        }
                    });
                }

                if (titles.length === 0) {
                    alert('Please enter at least one Point Title first.');
                    return;
                }

                tocContainer.innerHTML = '';
                titles.forEach(t => addTocRow(t));
            });
        }

        function escapeHtml(str) {
            return (str || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#039;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }

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
