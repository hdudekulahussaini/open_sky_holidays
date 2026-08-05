@extends('admin.layouts.app')

@section('title', 'Adventure Categories')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Adventures Management
                </span>
                <h1>Adventure Categories</h1>
                <p>Manage category names, slugs and status.</p>
            </div>

            <a href="{{ route('admin.adventure-categories.create') }}" class="ts-primary-btn">
                <span>+</span> Add Category
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Category List</h2>
                    <p>Total records: <strong>{{ $categories->total() }}</strong></p>
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
                            <th>Adventure Content</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>#{{ $category->id }}</td>

                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>

                            <td>
                                <code>{{ $category->slug }}</code>
                            </td>

                            <td>
                                @if ($category->adventure)
                                <span class="ts-status-badge ts-active">
                                    <span></span> Content Added
                                </span>
                                @else
                                <span class="ts-status-badge ts-inactive">
                                    <span></span> Content Pending
                                </span>
                                @endif
                            </td>

                            <td>
                                @if ($category->status === 'active')
                                <span class="ts-status-badge ts-active">
                                    <span></span> Active
                                </span>
                                @else
                                <span class="ts-status-badge ts-inactive">
                                    <span></span> Inactive
                                </span>
                                @endif
                            </td>

                            <td>
                                <div class="ts-actions">
                                    <a href="{{ route('admin.adventure-categories.edit', $category) }}" class="ts-action-btn ts-edit-btn">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.adventure-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category? Related adventure content will also be deleted.');">
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
            </div> {{-- end list card for when there are records --}}
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No Categories Found</h3>
                <p>Add your first adventure category.</p>
                <a href="{{ route('admin.adventure-categories.create') }}" class="ts-primary-btn">
                    Add Category
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
