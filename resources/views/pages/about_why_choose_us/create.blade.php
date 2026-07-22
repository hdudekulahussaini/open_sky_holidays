@extends('admin.layouts.app')

@section('title', 'Create About Why Choose Us')

@section('content')
<div class="container-fluid">

    <div
        class="d-flex flex-wrap
               justify-content-between
               align-items-center gap-3 mb-4"
    >
        <div>
            <h2 class="fw-bold mb-1">
                Create About Why Choose Us
            </h2>

            <p class="text-muted mb-0">
                Add title, description, image,
                features and status.
            </p>
        </div>

        <a
            href="{{ route(
                'admin.about-why-choose-us.index'
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

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>
                Please correct the following errors:
            </strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route(
            'admin.about-why-choose-us.store'
        ) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        @include(
            'pages.about_why_choose_us.form'
        )
    </form>
</div>
@endsection