@extends('admin.layouts.app')

@section('title', 'Counters')

@section('content') <div class="ts-page-wrapper">


    {{-- Page Header --}}
    <div class="ts-page-header">
        <div>
            <span class="ts-page-eyebrow">
                Website Content
            </span>

            <h1>Counters</h1>

            <p>
                Manage counter statistics displayed on the website.
            </p>
        </div>

        <a href="{{ route('admin.counters.create') }}" class="ts-primary-btn">
            <span>+</span>
            Add Counter
        </a>
    </div>


    {{-- List Card --}}
    <div class="ts-list-card">

        <div class="ts-list-card-header">
            <div>
                <h2>Counters</h2>

                <p>
                    Total records:
                    <strong>{{ $counters->total() }}</strong>
                </p>
            </div>
        </div>

        <div class="ts-table-wrapper">
            <table class="ts-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Counter</th>
                        <th>Status</th>
                        <th>Created Date</th>

                        <th class="ts-action-column">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($counters as $counter)
                        <tr>

                            {{-- ID --}}
                            <td>
                                #{{ $counter->id }}
                            </td>

                            {{-- Counter --}}
                            <td>
                                <div class="ts-content-cell">
                                    <h3>
                                        {{ $counter->value }}
                                    </h3>

                                    <p>
                                        {{ $counter->name }}
                                    </p>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td>
                                @if ($counter->status)
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
                                    {{ $counter->created_at->format('d M Y') }}
                                </span>

                                <small class="story-created-time">
                                    {{ $counter->created_at->format('h:i A') }}
                                </small>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="ts-actions">

                                    <a href="{{ route('admin.counters.edit', $counter) }}"
                                        class="ts-action-btn ts-edit-btn">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.counters.destroy', $counter) }}"
                                        method="POST"
                                        onsubmit="return confirm(
                                            'Are you sure you want to delete this counter?'
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
                            <td colspan="5">
                                <div class="ts-empty-state">
                                    <div class="ts-empty-icon">
                                        ✦
                                    </div>

                                    <h3>No counter records</h3>

                                    <p>
                                        Create your first website counter.
                                    </p>

                                    <a href="{{ route('admin.counters.create') }}"
                                        class="ts-primary-btn">
                                        Create Counter
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($counters->hasPages())
            <div class="ts-pagination">
                {{ $counters->links() }}
            </div>
        @endif

    </div>
</div>


@endsection
