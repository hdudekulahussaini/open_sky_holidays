@extends('admin.layouts.app')

@section('title', 'Our Processes')
@section('page-title', 'Our Processes')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Our Processes</h1>
                <p>Manage process sections displayed on the website.</p>
            </div>

            <a href="{{ route('admin.our-processes.create') }}" class="ts-primary-btn">
                <span>+</span> Add Our Process
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Our Processes</h2>
                    <p>Total records: <strong>{{ $ourProcesses->count() }}</strong></p>
                </div>
            </div>

        @if ($ourProcesses->count() > 0)
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
                                    <span class="ts-status-badge {{ $ourProcess->status ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
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
                <div class="ts-pagination">
                    {{ $ourProcesses->links() }}
                </div>
            @endif
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No processes found.</h3>
                <p>Add your first Our Process item.</p>
                <a href="{{ route('admin.our-processes.create') }}" class="ts-primary-btn">
                    Create Process
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
