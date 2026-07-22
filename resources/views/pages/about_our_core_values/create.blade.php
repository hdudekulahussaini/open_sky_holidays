@extends('admin.layouts.app')

@section('title', 'Create Core Value')

@section('content')
<div class="container-fluid">

    <div
        class="d-flex flex-wrap
               justify-content-between
               align-items-center gap-3 mb-4"
    >
        <div>
            <h2 class="fw-bold mb-1">
                Create Core Value
            </h2>

            <p class="text-muted mb-0">
                Add a new value to the
                About Our Core Values section.
            </p>
        </div>

        <a
            href="{{ route(
                'admin.about-our-core-values.index'
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
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route(
            'admin.about-our-core-values.store'
        ) }}"
        method="POST"
    >
        @csrf

        @include(
            'pages.about_our_core_values.form'
        )
    </form>
</div>
@endsection