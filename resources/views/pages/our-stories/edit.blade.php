@extends('admin.layouts.app')

@section('title', 'Edit Our Story')

@section('content')
<div class="ts-page-wrapper">
    <div class="ts-page-header">
        <div>
            <span class="ts-page-eyebrow">
                Story Management
            </span>

            <h1>Edit Our Story</h1>

            <p>
                Update the story content, images and features.
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
            action="{{ route(
                'admin.our-stories.update',
                $ourStory
            ) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            @include('pages.our-stories.form')
        </form>
    </div>
</div>
@endsection