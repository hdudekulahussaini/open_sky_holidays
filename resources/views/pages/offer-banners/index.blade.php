@extends('admin.layouts.app')

@section('title', 'Offer Banners')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Banner Management
                </span>

                <h1>Offer Banners</h1>

                <p>
                    Manage website promotional deals and offers.
                </p>
            </div>

            <a href="{{ route('admin.offer-banners.create') }}"
                class="ts-primary-btn">
                <span>+</span>
                Add Offer Banner
            </a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Offer Banners List</h2>

                    <p>
                        Total records:
                        <strong>{{ $offerBanners->total() }}</strong>
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
                            <th>Discount</th>
                            <th>Subtitle</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($offerBanners as $offerBanner)
                            <tr>
                                <td>{{ $offerBanner->id }}</td>
                                <td>
                                    @if ($offerBanner->image)
                                        <img
                                            src="{{ asset('storage/' . $offerBanner->image) }}"
                                            alt="{{ $offerBanner->title }}"
                                            width="110"
                                            height="70"
                                            class="rounded border"
                                            style="object-fit: cover;"
                                        >
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td><strong>{{ $offerBanner->title }}</strong></td>
                                <td>{{ $offerBanner->discount_text }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($offerBanner->subtitle, 50) }}</td>
                                <td>
                                    <span class="status-badge {{ $offerBanner->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $offerBanner->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.offer-banners.edit', $offerBanner) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.offer-banners.destroy', $offerBanner) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this offer banner?')">
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

                                        <h3>No offer banners found</h3>

                                        <p>
                                            Create your first promotional offer.
                                        </p>

                                        <a href="{{ route('admin.offer-banners.create') }}" class="ts-primary-btn">
                                            Create Offer Banner
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($offerBanners->hasPages())
                <div class="ts-pagination">
                    {{ $offerBanners->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection