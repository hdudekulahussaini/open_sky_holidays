@extends('admin.layouts.app')

@section('title', 'Enquiry Details')
@section('page-title', 'Enquiry Details')

@push('styles')
<style>
    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .detail-item {
        padding-bottom: 14px;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-item label {
        display: block;
        margin-bottom: 6px;
        color: #64748b;
        font-size: 13px;
    }

    .detail-item p {
        margin: 0;
        color: #1e293b;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .top-actions {
        margin-bottom: 20px;
    }

    @media (max-width: 650px) {
        .details-grid {
            grid-template-columns: 1fr;
        }

        .full-width {
            grid-column: auto;
        }
    }
</style>
@endpush

@section('content')
    <div class="top-actions">
        <a
            href="{{ route('admin.enquiries.index') }}"
            class="button button-secondary"
        >
            Back to enquiries
        </a>
    </div>

    <section class="card">
        <div class="details-grid">
            <div class="detail-item">
                <label>Reference</label>

                <p>
                    ENQ-{{ str_pad(
                        $enquiry->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    ) }}
                </p>
            </div>

            <div class="detail-item">
                <label>Status</label>
                <p>{{ ucfirst($enquiry->status) }}</p>
            </div>

            <div class="detail-item">
                <label>Customer name</label>
                <p>{{ $enquiry->name }}</p>
            </div>

            <div class="detail-item">
                <label>Email</label>
                <p>{{ $enquiry->email }}</p>
            </div>

            <div class="detail-item">
                <label>Phone</label>
                <p>{{ $enquiry->phone }}</p>
            </div>

            <div class="detail-item">
                <label>Destination</label>

                <p>
                    {{ $enquiry->destination ?? 'Not specified' }}
                </p>
            </div>

            <div class="detail-item">
                <label>Travel date</label>

                <p>
                    {{ $enquiry->travel_date
                        ? \Illuminate\Support\Carbon::parse(
                            $enquiry->travel_date
                        )->format('d M Y')
                        : 'Not specified' }}
                </p>
            </div>

            <div class="detail-item">
                <label>Travellers</label>

                <p>
                    Adults: {{ $enquiry->adults ?? 0 }},
                    Children: {{ $enquiry->children ?? 0 }}
                </p>
            </div>

            <div class="detail-item full-width">
                <label>Subject</label>

                <p>
                    {{ $enquiry->subject ?? 'No subject' }}
                </p>
            </div>

            <div class="detail-item full-width">
                <label>Message</label>

                <p>{!! nl2br(e($enquiry->message)) !!}</p>
            </div>

            <div class="detail-item full-width">
                <label>Submitted date</label>

                <p>
                    {{ $enquiry->created_at->format(
                        'd M Y, h:i A'
                    ) }}
                </p>
            </div>
        </div>
    </section>
@endsection