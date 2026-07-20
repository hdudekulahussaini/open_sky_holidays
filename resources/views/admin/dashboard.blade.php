@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    <div class="dashboard-stats">

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Total Enquiries</span>
                <h2>{{ $totalEnquiries }}</h2>
            </div>

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                    <path d="M3 7l9 6 9-6"></path>
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">New Enquiries</span>
                <h2>{{ $newEnquiries }}</h2>
            </div>

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M12 8v4l3 2"></path>
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Contacted</span>
                <h2>{{ $contactedEnquiries }}</h2>
            </div>

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                        19.79 19.79 0 0 1-8.63-3.07
                        19.5 19.5 0 0 1-6-6
                        19.79 19.79 0 0 1-3.07-8.67
                        A2 2 0 0 1 3.9 2h3
                        a2 2 0 0 1 2 1.72
                        12.84 12.84 0 0 0 .7 2.81
                        2 2 0 0 1-.45 2.11L7.88 9.91
                        a16 16 0 0 0 6 6l1.27-1.27
                        a2 2 0 0 1 2.11-.45
                        12.84 12.84 0 0 0 2.81.7
                        A2 2 0 0 1 22 16.92z">
                    </path>
                </svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Closed</span>
                <h2>{{ $closedEnquiries }}</h2>
            </div>

            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M8 12l3 3 5-6"></path>
                </svg>
            </div>
        </div>

    </div>

    <div class="admin-card">

        <div class="admin-card-header">
            <div>
                <h3>Recent Enquiries</h3>
                <p>Latest enquiries submitted through the website</p>
            </div>

            <a href="{{ route('admin.enquiries.index') }}"
                class="btn btn-primary">
                View All
            </a>
        </div>

        <div class="table-responsive">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($recentEnquiries as $enquiry)

                        <tr>
                            <td>#{{ $enquiry->id }}</td>

                            <td>
                                <strong>{{ $enquiry->name }}</strong>

                                <small>
                                    {{ $enquiry->email }}
                                </small>
                            </td>

                            <td>
                                <a href="tel:{{ $enquiry->phone }}">
                                    {{ $enquiry->phone }}
                                </a>
                            </td>

                            <td>
                                {{ \Illuminate\Support\Str::limit(
                                    $enquiry->message ?: 'No message',
                                    45
                                ) }}
                            </td>

                            <td>
                                <span class="status-badge status-{{ $enquiry->status }}">
                                    {{ ucfirst($enquiry->status) }}
                                </span>
                            </td>

                            <td>
                                {{ $enquiry->created_at->format('d M Y') }}

                                <small>
                                    {{ $enquiry->created_at->format('h:i A') }}
                                </small>
                            </td>

                            <td>
                                <a
                                    href="{{ route(
                                        'admin.enquiries.show',
                                        $enquiry
                                    ) }}"
                                    class="action-button"
                                    title="View enquiry"
                                >
                                    <svg viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M1 12s4-7 11-7 11 7 11 7
                                            -4 7-11 7S1 12 1 12z">
                                        </path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>

                                    View
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="empty-table">
                                No enquiries found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection