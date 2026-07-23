@extends('admin.layouts.app')

@section('title', 'Create Why Choose Section')
@section('page-title', 'Why Choose Us')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Why Choose Section</h3>
                <p>Add a new Why Choose Us section record.</p>
            </div>
            <a href="{{ route('admin.why-choose-sections.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.why-choose-sections.store') }}" method="POST" class="admin-form">
                @csrf

                @include('pages.why-choose-sections.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.why-choose-sections.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Section</button>
                </div>
            </form>
        </div>
    </div>
@endsection