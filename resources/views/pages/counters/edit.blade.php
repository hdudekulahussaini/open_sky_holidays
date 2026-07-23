@extends('admin.layouts.app')

@section('title', 'Edit Counter')
@section('page-title', 'Counters')

@section('content')
    <div class="admin-form-card">
        <div class="admin-form-header">
            <div class="admin-form-header-content">
                <h3>Edit Counter</h3>
                <p>Update counter details below.</p>
            </div>
            <a href="{{ route('admin.counters.index') }}" class="btn btn-light">Back</a>
        </div>

        <div class="admin-form-body">
            <form action="{{ route('admin.counters.update', $counter) }}" method="POST" class="admin-form">
                @csrf
                @method('PUT')

                @include('pages.counters.form')

                <div class="admin-form-actions">
                    <a href="{{ route('admin.counters.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Counter</button>
                </div>
            </form>
        </div>
    </div>
@endsection
