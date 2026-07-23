@extends('admin.layouts.app')

@section('title', 'Create Tour Details')

@section('content')

    <div class="admin-page-header">

        <div>
            <h1>Create Tour Details</h1>

            <p>
                Add detailed information and gallery images for a tour.
            </p>
        </div>

        <a
            href="{{ route('admin.tour-details.index') }}"
            class="admin-back-button"
        >
            ← Back to List
        </a>

    </div>

    <form
        action="{{ route('admin.tour-details.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        @include('pages.tour-details.form')
    </form>

@endsection