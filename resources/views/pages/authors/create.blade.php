@extends('admin.layouts.app')

@section('title', 'Create Author')
@section('page-title', 'Authors')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Author</h3>
                <p>Add a new blog author with profile details and social links.</p>
            </div>
            <a href="{{ route('admin.authors.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.authors.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                
                @include('pages.authors.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.authors.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Author</button>
                </div>
            </form>
        </div>
    </div>
@endsection