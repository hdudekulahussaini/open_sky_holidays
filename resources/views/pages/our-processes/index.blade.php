@extends('admin.layouts.app')

@section('title', 'Our Processes')
@section('page-title', 'Our Processes')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>Our Processes</h3>
                <p>Manage process sections displayed on the website.</p>
            </div>

            <a href="{{ route('admin.our-processes.create') }}" class="btn btn-primary">
                + Add Our Process
            </a>
        </div>

        @if ($ourProcesses->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ourProcesses as $ourProcess)
                            <tr>
                                <td>#{{ $ourProcess->id }}</td>
                                <td>
                                    <strong>{{ $ourProcess->heading }}</strong>
                                    @if ($ourProcess->small_heading)
                                        <small>{{ $ourProcess->small_heading }}</small>
                                    @endif
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit(strip_tags($ourProcess->description), 100) }}</td>
                                <td>
                                    <span class="status-badge {{ $ourProcess->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $ourProcess->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.our-processes.edit', $ourProcess) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.our-processes.destroy', $ourProcess) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this process?')">
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

            @if ($ourProcesses->hasPages())
                <div class="pagination-wrapper">
                    {{ $ourProcesses->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No processes found.</strong>
                <p>Add your first Our Process item.</p>
                <a href="{{ route('admin.our-processes.create') }}" class="btn btn-primary">
                    Create Process
                </a>
            </div>
        @endif
    </div>
@endsection
