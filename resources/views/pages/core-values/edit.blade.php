@extends('admin.layouts.app')

@section('title', 'Edit Core Value')
@section('page-title', 'Core Values')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Core Value</h3>
                <p>Update the core value details below.</p>
            </div>
            <a href="{{ route('admin.core-values.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.core-values.update', $coreValue) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.core-values.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.core-values.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Core Value</button>
                </div>
            </form>
        </div>
    </div>
@endsection