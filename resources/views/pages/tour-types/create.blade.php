@extends('admin.layouts.app')

@section('title', 'Create Tour Type')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Create Tour Type</h1>

            <p>
                Add a Domestic or International tour category.
            </p>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="admin-card">
        <form
            action="{{ route('admin.tour-types.store') }}"
            method="POST"
        >
            @csrf

            @include('pages.tour-types.form')
        </form>
    </div>
@endsection