@extends('admin.layouts.app')

@section('title', 'Create What We Offer')
@section('page-title', 'What We Offer')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create What We Offer</h3>
                <p>Add a new travel solution to the What We Offer section.</p>
            </div>
            <a href="{{ route('admin.what-we-offers.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.what-we-offers.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.what-we-offers.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.what-we-offers.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save What We Offer</button>
                </div>
            </form>
        </div>
    </div>
@endsection