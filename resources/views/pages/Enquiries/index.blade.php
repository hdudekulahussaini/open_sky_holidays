@extends('admin.layouts.app')

@section('title', 'Enquiries')
@section('page-title', 'Customer Enquiries')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Bookings & Inquiries
                </span>
                <h1>Customer Enquiries</h1>
                <p>View and manage travel enquiries submitted through the website.</p>
            </div>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header" style="flex-wrap: wrap; gap: 1rem; align-items: center;">
                <div>
                    <h2>Enquiries List</h2>
                    <p>Total records: <strong>{{ $enquiries->total() }}</strong></p>
                </div>

                <form method="GET" action="{{ route('admin.enquiries.index') }}" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customer or destination" style="padding: 8px 12px; border: 1px solid var(--ts-border); border-radius: 6px; outline: none; min-width: 250px;">
                    
                    <select name="status" style="padding: 8px 12px; border: 1px solid var(--ts-border); border-radius: 6px; outline: none; background: #fff;">
                        <option value="">All Statuses</option>
                        <option value="new" @selected(request('status') === 'new')>New</option>
                        <option value="contacted" @selected(request('status') === 'contacted')>Contacted</option>
                        <option value="closed" @selected(request('status') === 'closed')>Closed</option>
                    </select>

                    <button type="submit" class="ts-primary-btn" style="padding: 8px 16px;">
                        Search
                    </button>
                    <a href="{{ route('admin.enquiries.index') }}" class="ts-action-btn" style="padding: 8px 16px; border: 1px solid var(--ts-border); background: #fff; text-decoration: none; color: inherit;">
                        Reset
                    </a>
                </form>
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
                            <th class="ts-action-column">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($enquiries as $enquiry)
                            <tr>
                                <td>#{{ $enquiry->id }}</td>
                                <td>
                                    <strong>{{ $enquiry->name }}</strong>
                                    <br>
                                    <small>
                                        <a href="mailto:{{ $enquiry->email }}" style="color: var(--ts-text-muted); text-decoration: none;">
                                            {{ $enquiry->email }}
                                        </a>
                                    </small>
                                </td>
                                <td>
                                    <a href="tel:{{ $enquiry->phone }}" style="color: var(--ts-text-main); text-decoration: none;">
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
                                    <span class="ts-status-badge {{ $enquiry->status === 'new' ? 'ts-active' : ($enquiry->status === 'contacted' ? 'ts-primary' : 'ts-inactive') }}">
                                        <span></span>
                                        {{ ucfirst($enquiry->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.enquiries.show', $enquiry) }}" class="ts-action-btn ts-edit-btn" title="View Enquiry">
                                            View
                                        </a>

                                        <form action="{{ route('admin.enquiries.destroy', $enquiry) }}" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this enquiry? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ts-action-btn ts-delete-btn" title="Delete Enquiry">
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
                                        <div class="ts-empty-icon">✦</div>
                                        <h3>No enquiries found.</h3>
                                        <p>Enquiries submitted from the website will appear here.</p>
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
