@extends('admin.layouts.app')

@section('title', 'Authors')
@section('page-title', 'Authors')

@section('content')
    <div class="admin-card">

        <div class="admin-card-header">
            <div>
                <h3>Blog Authors</h3>
                <p>Manage blog authors and their social profiles.</p>
            </div>

            <a href="{{ route('admin.authors.create') }}" class="btn btn-primary">
                Add Author
            </a>
        </div>


        @if ($authors->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
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
                                    <span class="status-badge {{ $author->status ? 'status-active' : 'status-inactive' }}">
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
                <div class="pagination-wrapper" style="padding: 20px 24px;">
                    {{ $authors->links() }}
                </div>
            @endif
        @else
            <div class="empty-table" style="padding: 40px; text-align: center;">
                <strong>No authors found.</strong>
                <p>Create your first blog author.</p>
                <a href="{{ route('admin.authors.create') }}" class="btn btn-primary" style="margin-top: 15px;">
                    Create Author
                </a>
            </div>
        @endif

    </div>
@endsection