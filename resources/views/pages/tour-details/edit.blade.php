
@extends('admin.layouts.app')

@section('title', 'Edit Tour Details')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Tour Management
                </span>

                <h1>Edit Tour Details</h1>

                <p>
                    Update the content and gallery images for
                    {{ $tourDetail->tour?->title ?? 'the selected tour' }}.
                </p>
            </div>

            <a
                href="{{ route('admin.tour-details.index') }}"
                class="ts-back-btn"
            >
                ← Back to List
            </a>
        </div>

        {{-- Error Message --}}
        @if (session('error'))
            <div class="ts-alert ts-alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation Summary --}}
        @if ($errors->any())
            <div class="ts-alert ts-alert-danger">
                <strong>Please correct the following errors:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="ts-form-card">
            <form
                action="{{ route(
                    'admin.tour-details.update',
                    $tourDetail
                ) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                @include('pages.tour-details.form')
            </form>
        </div>
    </div>
@endsection

