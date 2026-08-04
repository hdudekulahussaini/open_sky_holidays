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
                            <th class="ts-action-column">Actions</th>
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
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.counters.edit', $counter) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.counters.destroy', $counter) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this counter?')">
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
