@extends('admin.layouts.app')

@section('title', 'Offer Banners')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="mb-1">Offer Banners</h2>

            <p class="text-muted mb-0">
                Manage website promotional deals and offers.
            </p>
        </div>

        <a
            href="{{ route('admin.offer-banners.create') }}"
            class="btn btn-primary"
        >
            Add Offer Banner
        </a>
    </div>


    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Offer Banner List
                </h5>

                <span class="badge bg-light text-dark border">
                    Total: {{ $offerBanners->total() }}
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Discount</th>
                            <th>Subtitle</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($offerBanners as $offerBanner)
                            <tr>
                                <td class="ps-4">
                                    {{ $offerBanner->id }}
                                </td>

                                <td>
                                    @if ($offerBanner->image)
                                        <img
                                            src="{{ asset(
                                                'storage/' . $offerBanner->image
                                            ) }}"
                                            alt="{{ $offerBanner->title }}"
                                            width="110"
                                            height="70"
                                            class="rounded border"
                                            style="object-fit: cover;"
                                        >
                                    @else
                                        <span class="text-muted">
                                            No image
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <strong>
                                        {{ $offerBanner->title }}
                                    </strong>
                                </td>

                                <td>
                                    <span class="fw-semibold text-primary">
                                        {{ $offerBanner->discount_text }}
                                    </span>
                                </td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit(
                                        $offerBanner->subtitle,
                                        50
                                    ) }}
                                </td>

                                <td>
                                    @if ($offerBanner->status)
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <a
                                        href="{{ route(
                                            'admin.offer-banners.edit',
                                            $offerBanner
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route(
                                            'admin.offer-banners.destroy',
                                            $offerBanner
                                        ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm(
                                            'Are you sure you want to delete this offer banner?'
                                        )"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >
                                    <h5 class="text-muted">
                                        No offer banners found
                                    </h5>

                                    <p class="text-muted mb-3">
                                        Create your first promotional offer.
                                    </p>

                                    <a
                                        href="{{ route(
                                            'admin.offer-banners.create'
                                        ) }}"
                                        class="btn btn-primary"
                                    >
                                        Add Offer Banner
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($offerBanners->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $offerBanners->links() }}
            </div>
        @endif
    </div>
</div>
@endsection