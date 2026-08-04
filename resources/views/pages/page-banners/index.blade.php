@extends('admin.layouts.app')

@section('title', 'Page Banners')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Banner Management
                </span>

                <h1>Page Banners</h1>

                <p>
                    Manage page banner sections.
                </p>
            </div>

            <a href="{{ route('admin.page-banners.create') }}"
                class="ts-primary-btn">
                <span>+</span>
                Add Page Banner
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Page Banners List</h2>

                    <p>
                        Total records:
                        <strong>{{ $pageBanners->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                                    <span class="status-badge status-active">
                                        {{ ucfirst($banner->page) }}
                                    </span>
                                </td>
                                <td>{{ $banner->label ?? '-' }}</td>
                                <td>{{ $banner->title }}</td>
                                <td>{{ $banner->description ?? '-' }}</td>
                                <td>{{ $banner->breadcrumb_title ?? '-' }}</td>
                                <td>
                                    <span class="status-badge {{ $banner->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $banner->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.page-banners.edit', $banner) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.page-banners.destroy', $banner) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this banner?')">
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
                                <td colspan="9">
                                    <div class="ts-empty-state">
                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No page banners found</h3>

                                        <p>
                                            Create your first page banner.
                                        </p>

                                        <a href="{{ route('admin.page-banners.create') }}" class="ts-primary-btn">
                                            Create Page Banner
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pageBanners->hasPages())
                <div class="ts-pagination">
                    {{ $pageBanners->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection