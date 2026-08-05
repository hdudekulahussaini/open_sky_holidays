@extends('admin.layouts.app')

@section('title', 'Create About Why Choose Us')
@section('page-title', 'About Why Choose Us')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create About Why Choose Us</h3>
                <p>Add title, description, image, features and status.</p>
            </div>
            <a href="{{ route('admin.about-why-choose-us.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.about-why-choose-us.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.about_why_choose_us.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.about-why-choose-us.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Section</button>
                </div>
            </form>
        </div>
    </div>
@endsection