@extends('admin.layouts.app')

@section('title', 'Edit Our Process')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Edit Our Process</h1>

            <p>
                Update process details, count information
                and promises.
            </p>
        </div>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.our-processes.update', $ourProcess) }}"
            method="POST">
            @csrf
            @method('PUT')

            @include('pages.our-processes.form')
        </form>
    </div>
@endsection
