@extends('admin.layouts.app')

@section('title', 'What We Offer')
@section('page-title', 'What We Offer')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>What We Offer</h1>
                <p>Manage travel solutions, descriptions, images, and status.</p>
            </div>

            <a href="{{ route('admin.what-we-offers.create') }}" class="ts-primary-btn">
                <span>+</span> Add Offer
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>What We Offer</h2>
                    <p>Total records: <strong>{{ $whatWeOffers->count() }}</strong></p>
                </div>
            </div>

        @if ($whatWeOffers->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Icon</th>
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
                                <td>
                                    <div style="width: 34px; height: 34px; border-radius: 50%; background: #ffaa00; display: inline-flex; align-items: center; justify-content: center; font-size: 0.95rem; color: #111;">
                                        <i class="{{ $offer->icon ?? 'fa-solid fa-location-dot' }}"></i>
                                    </div>
                                </td>
                                <td><strong>{{ $offer->title }}</strong></td>
                                <td>{{ $offer->subtitle ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($offer->description, 90) }}</td>
                                <td>
                                    <span class="ts-status-badge {{ ($offer->status === 'active' || $offer->status == '1') ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
                                        {{ ucfirst($offer->status) }}
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
                <div class="ts-pagination">
                    {{ $whatWeOffers->links() }}
                </div>
            @endif
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No items found.</h3>
                <p>Add your first What We Offer item.</p>
                <a href="{{ route('admin.what-we-offers.create') }}" class="ts-primary-btn">
                    Create Item
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection