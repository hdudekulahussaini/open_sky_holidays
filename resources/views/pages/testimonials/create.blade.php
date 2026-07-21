@extends('admin.layouts.app')

@section('title', 'Create Testimonial')

@section('content')
    <div class="admin-form-card">

        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Testimonial</h3>

                <p>
                    Add a new customer testimonial to the website.
                </p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-error admin-form-alert">
                Please correct the errors below and try again.
            </div>
        @endif

        <div class="admin-form-body">
            <form
                action="{{ route('admin.testimonials.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="admin-form"
            >
                @csrf

                @include(
                    'pages.testimonials.form',
                    [
                        'buttonText' => 'Create Testimonial'
                    ]
                )
            </form>
        </div>
    </div>
@endsection