@extends('admin.layouts.app')

@section('title', 'Our Processes')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>

                <h1>Our Processes</h1>

                <p>
                    Manage process sections displayed on the website.
                </p>
            </div>

            <a href="{{ route('admin.our-processes.create') }}" class="ts-primary-btn">
                <span>+</span>
                Add Our Process
            </a>
        </div>
        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Our Processes</h2>

                    <p>
                        Total records:
                        <strong>{{ $ourProcesses->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Content</th>
                            <th>Promises</th>
                            <th>Status</th>
                            <th>Created Date</th>

                            <th class="ts-action-column">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($ourProcesses as $ourProcess)
                            <tr>

                                {{-- ID --}}
                                <td>
                                    #{{ $ourProcess->id }}
                                </td>

                                {{-- Content --}}
                                <td>
                                    <div class="ts-content-cell">
                                        @if ($ourProcess->small_heading)
                                            <small class="story-small-heading">
                                                {{ $ourProcess->small_heading }}
                                            </small>
                                        @endif

                                        <h3>
                                            {{ $ourProcess->heading }}
                                        </h3>

                                        <p>
                                            {{ \Illuminate\Support\Str::limit(strip_tags($ourProcess->description), 100) }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Promises --}}
                                <td>
                                    @php
                                        $promises = $ourProcess->promises ?? [];
                                    @endphp

                                    @if (count($promises))
                                        <ul class="story-feature-list">
                                            @foreach (array_slice($promises, 0, 3) as $promise)
                                                <li>
                                                    <strong>
                                                        {{ $promise['text'] ?? '' }}
                                                    </strong>
                                                </li>
                                            @endforeach

                                            @if (count($promises) > 3)
                                                <li class="story-feature-more">
                                                    +{{ count($promises) - 3 }} more
                                                </li>
                                            @endif
                                        </ul>
                                    @else
                                        —
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if ($ourProcess->status === 'active')
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
                                        {{ $ourProcess->created_at->format('d M Y') }}
                                    </span>

                                    <small class="story-created-time">
                                        {{ $ourProcess->created_at->format('h:i A') }}
                                    </small>
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="ts-actions">

                                        <a href="{{ route('admin.our-processes.edit', $ourProcess) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.our-processes.destroy', $ourProcess) }}"
                                            method="POST"
                                            onsubmit="return confirm(
                                                'Are you sure you want to delete this process?'
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

                                        <h3>No process records</h3>

                                        <p>
                                            Create your first website process section.
                                        </p>

                                        <a href="{{ route('admin.our-processes.create') }}"
                                            class="ts-primary-btn">
                                            Create Our Process
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($ourProcesses->hasPages())
                <div class="ts-pagination">
                    {{ $ourProcesses->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
