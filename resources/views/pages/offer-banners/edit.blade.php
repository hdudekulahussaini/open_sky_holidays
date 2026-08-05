@extends('admin.layouts.app')

@section('title', 'Edit Offer Banner')
@section('page-title', 'Offer Banners')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Offer Banner</h3>
                <p>Update this promotional offer details.</p>
            </div>
            <a href="{{ route('admin.offer-banners.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            @if (session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.offer-banners.update', $offerBanner) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.offer-banners.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.offer-banners.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Offer Banner</button>
                </div>
            </form>
        </div>
    </div>
@endsection
