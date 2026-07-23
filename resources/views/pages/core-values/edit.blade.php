@extends('admin.layouts.app')

@section('title', 'Edit Core Value')

@section('content')

    <div class="admin-page-header">
        <div>
            <h1>Edit Core Value</h1>

            <p>
                Update the selected core value information.
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
            action="{{ route('admin.core-values.update', $coreValue) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            @include('pages.core-values.form')

            <div class="admin-form-actions">
                <button
                    type="submit"
                    class="admin-button admin-button-primary"
                >
                    Update Core Value
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