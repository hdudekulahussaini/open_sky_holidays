@extends('admin.layouts.app')

@section('title', 'About Why Choose Us')
@section('page-title', 'About Why Choose Us')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>About Why Choose Us</h3>
                <p>Manage title, description, image, features, and status.</p>
            </div>

            <a href="{{ route('admin.about-why-choose-us.create') }}" class="btn btn-primary">
                + Add Section
            </a>
        </div>

        @if ($sections->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sections as $section)
                            <tr>
                                <td>#{{ $section->id }}</td>
                                <td>
                                    @if ($section->image)
                                        <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title }}" class="blog-table-image">
                                    @else
                                        <small>No image</small>
                                    @endif
                                </td>
                                <td><strong>{{ $section->title }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($section->description, 100) }}</td>
                                <td>
                                    <span class="status-badge {{ $section->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $section->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.about-why-choose-us.edit', $section) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.about-why-choose-us.destroy', $section) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this record?')">
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

            @if ($sections->hasPages())
                <div class="pagination-wrapper">
                    {{ $sections->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No sections found.</strong>
                <p>Create your first About Why Choose Us section.</p>
                <a href="{{ route('admin.about-why-choose-us.create') }}" class="btn btn-primary">
                    Create Section
                </a>
            </div>
        @endif
    </div>
@endsection