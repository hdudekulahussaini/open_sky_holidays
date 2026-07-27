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
                <i class="fa-solid fa-envelope fs-4 text-primary"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">New Enquiries</span>
                <h2>{{ $newEnquiries }}</h2>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-clock fs-4 text-warning"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Contacted</span>
                <h2>{{ $contactedEnquiries }}</h2>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-phone fs-4 text-info"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-content">
                <span class="stat-label">Closed</span>
                <h2>{{ $closedEnquiries }}</h2>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-circle-check fs-4 text-success"></i>
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
                                    <i class="fa-solid fa-eye me-1"></i> View
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