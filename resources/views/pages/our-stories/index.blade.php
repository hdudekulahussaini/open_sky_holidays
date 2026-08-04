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
                            <th class="ts-action-column">Actions</th>
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
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit(strip_tags($story->description), 100) }}</td>
                                <td>
                                    <span class="status-badge {{ $story->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $story->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.our-stories.edit', $story) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.our-stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this story?')">
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
