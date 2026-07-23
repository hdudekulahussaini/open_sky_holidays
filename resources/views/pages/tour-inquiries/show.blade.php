@extends('admin.layouts.app')

@section('title', 'Tour Inquiry Details')
@section('page-title', 'Tour Inquiry Details')

@section('content')

    <div class="details-page">

        {{-- Details Header --}}
        <div class="details-header">
            <div>
                <a href="{{ route('admin.tour-inquiries.index') }}" class="back-link">
                    ← Back to Tour Inquiries
                </a>
                <h2>
                    Tour Inquiry #{{ $tourInquiry->id }}
                </h2>
                <p>
                    Submitted on {{ $tourInquiry->created_at?->format('d M Y, h:i A') }}
                </p>
            </div>
            <span class="status-badge status-{{ $tourInquiry->status }}">
                {{ ucfirst($tourInquiry->status) }}
            </span>
        </div>

        {{-- Customer and Tour Information --}}
        <div class="details-grid">

            {{-- Customer Information --}}
            <div class="details-card">
                <h3>Customer Information</h3>

                <div class="detail-row">
                    <span>Customer Name</span>
                    <strong>{{ $tourInquiry->name }}</strong>
                </div>

                <div class="detail-row">
                    <span>Email Address</span>
                    <strong>
                        <a href="mailto:{{ $tourInquiry->email }}">
                            {{ $tourInquiry->email }}
                        </a>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Mobile Number</span>
                    <strong>
                        <a href="tel:{{ $tourInquiry->phone }}">
                            {{ $tourInquiry->phone }}
                        </a>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Submitted Date</span>
                    <strong>{{ $tourInquiry->created_at?->format('d M Y, h:i A') }}</strong>
                </div>
            </div>

            {{-- Tour Booking Information --}}
            <div class="details-card">
                <h3>Tour Booking Information</h3>

                <div class="detail-row">
                    <span>Selected Tour</span>
                    <strong>
                        @if ($tourInquiry->tour)
                            {{ $tourInquiry->tour->title }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Travel Date</span>
                    <strong>
                        {{ $tourInquiry->travel_date ? $tourInquiry->travel_date->format('d M Y') : 'N/A' }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Number of Travelers</span>
                    <strong>{{ $tourInquiry->travelers }}</strong>
                </div>
            </div>

        </div>

        {{-- Update Status Card --}}
        <div class="details-card message-card" style="margin-top: 24px;">
            <h3>Update Inquiry Status</h3>
            <form
                method="POST"
                action="{{ route('admin.tour-inquiries.update', $tourInquiry) }}"
                style="margin-top: 16px;"
            >
                @csrf
                @method('PUT')

                <div class="form-group" style="margin-bottom: 16px; max-width: 300px;">
                    <label for="status" style="display: block; margin-bottom: 8px; font-weight: 500;">Inquiry Status</label>
                    <select name="status" id="status" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="new" @selected($tourInquiry->status === 'new')>New</option>
                        <option value="contacted" @selected($tourInquiry->status === 'contacted')>Contacted</option>
                        <option value="closed" @selected($tourInquiry->status === 'closed')>Closed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Status
                </button>
            </form>
        </div>

        {{-- Action Buttons --}}
        <div class="details-actions" style="margin-top: 24px; display: flex; gap: 12px; align-items: center;">
            <a href="mailto:{{ $tourInquiry->email }}" class="btn btn-primary">
                Send Email
            </a>

            <a href="tel:{{ $tourInquiry->phone }}" class="btn btn-light">
                Call Customer
            </a>

            <form
                method="POST"
                action="{{ route('admin.tour-inquiries.destroy', $tourInquiry) }}"
                onsubmit="return confirm('Are you sure you want to delete this tour inquiry? This action cannot be undone.');"
                style="margin: 0;"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Delete Inquiry
                </button>
            </form>
        </div>

    </div>

@endsection
