@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Blog Categories</h1>
                <p>Manage categories used for travel blogs.</p>
            </div>

            <a href="{{ route('admin.categories.create') }}" class="ts-primary-btn">
                <span>+</span> Add Category
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Blog Categories</h2>
                    <p>Total records: <strong>{{ $categories->count() }}</strong></p>
                </div>
            </div>

        @if ($categories->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                <div class="ts-pagination">
                    {{ $categories->links() }}
                </div>
            @endif
            </div>
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No categories found.</h3>
                <p>Create your first blog category.</p>
                <a href="{{ route('admin.categories.create') }}" class="ts-primary-btn">
                    Create Category
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
