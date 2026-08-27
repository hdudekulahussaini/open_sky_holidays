@extends('admin.layouts.app')

@section('title', 'Edit Top Header Bar')
@section('page-title', 'Top Header Bar')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Top Header Bar</h3>
                <p>Modify top announcement bar text, contact email, call-to-action button, and social media links.</p>
            </div>
            <a href="{{ route('admin.top-headers.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.top-headers.update', $topHeader) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.top-headers.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.top-headers.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Top Header</button>
                </div>
            </form>
        </div>
    </div>
@endsection
