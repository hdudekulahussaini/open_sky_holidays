@extends('admin.layouts.app')

@section('title', 'Edit Travel Support')

@section('content')
<div class="ts-page-wrapper">
    <div class="ts-page-header">
        <div>
            <span class="ts-page-eyebrow">
                Travel Support Management
            </span>

            <h1>Edit Travel Support</h1>

            <p>
                Update the travel support content, image and features.
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
            action="{{ route(
                'admin.travel-support.update',
                $travelSupport
            ) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            @include('pages.travel-support.form')
        </form>
    </div>
</div>
@endsection

