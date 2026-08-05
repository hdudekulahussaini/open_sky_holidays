@extends('admin.layouts.app')

@section('title', 'Travel Support')
@section('page-title', 'Travel Support')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Travel Support</h1>
                <p>Manage travel support sections and contact options.</p>
            </div>

            <a href="{{ route('admin.travel-support.create') }}" class="ts-primary-btn">
                <span>+</span> Add Support Section
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Travel Support</h2>
                    <p>Total records: <strong>{{ $travelSupports->count() }}</strong></p>
                </div>
            </div>

        @if ($travelSupports->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Features</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($travelSupports as $support)
                            <tr>
                                <td>
                                    <strong>{{ $support->heading }}</strong>
                                    @if ($support->small_heading)
                                        <small class="d-block text-muted" style="margin-top: 2px; font-size: 0.8rem;">{{ $support->small_heading }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ \Illuminate\Support\Str::limit(strip_tags($support->description), 80) }}
                                </td>
                                <td>
                                    @if ($support->image)
                                        <img src="{{ asset('storage/' . $support->image) }}" alt="{{ $support->heading }}" class="blog-table-image">
                                    @else
                                        <small class="text-muted">No image</small>
                                    @endif
                                </td>
                                <td>
                                    @if (is_array($support->features))
                                        <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                            @foreach ($support->features as $feature)
                                                <span style="background-color: #f3f4f6; color: #4b5563; font-size: 0.75rem; padding: 2px 8px; border-radius: 4px; border: 1px solid #e5e7eb; display: inline-block; white-space: nowrap; margin-bottom: 2px;">{{ $feature }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="ts-status-badge {{ $support->status ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
                                        {{ $support->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.travel-support.edit', $support) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.travel-support.destroy', $support) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this support section?')">
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

            @if ($travelSupports->hasPages())
                <div class="ts-pagination">
                    {{ $travelSupports->links() }}
                </div>
            @endif
            </div> {{-- end list card for when there are records --}}
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No support sections found.</h3>
                <p>Add your first Travel Support record.</p>
                <a href="{{ route('admin.travel-support.create') }}" class="ts-primary-btn">
                    Create Section
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
