@extends('admin.layouts.app')

@section('title', 'Blogs')
@section('page-title', 'Blogs')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Blog Management
                </span>

                <h1>Blogs</h1>

                <p>
                    Manage travel blog listings, table of contents, images, and complete blog content.
                </p>
            </div>

            <a href="{{ route('admin.blogs.create') }}"
                class="ts-primary-btn">
                <span>+</span>
                Add Blog
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Travel Blogs List</h2>

                    <p>
                        Total records:
                        <strong>{{ $blogs->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Blog</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Sections</th>
                            <th>Read Time</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $blog)
                            <tr>
                                <td>#{{ $blog->id }}</td>
                                <td>
                                    <div class="blog-table-info">
                                        @if ($blog->featured_image)
                                            <img
                                                src="{{ asset('storage/' . $blog->featured_image) }}"
                                                alt="{{ $blog->title }}"
                                                class="blog-table-image"
                                            >
                                        @endif
                                        <div>
                                            <strong>{{ $blog->title }}</strong>
                                            <small>{{ $blog->slug }}</small>
                                            @if ($blog->featured_image)
                                                <a
                                                    href="{{ asset('storage/' . $blog->featured_image) }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="blog-image-link"
                                                >
                                                    View Image
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $blog->category?->name ?? 'No Category' }}</td>
                                <td>{{ $blog->author?->name ?? 'Open Sky Team' }}</td>
                                <td>
                                    @php
                                        $tocCount = is_array($blog->table_of_contents)
                                            ? count($blog->table_of_contents)
                                            : 0;
                                    @endphp
                                    <span class="toc-count-badge">
                                        {{ $tocCount }}
                                        {{ $tocCount === 1 ? 'Section' : 'Sections' }}
                                    </span>
                                </td>
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
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.blogs.edit', $blog) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this blog?')">
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

                                        <h3>No blogs found</h3>

                                        <p>
                                            Create your first travel blog.
                                        </p>

                                        <a href="{{ route('admin.blogs.create') }}" class="ts-primary-btn">
                                            Create Blog
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($blogs->hasPages())
                <div class="ts-pagination">
                    {{ $blogs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection