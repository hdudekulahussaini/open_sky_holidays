@extends('admin.layouts.app')

@section('title', 'Travel Support')

@section('content')
    <div class="ts-page-wrapper">
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>

                <h1>Travel Support</h1>

                <p>
                    Manage travel support sections displayed on the website.
                </p>
            </div>

            <a href="{{ route('admin.travel-support.create') }}" class="ts-primary-btn">
                <span>+</span>
                Add Travel Support
            </a>
        </div>



        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Travel Support Sections</h2>
                    <p>
                        Total records:
                        <strong>{{ $travelSupportSections->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Content</th>
                            <th>Features</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($travelSupportSections as $section)
                            <tr>
                              <td>#{{ $section->id }}</td>
                                <td>

                                    <div class="ts-table-image-wrap">
                                        @if ($section->image)
                                            <img src="{{ asset('storage/' . $section->image) }}"
                                                alt="{{ $section->heading }}" class="ts-table-image">
                                        @else
                                            <div class="ts-table-image-empty">
                                                ✦
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div class="ts-content-cell">
                                        @if ($section->small_heading)
                                            <span class="ts-small-heading">
                                                {{ $section->small_heading }}
                                            </span>
                                        @endif

                                        <h3>
                                            {{ $section->heading }}
                                        </h3>

                                        <p>
                                            {{ \Illuminate\Support\Str::limit($section->description, 100) }}
                                        </p>
                                    </div>
                                </td>

                                <td>
                                    <div class="ts-feature-list">
                                        @foreach (array_slice($section->features ?? [], 0, 3) as $feature)
                                            <span class="ts-feature-badge">
                                                {{ $feature }}
                                            </span>
                                        @endforeach

                                        @if (count($section->features ?? []) > 3)
                                            <span class="ts-more-features">
                                                +{{ count($section->features) - 3 }}
                                                more
                                            </span>
                                        @endif
                                    </div>
                                </td>

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

                                <td>
                                    <span class="ts-date">
                                        {{ $section->created_at->format('d M Y') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.travel-support.edit', $section) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.travel-support.destroy', $section) }}" method="POST"
                                            onsubmit="return confirm(
                                            'Are you sure you want to delete this travel support section?'
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
                                <td colspan="6">
                                    <div class="ts-empty-state">
                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No travel support records</h3>

                                        <p>
                                            Create your first travel support section.
                                        </p>

                                        <a href="{{ route('admin.travel-support.create') }}" class="ts-primary-btn">
                                            Create Travel Support
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($travelSupportSections->hasPages())
                <div class="ts-pagination">
                    {{ $travelSupportSections->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
