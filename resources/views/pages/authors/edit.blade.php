@extends('admin.layouts.app')

@section('title', 'Edit Author')

@section('content')
    <div class="admin-form-card">

        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Author</h3>
                <p>Update the author profile details, bio, and social profiles.</p>
            </div>

            <a href="{{ route('admin.authors.index') }}" class="btn btn-light">
                Back
            </a>
        </div>

        <div class="admin-form-body">
            <form
                action="{{ route(
                    'admin.authors.update',
                    $author
                ) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @method('PUT')

                @include(
                    'pages.authors.form',
                    [
                        'buttonText' => 'Update Author',
                        'author' => $author
                    ]
                )
            </form>
        </div>

    </div>
@endsection