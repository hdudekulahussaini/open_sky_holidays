@extends('admin.layouts.app')

@section('title', 'Travel Support')
@section('page-title', 'Travel Support')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>Travel Support</h3>
                <p>Manage travel support sections and contact options.</p>
            </div>

            <a href="{{ route('admin.travel-support.create') }}" class="btn btn-primary">
                + Add Support Section
            </a>
        </div>

        @if ($travelSupports->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Features</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($travelSupports as $support)
                            <tr>
                                <td>
                                    <strong>{{ $support->heading }}</strong>
                                    @if ($support->small_heading)
                                        <small class="d-block text-muted" style="margin-top: 2px; font-size: 0.8rem;">{{ $support->small_heading }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ \Illuminate\Support\Str::limit(strip_tags($support->description), 80) }}
                                </td>
                                <td>
                                    @if ($support->image)
                                        <img src="{{ asset('storage/' . $support->image) }}" alt="{{ $support->heading }}" class="blog-table-image">
                                    @else
                                        <small class="text-muted">No image</small>
                                    @endif
                                </td>
                                <td>
                                    @if ($support->features)
                                        <div style="display: flex; flex-direction: column; gap: 2px;">
                                            @foreach ($support->features as $feature)
                                                <span style="background-color: #f3f4f6; color: #4b5563; font-size: 0.75rem; padding: 2px 8px; border-radius: 4px; border: 1px solid #e5e7eb; display: inline-block; white-space: nowrap; margin-bottom: 2px;">{{ $feature }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge {{ $support->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $support->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.travel-support.edit', $support) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.travel-support.destroy', $support) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this support section?')">
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

            @if ($travelSupports->hasPages())
                <div class="pagination-wrapper">
                    {{ $travelSupports->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No support sections found.</strong>
                <p>Add your first Travel Support record.</p>
                <a href="{{ route('admin.travel-support.create') }}" class="btn btn-primary">
                    Create Section
                </a>
            </div>
        @endif
    </div>
@endsection
