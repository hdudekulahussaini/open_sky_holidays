@extends('admin.layouts.app')

@section('title', 'Authors')
@section('page-title', 'Authors')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Blog Authors</h1>
                <p>Manage blog authors and their social profiles.</p>
            </div>

            <a href="{{ route('admin.authors.create') }}" class="ts-primary-btn">
                <span>+</span> Add Author
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Blog Authors</h2>
                    <p>Total records: <strong>{{ $authors->count() }}</strong></p>
                </div>
            </div>

        @if ($authors->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($authors as $author)
                            <tr>
                                <td>#{{ $author->id }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if ($author->image)
                                            <img
                                                src="{{ asset('storage/' . $author->image) }}"
                                                alt="{{ $author->name }}"
                                                width="40"
                                                height="40"
                                                style="object-fit: cover; border-radius: 50%;"
                                            >
                                        @else
                                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #475569;">
                                                {{ strtoupper(substr($author->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <strong>{{ $author->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($author->description, 80) }}</td>
                                <td>
                                    <span class="ts-status-badge {{ $author->status ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
                                        {{ $author->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $author->created_at ? $author->created_at->format('d M Y') : 'Not Set' }}
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.authors.edit', $author) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this author?')">
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

            @if ($authors->hasPages())
                <div class="ts-pagination">
                    {{ $authors->links() }}
                </div>
            @endif
            </div>
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No authors found.</h3>
                <p>Create your first blog author.</p>
                <a href="{{ route('admin.authors.create') }}" class="ts-primary-btn">
                    Create Author
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
