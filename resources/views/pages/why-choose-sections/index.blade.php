@extends('admin.layouts.app')

@section('title', 'Why Choose Us')
@section('page-title', 'Why Choose Us')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>Why Choose Us</h3>
                <p>Manage the Why Choose Us sections displayed on the website.</p>
            </div>

            <a href="{{ route('admin.why-choose-sections.create') }}" class="btn btn-primary">
                + Add Section
            </a>
        </div>

        @if ($whyChooseSections->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whyChooseSections as $section)
                            <tr>
                                <td>#{{ $section->id }}</td>
                                <td><strong>{{ $section->title }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($section->description, 100) }}</td>
                                <td>{{ $section->sort_order }}</td>
                                <td>
                                    <span class="status-badge {{ $section->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $section->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.why-choose-sections.edit', $section) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.why-choose-sections.destroy', $section) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this section?')">
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

            @if ($whyChooseSections->hasPages())
                <div class="pagination-wrapper">
                    {{ $whyChooseSections->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No sections found.</strong>
                <p>Add your first Why Choose Us section.</p>
                <a href="{{ route('admin.why-choose-sections.create') }}" class="btn btn-primary">
                    Create Section
                </a>
            </div>
        @endif
    </div>
@endsection