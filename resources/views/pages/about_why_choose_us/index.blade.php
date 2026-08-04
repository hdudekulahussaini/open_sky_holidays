@extends('admin.layouts.app')

@section('title', 'About Why Choose Us')
@section('page-title', 'About Why Choose Us')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>About Why Choose Us</h3>
                <p>Manage title, description, image, features, and status.</p>
            </div>

            <a href="{{ route('admin.about-why-choose-us.create') }}" class="btn btn-primary">
                + Add Section
            </a>
        </div>

        @if ($sections->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sections as $section)
                            <tr>
                                <td>#{{ $section->id }}</td>
                                <td>
                                    @if ($section->image)
                                        <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title }}" class="blog-table-image">
                                    @else
                                        <small>No image</small>
                                    @endif
                                </td>
                                <td><strong>{{ $section->title }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($section->description, 100) }}</td>
                                <td>
                                    <span class="status-badge {{ $section->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $section->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.about-why-choose-us.edit', $section) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.about-why-choose-us.destroy', $section) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
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

            @if ($sections->hasPages())
                <div class="pagination-wrapper">
                    {{ $sections->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No sections found.</strong>
                <p>Create your first About Why Choose Us section.</p>
                <a href="{{ route('admin.about-why-choose-us.create') }}" class="btn btn-primary">
                    Create Section
                </a>
            </div>
        @endif
    </div>
@endsection