@extends('admin.layouts.app')

@section('title', 'Tour Details')

@section('content')

<div class="ts-page-wrapper">

    {{-- Header --}}
    <div class="ts-page-header">

        <div>

            <span class="ts-page-eyebrow">
                Tour Management
            </span>

            <h1>
                Tour Details
            </h1>

            <p>
                Manage detailed information for all tours.
            </p>

        </div>

        <a
            href="{{ route('admin.tour-details.create') }}"
            class="ts-primary-btn"
        >
            <span>+</span>
            Add Tour Details
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="ts-alert ts-alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- List Card --}}
    <div class="ts-list-card">

        <div class="ts-list-card-header">

            <div>

                <h2>
                    Tour Detail Records
                </h2>

                <p>
                    Total Records :
                    <strong>
                        {{ $tourDetails->total() }}
                    </strong>
                </p>

            </div>

        </div>


        <div class="ts-table-wrapper">

            <table class="ts-table">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Gallery</th>

                        <th>Tour</th>

                        <th>Heading</th>

                        <th>Status</th>

                        <th>Created</th>

                        <th class="ts-action-column">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($tourDetails as $tourDetail)

                        @php
                            $gallery = $tourDetail->gallery ?? [];
                            $firstImage = $gallery[0] ?? null;
                        @endphp

                        <tr>

                            {{-- ID --}}
                            <td>
                                #{{ $tourDetail->id }}
                            </td>


                            {{-- Gallery --}}
                            <td>

                                <div class="ts-table-image-wrap">

                                    @if($firstImage)

                                        <img
                                            src="{{ asset('storage/'.$firstImage) }}"
                                            alt="{{ $tourDetail->heading }}"
                                            class="ts-table-image"
                                        >

                                    @else

                                        <div class="ts-table-image-empty">
                                            ✦
                                        </div>

                                    @endif

                                </div>

                            </td>


                            {{-- Tour --}}
                            <td>

                                <div class="ts-content-cell">

                                    <h3>
                                        {{ $tourDetail->tour->title }}
                                    </h3>

                                    <p>

                                        {{ $tourDetail->tour->tourType->name ?? '' }}

                                    </p>

                                </div>

                            </td>


                            {{-- Heading --}}
                            <td>

                                <div class="ts-content-cell">

                                    <h3>
                                        {{ $tourDetail->heading }}
                                    </h3>

                                    <p>
                                        {{ \Illuminate\Support\Str::limit($tourDetail->description,80) }}
                                    </p>

                                </div>

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($tourDetail->status == 'active')

                                    <span class="ts-status-badge ts-active">

                                        <span></span>

                                        Active

                                    </span>

                                @else

                                    <span class="ts-status-badge ts-inactive">

                                        <span></span>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- Created --}}
                            <td>

                                <span class="ts-date">

                                    {{ $tourDetail->created_at->format('d M Y') }}

                                </span>

                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="ts-actions">
                                    <a
                                        href="{{ route('admin.tour-details.edit',$tourDetail) }}"
                                        class="ts-action-btn ts-edit-btn"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.tour-details.destroy',$tourDetail) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this record?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="ts-action-btn ts-delete-btn"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7">

                                <div class="ts-empty-state">

                                    <div class="ts-empty-icon">
                                        ✦
                                    </div>

                                    <h3>
                                        No Tour Details Found
                                    </h3>

                                    <p>

                                        Create your first tour detail.

                                    </p>

                                    <a
                                        href="{{ route('admin.tour-details.create') }}"
                                        class="ts-primary-btn"
                                    >
                                        Create Tour Detail
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($tourDetails->hasPages())

            <div class="ts-pagination">

                {{ $tourDetails->links() }}

            </div>

        @endif

    </div>

</div>

@endsection

