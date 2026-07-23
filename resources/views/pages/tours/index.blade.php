@extends('admin.layouts.app')

@section('title', 'Tours')

@section('content')
    <div class="ts-page-wrapper">

        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Tour Management
                </span>

                <h1>Tours</h1>

                <p>
                    Manage tour cards displayed on the website.
                </p>
            </div>

            <a href="{{ route('admin.tours.create') }}" class="ts-primary-btn">
                <span>+</span>
                Add Tour
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Tour List</h2>

                    <p>
                        Total records:
                        <strong>{{ $tours->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Tour</th>
                            <th>Tour Type</th>
                            <th>Country</th>
                            <th>Duration</th>
                            <th>Counts</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="ts-action-column">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tours as $tour)
                            <tr>
                                <td>
                                    #{{ $tour->id }}
                                </td>

                                <td>
                                    <div class="ts-table-image-wrap">
                                        @if ($tour->thumbnail)
                                            <img src="{{ asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}"
                                                class="ts-table-image">
                                        @else
                                            <div class="ts-table-image-empty">
                                                ✦
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div class="ts-content-cell">
                                        <span class="ts-small-heading">
                                            {{ $tour->slug }}
                                        </span>

                                        <h3>
                                            {{ $tour->title }}
                                        </h3>

                                    </div>
                                </td>

                                <td>
                                    <div class="ts-feature-list">
                                        <span class="ts-feature-badge">
                                            {{ $tour->tourType?->name ?? 'Not Assigned' }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    {{ $tour->country }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $tour->duration }}
                                    </strong>
                                </td>

                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 4px; font-size: 12px; color: #475569;">
                                        <span><i class="fa-regular fa-image" style="width: 16px;"></i> Gallery: <strong>{{ $tour->gallery_count }}</strong></span>
                                        <span><i class="fa-solid fa-box" style="width: 16px;"></i> Packages: <strong>{{ $tour->package_inclusions_count }}</strong></span>
                                        <span><i class="fa-solid fa-map-location-dot" style="width: 16px;"></i> Places: <strong>{{ $tour->places_covered_count }}</strong></span>
                                        <span><i class="fa-solid fa-star" style="width: 16px;"></i> Highlights: <strong>{{ $tour->tour_highlights_count }}</strong></span>
                                    </div>
                                </td>

                                <td>
                                    @if ($tour->status)
                                        <span class="ts-status-badge ts-active">
                                            <span></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="ts-status-badge ts-inactive">
                                            <span></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="ts-date">
                                        {{ $tour->created_at->format('d M Y') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.tours.edit', $tour) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST"
                                            onsubmit="return confirm(
                                                'Are you sure you want to delete this tour?'
                                            )">
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
                                <td colspan="9">
                                    <div class="ts-empty-state">
                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No tours found</h3>

                                        <p>
                                            Create your first tour to display it here.
                                        </p>

                                        <a href="{{ route('admin.tours.create') }}" class="ts-primary-btn">
                                            Create Tour
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tours->hasPages())
                <div class="ts-pagination">
                    {{ $tours->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
