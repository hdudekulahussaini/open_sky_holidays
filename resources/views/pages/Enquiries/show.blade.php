@extends('admin.layouts.app')

@section('title', 'Enquiry Details')
@section('page-title', 'Enquiry Details')

@section('content')

    <div class="details-page">

        {{-- Details Header --}}
        <div class="details-header">

            <div>
                <a
                    href="{{ route('admin.enquiries.index') }}"
                    class="back-link"
                >
                    ← Back to Enquiries
                </a>

                <h2>
                    Enquiry #{{ $enquiry->id }}
                </h2>

                <p>
                    Submitted on
                    {{ $enquiry->created_at?->format('d M Y, h:i A') }}
                </p>
            </div>

            <span class="status-badge status-{{ $enquiry->status }}">
                {{ ucfirst($enquiry->status) }}
            </span>

        </div>

        {{-- Customer and Travel Information --}}
        <div class="details-grid">

            {{-- Customer Information --}}
            <div class="details-card">

                <h3>Customer Information</h3>

                <div class="detail-row">
                    <span>Name</span>

                    <strong>
                        {{ $enquiry->name }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Email</span>

                    <strong>
                        <a href="mailto:{{ $enquiry->email }}">
                            {{ $enquiry->email }}
                        </a>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Phone</span>

                    <strong>
                        <a href="tel:{{ $enquiry->phone }}">
                            {{ $enquiry->phone }}
                        </a>
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Submitted Date</span>

                    <strong>
                        {{ $enquiry->created_at?->format('d M Y, h:i A') }}
                    </strong>
                </div>

            </div>

            {{-- Travel Information --}}
            <div class="details-card">

                <h3>Travel Information</h3>

                <div class="detail-row">
                    <span>Travel Date</span>

                    <strong>
                        {{ $enquiry->travel_date
                            ? $enquiry->travel_date->format('d M Y')
                            : 'Not provided' }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Destination</span>

                    <strong>
                        {{ $enquiry->destination ?: 'Not provided' }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Number of Travelers</span>

                    <strong>
                        {{ $enquiry->travelers ?: 'Not provided' }}
                    </strong>
                </div>

                <div class="detail-row">
                    <span>Tour Type</span>

                    <strong>
                        {{ $enquiry->tour_type ?: 'Not provided' }}
                    </strong>
                </div>

            </div>

        </div>

        {{-- Customer Message --}}
        <div class="details-card message-card">

            <h3>Additional Requirements / Message</h3>

            <div class="customer-message">
                {{ $enquiry->message
                    ?: 'The customer did not provide any additional requirements.' }}
            </div>

        </div>

        {{-- Update Status --}}
        <div class="details-card message-card">

            <h3>Update Enquiry Status</h3>

            <form
                method="POST"
                action="{{ route('admin.enquiries.status', $enquiry) }}"
            >
                @csrf
                @method('PATCH')

                <div class="form-group">

                    <label for="status">
                        Enquiry Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        required
                    >
                        <option
                            value="new"
                            @selected($enquiry->status === 'new')
                        >
                            New
                        </option>

                        <option
                            value="contacted"
                            @selected($enquiry->status === 'contacted')
                        >
                            Contacted
                        </option>

                        <option
                            value="closed"
                            @selected($enquiry->status === 'closed')
                        >
                            Closed
                        </option>
                    </select>

                    @error('status')
                        <div class="field-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Update Status
                </button>

            </form>

        </div>

        {{-- Action Buttons --}}
        <div class="details-actions">

            <a
                href="mailto:{{ $enquiry->email }}"
                class="btn btn-primary"
            >
                Send Email
            </a>

            <a
                href="tel:{{ $enquiry->phone }}"
                class="btn btn-light"
            >
                Call Customer
            </a>

            <form
                method="POST"
                action="{{ route('admin.enquiries.destroy', $enquiry) }}"
                onsubmit="return confirm('Are you sure you want to delete this enquiry? This action cannot be undone.');"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-danger"
                >
                    Delete Enquiry
                </button>

            </form>

        </div>

    </div>

@endsection