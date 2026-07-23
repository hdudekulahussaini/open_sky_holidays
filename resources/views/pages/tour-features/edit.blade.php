@extends('admin.layouts.app')

@section('title', 'Edit Tour Feature')

@section('content')

    <div class="tf-page-header">

        <div>
            <h1>Edit Tour Feature</h1>

            <p>
                Update {{ $tourFeature->title }}.
            </p>
        </div>

        <a
            href="{{ route('admin.tour-features.index') }}"
            class="tf-back-button"
        >
            Back to List
        </a>

    </div>

    <form
        action="{{ route(
            'admin.tour-features.update',
            $tourFeature
        ) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        @include('pages.tour-features.form')
    </form>

@endsection

@push('styles')
    <style>
        .tf-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .tf-page-header h1 {
            margin: 0 0 6px;
            color: #172033;
            font-size: 27px;
            font-weight: 750;
        }

        .tf-page-header p {
            margin: 0;
            color: #7b8798;
            font-size: 14px;
        }

        .tf-back-button {
            display: inline-flex;
            min-height: 42px;
            padding: 9px 15px;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            background: #ffffff;
            border: 1px solid #d7dee7;
            border-radius: 9px;
        }

        @media (max-width: 600px) {
            .tf-page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .tf-back-button {
                width: 100%;
            }
        }
    </style>
@endpush