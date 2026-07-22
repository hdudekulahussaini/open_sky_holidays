@extends('admin.layouts.app')

@section('title', 'Create What We Offer')

@section('content')
<div class="container-fluid">

    <div
        class="d-flex flex-wrap
               justify-content-between
               align-items-center gap-3 mb-4"
    >
        <div>
            <h2 class="fw-bold mb-1">
                Create What We Offer
            </h2>

            <p class="text-muted mb-0">
                Add a new travel solution to the
                What We Offer section.
            </p>
        </div>

        <a
            href="{{ route(
                'admin.what-we-offers.index'
            ) }}"
            class="btn btn-outline-secondary"
        >
            <i
                class="fa-solid
                       fa-arrow-left me-2"
            ></i>

            Back
        </a>
    </div>

    @if ($errors->any())
        <div
            class="alert alert-danger
                   border-0 shadow-sm"
        >
            <div class="fw-semibold mb-2">
                Please correct the following errors:
            </div>

            <ul class="mb-0">
                @foreach (
                    $errors->all() as $error
                )
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route(
            'admin.what-we-offers.store'
        ) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        @include(
            'pages.what-we-offers.form'
        )
    </form>
</div>
@endsection