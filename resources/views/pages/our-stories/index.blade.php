@extends('admin.layouts.app')

@section('title', 'Our Stories')
@section('page-title', 'Our Stories')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Our Stories
                </span>

                <h1>Our Stories</h1>

                <p>
                    Manage company stories and timeline milestones.
                </p>
            </div>

            <a href="{{ route('admin.our-stories.create') }}"
                class="ts-primary-btn">
                <span>+</span>
                Add Our Story
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Our Stories List</h2>

                    <p>
                        Total records:
                        <strong>{{ $ourStories->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                        @forelse ($ourStories as $story)
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
                                        <a href="{{ route('admin.our-stories.edit', $story) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.our-stories.destroy', $story) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this story?')">
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

                                        <h3>No stories found</h3>

                                        <p>
                                            Add your first Our Story record.
                                        </p>

                                        <a href="{{ route('admin.our-stories.create') }}" class="ts-primary-btn">
                                            Create Story
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($ourStories->hasPages())
                <div class="ts-pagination">
                    {{ $ourStories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
