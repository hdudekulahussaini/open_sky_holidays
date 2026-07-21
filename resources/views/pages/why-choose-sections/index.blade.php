@extends('admin.layouts.app')

@section('title', 'Why Choose Us')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>

                <h1>Why Choose Us</h1>

                <p>
                    Manage the Why Choose Us sections displayed on the website.
                </p>
            </div>

            <a
                href="{{ route('admin.why-choose-sections.create') }}"
                class="ts-primary-btn"
            >
                <span>+</span>
                Add Why Choose Section
            </a>
        </div>


        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Why Choose Sections</h2>

                    <p>
                        Total records: {{ $whyChooseSections->total() }}
                    </p>
                </div>
            </div>

            @if ($whyChooseSections->count() > 0)

                <div class="ts-table-wrapper">
                    <table class="ts-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Content</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="ts-action-column">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($whyChooseSections as $section)
                                <tr>

                                    {{-- ID --}}
                                    <td>
                                        #{{ $section->id }}
                                    </td>

                                    {{-- Content --}}
                                    <td>
                                        <div class="ts-content-cell">
                                            <h3>
                                                {{ $section->title }}
                                            </h3>

                                            <p>
                                                {{ \Illuminate\Support\Str::limit(
                                                    $section->description,
                                                    100
                                                ) }}
                                            </p>
                                        </div>
                                    </td>

                                    {{-- Sort Order --}}
                                    <td>
                                        {{ $section->sort_order }}
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @if ($section->status)
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
                                            {{ $section->created_at?->format('d M Y') }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="ts-action-column">
                                        <div class="ts-actions">

                                            <a
                                                href="{{ route(
                                                    'admin.why-choose-sections.edit',
                                                    $section
                                                ) }}"
                                                class="ts-action-btn ts-edit-btn"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route(
                                                    'admin.why-choose-sections.destroy',
                                                    $section
                                                ) }}"
                                                method="POST"
                                                onsubmit="return confirm(
                                                    'Are you sure you want to delete this section?'
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
                            @endforeach
                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                @if ($whyChooseSections->hasPages())
                    <div class="ts-pagination">
                        {{ $whyChooseSections->links() }}
                    </div>
                @endif

            @else

                {{-- Empty State --}}
                <div class="ts-empty-state">

                    <div class="ts-empty-icon">
                        ✦
                    </div>

                    <h3>No Why Choose Us records</h3>

                    <p>
                        Create your first Why Choose Us section.
                    </p>

                    <a
                        href="{{ route('admin.why-choose-sections.create') }}"
                        class="ts-primary-btn"
                    >
                        Create Why Choose Section
                    </a>

                </div>

            @endif

        </div>
    </div>
@endsection