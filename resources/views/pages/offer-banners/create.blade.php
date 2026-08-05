@extends('admin.layouts.app')

@section('title', 'Create Offer Banner')
@section('page-title', 'Offer Banners')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Offer Banner</h3>
                <p>Add a new promotional deal to the website.</p>
            </div>
            <a href="{{ route('admin.offer-banners.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            @if (session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.offer-banners.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.offer-banners.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.offer-banners.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Offer Banner</button>
                </div>
            </form>
        </div>
    </div>
@endsection
