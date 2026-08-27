@extends('admin.layouts.app')

@section('title', 'Create Contact Section')
@section('page-title', 'Contact Section')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Contact Section</h3>
                <p>Add contact information cards, phone numbers, addresses, and office map details.</p>
            </div>
            <a href="{{ route('admin.contact-sections.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.contact-sections.store') }}" method="POST" class="admin-form">
                @csrf

                @include('pages.contact-sections.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.contact-sections.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Contact Section</button>
                </div>
            </form>
        </div>
    </div>
@endsection
