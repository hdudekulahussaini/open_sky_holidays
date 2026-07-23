@extends('admin.layouts.app')

@section('title', 'Tour Inquiries')
@section('page-title', 'Tour Inquiries')

@section('content')

    <div class="admin-card">

        <div class="admin-card-header">
            <div>
                <h3>Tour Booking Inquiries</h3>
                <p>
                    View and manage tour-specific booking inquiries submitted through the website.
                </p>
            </div>
            <div class="enquiry-count">
                Total: {{ $inquiries->total() }}
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

            <button type="submit" class="btn btn-primary">
                Search
            </button>

            <a
                href="{{ route('admin.tour-inquiries.index') }}"
                class="btn btn-light"
            >
                Reset
            </a>
        </form>

        <div class="table-responsive">

            <table class="admin-table">

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
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($inquiries as $inquiry)

                        <tr>
                            <td>
                                #{{ $inquiry->id }}
                            </td>

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

                            <td>
                                {{ $inquiry->travelers }}
                            </td>

                            <td>
                                {{ $inquiry->created_at ? $inquiry->created_at->format('d M Y') : 'N/A' }}
                            </td>

                            <td>
                                <span class="status-badge status-{{ $inquiry->status }}">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons-group" style="display: flex; gap: 8px;">
                                    <a
                                        href="{{ route('admin.tour-inquiries.show', $inquiry) }}"
                                        class="action-button"
                                        title="View Details"
                                    >
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        View
                                    </a>

                                    <a
                                        href="{{ route('admin.tour-inquiries.edit', $inquiry) }}"
                                        class="action-button edit-btn"
                                        title="Edit Status / Details"
                                    >
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="empty-table">
                                <strong>No tour inquiries found.</strong>
                                <p>
                                    Tour booking submissions from the website will appear here.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($inquiries->hasPages())
            <div class="pagination-wrapper">
                {{ $inquiries->links() }}
            </div>
        @endif

    </div>

@endsection
