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
                            <th class="ts-action-column">Actions</th>
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
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
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