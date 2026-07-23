@extends('admin.layouts.app')

@section('title', 'What We Offer')
@section('page-title', 'What We Offer')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3>What We Offer</h3>
                <p>Manage travel solutions, descriptions, images, and status.</p>
            </div>

            <a href="{{ route('admin.what-we-offers.create') }}" class="btn btn-primary">
                + Add Offer
            </a>
        </div>

        @if ($whatWeOffers->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whatWeOffers as $offer)
                            <tr>
                                <td>#{{ $offer->id }}</td>
                                <td>
                                    @if ($offer->image)
                                        <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->title }}" class="blog-table-image">
                                    @else
                                        <small>No image</small>
                                    @endif
                                </td>
                                <td><strong>{{ $offer->title }}</strong></td>
                                <td>{{ $offer->subtitle ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($offer->description, 90) }}</td>
                                <td>
                                    <span class="status-badge {{ $offer->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $offer->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.what-we-offers.edit', $offer) }}" class="action-button action-edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.what-we-offers.destroy', $offer) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this offer?')">
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

            @if ($whatWeOffers->hasPages())
                <div class="pagination-wrapper">
                    {{ $whatWeOffers->links() }}
                </div>
            @endif
        @else
            <div class="empty-table">
                <strong>No items found.</strong>
                <p>Add your first What We Offer item.</p>
                <a href="{{ route('admin.what-we-offers.create') }}" class="btn btn-primary">
                    Create Item
                </a>
            </div>
        @endif
    </div>
@endsection