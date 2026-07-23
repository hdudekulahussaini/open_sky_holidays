@extends('admin.layouts.app')

@section('title', 'Create Support Section')
@section('page-title', 'Travel Support')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Support Section</h3>
                <p>Add a new travel support record.</p>
            </div>
            <a href="{{ route('admin.travel-support.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.travel-support.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.travel-support.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.travel-support.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Support Section</button>
                </div>
            </form>
        </div>
    </div>
@endsection
