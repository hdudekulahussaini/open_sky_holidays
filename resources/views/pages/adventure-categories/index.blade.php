@extends('admin.layouts.app')

@section('title', 'Adventure Categories')

@section('content')
<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Adventure Categories</h2>

            <p class="text-muted mb-0">
                Manage category names, slugs and status.
            </p>
        </div>

        <a
            href="{{ route('admin.adventure-categories.create') }}"
            class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Add Category
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-0">
                    Category List
                </h5>

                <span class="badge bg-light text-dark">
                    Total: {{ $categories->total() }}
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Adventure Content</th>
                            <th>Status</th>
                            <th class="text-end px-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td class="px-4">
                                #{{ $category->id }}
                            </td>

                            <td>
                                <strong>{{ $category->name }}</strong>
                            </td>

                            <td>
                                <code>{{ $category->slug }}</code>
                            </td>

                            <td>
                                @if ($category->adventure)
                                <span class="badge bg-success">
                                    Content Added
                                </span>
                                @else
                                <span class="badge bg-warning text-dark">
                                    Content Pending
                                </span>
                                @endif
                            </td>

                            <td>
                                @if ($category->status === 'active')
                                <span class="badge bg-success">
                                    Active
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    Inactive
                                </span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a
                                        href="{{ route(
                                                'admin.adventure-categories.edit',
                                                $category
                                            ) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-pen me-1"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route(
                                                'admin.adventure-categories.destroy',
                                                $category
                                            ) }}"
                                        method="POST"
                                        onsubmit="
                                                return confirm(
                                                    'Delete this category? Related adventure content will also be deleted.'
                                                );
                                            ">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash me-1"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td
                                colspan="6"
                                class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3"></i>

                                    <h5>No Categories Found</h5>

                                    <p>
                                        Add your first adventure category.
                                    </p>

                                    <a
                                        href="{{ route(
                                                'admin.adventure-categories.create'
                                            ) }}"
                                        class="btn btn-primary">
                                        Add Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($categories->hasPages())
        <div class="card-footer bg-white border-top py-3">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection