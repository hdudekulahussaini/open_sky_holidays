@extends('admin.layouts.app')

@section('title', 'Tour Inquiries')
@section('page-title', 'Tour Inquiries')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Tour Management
                </span>

                <h1>Tour Booking Inquiries</h1>

                <p>
                    View and manage tour-specific booking inquiries submitted through the website.
                </p>
            </div>
        </div>

        <form
            method="GET"
            action="{{ route('admin.tour-inquiries.index') }}"
            class="table-filters"
        >
            <div class="filter-input">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name, email, phone or tour"
                >
            </div>

            <div class="filter-select">
                <select name="status">
                    <option value="">All Statuses</option>
                    <option value="new" @selected(request('status') === 'new')>New</option>
                    <option value="contacted" @selected(request('status') === 'contacted')>Contacted</option>
                    <option value="closed" @selected(request('status') === 'closed')>Closed</option>
                </select>
            </div>

            <button type="submit" class="ts-primary-btn" style="padding: 8px 16px; font-size: 13px;">
                Search
            </button>

            <a
                href="{{ route('admin.tour-inquiries.index') }}"
                class="btn btn-light"
                style="border: 1px solid var(--ts-border); padding: 8px 16px; font-size: 13px; font-weight: 600;"
            >
                Reset
            </a>
        </form>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Tour Inquiries List</h2>

                    <p>
                        Total records:
                        <strong>{{ $inquiries->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tour Name</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Travel Date</th>
                            <th>Travelers</th>
                            <th>Submitted Date</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inquiries as $inquiry)
                            <tr>
                                <td>#{{ $inquiry->id }}</td>
                                <td>
                                    @if ($inquiry->tour)
                                        <strong>{{ $inquiry->tour->title }}</strong>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $inquiry->name }}</strong>
                                    <small>
                                        <a href="mailto:{{ $inquiry->email }}">
                                            {{ $inquiry->email }}
                                        </a>
                                    </small>
                                </td>
                                <td>
                                    <a href="tel:{{ $inquiry->phone }}">
                                        {{ $inquiry->phone }}
                                    </a>
                                </td>
                                <td>
                                    {{ $inquiry->travel_date ? $inquiry->travel_date->format('d M Y') : 'N/A' }}
                                </td>
                                <td>{{ $inquiry->travelers }}</td>
                                <td>
                                    {{ $inquiry->created_at ? $inquiry->created_at->format('d M Y') : 'N/A' }}
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $inquiry->status }}">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.tour-inquiries.show', $inquiry) }}"
                                            class="ts-action-btn">
                                            View
                                        </a>
                                        <form action="{{ route('admin.tour-inquiries.destroy', $inquiry) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this tour inquiry? This action cannot be undone.');">
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

                                        <h3>No tour inquiries found</h3>

                                        <p>
                                            Tour booking submissions from the website will appear here.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($inquiries->hasPages())
                <div class="ts-pagination">
                    {{ $inquiries->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
