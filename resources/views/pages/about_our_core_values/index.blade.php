@extends('admin.layouts.app')

@section('title', 'About Our Core Values')
@section('page-title', 'About Our Core Values')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>About Our Core Values</h3>
                <p>Manage the core value titles and descriptions.</p>
            </div>

            <a href="{{ route('admin.about-our-core-values.create') }}" class="btn btn-primary">
                + Add Core Value
            </a>
        </div>

        @if ($coreValues->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coreValues as $coreValue)
                            <tr>
                                <td>#{{ $coreValue->id }}</td>
                                <td><strong>{{ $coreValue->title }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($coreValue->description, 120) }}</td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.about-our-core-values.edit', $coreValue) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.about-our-core-values.destroy', $coreValue) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this core value?')">
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
                <div class="pagination-wrapper">
                    {{ $coreValues->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No core values found.</strong>
                <p>Add your first About Our Core Value.</p>
                <a href="{{ route('admin.about-our-core-values.create') }}" class="btn btn-primary">
                    Create Core Value
                </a>
            </div>
        @endif
    </div>
@endsection