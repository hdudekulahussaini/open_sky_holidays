@extends('admin.layouts.app')

@section('title', 'Counters')
@section('page-title', 'Counters')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>Counters</h3>
                <p>Manage counter statistics displayed on the website.</p>
            </div>

            <a href="{{ route('admin.counters.create') }}" class="btn btn-primary">
                + Add Counter
            </a>
        </div>

        @if ($counters->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Value</th>
                            <th>Name / Label</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($counters as $counter)
                            <tr>
                                <td>#{{ $counter->id }}</td>
                                <td><strong>{{ $counter->value }}</strong></td>
                                <td>{{ $counter->name }}</td>
                                <td>
                                    <span class="status-badge {{ $counter->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $counter->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.counters.edit', $counter) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.counters.destroy', $counter) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this counter?')">
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

            @if ($counters->hasPages())
                <div class="pagination-wrapper">
                    {{ $counters->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No counters found.</strong>
                <p>Add your first Counter statistic.</p>
                <a href="{{ route('admin.counters.create') }}" class="btn btn-primary">
                    Create Counter
                </a>
            </div>
        @endif
    </div>
@endsection
