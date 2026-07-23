@extends('admin.layouts.app')

@section('title', 'Tour Features')
@section('page-title', 'Tour Features')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>Tour Features</h3>
                <p>Manage tour package inclusions, highlights, and covered places.</p>
            </div>

            <a href="{{ route('admin.tour-features.create') }}" class="btn btn-primary">
                + Add Tour Feature
            </a>
        </div>

        @if ($tourFeatures->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tour</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tourFeatures as $feature)
                            <tr>
                                <td>#{{ $feature->id }}</td>
                                <td><strong>{{ $feature->tour?->title ?? 'Global / Unassigned' }}</strong></td>
                                <td>{{ $feature->title }}</td>
                                <td><span class="toc-count-badge">{{ ucfirst(str_replace('_', ' ', $feature->type ?? 'feature')) }}</span></td>
                                <td>
                                    <span class="status-badge {{ $feature->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $feature->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.tour-features.edit', $feature) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tour-features.destroy', $feature) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this feature?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-button action-delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6l-1 14H6L5 6"></path>
                                                    <path d="M10 11v6"></path>
                                                    <path d="M14 11v6"></path>
                                                    <path d="M9 6V4h6v2"></path>
                                                </svg>
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

            @if ($tourFeatures->hasPages())
                <div class="pagination-wrapper">
                    {{ $tourFeatures->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No tour features found.</strong>
                <p>Add your first Tour Feature record.</p>
                <a href="{{ route('admin.tour-features.create') }}" class="btn btn-primary">
                    Create Feature
                </a>
            </div>
        @endif
    </div>
@endsection
