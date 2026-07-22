@extends('admin.layouts.app')

@section('title', 'Create Counter')

@section('content')

    <div class="admin-page-header">
        <div>
            <h1>Create Counter</h1>
            <p>Add a new counter to your website.</p>
        </div>

        <a
            href="{{ route('admin.counters.index') }}"
            class="admin-button admin-button-secondary"
        >
            Back to Counters
        </a>
    </div>

    <div class="admin-card">

        <form
            action="{{ route('admin.counters.store') }}"
            method="POST"
        >
            @csrf

            @include('pages.counters.form')

            <div class="admin-form-actions">
                <button
                    type="submit"
                    class="admin-button admin-button-primary"
                >
                    Save Counter
                </button>

                <a
                    href="{{ route('admin.counters.index') }}"
                    class="admin-button admin-button-secondary"
                >
                    Cancel
                </a>
            </div>
        </form>

    </div>

@endsection