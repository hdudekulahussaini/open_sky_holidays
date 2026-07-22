@extends('admin.layouts.app')

@section('title', 'Edit Counter')

@section('content')

    <div class="admin-page-header">
        <div>
            <h1>Edit Counter</h1>
            <p>Update the selected counter information.</p>
        </div>

        <a href="{{ route('admin.counters.index') }}" class="admin-button admin-button-secondary">
            Back to Counters
        </a>
    </div>

    <div class="admin-card">

        <form action="{{ route('admin.counters.update', $counter) }}" method="POST">
            @csrf
            @method('PUT')

            @include('pages.counters.form')

            <div class="admin-form-actions">
                <button type="submit" class="admin-button admin-button-primary">
                    Update Counter
                </button>

                <a href="{{ route('admin.counters.index') }}" class="admin-button admin-button-secondary">
                    Cancel
                </a>
            </div>
        </form>

    </div>

@endsection
