@extends('admin.layouts.app')

@section('title', 'Services')
@section('page-title', 'Services Management')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Services</h1>
                <p>Manage Visa, Passport, Flight Ticket and travel services displayed on the website.</p>
            </div>

            <a href="{{ route('admin.services.create') }}" class="ts-primary-btn">
                <span>+</span> Add Service
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Services List</h2>
                    <p>Total records: <strong>{{ $services->total() }}</strong></p>
                </div>
            </div>

            @if ($services->count() > 0)
                <div class="ts-table-wrapper">
                    <table class="ts-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Service Title</th>
                                <th>About Title</th>
                                <th>Features</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th class="ts-action-column">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>#{{ $service->id }}</td>
                                    <td>
                                        <div class="ts-table-image-wrap">
                                            @if ($service->about_image)
                                                <img
                                                    src="{{ asset('storage/' . $service->about_image) }}"
                                                    alt="{{ $service->title }}"
                                                    class="ts-table-image"
                                                >
                                            @else
                                                <div class="ts-table-image-empty">
                                                    ✦
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ts-content-cell">
                                            <span class="ts-small-heading" style="font-family: monospace; font-size: 0.75rem; color: #64748b;">
                                                /{{ $service->slug }}
                                            </span>
                                            <h3 style="font-size: 0.95rem; font-weight: 600; color: #0f172a; margin-top: 2px;">
                                                {{ $service->title }}
                                            </h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ts-content-cell">
                                            <p style="font-size: 0.875rem; color: #334155; margin: 0;">
                                                {{ \Illuminate\Support\Str::limit($service->about_title, 40) }}
                                            </p>
                                            @if ($service->about_description)
                                                <small style="color: #64748b; font-size: 0.775rem;">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($service->about_description), 50) }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $featureCount = is_array($service->features) ? count($service->features) : 0;
                                            $docCount = is_array($service->documents) ? count($service->documents) : 0;
                                        @endphp
                                        <div style="display: flex; flex-direction: column; gap: 4px; font-size: 0.75rem;">
                                            @if ($featureCount > 0)
                                                <span class="ts-status-badge ts-primary" style="display: inline-flex;">
                                                    <span></span> {{ $featureCount }} {{ Str::plural('Feature', $featureCount) }}
                                                </span>
                                            @endif
                                            @if ($docCount > 0)
                                                <span style="background-color: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; border: 1px solid #e2e8f0; display: inline-block;">
                                                    📄 {{ $docCount }} {{ Str::plural('Doc', $docCount) }}
                                                </span>
                                            @endif
                                            @if ($featureCount === 0 && $docCount === 0)
                                                <span style="color: #94a3b8;">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="ts-status-badge {{ $service->status ? 'ts-active' : 'ts-inactive' }}">
                                            <span></span>
                                            {{ $service->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="ts-date">
                                            {{ $service->created_at?->format('d M Y') ?: 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="ts-actions">
                                            <a href="{{ route('admin.services.show', $service) }}" class="ts-action-btn" title="View Service">
                                                View
                                            </a>
                                            <a href="{{ route('admin.services.edit', $service) }}" class="ts-action-btn ts-edit-btn" title="Edit Service">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ts-action-btn ts-delete-btn" title="Delete Service">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($services->hasPages())
                    <div class="ts-pagination">
                        {{ $services->links() }}
                    </div>
                @endif
            @else
                <div class="ts-empty-state">
                    <div class="ts-empty-icon">✦</div>
                    <h3>No services found.</h3>
                    <p>Create your first service (e.g., Visa Assistance, Flight Booking).</p>
                    <a href="{{ route('admin.services.create') }}" class="ts-primary-btn">
                        Add Service
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
