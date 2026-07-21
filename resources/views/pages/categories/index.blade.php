@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    <div class="admin-card">

        <div class="admin-card-header">
            <div>
                <h3>Blog Categories</h3>
                <p>Manage categories used for travel blogs.</p>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                Add Category
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($categories->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Total Blogs</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>#{{ $category->id }}</td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->blogs_count }}</td>
                                <td>
                                    {{ $category->created_at ? $category->created_at->format('d M Y') : 'Not Set' }}
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this category?')">
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

            @if ($categories->hasPages())
                <div class="pagination-wrapper" style="padding: 20px 24px;">
                    {{ $categories->links() }}
                </div>
            @endif
        @else
            <div class="empty-table" style="padding: 40px; text-align: center;">
                <strong>No categories found.</strong>
                <p>Create your first blog category.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                    Create Category
                </a>
            </div>
        @endif

    </div>
@endsection