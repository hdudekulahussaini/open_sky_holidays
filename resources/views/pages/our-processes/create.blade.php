@extends('admin.layouts.app')

@section('title', 'Create Our Process')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Create Our Process</h1>

            <p>
                Add process details, count information
                and promises.
            </p>
        </div>
    </div>

    <div class="admin-card">
        <form action="{{ route('admin.our-processes.store') }}" method="POST">
            @csrf

            @include('pages.our-processes.form')
        </form>
    </div>
@endsection
