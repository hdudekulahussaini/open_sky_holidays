@extends('admin.layouts.app')

@section('title', 'Counters')
@section('page-title', 'Counters')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Counters</h1>
                <p>Manage counter statistics displayed on the website.</p>
            </div>

            <a href="{{ route('admin.counters.create') }}" class="ts-primary-btn">
                <span>+</span> Add Counter
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Counters</h2>
                    <p>Total records: <strong>{{ $counters->count() }}</strong></p>
                </div>
            </div>

        @if ($counters->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                                    <span class="ts-status-badge {{ $counter->status ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
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
                <div class="ts-pagination">
                    {{ $counters->links() }}
                </div>
            @endif
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No counters found.</h3>
                <p>Add your first Counter statistic.</p>
                <a href="{{ route('admin.counters.create') }}" class="ts-primary-btn">
                    Create Counter
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
