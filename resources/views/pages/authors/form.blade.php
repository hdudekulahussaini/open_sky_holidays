@php
    $defaultSocials = [
        ['platform' => 'Twitter / X', 'icon' => 'fa-brands fa-x-twitter', 'url' => ''],
        ['platform' => 'Facebook', 'icon' => 'fa-brands fa-facebook-f', 'url' => ''],
        ['platform' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in', 'url' => ''],
    ];

    $existingSocials = [];
    if (isset($author)) {
        if (is_array($author->social_links) && count($author->social_links) > 0) {
            $existingSocials = $author->social_links;
        } else {
            if ($author->twitter_url) {
                $existingSocials[] = ['platform' => 'Twitter / X', 'icon' => 'fa-brands fa-x-twitter', 'url' => $author->twitter_url];
            }
            if ($author->facebook_url) {
                $existingSocials[] = ['platform' => 'Facebook', 'icon' => 'fa-brands fa-facebook-f', 'url' => $author->facebook_url];
            }
            if ($author->linkedin_url) {
                $existingSocials[] = ['platform' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in', 'url' => $author->linkedin_url];
            }
        }
    }

    $socialRows = old('social_links', !empty($existingSocials) ? $existingSocials : $defaultSocials);

    $iconList = [
        'fa-brands fa-x-twitter' => 'Twitter / X',
        'fa-brands fa-facebook-f' => 'Facebook',
        'fa-brands fa-instagram' => 'Instagram',
        'fa-brands fa-linkedin-in' => 'LinkedIn',
        'fa-brands fa-youtube' => 'YouTube',
        'fa-brands fa-whatsapp' => 'WhatsApp',
        'fa-brands fa-pinterest-p' => 'Pinterest',
        'fa-brands fa-tiktok' => 'TikTok',
        'fa-brands fa-threads' => 'Threads',
        'fa-brands fa-telegram' => 'Telegram',
        'fa-brands fa-snapchat' => 'Snapchat',
        'fa-brands fa-reddit-alien' => 'Reddit',
        'fa-brands fa-discord' => 'Discord',
        'fa-brands fa-github' => 'GitHub',
        'fa-solid fa-globe' => 'Website / Blog',
        'fa-solid fa-envelope' => 'Email',
        'fa-solid fa-phone' => 'Phone',
    ];
@endphp

<div class="ts-form-grid">
    <div class="ts-form-main">

        {{-- Author Name --}}
        <div class="ts-form-group">
            <label for="name" class="ts-label">
                Author Name
                <span class="ts-required">*</span>
            </label>

            <input type="text" name="name" id="name"
                class="ts-input @error('name') ts-input-error @enderror"
                value="{{ old('name', $author->name ?? '') }}"
                placeholder="Example: Sneha Patel"
                required>

            @error('name')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Description --}}
        <div class="ts-form-group">
            <label for="description" class="ts-label">
                Description
            </label>

            <textarea name="description" id="description" rows="5"
                class="ts-textarea @error('description') ts-input-error @enderror"
                placeholder="Enter author description">{{ old('description', $author->description ?? '') }}</textarea>

            @error('description')
                <span class="ts-error-message">
                    {{ $message }}
                </span>
            @enderror
        </div>

        {{-- Dynamic Social Profiles Repeater --}}
        <div class="ts-form-group mb-0">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <div>
                    <label class="ts-label mb-0" style="font-size: 1rem; font-weight: 700; color: #1e293b;">
                        <i class="fa-solid fa-share-nodes text-primary me-1"></i> Social Profiles
                    </label>
                    <p class="text-muted small mb-0" style="font-size: 0.82rem;">Select platform icons and enter profile links.</p>
                </div>

                <button type="button" class="btn btn-primary btn-sm px-3 fw-semibold shadow-sm" id="addAuthorSocialBtn" style="border-radius: 8px;">
                    <i class="fa-solid fa-plus me-1"></i> Add Social Profile
                </button>
            </div>

            <div id="authorSocialLinksList">
                @foreach ($socialRows as $index => $social)
                    @php
                        $iconClass = $social['icon'] ?? 'fa-brands fa-x-twitter';
                        $platformName = $social['platform'] ?? 'Twitter / X';
                        $urlVal = $social['url'] ?? '';
                    @endphp
                    <div class="p-3 border rounded-3 mb-3 js-author-social-row" style="background: #f8fafc;">
                        <div class="row g-3 align-items-center">

                            {{-- Visual Icon Box Preview --}}
                            <div class="col-auto">
                                <label class="form-label fw-semibold mb-1 d-block" style="font-size: 0.75rem; color: #64748b;">Icon</label>
                                <div class="rounded-3 bg-white border d-flex align-items-center justify-content-center shadow-sm text-primary"
                                     style="width: 42px; height: 38px; font-size: 1.25rem;">
                                    <i class="{{ $iconClass }} js-author-icon-preview"></i>
                                </div>
                            </div>

                            {{-- Select Icon Dropdown --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold mb-1" style="font-size: 0.8rem; color: #475569;">Select Platform</label>
                                <select name="social_links[{{ $index }}][icon]" class="form-select form-select-sm js-author-icon-select" style="height: 38px; font-size: 0.88rem;">
                                    @foreach($iconList as $iVal => $iLabel)
                                        <option value="{{ $iVal }}" data-name="{{ $iLabel }}" @selected($iconClass === $iVal)>
                                            {{ $iLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Platform Name --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold mb-1" style="font-size: 0.8rem; color: #475569;">Platform Label</label>
                                <input type="text" name="social_links[{{ $index }}][platform]"
                                    class="form-control form-control-sm js-author-platform-input"
                                    value="{{ $platformName }}"
                                    style="height: 38px; font-size: 0.88rem;"
                                    placeholder="e.g. Instagram">
                            </div>

                            {{-- Profile URL --}}
                            <div class="col-md">
                                <label class="form-label fw-semibold mb-1" style="font-size: 0.8rem; color: #475569;">Profile Link URL</label>
                                <input type="url" name="social_links[{{ $index }}][url]"
                                    class="form-control form-control-sm js-author-url-input"
                                    value="{{ $urlVal }}"
                                    style="height: 38px; font-size: 0.88rem;"
                                    placeholder="https://...">
                            </div>

                            {{-- Remove Button --}}
                            <div class="col-auto text-end">
                                <label class="form-label fw-semibold mb-1 d-block">&nbsp;</label>
                                <button type="button" class="btn btn-outline-danger btn-sm js-remove-author-social" title="Delete profile" style="height: 38px; width: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            @error('social_links')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="ts-form-sidebar">
        {{-- Author Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>Author Image</h3>
                <p>Upload a profile picture for the author.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($author) && $author->image ? asset('storage/' . $author->image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview {{ isset($author) && $author->image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder" class="ts-image-placeholder {{ isset($author) && $author->image ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">✦</span>
                    <strong>No image selected</strong>
                    <small>JPG, PNG, WEBP or AVIF</small>
                </div>
            </div>

            <label for="image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="image" id="image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp,.avif,image/*">

            @error('image')
                <span class="ts-error-message">
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

            <select id="status" name="status" class="admin-form-control @error('status') is-invalid @enderror" required>
                <option value="1" @selected(old('status', $author->status ?? 1) == 1)>
                    Active
                </option>
                <option value="0" @selected(old('status', $author->status ?? 1) == 0)>
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
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Image Preview Logic
        const imageInput = document.getElementById('image');
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

        // Dynamic Social Profiles Logic
        const container = document.getElementById('authorSocialLinksList');
        const addBtn = document.getElementById('addAuthorSocialBtn');

        const iconOptionsHtml = `
            <option value="fa-brands fa-x-twitter" data-name="Twitter / X">Twitter / X</option>
            <option value="fa-brands fa-facebook-f" data-name="Facebook">Facebook</option>
            <option value="fa-brands fa-instagram" data-name="Instagram" selected>Instagram</option>
            <option value="fa-brands fa-linkedin-in" data-name="LinkedIn">LinkedIn</option>
            <option value="fa-brands fa-youtube" data-name="YouTube">YouTube</option>
            <option value="fa-brands fa-whatsapp" data-name="WhatsApp">WhatsApp</option>
            <option value="fa-brands fa-pinterest-p" data-name="Pinterest">Pinterest</option>
            <option value="fa-brands fa-tiktok" data-name="TikTok">TikTok</option>
            <option value="fa-brands fa-threads" data-name="Threads">Threads</option>
            <option value="fa-brands fa-telegram" data-name="Telegram">Telegram</option>
            <option value="fa-brands fa-snapchat" data-name="Snapchat">Snapchat</option>
            <option value="fa-brands fa-reddit-alien" data-name="Reddit">Reddit</option>
            <option value="fa-brands fa-discord" data-name="Discord">Discord</option>
            <option value="fa-brands fa-github" data-name="GitHub">GitHub</option>
            <option value="fa-solid fa-globe" data-name="Website / Blog">Website / Blog</option>
            <option value="fa-solid fa-envelope" data-name="Email">Email</option>
            <option value="fa-solid fa-phone" data-name="Phone">Phone</option>
        `;

        function reindexAuthorSocialRows() {
            const rows = container.querySelectorAll('.js-author-social-row');
            rows.forEach((row, idx) => {
                const icon = row.querySelector('.js-author-icon-select');
                const plat = row.querySelector('.js-author-platform-input');
                const url = row.querySelector('.js-author-url-input');

                if (icon) icon.name = `social_links[${idx}][icon]`;
                if (plat) plat.name = `social_links[${idx}][platform]`;
                if (url) url.name = `social_links[${idx}][url]`;
            });
        }

        // Handle icon select change
        container.addEventListener('change', function (e) {
            if (e.target.classList.contains('js-author-icon-select')) {
                const row = e.target.closest('.js-author-social-row');
                const iconSelect = e.target;
                const iconPreview = row.querySelector('.js-author-icon-preview');
                const platformInput = row.querySelector('.js-author-platform-input');

                const selectedOption = iconSelect.options[iconSelect.selectedIndex];
                const selectedIcon = iconSelect.value;
                const platformName = selectedOption.getAttribute('data-name');

                if (iconPreview) {
                    iconPreview.className = `${selectedIcon} js-author-icon-preview`;
                }

                if (platformInput && platformName) {
                    platformInput.value = platformName;
                }
            }
        });

        // Add row
        addBtn.addEventListener('click', function () {
            const rows = container.querySelectorAll('.js-author-social-row');
            const newIndex = rows.length;

            const div = document.createElement('div');
            div.className = 'p-3 border rounded-3 mb-3 js-author-social-row';
            div.style.background = '#f8fafc';

            div.innerHTML = `
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="form-label fw-semibold mb-1 d-block" style="font-size: 0.75rem; color: #64748b;">Icon</label>
                        <div class="rounded-3 bg-white border d-flex align-items-center justify-content-center shadow-sm text-primary"
                             style="width: 42px; height: 38px; font-size: 1.25rem;">
                            <i class="fa-brands fa-instagram js-author-icon-preview"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold mb-1" style="font-size: 0.8rem; color: #475569;">Select Platform</label>
                        <select name="social_links[${newIndex}][icon]" class="form-select form-select-sm js-author-icon-select" style="height: 38px; font-size: 0.88rem;">
                            ${iconOptionsHtml}
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold mb-1" style="font-size: 0.8rem; color: #475569;">Platform Label</label>
                        <input type="text" name="social_links[${newIndex}][platform]" class="form-control form-control-sm js-author-platform-input" value="Instagram" style="height: 38px; font-size: 0.88rem;" placeholder="e.g. Instagram">
                    </div>

                    <div class="col-md">
                        <label class="form-label fw-semibold mb-1" style="font-size: 0.8rem; color: #475569;">Profile Link URL</label>
                        <input type="url" name="social_links[${newIndex}][url]" class="form-control form-control-sm js-author-url-input" style="height: 38px; font-size: 0.88rem;" placeholder="https://...">
                    </div>

                    <div class="col-auto text-end">
                        <label class="form-label fw-semibold mb-1 d-block">&nbsp;</label>
                        <button type="button" class="btn btn-outline-danger btn-sm js-remove-author-social" title="Delete profile" style="height: 38px; width: 38px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(div);
            reindexAuthorSocialRows();
            div.querySelector('.js-author-url-input').focus();
        });

        // Remove row
        container.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.js-remove-author-social');
            if (removeBtn) {
                const row = removeBtn.closest('.js-author-social-row');
                const allRows = container.querySelectorAll('.js-author-social-row');
                if (allRows.length === 1) {
                    row.querySelector('.js-author-platform-input').value = '';
                    row.querySelector('.js-author-url-input').value = '';
                } else {
                    row.remove();
                    reindexAuthorSocialRows();
                }
            }
        });
    });
</script>
@endpush
