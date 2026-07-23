@extends('admin.layouts.app')

@section('title', 'Create Core Value')

@section('content')

    <div class="admin-page-header">
        <div>
            <h1>Create Core Value</h1>

            <p>
                Add a new core value to the website.
            </p>
        </div>

        <a
            href="{{ route('admin.core-values.index') }}"
            class="admin-button admin-button-secondary"
        >
            Back to Core Values
        </a>
    </div>

    <div class="admin-card">

        <form
            action="{{ route('admin.core-values.store') }}"
            method="POST"
        >
            @csrf

            @include('pages.core-values.form')

            <div class="admin-form-actions">
                <button
                    type="submit"
                    class="admin-button admin-button-primary"
                >
                    Save Core Value
                </button>

                <a
                    href="{{ route('admin.core-values.index') }}"
                    class="admin-button admin-button-secondary"
                >
                    Cancel
                </a>
            </div>
        </form>

    </div>

@endsection