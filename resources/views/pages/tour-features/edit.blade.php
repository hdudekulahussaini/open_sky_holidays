@extends('admin.layouts.app')

@section('title', 'Edit Tour Feature')
@section('page-title', 'Tour Features')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Tour Feature</h3>
                <p>Update feature details below.</p>
            </div>
            <a href="{{ route('admin.tour-features.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.tour-features.update', $tourFeature) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.tour-features.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.tour-features.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Tour Feature</button>
                </div>
            </form>
        </div>
    </div>
@endsection