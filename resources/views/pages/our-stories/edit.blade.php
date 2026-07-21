@extends('admin.layouts.app')

@section('title', 'Edit Our Story')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Edit Our Story</h1>
            <p>Update story content, images and features.</p>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="admin-card">
        <form
            action="{{ route('admin.our-stories.update', $ourStory) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            @include('pages.our-stories.form')
        </form>
    </div>
@endsection