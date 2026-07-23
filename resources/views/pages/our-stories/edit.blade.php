@extends('admin.layouts.app')

@section('title', 'Edit Story')
@section('page-title', 'Our Stories')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Story</h3>
                <p>Update story details below.</p>
            </div>
            <a href="{{ route('admin.our-stories.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.our-stories.update', $ourStory) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.our-stories.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.our-stories.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Story</button>
                </div>
            </form>
        </div>
    </div>
@endsection