@extends('admin.layouts.app')

@section('title', 'Edit Blog')
@section('page-title', 'Blogs')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Blog</h3>
                <p>Update the travel blog details, table of contents, image, and complete content.</p>
            </div>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.blogs.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Blog</button>
                </div>
            </form>
        </div>
    </div>
@endsection