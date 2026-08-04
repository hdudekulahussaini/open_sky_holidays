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
                        <th class="ts-action-column">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($enquiries as $enquiry)

                        <tr>
                            <td>
                                #{{ $enquiry->id }}
                            </td>

                            <td>
                                <strong>{{ $enquiry->name }}</strong>
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
                                {{ $enquiry->travel_date ? $enquiry->travel_date->format('d M Y') : 'N/A' }}
                            </td>

                            <td>
                                {{ $enquiry->destination ?: 'N/A' }}
                            </td>

                            <td>
                                {{ $enquiry->no_of_travelers ?: 'N/A' }}
                            </td>

                            <td>
                                {{ $enquiry->tourType ? $enquiry->tourType->name : 'N/A' }}
                            </td>

                            <td>
                                <span class="status-badge status-{{ $enquiry->status }}">
                                    {{ ucfirst($enquiry->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="ts-actions">
                                    <a
                                        href="{{ route('admin.enquiries.show', $enquiry) }}"
                                        class="ts-action-btn"
                                    >
                                        View
                                    </a>

                                    <form
                                        action="{{ route('admin.enquiries.destroy', $enquiry) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this enquiry? This action cannot be undone.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="ts-action-btn ts-delete-btn"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
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