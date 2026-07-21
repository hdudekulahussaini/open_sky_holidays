@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>

                <h1>Testimonials</h1>

                <p>
                    Manage customer testimonials displayed on the website.
                </p>
            </div>

            <a href="{{ route('admin.testimonials.create') }}"
                class="ts-primary-btn">
                <span>+</span>
                Add Testimonial
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Testimonials</h2>

                    <p>
                        Total records:
                        <strong>{{ $testimonials->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Platform</th>
                            <th>Customer Name</th>
                            <th>Location</th>
                            <th>Rating</th>
                            <th>Review Date & Time</th>
                            <th>Status</th>
                            <th class="ts-action-column">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($testimonials as $testimonial)
                            <tr>

                                {{-- ID --}}
                                <td>
                                    #{{ $testimonial->id }}
                                </td>

                                {{-- Customer Image --}}
                                <td>
                                    <div class="ts-table-image-wrap">
                                        @if ($testimonial->customer_image)
                                            <img
                                                src="{{ asset('storage/' . $testimonial->customer_image) }}"
                                                alt="{{ $testimonial->customer_name }}"
                                                class="ts-table-image"
                                            >
                                        @else
                                            <div class="ts-table-image-empty">
                                                {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Platform --}}
                                <td>
                                    <strong>
                                        {{ $testimonial->platform }}
                                    </strong>
                                </td>

                                {{-- Customer Name --}}
                                <td>
                                    <div class="ts-content-cell">
                                        <h3>
                                            {{ $testimonial->customer_name }}
                                        </h3>
                                    </div>
                                </td>

                                {{-- Location --}}
                                <td>
                                    {{ $testimonial->location ?: '—' }}
                                </td>

                                {{-- Rating --}}
                                <td>
                                    <div
                                        style="
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 3px;
                                            color: #ffb400;
                                            white-space: nowrap;
                                        "
                                    >
                                        @for ($star = 1; $star <= 5; $star++)
                                            @if ($star <= $testimonial->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>

                                {{-- Review Date and Time --}}
                                <td>
                                    @if ($testimonial->reviewed_at)
                                        <span class="ts-date">
                                            {{ $testimonial->reviewed_at->format('d M Y') }}
                                        </span>

                                        <small
                                            style="
                                                display: block;
                                                margin-top: 5px;
                                            "
                                        >
                                            {{ $testimonial->reviewed_at->format('h:i A') }}
                                        </small>
                                    @else
                                        <span>—</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if ($testimonial->status)
                                        <span class="ts-status-badge ts-active">
                                            <span></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="ts-status-badge ts-inactive">
                                            <span></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="ts-actions">

                                        <a
                                            href="{{ route('admin.testimonials.show', $testimonial) }}"
                                            class="ts-action-btn"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                            class="ts-action-btn ts-edit-btn"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this testimonial?')"
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
                                <td colspan="9">
                                    <div class="ts-empty-state">
                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No testimonial records</h3>

                                        <p>
                                            Create your first customer testimonial.
                                        </p>

                                        <a
                                            href="{{ route('admin.testimonials.create') }}"
                                            class="ts-primary-btn"
                                        >
                                            Create Testimonial
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($testimonials->hasPages())
                <div class="ts-pagination">
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection