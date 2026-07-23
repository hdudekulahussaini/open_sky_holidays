@extends('admin.layouts.app')

@section('title', 'Edit Core Value')
@section('page-title', 'About Our Core Values')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Core Value</h3>
                <p>Update the core value details below.</p>
            </div>
            <a href="{{ route('admin.about-our-core-values.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.about-our-core-values.update', $aboutOurCoreValue) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-form-grid">
                    <div class="admin-form-group full-width">
                        <label for="title">Title <span class="required">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $aboutOurCoreValue->title) }}" class="admin-form-control @error('title') is-invalid @enderror" required>
                        @error('title')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-form-group full-width">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea id="description" name="description" rows="5" class="admin-form-control @error('description') is-invalid @enderror" required>{{ old('description', $aboutOurCoreValue->description) }}</textarea>
                        @error('description')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="admin-form-actions">
                    <a href="{{ route('admin.about-our-core-values.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Core Value</button>
                </div>
            </form>
        </div>
    </div>
@endsection
