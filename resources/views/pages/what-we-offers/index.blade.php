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
                            <th class="ts-action-column">Actions</th>
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
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.what-we-offers.edit', $offer) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.what-we-offers.destroy', $offer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this offer?')">
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