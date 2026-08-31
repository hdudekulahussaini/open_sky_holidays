@extends('admin.layouts.app')

@section('title', 'Create Core Value')
@section('page-title', 'About Our Core Values')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Core Value</h3>
                <p>Fill in the details to add a new core value.</p>
            </div>
            <a href="{{ route('admin.about-our-core-values.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.about-our-core-values.store') }}" method="POST" class="admin-form">
                @csrf

                @include('pages.about_our_core_values.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.about-our-core-values.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Core Value</button>
                </div>
            </form>
        </div>
    </div>
@endsection