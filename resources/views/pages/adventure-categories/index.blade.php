@extends('admin.layouts.app')

@section('title', 'Adventure Categories')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Adventure Management
                </span>

                <h1>Adventure Categories</h1>

                <p>
                    Manage category names, slugs and status.
                </p>
            </div>

            <a href="{{ route('admin.adventure-categories.create') }}"
                class="ts-primary-btn">
                <span>+</span>
                Add Category
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Adventure Categories List</h2>

                    <p>
                        Total records:
                        <strong>{{ $categories->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Adventure Content</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>#{{ $category->id }}</td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td>
                                    <span class="status-badge {{ $category->adventure ? 'status-active' : 'status-inactive' }}">
                                        {{ $category->adventure ? 'Content Added' : 'Content Pending' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $category->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                        {{ ucfirst($category->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.adventure-categories.edit', $category) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.adventure-categories.destroy', $category) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this category? Related adventure content will also be deleted.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ts-action-btn ts-delete-btn">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="ts-empty-state">
                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No Categories Found</h3>

                                        <p>
                                            Add your first adventure category.
                                        </p>

                                        <a href="{{ route('admin.adventure-categories.create') }}" class="ts-primary-btn">
                                            Add Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="ts-pagination">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection