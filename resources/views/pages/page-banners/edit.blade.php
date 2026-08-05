@extends('admin.layouts.app')

@section('title', 'Edit Page Banner')
@section('page-title', 'Page Banners')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Page Banner</h3>
                <p>Update banner details for this page.</p>
            </div>
            <a href="{{ route('admin.page-banners.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.page-banners.update', $pageBanner) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.page-banners.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.page-banners.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Page Banner</button>
                </div>
            </form>
        </div>
    </div>
@endsection
