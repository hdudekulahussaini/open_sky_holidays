@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')
@section('page-title', 'Testimonials')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Testimonial</h3>
                <p>Update testimonial information.</p>
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            @if ($errors->any())
                <div class="alert alert-danger admin-form-alert">
                    Please correct the errors below and try again.
                </div>
            @endif

            <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.testimonials.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Testimonial</button>
                </div>
            </form>
        </div>
    </div>
@endsection