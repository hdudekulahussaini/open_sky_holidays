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
                            <th class="ts-action-column">Actions</th>
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
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.our-processes.edit', $ourProcess) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.our-processes.destroy', $ourProcess) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this process?')">
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
