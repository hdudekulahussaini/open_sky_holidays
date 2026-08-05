@extends('admin.layouts.app')

@section('title', 'Edit Author')
@section('page-title', 'Authors')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Author</h3>
                <p>Update the author profile details, bio, and social profiles.</p>
            </div>
            <a href="{{ route('admin.authors.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.authors.update', $author) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.authors.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.authors.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Author</button>
                </div>
            </form>
        </div>
    </div>
@endsection