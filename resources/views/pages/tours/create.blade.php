@extends('admin.layouts.app')

@section('title', 'Create Tour')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Create Tour</h1>

            <p>
                Add the basic tour card information.
            </p>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('pages.tours.form')
    </form>
@endsection
