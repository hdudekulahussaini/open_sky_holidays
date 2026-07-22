@extends('admin.layouts.app')

@section('title', 'Create Our Story')

@section('content')
<div class="ts-page-wrapper">
    <div class="ts-page-header">
        <div>
            <span class="ts-page-eyebrow">
                Story Management
            </span>

            <h1>Create Our Story</h1>

            <p>
                Create a new website story section with dynamic images and features.
            </p>
        </div>

        <a
            href="{{ route('admin.our-stories.index') }}"
            class="ts-back-btn"
        >
            ← Back to List
        </a>
    </div>

    @if(session('error'))
        <div class="ts-alert ts-alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="ts-form-card">
        <form
            action="{{ route('admin.our-stories.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            @include('pages.our-stories.form')
        </form>
    </div>
</div>
@endsection