@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
    <div class="admin-form-card">

        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Category</h3>
                <p>Update category details and slug.</p>
            </div>

            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
                Back
            </a>
        </div>

        <div class="admin-form-body">
            <form
                action="{{ route(
                    'admin.categories.update',
                    $category
                ) }}"
                method="POST"
            >
                @method('PUT')

                @include(
                    'pages.categories.form',
                    [
                        'buttonText' => 'Update Category',
                        'category' => $category
                    ]
                )
            </form>
        </div>

    </div>
@endsection