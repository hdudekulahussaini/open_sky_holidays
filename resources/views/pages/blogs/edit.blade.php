@extends('admin.layouts.app')

@section('title', 'Edit Blog')

@section('content')
    <div class="admin-form-card">

        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Blog</h3>

                <p>
                    Update the travel blog details, table of contents,
                    image, and complete content.
                </p>
            </div>

            <a
                href="{{ route('admin.blogs.index') }}"
                class="btn btn-light"
            >
                Back
            </a>
        </div>

        <div class="admin-form-body">
            <form
                action="{{ route('admin.blogs.update', $blog) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @method('PUT')

                @include(
                    'pages.blogs.form',
                    [
                        'buttonText' => 'Update Blog',
                        'blog' => $blog,
                    ]
                )
            </form>
        </div>

    </div>
@endsection