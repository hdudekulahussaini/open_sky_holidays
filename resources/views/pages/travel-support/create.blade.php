@extends('admin.layouts.app')

@section('title', 'Create Travel Support')

@section('content')
<div class="ts-page-wrapper">
    <div class="ts-page-header">
        <div>
            <span class="ts-page-eyebrow">
                Travel Support Management
            </span>

            <h1>Create Travel Support</h1>

            <p>
                Create a new travel assistance section with dynamic features.
            </p>
        </div>

        <a
            href="{{ route('admin.travel-support.index') }}"
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
            action="{{ route('admin.travel-support.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            @include('pages.travel-support.form')
        </form>
    </div>
</div>
@endsection

