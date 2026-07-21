@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
    <div class="admin-form-card">

        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Category</h3>
                <p>Add a new category for travel blogs.</p>
            </div>

            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
                Back
            </a>
        </div>

        <div class="admin-form-body">
            <form
                action="{{ route('admin.categories.store') }}"
                method="POST"
            >
                @include(
                    'pages.categories.form',
                    ['buttonText' => 'Create Category']
                )
            </form>
        </div>

    </div>
@endsection