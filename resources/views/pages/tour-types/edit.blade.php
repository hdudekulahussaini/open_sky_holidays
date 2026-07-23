@extends('admin.layouts.app')

@section('title', 'Edit Tour Type')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Edit Tour Type</h1>

            <p>
                Update the {{ $tourType->name }} tour category.
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
            action="{{ route('admin.tour-types.update', $tourType) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            @include('pages.tour-types.form')
        </form>
    </div>
@endsection