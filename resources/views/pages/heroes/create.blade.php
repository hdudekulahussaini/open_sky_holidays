@extends('admin.layouts.app')

@section('title', 'Create Hero')
@section('page-title', 'Hero Sliders')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Hero</h3>
                <p>Add a new hero slider banner.</p>
            </div>
            <a href="{{ route('admin.heroes.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.heroes.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                @include('pages.heroes.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.heroes.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Hero</button>
                </div>
            </form>
        </div>
    </div>
@endsection
