@extends('admin.layouts.app')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service')

@section('content')

<div class="service-form-page">
    <div class="page-header">
        <div>
            <h2>Edit Service: {{ $service->title }}</h2>
            <p>Update service details, features, about section, service items, and process steps.</p>
        </div>
        <a href="{{ route('admin.services.index') }}" class="back-btn">
            &larr; Back to Services
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf
        @method('PUT')

        <!-- 1. Basic Information -->
        <div class="form-section">
            <div class="section-title">Basic Information</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="title" class="form-label">Service Title <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="form-input" value="{{ old('title', $service->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="slug" class="form-label">Slug <span class="required">*</span></label>
                    <input type="text" name="slug" id="slug" class="form-input" value="{{ old('slug', $service->slug) }}" required>
                </div>
            </div>
        </div>

        <!-- 2. About Section -->
        <div class="form-section">
            <div class="section-title">About Section</div>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="about_title" class="form-label">About Title <span class="required">*</span></label>
                    <input type="text" name="about_title" id="about_title" class="form-input" value="{{ old('about_title', $service->about_title) }}" required>
                </div>

                <div class="form-group full-width">
                    <label for="about_description" class="form-label">About Description</label>
                    <textarea name="about_description" id="about_description" rows="4" class="form-input">{{ old('about_description', $service->about_description) }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label for="about_image" class="form-label">About Image</label>
                    @if ($service->about_image)
                        <div style="margin-bottom: 12px;">
                            <img src="{{ asset('storage/' . $service->about_image) }}" alt="{{ $service->title }}" style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                        </div>
                    @endif
                    <input type="file" name="about_image" id="about_image" class="form-input" accept="image/*">
                </div>
            </div>
        </div>

        <!-- 3. Features -->
        <div class="form-section">
            <div class="repeater-header">
                <div>
                    <h3 class="section-title mb-0">Features</h3>
                    <p class="section-subtitle">Add feature heading title and description</p>
                </div>
                <button type="button" class="add-btn" id="addFeatureBtn">+ Add Feature</button>
            </div>
            <div id="featuresContainer" class="repeater-list">
                @php 
                    $features = old('features', $service->features ?? []);
                    if (empty($features)) {
                        $features = [['title' => '', 'description' => '']];
                    }
                @endphp
                @foreach ($features as $i => $item)
                    <div class="repeater-card feature-row">
                        <button type="button" class="remove-btn removeFeatureBtn" title="Remove Feature">&times;</button>
                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label class="form-label">Feature Title <span class="required">*</span></label>
                                <input type="text" name="features[{{ $i }}][title]" value="{{ is_array($item) ? ($item['title'] ?? '') : $item }}" class="form-input" placeholder="Enter feature title" required>
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label">Feature Description</label>
                                <input type="text" name="features[{{ $i }}][description]" value="{{ is_array($item) ? ($item['description'] ?? '') : '' }}" class="form-input" placeholder="Enter feature description">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 4. Service Items -->
        <div class="form-section">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h3 class="form-label fw-bold mb-1">Service Items</h3>
                    <p class="small text-muted mb-0">Add or delete each service item separately.</p>
                </div>
                <button type="button" class="btn btn-sm btn-primary" id="addServiceItemBtn">+ Add Service Item</button>
            </div>
            <div id="serviceItemsContainer">
                @php 
                    $items = old('service_items', $service->service_items ?? []);
                    if (empty($items)) {
                        $items = [''];
                    }
                @endphp
                @foreach ($items as $val)
                    <div class="service-item-row row g-2 align-items-start mb-3">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-check"></i></span>
                                <input type="text" name="service_items[]" value="{{ is_array($val) ? ($val['title'] ?? '') : $val }}" class="form-control" placeholder="Enter service item name" required>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger removeServiceItemBtn" title="Remove Item">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 5. Process Steps -->
        <div class="form-section">
            <div class="repeater-header">
                <div>
                    <h3 class="section-title mb-0">Process Steps</h3>
                    <p class="section-subtitle">Step Icon/Number, Title, Description</p>
                </div>
                <button type="button" class="add-btn" id="addProcessStepBtn">+ Add Step</button>
            </div>
            <div id="processStepsContainer" class="repeater-list">
                @php 
                    $steps = old('process_steps', $service->process_steps ?? []);
                    if (empty($steps)) {
                        $steps = [['icon' => '', 'title' => '', 'description' => '']];
                    }
                @endphp
                @foreach ($steps as $i => $step)
                    <div class="repeater-card step-row">
                        <button type="button" class="remove-btn removeStepBtn" title="Remove Step">&times;</button>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Step Icon / Number</label>
                                <input type="text" name="process_steps[{{ $i }}][icon]" value="{{ $step['icon'] ?? '' }}" class="form-input" placeholder="e.g. 01">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Step Title <span class="required">*</span></label>
                                <input type="text" name="process_steps[{{ $i }}][title]" value="{{ $step['title'] ?? '' }}" class="form-input" placeholder="Enter step title" required>
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label">Step Description</label>
                                <input type="text" name="process_steps[{{ $i }}][description]" value="{{ $step['description'] ?? '' }}" class="form-input" placeholder="Enter step description">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 6. Required Documents -->
        <div class="form-section">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h3 class="form-label fw-bold mb-1">Required Documents</h3>
                    <p class="small text-muted mb-0">Add or delete required document items separately.</p>
                </div>
                <button type="button" class="btn btn-sm btn-primary" id="addDocumentBtn">+ Add Document</button>
            </div>
            <div id="documentsContainer">
                @php 
                    $docs = old('documents', $service->documents ?? []);
                    if (empty($docs)) { $docs = ['']; }
                @endphp
                @foreach ($docs as $val)
                    <div class="doc-row row g-2 align-items-start mb-3">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-check"></i></span>
                                <input type="text" name="documents[]" value="{{ $val }}" class="form-control" placeholder="Enter document name">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger removeDocBtn" title="Remove Document">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 7. Why Choose Items -->
        <div class="form-section">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h3 class="form-label fw-bold mb-1">Why Choose Us Items</h3>
                    <p class="small text-muted mb-0">Add or delete why choose us points separately.</p>
                </div>
                <button type="button" class="btn btn-sm btn-primary" id="addWhyChooseBtn">+ Add Item</button>
            </div>
            <div id="whyChooseContainer">
                @php 
                    $whyItems = old('why_choose_items', $service->why_choose_items ?? []);
                    if (empty($whyItems)) { $whyItems = ['']; }
                @endphp
                @foreach ($whyItems as $val)
                    <div class="why-row row g-2 align-items-start mb-3">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-check"></i></span>
                                <input type="text" name="why_choose_items[]" value="{{ $val }}" class="form-control" placeholder="Enter why choose point">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger removeWhyBtn" title="Remove Item">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="form-section mb-0">
            <div class="form-group full-width mb-0">
                <label class="checkbox-label">
                    <input type="checkbox" name="status" value="1" {{ old('status', $service->status) ? 'checked' : '' }}>
                    <span>Active Status</span>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-btn">Update Service</button>
            <a href="{{ route('admin.services.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

@endsection
