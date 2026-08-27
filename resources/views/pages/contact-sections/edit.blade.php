@extends('admin.layouts.app')

@section('title', 'Edit Contact Section')
@section('page-title', 'Contact Section')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Contact Section</h3>
                <p>Modify contact information cards, phone numbers, addresses, and office map details.</p>
            </div>
            <a href="{{ route('admin.contact-sections.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.contact-sections.update', $contactSection) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.contact-sections.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.contact-sections.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Contact Section</button>
                </div>
            </form>
        </div>
    </div>
@endsection
