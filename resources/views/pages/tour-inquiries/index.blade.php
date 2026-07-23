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

                                    <form
                                        method="POST"
                                        action="{{ route('admin.tour-inquiries.destroy', $inquiry) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this tour inquiry? This action cannot be undone.');"
                                        style="margin: 0; display: inline;"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="action-button"
                                            title="Delete Inquiry"
                                            style="background: none; border: none; padding: 0; color: #e15b5b; cursor: pointer; display: flex; align-items: center; gap: 4px; font: inherit;"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 16px; height: 16px;">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
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
