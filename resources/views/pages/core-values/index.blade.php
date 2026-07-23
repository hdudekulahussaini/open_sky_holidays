@extends('admin.layouts.app')

@section('title', 'Core Values')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>

                <h1>Core Values</h1>

                <p>
                    Manage core values displayed on the website.
                </p>
            </div>

            <a
                href="{{ route('admin.core-values.create') }}"
                class="ts-primary-btn"
            >
                <span>+</span>
                Add Core Value
            </a>
        </div>


        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Core Values</h2>

                    <p>
                        Total records:
                        <strong>{{ $coreValues->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>

                            <th>Content</th>

                            <th>Status</th>

                            <th>Created Date</th>

                            <th class="ts-action-column">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($coreValues as $coreValue)
                            <tr>

                                {{-- ID --}}
                                <td>
                                    #{{ $coreValue->id }}
                                </td>

                                {{-- Content --}}
                                <td>
                                    <div class="ts-content-cell">
                                        <h3>
                                            {{ $coreValue->heading }}
                                        </h3>

                                        <p>
                                            {{ \Illuminate\Support\Str::limit(
                                                strip_tags($coreValue->description),
                                                100
                                            ) }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if ($coreValue->status === 'active')
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

                                {{-- Created Date --}}
                                <td>
                                    <span class="ts-date">
                                        {{ $coreValue->created_at->format('d M Y') }}
                                    </span>

                                    <small class="story-created-time">
                                        {{ $coreValue->created_at->format('h:i A') }}
                                    </small>
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="ts-actions">

                                        <a
                                            href="{{ route('admin.core-values.edit', $coreValue) }}"
                                            class="ts-action-btn ts-edit-btn"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.core-values.destroy', $coreValue) }}"
                                            method="POST"
                                            onsubmit="return confirm(
                                                'Are you sure you want to delete this core value?'
                                            )"
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
                                <td colspan="5">
                                    <div class="ts-empty-state">

                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No core value records</h3>

                                        <p>
                                            Create your first website core value.
                                        </p>

                                        <a
                                            href="{{ route('admin.core-values.create') }}"
                                            class="ts-primary-btn"
                                        >
                                            Create Core Value
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($coreValues->hasPages())
                <div class="ts-pagination">
                    {{ $coreValues->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection