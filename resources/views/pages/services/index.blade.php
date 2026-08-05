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
                <p>Manage Visa, Passport and Flight Ticket services.</p>
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

            <div class="ts-table-wrapper">
                <table class="ts-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>About Title</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th class="ts-action-column">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                @if ($service->about_image)
                                    <img
                                        src="{{ asset('storage/' . $service->about_image) }}"
                                        alt="{{ $service->title }}"
                                        class="service-image"
                                    >
                                @else
                                    <div class="no-image">
                                        No Image
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $service->title }}</strong>
                            </td>
                            <td>
                                <span class="slug-text">{{ $service->slug }}</span>
                            </td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($service->about_title, 35) }}
                            </td>
                            <td>
                                @if ($service->status)
                                    <span class="ts-status-badge ts-active">
                                        <span></span> Active
                                    </span>
                                @else
                                    <span class="ts-status-badge ts-inactive">
                                        <span></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $service->created_at?->format('d M Y') }}
                            </td>
                            <td>
                                <div class="ts-actions">
                                    <a href="{{ route('admin.services.show', $service) }}" class="ts-action-btn ts-edit-btn">
                                        View
                                    </a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="ts-action-btn ts-edit-btn">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ts-action-btn ts-delete-btn">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="ts-empty-state">
                                    <div class="ts-empty-icon">✦</div>
                                    <h3>No services found.</h3>
                                    <p>Create your first service.</p>
                                    <a href="{{ route('admin.services.create') }}" class="ts-primary-btn">
                                        Add Service
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

            @if ($services->hasPages())
                <div class="ts-pagination">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
