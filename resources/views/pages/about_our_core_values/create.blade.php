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

                <div class="admin-form-grid">
                    <div class="admin-form-group full-width">
                        <label for="title">Title <span class="required">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="admin-form-control @error('title') is-invalid @enderror" placeholder="e.g. Integrity" required>
                        @error('title')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-form-group full-width">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea id="description" name="description" rows="5" class="admin-form-control @error('description') is-invalid @enderror" placeholder="Enter core value description..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-actions">
                    <a href="{{ route('admin.about-our-core-values.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Core Value</button>
                </div>
            </form>
        </div>
    </div>
@endsection