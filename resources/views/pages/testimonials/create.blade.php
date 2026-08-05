@extends('admin.layouts.app')

@section('title', 'Create Testimonial')
@section('page-title', 'Testimonials')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Testimonial</h3>
                <p>Add a new customer testimonial to the website.</p>
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            @if ($errors->any())
                <div class="alert alert-danger admin-form-alert">
                    Please correct the errors below and try again.
                </div>
            @endif

            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.testimonials.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Testimonial</button>
                </div>
            </form>
        </div>
    </div>
@endsection