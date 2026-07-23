@extends('admin.layouts.app')

@section('title', 'Create Process')
@section('page-title', 'Our Processes')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Process</h3>
                <p>Add a new process section to your website.</p>
            </div>
            <a href="{{ route('admin.our-processes.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.our-processes.store') }}" method="POST" class="admin-form">
                @csrf

                @include('pages.our-processes.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.our-processes.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Process</button>
                </div>
            </form>
        </div>
    </div>
@endsection
