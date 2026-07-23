@extends('admin.layouts.app')

@section('title', 'Edit Process')
@section('page-title', 'Our Processes')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Process</h3>
                <p>Update process section details below.</p>
            </div>
            <a href="{{ route('admin.our-processes.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.our-processes.update', $ourProcess) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.our-processes.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.our-processes.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Process</button>
                </div>
            </form>
        </div>
    </div>
@endsection
