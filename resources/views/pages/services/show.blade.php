@extends('admin.layouts.app')

@section('title', 'Service Details')
@section('page-title', 'Service Details')

@section('content')

<div class="service-show-page">
    <div class="page-header">
        <div>
            <h2>{{ $service->title }}</h2>
            <p class="slug-badge">Slug: <code>{{ $service->slug }}</code></p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.services.edit', $service) }}" class="edit-btn">Edit Service</a>
            <a href="{{ route('admin.services.index') }}" class="back-btn">&larr; Back to Services</a>
        </div>
    </div>

    <div class="details-card">
        <div class="detail-row">
            <span class="detail-label">Status</span>
            @if ($service->status)
                <span class="status-badge active">Active</span>
            @else
                <span class="status-badge inactive">Inactive</span>
            @endif
        </div>

        <div class="detail-row">
            <span class="detail-label">About Title</span>
            <p class="detail-value">{{ $service->about_title }}</p>
        </div>

        <div class="detail-row">
            <span class="detail-label">About Description</span>
            <p class="detail-value">{{ $service->about_description ?? 'N/A' }}</p>
        </div>

        @if ($service->about_image)
            <div class="detail-row">
                <span class="detail-label">About Image</span>
                <img src="{{ asset('storage/' . $service->about_image) }}" alt="{{ $service->title }}" class="preview-img">
            </div>
        @endif

        <hr class="divider">

        <!-- Features (Icon, Title & Description) -->
        <div class="detail-section">
            <h3 class="section-title">Features</h3>
            @if (!empty($service->features))
                <div class="grid-list">
                    @foreach ($service->features as $feature)
                        <div class="info-card">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                @if(is_array($feature) && !empty($feature['icon']))
                                    <i class="{{ $feature['icon'] }} text-primary"></i>
                                @endif
                                <strong>{{ is_array($feature) ? ($feature['title'] ?? 'N/A') : $feature }}</strong>
                            </div>
                            @if(is_array($feature) && !empty($feature['description']))
                                <p class="mb-0 text-muted">{{ $feature['description'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="muted">No features added.</p>
            @endif
        </div>

        <hr class="divider">

        <!-- Service Items -->
        <div class="detail-section">
            <h3 class="section-title">Service Items</h3>
            @if (!empty($service->service_items))
                <ul class="badge-list">
                    @foreach ($service->service_items as $item)
                        <li class="item-badge">{{ is_array($item) ? ($item['title'] ?? '') : $item }}</li>
                    @endforeach
                </ul>
            @else
                <p class="muted">No service items added.</p>
            @endif
        </div>

        <hr class="divider">

        <!-- Process Steps -->
        <div class="detail-section">
            <h3 class="section-title">Process Steps</h3>
            @if (!empty($service->process_steps))
                <div class="grid-list">
                    @foreach ($service->process_steps as $step)
                        <div class="info-card">
                            <strong>Step {{ $step['icon'] ?? '#' }}: {{ $step['title'] ?? 'N/A' }}</strong>
                            <p>{{ $step['description'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="muted">No process steps added.</p>
            @endif
        </div>

        <hr class="divider">

        <!-- Documents Required -->
        <div class="detail-section">
            <h3 class="section-title">Required Documents</h3>
            @if (!empty($service->documents))
                <ul class="badge-list">
                    @foreach ($service->documents as $doc)
                        <li class="item-badge doc-badge">{{ $doc }}</li>
                    @endforeach
                </ul>
            @else
                <p class="muted">No documents added.</p>
            @endif
        </div>

        <hr class="divider">

        <!-- Why Choose Us Items -->
        <div class="detail-section">
            <h3 class="section-title">Why Choose Us Items</h3>
            @if (!empty($service->why_choose_items))
                <ul class="badge-list">
                    @foreach ($service->why_choose_items as $item)
                        <li class="item-badge why-badge">{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p class="muted">No items added.</p>
            @endif
        </div>

        <hr class="divider">

        <!-- CTA & Statistics Banner -->
        <div class="detail-section">
            <h3 class="section-title">Call To Action & Statistics Banner</h3>
            <div class="detail-row">
                <span class="detail-label">Banner Title</span>
                <p class="detail-value">{{ $service->cta_title ?? 'N/A' }}</p>
            </div>
            <div class="detail-row">
                <span class="detail-label">Banner Description</span>
                <p class="detail-value">{{ $service->cta_description ?? 'N/A' }}</p>
            </div>
            @if ($service->cta_background_image)
                <div class="detail-row">
                    <span class="detail-label">Banner Background</span>
                    <img src="{{ asset('storage/' . $service->cta_background_image) }}" alt="CTA Banner" class="preview-img">
                </div>
            @endif

            @if (!empty($service->stats))
                <div class="mt-3">
                    <span class="detail-label d-block mb-2">Statistics Counters</span>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($service->stats as $st)
                            <div class="p-2 border rounded bg-light text-center" style="min-width: 130px;">
                                <div class="fw-bold text-primary fs-5">{{ $st['number'] ?? '' }}</div>
                                <small class="text-muted">{{ $st['label'] ?? '' }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
