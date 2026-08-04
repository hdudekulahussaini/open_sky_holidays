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
                            <th class="ts-action-column">Actions</th>
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
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.tour-features.edit', $feature) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tour-features.destroy', $feature) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feature?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ts-action-btn ts-delete-btn">
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
