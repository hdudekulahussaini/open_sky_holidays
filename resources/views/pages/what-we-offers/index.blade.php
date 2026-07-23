@extends('admin.layouts.app')

@section('title', 'What We Offer')

@section('content')
<div class="container-fluid">

    <div
        class="d-flex flex-wrap justify-content-between
               align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                What We Offer
            </h2>

            <p class="text-muted mb-0">
                Manage travel solutions, descriptions,
                images and status.
            </p>
        </div>

        <a
            href="{{ route('admin.what-we-offers.create') }}"
            class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>
            Add What We Offer
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div
            class="card-header bg-white
                   border-bottom py-3 px-4">
            <div
                class="d-flex justify-content-between
                       align-items-center">
                <h5 class="fw-semibold mb-0">
                    What We Offer List
                </h5>

                <span class="badge bg-light text-dark">
                    Total: {{ $whatWeOffers->total() }}
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table
                    class="table table-hover
                           align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th class="text-end px-4">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($whatWeOffers as $offer)
                        <tr>
                            <td class="px-4">
                                #{{ $offer->id }}
                            </td>

                            <td>
                                @if ($offer->image)
                                <img
                                    src="{{ asset(
                                                'storage/' .
                                                $offer->image
                                            ) }}"
                                    alt="{{ $offer->title }}"
                                    width="115"
                                    height="78"
                                    class="offer-table-image">
                                @else
                                <span class="text-muted">
                                    No image
                                </span>
                                @endif
                            </td>

                            <td style="min-width: 190px;">
                                <strong>
                                    {{ $offer->title }}
                                </strong>
                            </td>

                            <td style="min-width: 170px;">
                                {{ $offer->subtitle ?? '-' }}
                            </td>

                            <td style="min-width: 280px;">
                                @if ($offer->description)
                                {{ \Illuminate\Support\Str::limit(
                                            $offer->description,
                                            110
                                        ) }}
                                @else
                                <span class="text-muted">
                                    No description
                                </span>
                                @endif
                            </td>

                            <td>
                                @if ($offer->status === 'active')
                                <span class="badge bg-success">
                                    Active
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    Inactive
                                </span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <div
                                    class="d-flex justify-content-end
                                               align-items-center gap-2">
                                    <a
                                        href="{{ route(
                                                'admin.what-we-offers.edit',
                                                $offer
                                            ) }}"
                                        class="btn btn-sm
                                                   btn-outline-primary">
                                        <i
                                            class="fa-solid
                                                       fa-pen me-1"></i>

                                        Edit
                                    </a>

                                    <form
                                        action="{{ route(
                                                'admin.what-we-offers.destroy',
                                                $offer
                                            ) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="
                                                return confirm(
                                                    'Delete this What We Offer item?'
                                                );
                                            ">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm
                                                       btn-outline-danger">
                                            <i
                                                class="fa-solid
                                                           fa-trash me-1"></i>

                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td
                                colspan="7"
                                class="text-center py-5">
                                <div class="text-muted">
                                    <i
                                        class="fa-solid
                                                   fa-plane-departure
                                                   fa-3x mb-3"></i>

                                    <h5>
                                        No What We Offer Items
                                    </h5>

                                    <p>
                                        Add your first travel solution.
                                    </p>

                                    <a
                                        href="{{ route(
                                                'admin.what-we-offers.create'
                                            ) }}"
                                        class="btn btn-primary">
                                        Add What We Offer
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($whatWeOffers->hasPages())
        <div
            class="card-footer bg-white
                       border-top py-3">
            {{ $whatWeOffers->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .offer-table-image {
        object-fit: cover;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }
</style>
@endsection