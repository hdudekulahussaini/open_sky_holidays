@extends('admin.layouts.app')

@section('title', 'Edit What We Offer')
@section('page-title', 'What We Offer')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit What We Offer</h3>
                <p>Update the selected travel solution.</p>
            </div>
            <a href="{{ route('admin.what-we-offers.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.what-we-offers.update', $whatWeOffer) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.what-we-offers.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.what-we-offers.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update What We Offer</button>
                </div>
            </form>
        </div>
    </div>
@endsection