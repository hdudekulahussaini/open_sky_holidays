@extends('admin.layouts.app')

@section('title', 'Create Story')
@section('page-title', 'Our Stories')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Story</h3>
                <p>Add a new story record to your website.</p>
            </div>
            <a href="{{ route('admin.our-stories.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.our-stories.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.our-stories.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.our-stories.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Story</button>
                </div>
            </form>
        </div>
    </div>
@endsection