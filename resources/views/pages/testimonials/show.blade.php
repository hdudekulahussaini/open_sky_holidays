@extends('admin.layouts.app')

@section('title', 'View Testimonial')

@section('content')
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">
                    Testimonial Details
                </h1>

                <p class="text-muted mb-0">
                    Complete customer testimonial details.
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-primary">
                    Edit
                </a>

                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">
                    Back
                </a>
            </div>
        </div>

        {{-- Testimonial Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row g-4">

                    {{-- Customer Information --}}
                    <div class="col-lg-4">
                        <div class="text-center">
                            @if ($testimonial->customer_image)
                                <img src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                    alt="{{ $testimonial->customer_name }}" class="show-customer-image">
                            @else
                                <div class="show-customer-placeholder">
                                    {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                                </div>
                            @endif

                            <h3 class="h5 mt-3 mb-1">
                                {{ $testimonial->customer_name }}
                            </h3>

                            <p class="text-muted mb-0">
                                {{ $testimonial->location ?: 'No location' }}
                            </p>
                        </div>
                    </div>

                    {{-- Testimonial Details --}}
                    <div class="col-lg-8">
                        <dl class="row mb-0">

                            {{-- Platform --}}
                            <dt class="col-sm-4 mb-3">
                                Platform
                            </dt>

                            <dd class="col-sm-8 mb-3">
                                {{ $testimonial->platform }}
                            </dd>

                            {{-- Customer Name --}}
                            <dt class="col-sm-4 mb-3">
                                Customer Name
                            </dt>

                            <dd class="col-sm-8 mb-3">
                                {{ $testimonial->customer_name }}
                            </dd>

                            {{-- Location --}}
                            <dt class="col-sm-4 mb-3">
                                Location
                            </dt>

                            <dd class="col-sm-8 mb-3">
                                {{ $testimonial->location ?: '—' }}
                            </dd>

                            {{-- Rating --}}
                            <dt class="col-sm-4 mb-3">
                                Rating
                            </dt>

                            <dd class="col-sm-8 mb-3">
                                <span class="rating-stars">
                                    @for ($star = 1; $star <= 5; $star++)
                                        <i
                                            class="{{ $star <= $testimonial->rating ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                                    @endfor
                                </span>

                                <span class="ms-2">
                                    {{ $testimonial->rating }}/5
                                </span>
                            </dd>

                            {{-- Review Date and Time --}}
                            <dt class="col-sm-4 mb-3">
                                Review Date & Time
                            </dt>

                            <dd class="col-sm-8 mb-3">
                                @if ($testimonial->reviewed_at)
                                    {{ $testimonial->reviewed_at->format('F d, Y h:i A') }}
                                @else
                                    —
                                @endif
                            </dd>

                            {{-- Status --}}
                            <dt class="col-sm-4 mb-3">
                                Status
                            </dt>

                            <dd class="col-sm-8 mb-3">
                                @if ($testimonial->status)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Inactive
                                    </span>
                                @endif
                            </dd>

                            {{-- Review --}}
                            <dt class="col-sm-4 mb-3">
                                Review
                            </dt>

                            <dd class="col-sm-8 mb-3">
                                <div class="testimonial-review">
                                    {!! nl2br(e($testimonial->review)) !!}
                                </div>
                            </dd>


                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .show-customer-image,
        .show-customer-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
        }

        .show-customer-image {
            object-fit: cover;
            border: 4px solid #ffffff;
            box-shadow: 0 8px 24px rgba(16, 24, 40, 0.12);
        }

        .show-customer-placeholder {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 42px;
            font-weight: 700;
            background-color: #667085;
            box-shadow: 0 8px 24px rgba(16, 24, 40, 0.12);
        }

        .rating-stars {
            display: inline-flex;
            gap: 3px;
            color: #ffb400;
        }

        .testimonial-review {
            line-height: 1.8;
            white-space: normal;
            word-break: break-word;
        }

        @media (max-width: 767px) {

            .show-customer-image,
            .show-customer-placeholder {
                width: 110px;
                height: 110px;
            }

            .show-customer-placeholder {
                font-size: 34px;
            }
        }
    </style>
@endpush
