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
                @php $oldFeatures = old('features', isset($service) ? $service->features : [['title' => '', 'description' => '']]); 
                     if (is_string($oldFeatures)) $oldFeatures = json_decode($oldFeatures, true) ?? [['title' => '', 'description' => '']];
                     if (empty($oldFeatures)) $oldFeatures = [['title' => '', 'description' => '']];
                @endphp
                @foreach ($oldFeatures as $i => $item)
                    <div class="feature-card border rounded-3 p-3 mb-3 s-feature-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0 text-primary">Feature</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="ts-label form-label fw-semibold">Feature Title <span class="ts-required">*</span></label>
                                <input type="text" name="features[{{ $i }}][title]" value="{{ is_array($item) ? ($item['title'] ?? '') : $item }}" class="ts-input" placeholder="Enter feature title" required>
                            </div>
                            <div class="col-md-12">
                                <label class="ts-label form-label fw-semibold">Feature Description</label>
                                <input type="text" name="features[{{ $i }}][description]" value="{{ is_array($item) ? ($item['description'] ?? '') : '' }}" class="ts-input" placeholder="Enter feature description">
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
                     if (empty($oldSteps)) $oldSteps = [['icon' => '', 'title' => '', 'description' => '']];
                @endphp
                @foreach ($oldSteps as $i => $step)
                    <div class="feature-card border rounded-3 p-3 mb-3 s-step-row" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0 text-primary">Process Step</h6>
                            <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="ts-label form-label fw-semibold">Icon / Number</label>
                                <input type="text" name="process_steps[{{ $i }}][icon]" value="{{ $step['icon'] ?? '' }}" class="ts-input" placeholder="e.g. 01">
                            </div>
                            <div class="col-md-8">
                                <label class="ts-label form-label fw-semibold">Step Title <span class="ts-required">*</span></label>
                                <input type="text" name="process_steps[{{ $i }}][title]" value="{{ $step['title'] ?? '' }}" class="ts-input" placeholder="Enter step title" required>
                            </div>
                            <div class="col-md-12">
                                <label class="ts-label form-label fw-semibold">Step Description</label>
                                <input type="text" name="process_steps[{{ $i }}][description]" value="{{ $step['description'] ?? '' }}" class="ts-input" placeholder="Enter step description">
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

            <input type="file" name="about_image" id="about_image" class="ts-file-input" accept=".jpg,.jpeg,.png,.webp">
            @error('about_image')<span class="ts-error-message">{{ $message }}</span>@enderror
        </div>

        {{-- Status --}}
        <div class="admin-form-group">
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
        // Image Preview
        const imageInput = document.getElementById('about_image');
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
                        <h6 class="fw-semibold mb-0 text-primary">Feature</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger s-remove-btn"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="ts-label form-label fw-semibold">Feature Title <span class="ts-required">*</span></label>
                            <input type="text" name="features[${index}][title]" class="ts-input" placeholder="Enter feature title" required>
                        </div>
                        <div class="col-md-12">
                            <label class="ts-label form-label fw-semibold">Feature Description</label>
                            <input type="text" name="features[${index}][description]" class="ts-input" placeholder="Enter feature description">
                        </div>
                    </div>
                </div>
            `;
        });

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
    });
</script>
@endpush
