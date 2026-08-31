<div class="ts-form-grid">
    <div class="ts-form-main">

        {{-- Basic Info --}}
        <div class="ts-form-group">
            <label for="title" class="ts-label">Service Title <span class="ts-required">*</span></label>
            <input type="text" name="title" id="title" class="ts-input @error('title') ts-input-error @enderror" value="{{ old('title', $service->title ?? '') }}" placeholder="e.g. Visa Assistance" required>
            @error('title')<span class="ts-error-message">{{ $message }}</span>@enderror
        </div>

        <div class="ts-form-group">
            <label for="slug" class="ts-label">Slug (Auto generated if empty)</label>
            <input type="text" name="slug" id="slug" class="ts-input @error('slug') ts-input-error @enderror" value="{{ old('slug', $service->slug ?? '') }}" placeholder="e.g. visa-assistance">
            @error('slug')<span class="ts-error-message">{{ $message }}</span>@enderror
        </div>

        {{-- About Section --}}
        <hr class="my-4" style="border-color: #e2e8f0;">
        <h4 class="mb-3" style="color: #0f172a; font-weight: 600;">About Section</h4>

        <div class="ts-form-group">
            <label for="about_title" class="ts-label">About Title <span class="ts-required">*</span></label>
            <input type="text" name="about_title" id="about_title" class="ts-input @error('about_title') ts-input-error @enderror" value="{{ old('about_title', $service->about_title ?? '') }}" placeholder="e.g. Hassle-Free Visa Services" required>
            @error('about_title')<span class="ts-error-message">{{ $message }}</span>@enderror
        </div>

        <div class="ts-form-group">
            <label for="about_description" class="ts-label">About Description</label>
            <textarea name="about_description" id="about_description" rows="4" class="ts-textarea @error('about_description') ts-input-error @enderror" placeholder="Planning an international trip?">{{ old('about_description', $service->about_description ?? '') }}</textarea>
            @error('about_description')<span class="ts-error-message">{{ $message }}</span>@enderror
        </div>


        {{-- Features Repeater --}}
        <hr class="my-4" style="border-color: #e2e8f0;">
        <div class="ts-form-group">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">Features</label>
                    <p class="ts-field-note">Add feature heading title and description</p>
                </div>
                <button type="button" class="ts-add-feature-btn" id="addServiceFeatureBtn"><span>+</span> Add Feature</button>
            </div>
            
            <div id="serviceFeaturesContainer" class="ts-features-container mt-3">
                @php 
                    $featureIcons = [
                        'fa-solid fa-clipboard-list' => '📋 Clipboard / Best Fares',
                        'fa-solid fa-shield-halved' => '🛡️ Shield / Global Reach & Security',
                        'fa-solid fa-clock' => '⏱️ Clock / Instant Booking',
                        'fa-solid fa-user' => '👤 User / Flexible Dates & Personal',
                        'fa-solid fa-headset' => '🎧 Headset / 24/7 Support',
                        'fa-solid fa-plane-departure' => '🛫 Airplane / Flight Tickets',
                        'fa-solid fa-hotel' => '🏨 Hotel / Luxury Accommodations',
                        'fa-solid fa-passport' => '🛂 Passport / Visa Services',
                        'fa-solid fa-wallet' => '👛 Wallet / Transparent Pricing',
                        'fa-solid fa-car' => '🚗 Car / Airport & Transfers',
                        'fa-solid fa-shield-heart' => '💖 Shield / Travel Insurance',
                        'fa-solid fa-star' => '⭐ Star / VIP Experience',
                        'fa-solid fa-tags' => '🏷️ Tags / Special Deals & Offers',
                        'fa-solid fa-globe' => '🌐 Globe / Worldwide Network',
                        'fa-solid fa-calendar-check' => '📅 Calendar / Easy Booking',
                        'fa-solid fa-phone-volume' => '📞 Phone / Dedicated Hotline',
                    ];
                    $oldFeatures = old('features', isset($service) ? $service->features : [['icon' => 'fa-solid fa-clipboard-list', 'title' => '', 'description' => '']]); 
                    if (is_string($oldFeatures)) $oldFeatures = json_decode($oldFeatures, true) ?? [['icon' => 'fa-solid fa-clipboard-list', 'title' => '', 'description' => '']];
                    if (!is_array($oldFeatures) || empty($oldFeatures)) $oldFeatures = [['icon' => 'fa-solid fa-clipboard-list', 'title' => '', 'description' => '']];
                    if (!isset($oldFeatures[0])) $oldFeatures = [$oldFeatures];
                    $oldFeatures = array_values($oldFeatures);
                @endphp
                @foreach ($oldFeatures as $item)
                    @php 
                        $curIcon = is_array($item) ? ($item['icon'] ?? 'fa-solid fa-clipboard-list') : 'fa-solid fa-clipboard-list';
                        $curTitle = is_array($item) ? ($item['title'] ?? '') : $item;
                        $curDesc = is_array($item) ? ($item['description'] ?? '') : '';
                    @endphp
                    <div class="feature-card border rounded-3 p-3 mb-3 s-feature-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0 text-primary">Feature #<span class="js-feature-index">{{ $loop->iteration }}</span></h6>
                            <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn" title="Remove"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="ts-label form-label fw-semibold">Feature Icon</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-3 bg-white border d-flex align-items-center justify-content-center text-primary flex-shrink-0 shadow-sm" style="width: 44px; height: 42px; font-size: 1.25rem;">
                                        <i class="{{ $curIcon }} js-feature-icon-preview"></i>
                                    </div>
                                    <select name="features[{{ $loop->index }}][icon]" class="ts-input m-0 js-feature-icon-select">
                                        @foreach ($featureIcons as $class => $label)
                                            <option value="{{ $class }}" @selected($curIcon === $class)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label class="ts-label form-label fw-semibold">Feature Title <span class="ts-required">*</span></label>
                                <input type="text" name="features[{{ $loop->index }}][title]" value="{{ $curTitle }}" class="ts-input" placeholder="e.g. Best Fares" required>
                            </div>
                            <div class="col-md-12">
                                <label class="ts-label form-label fw-semibold">Feature Description</label>
                                <input type="text" name="features[{{ $loop->index }}][description]" value="{{ $curDesc }}" class="ts-input" placeholder="e.g. Competitive pricing on all routes">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Service Items Repeater --}}
        <hr class="my-4" style="border-color: #e2e8f0;">
        <div class="ts-form-group">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">Service Items</label>
                    <p class="ts-field-note">Add or delete each service item separately.</p>
                </div>
                <button type="button" class="ts-add-feature-btn" id="addSvcItemBtn"><span>+</span> Add Item</button>
            </div>
            
            <div id="svcItemsContainer" class="ts-features-container mt-3">
                @php $oldItems = old('service_items', isset($service) ? $service->service_items : ['']); 
                     if (is_string($oldItems)) $oldItems = json_decode($oldItems, true) ?? [''];
                     if (empty($oldItems)) $oldItems = [''];
                @endphp
                @foreach ($oldItems as $val)
                    <div class="feature-card border rounded-3 p-2 mb-2 s-item-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-grow-1">
                                <input type="text" name="service_items[]" value="{{ is_array($val) ? ($val['title'] ?? '') : $val }}" class="ts-input m-0" placeholder="Enter service item name" required>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn" title="Remove"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Process Steps Repeater --}}
        <hr class="my-4" style="border-color: #e2e8f0;">
        <div class="ts-form-group">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">Process Steps</label>
                    <p class="ts-field-note">Step Icon/Number, Title, Description</p>
                </div>
                <button type="button" class="ts-add-feature-btn" id="addSvcStepBtn"><span>+</span> Add Step</button>
            </div>
            
            <div id="svcStepsContainer" class="ts-features-container mt-3">
                @php $oldSteps = old('process_steps', isset($service) ? $service->process_steps : [['icon' => '', 'title' => '', 'description' => '']]); 
                     if (is_string($oldSteps)) $oldSteps = json_decode($oldSteps, true) ?? [['icon' => '', 'title' => '', 'description' => '']];
                     if (!is_array($oldSteps) || empty($oldSteps)) $oldSteps = [['icon' => '', 'title' => '', 'description' => '']];
                     if (!isset($oldSteps[0])) $oldSteps = [$oldSteps];
                     $oldSteps = array_values($oldSteps);
                @endphp
                @foreach ($oldSteps as $step)
                    <div class="feature-card border rounded-3 p-3 mb-3 s-step-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0 text-primary">Process Step #<span class="js-step-index">{{ $loop->iteration }}</span></h6>
                            <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="ts-label form-label fw-semibold">Icon / Number</label>
                                <input type="text" name="process_steps[{{ $loop->index }}][icon]" value="{{ is_array($step) ? ($step['icon'] ?? '') : '' }}" class="ts-input" placeholder="e.g. 01">
                            </div>
                            <div class="col-md-8">
                                <label class="ts-label form-label fw-semibold">Step Title <span class="ts-required">*</span></label>
                                <input type="text" name="process_steps[{{ $loop->index }}][title]" value="{{ is_array($step) ? ($step['title'] ?? '') : '' }}" class="ts-input" placeholder="Enter step title" required>
                            </div>
                            <div class="col-md-12">
                                <label class="ts-label form-label fw-semibold">Step Description</label>
                                <input type="text" name="process_steps[{{ $loop->index }}][description]" value="{{ is_array($step) ? ($step['description'] ?? '') : '' }}" class="ts-input" placeholder="Enter step description">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Required Documents Repeater --}}
        <hr class="my-4" style="border-color: #e2e8f0;">
        <div class="ts-form-group">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">Required Documents</label>
                    <p class="ts-field-note">Add or delete required document items separately.</p>
                </div>
                <button type="button" class="ts-add-feature-btn" id="addSvcDocBtn"><span>+</span> Add Document</button>
            </div>
            
            <div id="svcDocsContainer" class="ts-features-container mt-3">
                @php $oldDocs = old('documents', isset($service) ? $service->documents : ['']); 
                     if (is_string($oldDocs)) $oldDocs = json_decode($oldDocs, true) ?? [''];
                     if (empty($oldDocs)) $oldDocs = [''];
                @endphp
                @foreach ($oldDocs as $val)
                    <div class="feature-card border rounded-3 p-2 mb-2 s-doc-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-grow-1">
                                <input type="text" name="documents[]" value="{{ $val }}" class="ts-input m-0" placeholder="Enter document name">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn" title="Remove"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Why Choose Us Items Repeater --}}
        <hr class="my-4" style="border-color: #e2e8f0;">
        <div class="ts-form-group">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">Why Choose Us Items</label>
                    <p class="ts-field-note">Add or delete why choose us points separately.</p>
                </div>
                <button type="button" class="ts-add-feature-btn" id="addSvcWhyBtn"><span>+</span> Add Item</button>
            </div>
            
            <div id="svcWhyContainer" class="ts-features-container mt-3">
                @php $oldWhy = old('why_choose_items', isset($service) ? $service->why_choose_items : ['']); 
                     if (is_string($oldWhy)) $oldWhy = json_decode($oldWhy, true) ?? [''];
                     if (empty($oldWhy)) $oldWhy = [''];
                @endphp
                @foreach ($oldWhy as $val)
                    <div class="feature-card border rounded-3 p-2 mb-2 s-why-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-grow-1">
                                <input type="text" name="why_choose_items[]" value="{{ $val }}" class="ts-input m-0" placeholder="Enter why choose point">
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn" title="Remove"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Call To Action Banner & Statistics Section --}}
        <hr class="my-4" style="border-color: #e2e8f0;">
        <div class="ts-section-header">
            <h3>Call To Action & Statistics Banner</h3>
            <p>Configure the bottom full-width banner ("Ready To Start Your Journey?", stats counters, and contact button).</p>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-md-12">
                <label for="cta_title" class="ts-label">Banner Title</label>
                <input type="text" name="cta_title" id="cta_title" value="{{ old('cta_title', $service->cta_title ?? '') }}" class="ts-input" placeholder="e.g. Ready To Start Your Journey?">
            </div>

            <div class="col-md-12">
                <label for="cta_description" class="ts-label">Banner Description</label>
                <textarea name="cta_description" id="cta_description" rows="2" class="ts-input" placeholder="e.g. Let us take care of your visa process while you focus on making unforgettable memories.">{{ old('cta_description', $service->cta_description ?? '') }}</textarea>
            </div>
        </div>

        {{-- Stats / Counters Repeater --}}
        <div class="ts-form-group mt-4">
            <div class="ts-feature-heading">
                <div>
                    <label class="ts-label">Statistics / Counters</label>
                    <p class="ts-field-note">Counters displayed in banner (e.g. 10,000+ Visas Processed, 25+ Countries, 98% Success Rate)</p>
                </div>
                <button type="button" class="ts-add-feature-btn" id="addSvcStatBtn"><span>+</span> Add Stat</button>
            </div>
            
            <div id="svcStatsContainer" class="ts-features-container mt-3">
                @php $oldStats = old('stats', isset($service) ? $service->stats : [['number' => '10,000+', 'label' => 'Visas Processed'], ['number' => '25+', 'label' => 'Countries Covered'], ['number' => '98%', 'label' => 'Success Rate']]); 
                     if (is_string($oldStats)) $oldStats = json_decode($oldStats, true) ?? [['number' => '', 'label' => '']];
                     if (!is_array($oldStats) || empty($oldStats)) $oldStats = [['number' => '', 'label' => '']];
                     if (!isset($oldStats[0])) $oldStats = [$oldStats];
                     $oldStats = array_values($oldStats);
                @endphp
                @foreach ($oldStats as $stat)
                    <div class="feature-card border rounded-3 p-3 mb-2.5 s-stat-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 35%;">
                                <label class="ts-label form-label fw-semibold small mb-1">Counter / Number</label>
                                <input type="text" name="stats[{{ $loop->index }}][number]" value="{{ is_array($stat) ? ($stat['number'] ?? '') : '' }}" class="ts-input m-0" placeholder="e.g. 10,000+">
                            </div>
                            <div class="flex-grow-1">
                                <label class="ts-label form-label fw-semibold small mb-1">Label / Description</label>
                                <input type="text" name="stats[{{ $loop->index }}][label]" value="{{ is_array($stat) ? ($stat['label'] ?? '') : '' }}" class="ts-input m-0" placeholder="e.g. Visas Processed">
                            </div>
                            <div class="pt-3">
                                <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn" title="Remove"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="ts-form-sidebar">
        {{-- About Image --}}
        <div class="ts-side-card">
            <div class="ts-side-card-header">
                <h3>About Image</h3>
                <p>Upload the about section image.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($service) && $service->about_image ? asset('storage/' . $service->about_image) : '' }}"
                    alt="Image preview" id="imagePreview"
                    class="ts-image-preview {{ isset($service) && $service->about_image ? '' : 'ts-hidden' }}">

                <div id="imagePlaceholder" class="ts-image-placeholder {{ isset($service) && $service->about_image ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">✦</span>
                    <strong>No image selected</strong>
                    <small>JPG, PNG or WEBP</small>
                </div>
            </div>

            <label for="about_image" class="ts-upload-label">
                Choose Image
            </label>

            <input type="file" name="about_image" id="about_image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp,.avif,image/*">
            @error('about_image')<span class="ts-error-message">{{ $message }}</span>@enderror
        </div>

        {{-- CTA Banner Background Image --}}
        <div class="ts-side-card mt-3">
            <div class="ts-side-card-header">
                <h3>CTA Banner Background</h3>
                <p>Upload background image for the CTA banner.</p>
            </div>

            <div class="ts-image-preview-box">
                <img src="{{ isset($service) && $service->cta_background_image ? asset('storage/' . $service->cta_background_image) : '' }}"
                    alt="CTA Image preview" id="ctaImagePreview"
                    class="ts-image-preview {{ isset($service) && $service->cta_background_image ? '' : 'ts-hidden' }}">

                <div id="ctaImagePlaceholder" class="ts-image-placeholder {{ isset($service) && $service->cta_background_image ? 'ts-hidden' : '' }}">
                    <span class="ts-image-placeholder-icon">✦</span>
                    <strong>No banner image selected</strong>
                    <small>JPG, PNG or WEBP</small>
                </div>
            </div>

            <label for="cta_background_image" class="ts-upload-label">
                Choose Banner Image
            </label>

            <input type="file" name="cta_background_image" id="cta_background_image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp,.avif,image/*">
            @error('cta_background_image')<span class="ts-error-message">{{ $message }}</span>@enderror
        </div>

        {{-- Status --}}
        <div class="admin-form-group mt-3">
            <label for="status">Status <span class="required">*</span></label>
            <select id="status" name="status" class="admin-form-control @error('status') is-invalid @enderror" required>
                <option value="1" @selected(old('status', $service->status ?? 1) == 1)>Active</option>
                <option value="0" @selected(old('status', $service->status ?? 1) == 0)>Inactive</option>
            </select>
            @error('status')<span class="admin-form-error">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Image Previews
        function setupImagePreview(inputId, previewId, placeholderId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);

            if (input && preview) {
                input.addEventListener('change', function () {
                    const file = this.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function (event) {
                        preview.src = event.target.result;
                        preview.classList.remove('ts-hidden');
                        if (placeholder) placeholder.classList.add('ts-hidden');
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        setupImagePreview('about_image', 'imagePreview', 'imagePlaceholder');
        setupImagePreview('cta_background_image', 'ctaImagePreview', 'ctaImagePlaceholder');

        // Generic Repeater Logic
        function setupRepeater(containerId, addBtnId, rowClass, templateFn) {
            const container = document.getElementById(containerId);
            const addBtn = document.getElementById(addBtnId);
            
            if (!container || !addBtn) return;
            
            addBtn.addEventListener('click', function() {
                const index = container.querySelectorAll('.' + rowClass).length;
                const row = document.createElement('div');
                row.innerHTML = templateFn(index);
                const element = row.firstElementChild;
                container.appendChild(element);
            });

            container.addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.s-remove-btn');
                if (removeBtn) {
                    const rows = container.querySelectorAll('.' + rowClass);
                    if (rows.length > 1) {
                        removeBtn.closest('.' + rowClass).remove();
                    } else {
                        removeBtn.closest('.' + rowClass).querySelectorAll('input').forEach(i => i.value = '');
                    }
                }
            });
        }

        setupRepeater('serviceFeaturesContainer', 'addServiceFeatureBtn', 's-feature-row', function(index) {
            return `
                <div class="feature-card border rounded-3 p-3 mb-3 s-feature-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0 text-primary">Feature #\${index + 1}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn" title="Remove"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="ts-label form-label fw-semibold">Feature Icon</label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-3 bg-white border d-flex align-items-center justify-content-center text-primary flex-shrink-0 shadow-sm" style="width: 44px; height: 42px; font-size: 1.25rem;">
                                    <i class="fa-solid fa-clipboard-list js-feature-icon-preview"></i>
                                </div>
                                <select name="features[\${index}][icon]" class="ts-input m-0 js-feature-icon-select">
                                    <option value="fa-solid fa-clipboard-list">📋 Clipboard / Best Fares</option>
                                    <option value="fa-solid fa-shield-halved">🛡️ Shield / Global Reach & Security</option>
                                    <option value="fa-solid fa-clock">⏱️ Clock / Instant Booking</option>
                                    <option value="fa-solid fa-user">👤 User / Flexible Dates & Personal</option>
                                    <option value="fa-solid fa-headset">🎧 Headset / 24/7 Support</option>
                                    <option value="fa-solid fa-plane-departure">🛫 Airplane / Flight Tickets</option>
                                    <option value="fa-solid fa-hotel">🏨 Hotel / Luxury Accommodations</option>
                                    <option value="fa-solid fa-passport">🛂 Passport / Visa Services</option>
                                    <option value="fa-solid fa-wallet">👛 Wallet / Transparent Pricing</option>
                                    <option value="fa-solid fa-car">🚗 Car / Airport & Transfers</option>
                                    <option value="fa-solid fa-shield-heart">💖 Shield / Travel Insurance</option>
                                    <option value="fa-solid fa-star">⭐ Star / VIP Experience</option>
                                    <option value="fa-solid fa-tags">🏷️ Tags / Special Deals & Offers</option>
                                    <option value="fa-solid fa-globe">🌐 Globe / Worldwide Network</option>
                                    <option value="fa-solid fa-calendar-check">📅 Calendar / Easy Booking</option>
                                    <option value="fa-solid fa-phone-volume">📞 Phone / Dedicated Hotline</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <label class="ts-label form-label fw-semibold">Feature Title <span class="ts-required">*</span></label>
                            <input type="text" name="features[\${index}][title]" class="ts-input" placeholder="e.g. Best Fares" required>
                        </div>
                        <div class="col-md-12">
                            <label class="ts-label form-label fw-semibold">Feature Description</label>
                            <input type="text" name="features[\${index}][description]" class="ts-input" placeholder="e.g. Competitive pricing on all routes">
                        </div>
                    </div>
                </div>
            `;
        });

        // Live icon preview handler for features select dropdown
        const featuresContainer = document.getElementById('serviceFeaturesContainer');
        if (featuresContainer) {
            featuresContainer.addEventListener('change', function(e) {
                if (e.target.classList.contains('js-feature-icon-select')) {
                    const row = e.target.closest('.s-feature-row');
                    const preview = row ? row.querySelector('.js-feature-icon-preview') : null;
                    if (preview) {
                        preview.className = e.target.value + ' js-feature-icon-preview';
                    }
                }
            });
        }

        setupRepeater('svcItemsContainer', 'addSvcItemBtn', 's-item-row', function(index) {
            return `
                <div class="feature-card border rounded-3 p-2 mb-2 s-item-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <input type="text" name="service_items[]" class="ts-input m-0" placeholder="Enter service item name" required>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `;
        });

        setupRepeater('svcStepsContainer', 'addSvcStepBtn', 's-step-row', function(index) {
            return `
                <div class="feature-card border rounded-3 p-3 mb-3 s-step-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0 text-primary">Process Step</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="ts-label form-label fw-semibold">Icon / Number</label>
                            <input type="text" name="process_steps[${index}][icon]" class="ts-input" placeholder="e.g. 01">
                        </div>
                        <div class="col-md-8">
                            <label class="ts-label form-label fw-semibold">Step Title <span class="ts-required">*</span></label>
                            <input type="text" name="process_steps[${index}][title]" class="ts-input" placeholder="Enter step title" required>
                        </div>
                        <div class="col-md-12">
                            <label class="ts-label form-label fw-semibold">Step Description</label>
                            <input type="text" name="process_steps[${index}][description]" class="ts-input" placeholder="Enter step description">
                        </div>
                    </div>
                </div>
            `;
        });

        setupRepeater('svcDocsContainer', 'addSvcDocBtn', 's-doc-row', function(index) {
            return `
                <div class="feature-card border rounded-3 p-2 mb-2 s-doc-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <input type="text" name="documents[]" class="ts-input m-0" placeholder="Enter document name">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `;
        });

        setupRepeater('svcWhyContainer', 'addSvcWhyBtn', 's-why-row', function(index) {
            return `
                <div class="feature-card border rounded-3 p-2 mb-2 s-why-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <input type="text" name="why_choose_items[]" class="ts-input m-0" placeholder="Enter why choose point">
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `;
        });

        setupRepeater('svcStatsContainer', 'addSvcStatBtn', 's-stat-row', function(index) {
            return `
                <div class="feature-card border rounded-3 p-3 mb-2.5 s-stat-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 35%;">
                            <label class="ts-label form-label fw-semibold small mb-1">Counter / Number</label>
                            <input type="text" name="stats[\${index}][number]" class="ts-input m-0" placeholder="e.g. 10,000+">
                        </div>
                        <div class="flex-grow-1">
                            <label class="ts-label form-label fw-semibold small mb-1">Label / Description</label>
                            <input type="text" name="stats[\${index}][label]" class="ts-input m-0" placeholder="e.g. Visas Processed">
                        </div>
                        <div class="pt-3">
                            <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn" title="Remove"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            `;
        });
    });
</script>
@endpush
