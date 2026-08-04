@extends('admin.layouts.app')

@section('title', 'Page Banners')

@section('content')
<div class="container-fluid">
    <div
        class="d-flex justify-content-between
                   align-items-center mb-4">
        <div>
            <h2 class="mb-1">Page Banners</h2>

            <p class="text-muted mb-0">
                Manage page banner sections.
            </p>
        </div>

        @if ($hasAvailablePages)
        <a
            href="{{ route('admin.page-banners.create') }}"
            class="btn btn-primary">
            Add Page Banner
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table
                    class="table table-bordered
                               table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Page</th>
                            <th>Label</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Breadcrumb Title</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pageBanners as $banner)
                        <tr>
                            <td>{{ $banner->id }}</td>

                            <td>
                                @if ($banner->image)
                                <img
                                    src="{{ asset('storage/' . $banner->image) }}"
                                    alt="{{ $banner->title }}"
                                    width="130"
                                    height="70"
                                    style="object-fit: cover; border-radius: 8px;">
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ ucfirst($banner->page) }}
                                </span>
                            </td>

                            <td>{{ $banner->label ?? '-' }}</td>

                            <td>{{ $banner->title }}</td>

                            <td>{{ $banner->description ?? '-' }}</td>

                            <td>{{ $banner->breadcrumb_title ?? '-' }}</td>

                            <td>
                                @if ($banner->status)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div class="ts-actions">
                                    <a
                                        href="{{ route('admin.page-banners.edit', $banner) }}"
                                        class="ts-action-btn ts-edit-btn">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.page-banners.destroy', $banner) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this banner?')">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="ts-action-btn ts-delete-btn">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                No page banners found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pageBanners->links() }}
            </div>
        </div>
    </div>
</div>
@endsection