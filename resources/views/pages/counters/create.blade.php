@extends('admin.layouts.app')

@section('title', 'Create Counter')
@section('page-title', 'Counters')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Create Counter</h3>
                <p>Add a new counter to your website.</p>
            </div>
            <a href="{{ route('admin.counters.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.counters.store') }}" method="POST" class="admin-form">
                @csrf

                @include('pages.counters.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.counters.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Counter</button>
                </div>
            </form>
        </div>
    </div>
@endsection