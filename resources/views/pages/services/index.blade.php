@extends('admin.layouts.app')

@section('title', 'Services')
@section('page-title', 'Services Management')

@section('content')

<div class="services-page">

    <div class="page-header">
        <div>
            <h2>Services</h2>
            <p>Manage Visa, Passport and Flight Ticket services.</p>
        </div>

        <a href="{{ route('admin.services.create') }}" class="add-service-btn">
            + Add Service
        </a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <div class="table-responsive">
            <table class="services-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>About Title</th>
                        <th>Status</th>
                        <th>Created Date</th>
                        <th class="text-center">Actions</th>
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
                                    <span class="status-badge active">Active</span>
                                @else
                                    <span class="status-badge inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{ $service->created_at?->format('d M Y') }}
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.services.show', $service) }}" class="action-btn view-btn">
                                        View
                                    </a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="action-btn edit-btn">
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('admin.services.destroy', $service) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this service?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-message">
                                No services found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($services->hasPages())
            <div class="pagination-wrapper">
                {{ $services->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
