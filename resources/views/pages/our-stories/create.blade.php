@extends('admin.layouts.app')

@section('title', 'Create Our Story')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Create Our Story</h1>
            <p>Add story content, images and features.</p>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="admin-card">
        <form
            action="{{ route('admin.our-stories.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            @include('pages.our-stories.form')
        </form>
    </div>
@endsection