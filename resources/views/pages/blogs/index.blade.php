@extends('admin.layouts.app')

@section('title', 'Blogs')
@section('page-title', 'Blogs')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Travel Blogs</h1>
                <p>Manage travel blog listings, table of contents, images, and complete blog content.</p>
            </div>

            <a href="{{ route('admin.blogs.create') }}" class="ts-primary-btn">
                <span>+</span> Add Blog
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Travel Blogs</h2>
                    <p>Total records: <strong>{{ $blogs->total() }}</strong></p>
                </div>
            </div>

        @if ($blogs->count() > 0)
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
                        @foreach ($blogs as $blog)
                            <tr>
                                <td>#{{ $blog->id }}</td>
                                <td>
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        @if ($blog->featured_image)
                                            <img
                                                src="{{ asset('storage/' . $blog->featured_image) }}"
                                                alt="{{ $blog->title }}"
                                                width="60"
                                                height="40"
                                                style="border-radius: 4px; object-fit: cover;"
                                            >
                                        @endif
                                        <div>
                                            <strong>{{ $blog->title }}</strong>
                                            @if ($blog->description)
                                                <div style="font-size: 12px; color: #64748b; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $blog->description }}">
                                                    {{ $blog->description }}
                                                </div>
                                            @else
                                                <div style="font-size: 12px; color: #94a3b8;">{{ $blog->slug }}</div>
                                            @endif
                                            @if ($blog->featured_image)
                                                <a href="{{ asset('storage/' . $blog->featured_image) }}" target="_blank" rel="noopener noreferrer" style="font-size: 11px; color: var(--ts-primary);">
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
                                    <span class="ts-status-badge ts-primary">
                                        <span></span>
                                        {{ $tocCount }} {{ $tocCount === 1 ? 'Section' : 'Sections' }}
                                    </span>
                                </td>
                                <td>{{ $blog->read_time }} min</td>
                                <td>
                                    <span class="ts-status-badge {{ $blog->status ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
                                        {{ $blog->status ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $blog->published_at ? $blog->published_at->format('d M Y') : 'Not Published' }}
                                </td>
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

            @if ($blogs->hasPages())
                <div class="ts-pagination">
                    {{ $blogs->links() }}
                </div>
            @endif
            </div>
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No blogs found.</h3>
                <p>Create your first travel blog.</p>
                <a href="{{ route('admin.blogs.create') }}" class="ts-primary-btn">
                    Create Blog
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
