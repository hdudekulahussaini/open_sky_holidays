@extends('admin.layouts.app')

@section('title', 'Add Service')
@section('page-title', 'Add New Service')

@section('content')

<div class="service-form-page">
    <div class="page-header">
        <div>
            <h2>Add New Service</h2>
            <p>Fill in service details, features, about section, service items, and process steps.</p>
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

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf

        <!-- 1. Basic Information -->
        <div class="form-section">
            <div class="section-title">Basic Information</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="title" class="form-label">Service Title <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" required placeholder="e.g. Visa Assistance">
                </div>

                <div class="form-group">
                    <label for="slug" class="form-label">Slug (Auto generated if empty)</label>
                    <input type="text" name="slug" id="slug" class="form-input" value="{{ old('slug') }}" placeholder="e.g. visa-assistance">
                </div>
            </div>
        </div>

        <!-- 2. About Section -->
        <div class="form-section">
            <div class="section-title">About Section</div>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="about_title" class="form-label">About Title <span class="required">*</span></label>
                    <input type="text" name="about_title" id="about_title" class="form-input" value="{{ old('about_title') }}" required placeholder="e.g. Hassle-Free Visa Services For Your Journey">
                </div>

                <div class="form-group full-width">
                    <label for="about_description" class="form-label">About Description</label>
                    <textarea name="about_description" id="about_description" rows="4" class="form-input" placeholder="Planning an international trip? We make visa processing simple and stress-free...">{{ old('about_description') }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label for="about_image" class="form-label">About Image</label>
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
                @php $oldFeatures = old('features', [['title' => '', 'description' => '']]); @endphp
                @foreach ($oldFeatures as $i => $item)
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
            <div class="repeater-header">
                <div>
                    <h3 class="section-title mb-0">Service Items</h3>
                    <p class="section-subtitle">Add service items to list in about section</p>
                </div>
                <button type="button" class="add-btn" id="addServiceItemBtn">+ Add Service Item</button>
            </div>
            <div id="serviceItemsContainer" class="repeater-list">
                @php $oldItems = old('service_items', ['']); @endphp
                @foreach ($oldItems as $val)
                    <div class="repeater-card inline-repeater service-item-row">
                        <div class="inline-repeater-input">
                            <input type="text" name="service_items[]" value="{{ is_array($val) ? ($val['title'] ?? '') : $val }}" class="form-input" placeholder="Enter service item name" required>
                        </div>
                        <button type="button" class="remove-btn removeServiceItemBtn" title="Remove Item">&times;</button>
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
                @php $oldSteps = old('process_steps', [['icon' => '', 'title' => '', 'description' => '']]); @endphp
                @foreach ($oldSteps as $i => $step)
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
            <div class="repeater-header">
                <div>
                    <h3 class="section-title mb-0">Required Documents</h3>
                    <p class="section-subtitle">Add required document items</p>
                </div>
                <button type="button" class="add-btn" id="addDocumentBtn">+ Add Document</button>
            </div>
            <div id="documentsContainer" class="repeater-list">
                @php $oldDocs = old('documents', ['']); @endphp
                @foreach ($oldDocs as $val)
                    <div class="repeater-card inline-repeater doc-row">
                        <div class="inline-repeater-input">
                            <input type="text" name="documents[]" value="{{ $val }}" class="form-input" placeholder="Enter document name">
                        </div>
                        <button type="button" class="remove-btn removeDocBtn" title="Remove Document">&times;</button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 7. Why Choose Items -->
        <div class="form-section">
            <div class="repeater-header">
                <div>
                    <h3 class="section-title mb-0">Why Choose Us Items</h3>
                    <p class="section-subtitle">Add why choose us points</p>
                </div>
                <button type="button" class="add-btn" id="addWhyChooseBtn">+ Add Item</button>
            </div>
            <div id="whyChooseContainer" class="repeater-list">
                @php $oldWhy = old('why_choose_items', ['']); @endphp
                @foreach ($oldWhy as $val)
                    <div class="repeater-card inline-repeater why-row">
                        <div class="inline-repeater-input">
                            <input type="text" name="why_choose_items[]" value="{{ $val }}" class="form-input" placeholder="Enter why choose point">
                        </div>
                        <button type="button" class="remove-btn removeWhyBtn" title="Remove Item">&times;</button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="form-section mb-0">
            <div class="form-group full-width mb-0">
                <label class="checkbox-label">
                    <input type="checkbox" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                    <span>Active Status</span>
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-btn">Create Service</button>
            <a href="{{ route('admin.services.index') }}" class="cancel-btn">Cancel</a>
        </div>
    </form>
</div>

@endsection
