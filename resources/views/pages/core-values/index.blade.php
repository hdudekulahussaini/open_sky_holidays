@extends('admin.layouts.app')

@section('title', 'Core Values')
@section('page-title', 'Core Values')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Core Values</h1>
                <p>Manage core values displayed on the website.</p>
            </div>

            <a href="{{ route('admin.core-values.create') }}" class="ts-primary-btn">
                <span>+</span> Add Core Value
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Core Values</h2>
                    <p>Total records: <strong>{{ $coreValues->count() }}</strong></p>
                </div>
            </div>

        @if ($coreValues->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                        @foreach ($coreValues as $coreValue)
                            <tr>
                                <td>#{{ $coreValue->id }}</td>
                                <td><strong>{{ $coreValue->heading }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit(strip_tags($coreValue->description), 100) }}</td>
                                <td>
                                    <span class="ts-status-badge {{ $coreValue->status === 'active' ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
                                        {{ ucfirst($coreValue->status ?? 'Active') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.core-values.edit', $coreValue) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.core-values.destroy', $coreValue) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this core value?')">
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

            @if ($coreValues->hasPages())
                <div class="ts-pagination">
                    {{ $coreValues->links() }}
                </div>
            @endif
            </div>
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No core values found.</h3>
                <p>Create your first Core Value.</p>
                <a href="{{ route('admin.core-values.create') }}" class="ts-primary-btn">
                    Create Core Value
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
