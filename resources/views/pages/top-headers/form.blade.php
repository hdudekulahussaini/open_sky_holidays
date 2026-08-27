@php
    $defaultSocials = [
        ['platform' => 'Facebook', 'icon' => 'fa-brands fa-facebook-f', 'url' => ''],
        ['platform' => 'Instagram', 'icon' => 'fa-brands fa-instagram', 'url' => ''],
        ['platform' => 'Twitter / X', 'icon' => 'fa-brands fa-x-twitter', 'url' => ''],
        ['platform' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in', 'url' => ''],
        ['platform' => 'YouTube', 'icon' => 'fa-brands fa-youtube', 'url' => ''],
    ];

    $existingSocials = isset($topHeader) && is_array($topHeader->social_links) && count($topHeader->social_links) > 0
        ? $topHeader->social_links
        : [];

    $socialRows = old('social_links', !empty($existingSocials) ? $existingSocials : $defaultSocials);

    $iconList = [
        'fa-brands fa-facebook-f' => 'Facebook',
        'fa-brands fa-instagram' => 'Instagram',
        'fa-brands fa-x-twitter' => 'Twitter / X',
        'fa-brands fa-linkedin-in' => 'LinkedIn',
        'fa-brands fa-youtube' => 'YouTube',
        'fa-brands fa-whatsapp' => 'WhatsApp',
        'fa-brands fa-pinterest-p' => 'Pinterest',
        'fa-brands fa-tiktok' => 'TikTok',
        'fa-brands fa-telegram' => 'Telegram',
        'fa-brands fa-threads' => 'Threads',
        'fa-brands fa-snapchat' => 'Snapchat',
        'fa-brands fa-reddit-alien' => 'Reddit',
        'fa-brands fa-discord' => 'Discord',
        'fa-brands fa-github' => 'GitHub',
        'fa-solid fa-globe' => 'Website / Globe',
        'fa-solid fa-envelope' => 'Email',
        'fa-solid fa-phone' => 'Phone',
        'fa-solid fa-location-dot' => 'Location',
    ];
@endphp

<div class="row g-4">

    {{-- Top Header Details Card --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 p-4" style="background: #ffffff;">
            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                <i class="fa-solid fa-heading text-primary fs-5"></i>
                <h5 class="mb-0 fw-bold">Top Header Details</h5>
            </div>

            <div class="row g-4">
                {{-- Email Address --}}
                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">
                        <i class="fa-solid fa-envelope text-warning me-1"></i> Email Address
                    </label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $topHeader->email ?? 'info@openskyholidays.com') }}"
                        placeholder="e.g. info@openskyholidays.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tagline / Announcement --}}
                <div class="col-md-6">
                    <label for="tagline" class="form-label fw-semibold">
                        <i class="fa-solid fa-bullhorn text-info me-1"></i> Announcement / Tagline
                    </label>
                    <input type="text" name="tagline" id="tagline"
                        class="form-control @error('tagline') is-invalid @enderror"
                        value="{{ old('tagline', $topHeader->tagline ?? 'The World Is Waiting. One Stop Destination For All Your Tours & Travels Needs.') }}"
                        placeholder="e.g. The World Is Waiting. One Stop Destination...">
                    @error('tagline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Button Text --}}
                <div class="col-md-6">
                    <label for="button_text" class="form-label fw-semibold">
                        <i class="fa-solid fa-square-pen text-primary me-1"></i> Button Text
                    </label>
                    <input type="text" name="button_text" id="button_text"
                        class="form-control @error('button_text') is-invalid @enderror"
                        value="{{ old('button_text', $topHeader->button_text ?? 'Book Your Tour') }}"
                        placeholder="e.g. Book Your Tour">
                    @error('button_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Button URL --}}
                <div class="col-md-6">
                    <label for="button_url" class="form-label fw-semibold">
                        <i class="fa-solid fa-link text-success me-1"></i> Button Link / URL
                    </label>
                    <input type="text" name="button_url" id="button_url"
                        class="form-control @error('button_url') is-invalid @enderror"
                        value="{{ old('button_url', $topHeader->button_url ?? '#') }}"
                        placeholder="e.g. /tours or https://openskyholidays.com/tours">
                    @error('button_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Social Media Links with Icon Selection Dropdown & + Add Option --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 p-4" style="background: #ffffff;">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-share-nodes text-success fs-5"></i>
                    <div>
                        <h5 class="mb-0 fw-bold">Social Media Links</h5>
                        <p class="text-muted small mb-0">Select icon, platform name, and add URLs.</p>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-sm px-3 fw-semibold" id="addSocialBtn">
                    <i class="fa-solid fa-plus me-1"></i> Add Social Link
                </button>
            </div>

            <div id="socialLinksList">
                @foreach ($socialRows as $index => $social)
                    @php
                        $iconClass = $social['icon'] ?? 'fa-brands fa-facebook-f';
                        $platformName = $social['platform'] ?? 'Facebook';
                        $urlVal = $social['url'] ?? '';
                    @endphp
                    <div class="p-3 border rounded-3 mb-3 js-social-row" style="background: #f8fafc;">
                        <div class="row g-3 align-items-center">
                            
                            {{-- Visual Icon Box Preview --}}
                            <div class="col-auto">
                                <label class="form-label fw-semibold mb-1 d-block" style="font-size: 0.8rem;">Icon</label>
                                <div class="rounded-3 bg-white border d-flex align-items-center justify-content-center shadow-sm text-primary" 
                                     style="width: 42px; height: 38px; font-size: 1.25rem;">
                                    <i class="{{ $iconClass }} js-icon-preview"></i>
                                </div>
                            </div>

                            {{-- Select Icon Dropdown --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold mb-1">Select Icon</label>
                                <select name="social_links[{{ $index }}][icon]" class="form-select js-icon-select">
                                    @foreach($iconList as $iVal => $iLabel)
                                        <option value="{{ $iVal }}" data-name="{{ $iLabel }}" @selected($iconClass === $iVal)>
                                            {{ $iLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Platform Name --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold mb-1">Platform Name</label>
                                <input type="text" name="social_links[{{ $index }}][platform]" 
                                    class="form-control js-platform-input"
                                    value="{{ $platformName }}" 
                                    placeholder="e.g. Facebook">
                            </div>

                            {{-- Profile URL --}}
                            <div class="col-md">
                                <label class="form-label fw-semibold mb-1">Profile / Link URL</label>
                                <input type="url" name="social_links[{{ $index }}][url]" 
                                    class="form-control js-url-input"
                                    value="{{ $urlVal }}" 
                                    placeholder="https://...">
                            </div>

                            {{-- Remove Button --}}
                            <div class="col-auto text-end">
                                <label class="form-label fw-semibold mb-1 d-block">&nbsp;</label>
                                <button type="button" class="btn btn-outline-danger js-remove-row" title="Delete row" style="height: 38px;">
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

    {{-- Status Card --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 p-4" style="background: #ffffff;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 fw-bold">Active Status</h6>
                    <p class="text-muted small mb-0">Enable or disable this top header bar on the public website.</p>
                </div>
                <div class="form-check form-switch fs-4">
                    <input type="checkbox" name="status" id="status" class="form-check-input" value="1"
                        {{ old('status', $topHeader->status ?? true) ? 'checked' : '' }}>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('socialLinksList');
        const addBtn = document.getElementById('addSocialBtn');

        const iconOptionsHtml = `
            <option value="fa-brands fa-facebook-f" data-name="Facebook" selected>Facebook</option>
            <option value="fa-brands fa-instagram" data-name="Instagram">Instagram</option>
            <option value="fa-brands fa-x-twitter" data-name="Twitter / X">Twitter / X</option>
            <option value="fa-brands fa-linkedin-in" data-name="LinkedIn">LinkedIn</option>
            <option value="fa-brands fa-youtube" data-name="YouTube">YouTube</option>
            <option value="fa-brands fa-whatsapp" data-name="WhatsApp">WhatsApp</option>
            <option value="fa-brands fa-pinterest-p" data-name="Pinterest">Pinterest</option>
            <option value="fa-brands fa-tiktok" data-name="TikTok">TikTok</option>
            <option value="fa-brands fa-telegram" data-name="Telegram">Telegram</option>
            <option value="fa-brands fa-threads" data-name="Threads">Threads</option>
            <option value="fa-brands fa-snapchat" data-name="Snapchat">Snapchat</option>
            <option value="fa-brands fa-reddit-alien" data-name="Reddit">Reddit</option>
            <option value="fa-brands fa-discord" data-name="Discord">Discord</option>
            <option value="fa-brands fa-github" data-name="GitHub">GitHub</option>
            <option value="fa-solid fa-globe" data-name="Website / Globe">Website / Globe</option>
            <option value="fa-solid fa-envelope" data-name="Email">Email</option>
            <option value="fa-solid fa-phone" data-name="Phone">Phone</option>
            <option value="fa-solid fa-location-dot" data-name="Location">Location</option>
        `;

        function reindexRows() {
            const rows = container.querySelectorAll('.js-social-row');
            rows.forEach((row, idx) => {
                const icon = row.querySelector('.js-icon-select');
                const plat = row.querySelector('.js-platform-input');
                const url = row.querySelector('.js-url-input');

                if (icon) icon.name = `social_links[${idx}][icon]`;
                if (plat) plat.name = `social_links[${idx}][platform]`;
                if (url) url.name = `social_links[${idx}][url]`;
            });
        }

        // When user changes the selected icon dropdown
        container.addEventListener('change', function (e) {
            if (e.target.classList.contains('js-icon-select')) {
                const row = e.target.closest('.js-social-row');
                const iconSelect = e.target;
                const iconPreview = row.querySelector('.js-icon-preview');
                const platformInput = row.querySelector('.js-platform-input');

                const selectedOption = iconSelect.options[iconSelect.selectedIndex];
                const selectedIcon = iconSelect.value;
                const platformName = selectedOption.getAttribute('data-name');

                if (iconPreview) {
                    iconPreview.className = `${selectedIcon} js-icon-preview`;
                }

                if (platformInput && platformName) {
                    platformInput.value = platformName;
                }
            }
        });

        // Add new row
        addBtn.addEventListener('click', function () {
            const rows = container.querySelectorAll('.js-social-row');
            const newIndex = rows.length;

            const div = document.createElement('div');
            div.className = 'p-3 border rounded-3 mb-3 js-social-row';
            div.style.background = '#f8fafc';

            div.innerHTML = `
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="form-label fw-semibold mb-1 d-block" style="font-size: 0.8rem;">Icon</label>
                        <div class="rounded-3 bg-white border d-flex align-items-center justify-content-center shadow-sm text-primary" 
                             style="width: 42px; height: 38px; font-size: 1.25rem;">
                            <i class="fa-brands fa-facebook-f js-icon-preview"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold mb-1">Select Icon</label>
                        <select name="social_links[${newIndex}][icon]" class="form-select js-icon-select">
                            ${iconOptionsHtml}
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold mb-1">Platform Name</label>
                        <input type="text" name="social_links[${newIndex}][platform]" class="form-control js-platform-input" value="Facebook" placeholder="e.g. Facebook">
                    </div>

                    <div class="col-md">
                        <label class="form-label fw-semibold mb-1">Profile / Link URL</label>
                        <input type="url" name="social_links[${newIndex}][url]" class="form-control js-url-input" placeholder="https://...">
                    </div>

                    <div class="col-auto text-end">
                        <label class="form-label fw-semibold mb-1 d-block">&nbsp;</label>
                        <button type="button" class="btn btn-outline-danger js-remove-row" title="Delete row" style="height: 38px;">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(div);
            reindexRows();
            div.querySelector('.js-url-input').focus();
        });

        // Remove row
        container.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.js-remove-row');
            if (removeBtn) {
                const row = removeBtn.closest('.js-social-row');
                const allRows = container.querySelectorAll('.js-social-row');
                if (allRows.length === 1) {
                    row.querySelector('.js-platform-input').value = '';
                    row.querySelector('.js-url-input').value = '';
                } else {
                    row.remove();
                    reindexRows();
                }
            }
        });
    });
</script>
@endpush
