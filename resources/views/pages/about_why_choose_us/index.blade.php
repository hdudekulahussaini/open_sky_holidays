@extends('admin.layouts.app')

@section('title', 'About Why Choose Us')
@section('page-title', 'About Why Choose Us')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>About Why Choose Us</h1>
                <p>Manage title, description, image, features, and status.</p>
            </div>

            <a href="{{ route('admin.about-why-choose-us.create') }}"
                class="ts-primary-btn">
                <span>+</span> Add Section
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>About Why Choose Us</h2>
                    <p>
                        Total records: <strong>{{ $sections->count() }}</strong>
                    </p>
                </div>
            </div>

        @if ($sections->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                                    <span class="ts-status-badge {{ $section->status ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
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
                <div class="ts-pagination">
                    {{ $sections->links() }}
                </div>
            @endif
            </div> {{-- end list card for when there are records --}}
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No sections found.</h3>
                <p>Create your first About Why Choose Us section.</p>
                <a href="{{ route('admin.about-why-choose-us.create') }}" class="ts-primary-btn">
                    Create Section
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection