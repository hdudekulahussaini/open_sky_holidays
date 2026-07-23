@extends('admin.layouts.app')

@section('title', 'Our Stories')
@section('page-title', 'Our Stories')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>Our Stories</h3>
                <p>Manage company stories and timeline milestones.</p>
            </div>

            <a href="{{ route('admin.our-stories.create') }}" class="btn btn-primary">
                + Add Our Story
            </a>
        </div>

        @if ($ourStories->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ourStories as $story)
                            <tr>
                                <td>#{{ $story->id }}</td>
                                <td>
                                    @if ($story->image)
                                        <img src="{{ asset('storage/' . $story->image) }}" alt="{{ $story->heading }}" class="blog-table-image">
                                    @else
                                        <small>No image</small>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $story->heading }}</strong>
                                    @if ($story->small_heading)
                                        <small>{{ $story->small_heading }}</small>
                                    @endif
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit(strip_tags($story->description), 100) }}</td>
                                <td>
                                    <span class="status-badge {{ $story->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $story->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.our-stories.edit', $story) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.our-stories.destroy', $story) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this story?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-button action-delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6l-1 14H6L5 6"></path>
                                                    <path d="M10 11v6"></path>
                                                    <path d="M14 11v6"></path>
                                                    <path d="M9 6V4h6v2"></path>
                                                </svg>
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

            @if ($ourStories->hasPages())
                <div class="pagination-wrapper">
                    {{ $ourStories->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No stories found.</strong>
                <p>Add your first Our Story record.</p>
                <a href="{{ route('admin.our-stories.create') }}" class="btn btn-primary">
                    Create Story
                </a>
            </div>
        @endif
    </div>
@endsection
