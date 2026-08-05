@extends('admin.layouts.app')

@section('title', 'Add Service')
@section('page-title', 'Services')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Add New Service</h3>
                <p>Fill in service details, features, about section, service items, and process steps.</p>
            </div>
            <a href="{{ route('admin.services.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                
                @include('pages.services.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Service</button>
                </div>
            </form>
        </div>
    </div>
@endsection
