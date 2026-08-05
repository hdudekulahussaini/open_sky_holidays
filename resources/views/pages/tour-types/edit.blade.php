@extends('admin.layouts.app')

@section('title', 'Edit Tour Type')
@section('page-title', 'Tour Types')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Tour Type</h3>
                <p>Update the {{ $tourType->name }} tour category.</p>
            </div>
            <a href="{{ route('admin.tour-types.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            @if (session('error'))
                <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.tour-types.update', $tourType) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.tour-types.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.tour-types.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Tour Type</button>
                </div>
            </form>
        </div>
    </div>
@endsection
