@extends('admin.layouts.app')

@section('title', 'Edit Support Section')
@section('page-title', 'Travel Support')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Support Section</h3>
                <p>Update support section details below.</p>
            </div>
            <a href="{{ route('admin.travel-support.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.travel-support.update', $travelSupport) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.travel-support.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.travel-support.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Support Section</button>
                </div>
            </form>
        </div>
    </div>
@endsection
