@extends('admin.layouts.app')

@section('title', 'Enquiries')
@section('page-title', 'Customer Enquiries')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Customer Management
                </span>

                <h1>Customer Enquiries</h1>

                <p>
                    View and manage travel enquiries submitted through the website.
                </p>
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
                    <option value="new" @selected(request('status') === 'new')>New</option>
                    <option value="contacted" @selected(request('status') === 'contacted')>Contacted</option>
                    <option value="closed" @selected(request('status') === 'closed')>Closed</option>
                </select>
            </div>

            <button type="submit" class="ts-primary-btn" style="padding: 8px 16px; font-size: 13px;">
                Search
            </button>

            <a
                href="{{ route('admin.enquiries.index') }}"
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
                    <h2>Enquiries List</h2>

                    <p>
                        Total records:
                        <strong>{{ $enquiries->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                                <td>#{{ $enquiry->id }}</td>
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
                                    {{ $enquiry->travel_date ? $enquiry->travel_date->format('d M Y') : 'Not provided' }}
                                </td>
                                <td>{{ $enquiry->destination ?: 'Not provided' }}</td>
                                <td>{{ $enquiry->travelers ?: 'Not provided' }}</td>
                                <td>{{ $enquiry->tour_type ?: 'Not provided' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $enquiry->status }}">
                                        {{ ucfirst($enquiry->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.enquiries.show', $enquiry) }}"
                                            class="ts-action-btn">
                                            View
                                        </a>
                                        <form action="{{ route('admin.enquiries.destroy', $enquiry) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this enquiry? This action cannot be undone.');">
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

                                        <h3>No enquiries found</h3>

                                        <p>
                                            Enquiries submitted from the website will appear here.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($enquiries->hasPages())
                <div class="ts-pagination">
                    {{ $enquiries->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection