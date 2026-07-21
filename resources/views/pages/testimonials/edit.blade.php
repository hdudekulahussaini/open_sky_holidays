@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
    <div class="container-fluid">
        <div
            class="d-flex flex-wrap justify-content-between
                align-items-center gap-3 mb-4"
        >
            <div>
                <h1 class="h3 mb-1">
                    Edit Testimonial
                </h1>

                <p class="text-muted mb-0">
                    Update testimonial information.
                </p>
            </div>

            <a
                href="{{ route(
                    'admin.testimonials.index'
                ) }}"
                class="btn btn-light"
            >
                Back to Testimonials
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form
                    action="{{ route(
                        'admin.testimonials.update',
                        $testimonial
                    ) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    @include(
                        'pages.testimonials.form',
                        [
                            'testimonial' => $testimonial,
                            'buttonText' =>
                                'Update Testimonial'
                        ]
                    )
                </form>
            </div>
        </div>
    </div>
@endsection