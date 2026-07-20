@extends('admin.layouts.app')

@section('title', 'Enquiries')
@section('page-title', 'Customer Enquiries')

@section('content')

    <div class="admin-card">

        <div class="admin-card-header">
            <div>
                <h3>Customer Enquiries</h3>

                <p>
                    View and manage travel enquiries submitted
                    through the website.
                </p>
            </div>

            <div class="enquiry-count">
                Total: {{ $enquiries->total() }}
            </div>
        </div>

        <form
            method="GET"
            action="{{ route('admin.enquiries.index') }}"
            class="table-filters"
        >
            <div class="filter-input">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search customer or destination"
                >
            </div>

            <div class="filter-select">
                <select name="status">
                    <option value="">All Statuses</option>

                    <option
                        value="new"
                        @selected(request('status') === 'new')
                    >
                        New
                    </option>

                    <option
                        value="contacted"
                        @selected(request('status') === 'contacted')
                    >
                        Contacted
                    </option>

                    <option
                        value="closed"
                        @selected(request('status') === 'closed')
                    >
                        Closed
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Search
            </button>

            <a
                href="{{ route('admin.enquiries.index') }}"
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
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Travel Date</th>
                        <th>Destination</th>
                        <th>Travelers</th>
                        <th>Tour Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($enquiries as $enquiry)

                        <tr>
                            <td>
                                #{{ $enquiry->id }}
                            </td>

                            <td>
                                <strong>
                                    {{ $enquiry->name }}
                                </strong>

                                <small>
                                    <a href="mailto:{{ $enquiry->email }}">
                                        {{ $enquiry->email }}
                                    </a>
                                </small>
                            </td>

                            <td>
                                <a href="tel:{{ $enquiry->phone }}">
                                    {{ $enquiry->phone }}
                                </a>
                            </td>

                            <td>
                                {{ $enquiry->travel_date
                                    ? $enquiry->travel_date->format('d M Y')
                                    : 'Not provided' }}
                            </td>

                            <td>
                                {{ $enquiry->destination ?: 'Not provided' }}
                            </td>

                            <td>
                                {{ $enquiry->travelers ?: 'Not provided' }}
                            </td>

                            <td>
                                {{ $enquiry->tour_type ?: 'Not provided' }}
                            </td>

                            <td>
                                <span
                                    class="status-badge status-{{ $enquiry->status }}"
                                >
                                    {{ ucfirst($enquiry->status) }}
                                </span>
                            </td>

                            <td>
                                <a
                                    href="{{ route(
                                        'admin.enquiries.show',
                                        $enquiry
                                    ) }}"
                                    class="action-button"
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"
                                        ></path>

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="3"
                                        ></circle>
                                    </svg>

                                    View
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="empty-table">
                                <strong>No enquiries found.</strong>

                                <p>
                                    Enquiries submitted from the website
                                    will appear here.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($enquiries->hasPages())
            <div class="pagination-wrapper">
                {{ $enquiries->links() }}
            </div>
        @endif

    </div>

@endsection