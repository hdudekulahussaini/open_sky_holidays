@extends('admin.layouts.app')

@section('title', 'Edit Hero')
@section('page-title', 'Hero Sliders')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Hero</h3>
                <p>Update hero slider banner details.</p>
            </div>
            <a href="{{ route('admin.heroes.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.heroes.update', $hero) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.heroes.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.heroes.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Hero</button>
                </div>
            </form>
        </div>
    </div>
@endsection
