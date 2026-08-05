@extends('admin.layouts.app')

@section('title', 'Create Tour')
@section('page-title', 'Tours')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Tour</h3>
                <p>Add the basic tour card information and details.</p>
            </div>
            <a href="{{ route('admin.tours.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            @if (session('error'))
                <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.tours.form')
            </form>
        </div>
    </div>
@endsection
