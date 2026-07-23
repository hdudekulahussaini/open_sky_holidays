@extends('admin.layouts.app')

@section('title', 'About Our Core Values')
@section('page-title', 'About Our Core Values')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>About Our Core Values</h3>
                <p>Manage the core value titles and descriptions.</p>
            </div>

            <a href="{{ route('admin.about-our-core-values.create') }}" class="btn btn-primary">
                + Add Core Value
            </a>
        </div>

        @if ($coreValues->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coreValues as $coreValue)
                            <tr>
                                <td>#{{ $coreValue->id }}</td>
                                <td><strong>{{ $coreValue->title }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($coreValue->description, 120) }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.about-our-core-values.edit', $coreValue) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.about-our-core-values.destroy', $coreValue) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this core value?')">
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

            @if ($coreValues->hasPages())
                <div class="pagination-wrapper">
                    {{ $coreValues->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No core values found.</strong>
                <p>Add your first About Our Core Value.</p>
                <a href="{{ route('admin.about-our-core-values.create') }}" class="btn btn-primary">
                    Create Core Value
                </a>
            </div>
        @endif
    </div>
@endsection