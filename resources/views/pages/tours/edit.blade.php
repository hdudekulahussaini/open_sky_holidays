@extends('admin.layouts.app')

@section('title', 'Edit Tour')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Edit Tour</h1>

            <p>
                Update the basic tour card information.
            </p>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="admin-card">
        <form action="{{ route('admin.tours.update', $tour) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('pages.tours.form')
        </form>
    </div>
@endsection
