@extends('admin.layouts.app')

@section('title', 'Tour Features')
@section('page-title', 'Tour Features')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Tour Management
                </span>
                <h1>Tour Features</h1>
                <p>Manage tour package inclusions and covered places.</p>
            </div>

            <a href="{{ route('admin.tour-features.create') }}" class="ts-primary-btn">
                <span>+</span> Add Tour Feature
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Tour Features</h2>
                    <p>Total records: <strong>{{ $tourFeatures->count() }}</strong></p>
                </div>
            </div>

        @if ($tourFeatures->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tour</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tourFeatures as $feature)
                            <tr>
                                <td>#{{ $feature->id }}</td>
                                <td><strong>{{ $feature->tour?->title ?? 'Global / Unassigned' }}</strong></td>
                                <td>{{ $feature->title }}</td>
                                <td><span class="toc-count-badge">{{ ucfirst(str_replace('_', ' ', $feature->type ?? 'feature')) }}</span></td>
                                <td>
                                    <span class="ts-status-badge {{ $feature->status ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
                                        {{ $feature->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.tour-features.edit', $feature) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.tour-features.destroy', $feature) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feature?')">
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

            @if ($tourFeatures->hasPages())
                <div class="ts-pagination">
                    {{ $tourFeatures->links() }}
                </div>
            @endif
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No tour features found.</h3>
                <p>Add your first Tour Feature record.</p>
                <a href="{{ route('admin.tour-features.create') }}" class="ts-primary-btn">
                    Create Feature
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
