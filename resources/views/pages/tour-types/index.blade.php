@extends('admin.layouts.app')

@section('title', 'Tour Types')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Tour Management
                </span>

                <h1>Tour Types</h1>

                <p>
                    Manage Domestic and International tour categories.
                </p>
            </div>

            <a href="{{ route('admin.tour-types.create') }}" class="ts-primary-btn">
                <span>+</span>
                Add Tour Type
            </a>
        </div>
        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Tour Types</h2>

                    <p>
                        Total records:
                        <strong>{{ $tourTypes->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tour Type</th>
                            <th>Slug</th>
                            <th>Created Date</th>

                            <th class="ts-action-column">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tourTypes as $tourType)
                            <tr>

                                {{-- ID --}}
                                <td>
                                    #{{ $tourType->id }}
                                </td>

                                {{-- Tour Type --}}
                                <td>
                                    <div class="ts-content-cell">
                                        <h3>
                                            {{ $tourType->name }}
                                        </h3>
                                    </div>
                                </td>

                                {{-- Slug --}}
                                <td>
                                    <span class="tour-type-slug">
                                        {{ $tourType->slug }}
                                    </span>
                                </td>

                                {{-- Created Date --}}
                                <td>
                                    <span class="ts-date">
                                        {{ $tourType->created_at->format('d M Y') }}
                                    </span>

                                    <small class="story-created-time">
                                        {{ $tourType->created_at->format('h:i A') }}
                                    </small>
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="ts-actions">

                                        <a href="{{ route('admin.tour-types.edit', $tourType) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.tour-types.destroy', $tourType) }}" method="POST"
                                            onsubmit="return confirm(
                                                'Are you sure you want to delete this tour type?'
                                            )">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="ts-action-btn ts-delete-btn">
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

                                        <h3>No tour types found</h3>

                                        <p>
                                            Create your first Domestic or
                                            International tour category.
                                        </p>

                                        <a href="{{ route('admin.tour-types.create') }}" class="ts-primary-btn">
                                            Create Tour Type
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tourTypes->hasPages())
                <div class="ts-pagination">
                    {{ $tourTypes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
