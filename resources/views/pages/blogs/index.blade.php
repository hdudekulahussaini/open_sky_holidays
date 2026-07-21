@extends('admin.layouts.app')

@section('title', 'Blogs')
@section('page-title', 'Blogs')

@section('content')
    <div class="admin-card">

        <div class="admin-card-header">
            <div>
                <h3>Travel Blogs</h3>
                <p>Manage travel blog listing and blog details content.</p>
            </div>

            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                Add Blog
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($blogs->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Blog</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Read Time</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $blog)
                            <tr>
                                <td>#{{ $blog->id }}</td>
                                <td>
                                    <strong>{{ $blog->title }}</strong>
                                    @if ($blog->featured_image)
                                        <small>
                                            <a href="{{ asset('storage/' . $blog->featured_image) }}" target="_blank">
                                                View Image
                                            </a>
                                        </small>
                                    @endif
                                </td>
                                <td>{{ $blog->category?->name ?? 'No Category' }}</td>
                                <td>{{ $blog->author?->name ?? 'Open Sky Team' }}</td>
                                <td>{{ $blog->read_time }} min</td>
                                <td>
                                    <span class="status-badge {{ $blog->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $blog->status ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $blog->published_at ? $blog->published_at->format('d M Y') : 'Not Published' }}
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this blog?')">
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

            @if ($blogs->hasPages())
                <div class="pagination-wrapper" style="padding: 20px 24px;">
                    {{ $blogs->links() }}
                </div>
            @endif
        @else
            <div class="empty-table" style="padding: 40px; text-align: center;">
                <strong>No blogs found.</strong>
                <p>Create your first travel blog.</p>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                    Create Blog
                </a>
            </div>
        @endif

    </div>
@endsection