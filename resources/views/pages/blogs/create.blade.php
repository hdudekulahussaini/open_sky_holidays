@extends('admin.layouts.app')

@section('title', 'Create Blog')
@section('page-title', 'Blogs')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Blog</h3>
                <p>Create a new travel blog post with category, author, table of contents, and complete content.</p>
            </div>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                
                @include('pages.blogs.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Blog</button>
                </div>
            </form>
        </div>
    </div>
@endsection