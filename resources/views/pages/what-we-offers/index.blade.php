@extends('admin.layouts.app')

@section('title', 'What We Offer')
@section('page-title', 'What We Offer')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    What We Offer
                </span>

                <h1>What We Offer</h1>

                <p>
                    Manage travel solutions, descriptions, images, and status.
                </p>
            </div>

            <a href="{{ route('admin.what-we-offers.create') }}"
                class="ts-primary-btn">
                <span>+</span>
                Add Offer
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>What We Offer List</h2>

                    <p>
                        Total records:
                        <strong>{{ $whatWeOffers->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                        @forelse ($whatWeOffers as $offer)
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
                                        <a href="{{ route('admin.what-we-offers.edit', $offer) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.what-we-offers.destroy', $offer) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this offer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ts-action-btn ts-delete-btn">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="ts-empty-state">
                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No items found</h3>

                                        <p>
                                            Add your first What We Offer item.
                                        </p>

                                        <a href="{{ route('admin.what-we-offers.create') }}" class="ts-primary-btn">
                                            Create Item
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($whatWeOffers->hasPages())
                <div class="ts-pagination">
                    {{ $whatWeOffers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection