@extends('admin.layouts.app')

@section('title', 'Create Page Banner')
@section('page-title', 'Page Banners')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Page Banner</h3>
                <p>Add a new banner for a specific page.</p>
            </div>
            <a href="{{ route('admin.page-banners.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.page-banners.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.page-banners.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.page-banners.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Page Banner</button>
                </div>
            </form>
        </div>
    </div>
@endsection
