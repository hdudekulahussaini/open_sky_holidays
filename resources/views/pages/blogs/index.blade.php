@extends('admin.layouts.app')

@section('title', 'Blogs')
@section('page-title', 'Blogs')

@section('content')
    <div class="admin-card">

        <div class="admin-card-header">
            <div>
                <h3>Travel Blogs</h3>

                <p>
                    Manage travel blog listings, table of contents,
                    images, and complete blog content.
                </p>
            </div>

            <a
                href="{{ route('admin.blogs.create') }}"
                class="btn btn-primary"
            >
                Add Blog
            </a>
        </div>


        @if ($blogs->count() > 0)

            <div class="table-responsive">
                <table class="admin-table">

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
                        @foreach ($blogs as $blog)
                            <tr>
                                {{-- ID --}}
                                <td>
                                    #{{ $blog->id }}
                                </td>

                                {{-- Blog --}}
                                <td>
                                    <div class="blog-table-info">

                                        @if ($blog->featured_image)
                                            <img
                                                src="{{ asset(
                                                    'storage/' .
                                                    $blog->featured_image
                                                ) }}"
                                                alt="{{ $blog->title }}"
                                                class="blog-table-image"
                                            >
                                        @endif

                                        <div>
                                            <strong>
                                                {{ $blog->title }}
                                            </strong>

                                            <small>
                                                {{ $blog->slug }}
                                            </small>

                                            @if ($blog->featured_image)
                                                <a
                                                    href="{{ asset(
                                                        'storage/' .
                                                        $blog->featured_image
                                                    ) }}"
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

                                {{-- Category --}}
                                <td>
                                    {{ $blog->category?->name
                                        ?? 'No Category' }}
                                </td>

                                {{-- Author --}}
                                <td>
                                    {{ $blog->author?->name
                                        ?? 'Open Sky Team' }}
                                </td>

                                {{-- Table of Contents count --}}
                                <td>
                                    @php
                                        $tocCount = $blog->sections
                                            ? count($blog->sections)
                                            : 0;
                                    @endphp

                                    <span class="toc-count-badge">
                                        {{ $tocCount }}
                                        {{ $tocCount === 1
                                            ? 'Section'
                                            : 'Sections' }}
                                    </span>
                                </td>

                                {{-- Read Time --}}
                                <td>
                                    {{ $blog->read_time }} min
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span
                                        class="status-badge
                                            {{ $blog->status
                                                ? 'status-active'
                                                : 'status-inactive' }}"
                                    >
                                        {{ $blog->status
                                            ? 'Published'
                                            : 'Draft' }}
                                    </span>
                                </td>

                                {{-- Published date --}}
                                <td>
                                    {{ $blog->published_at
                                        ? $blog->published_at
                                            ->format('d M Y')
                                        : 'Not Published' }}
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
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
                        @endforeach
                    </tbody>

                </table>
            </div>

            {{-- Pagination --}}
            @if ($blogs->hasPages())
                <div class="pagination-wrapper">
                    {{ $blogs->links() }}
                </div>
            @endif

        @else

            <div class="empty-table">
                <strong>No blogs found.</strong>

                <p>
                    Create your first travel blog.
                </p>

                <a
                    href="{{ route('admin.blogs.create') }}"
                    class="btn btn-primary"
                >
                    Create Blog
                </a>
            </div>

        @endif
        
    </div>
@endsection