@extends('admin.layouts.app')

@section('title', 'Adventures')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Adventures
                </span>
                <h1>Adventure Management</h1>

                <p>
                    Manage adventure content, features, video and images.
                </p>
            </div>

            <a href="{{ route('admin.adventures.create') }}"
                class="ts-primary-btn">
                <span>+</span> Add Adventure
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Adventure List</h2>

                    <p>
                        Total records:
                        <strong>{{ $adventures->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Images</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Features</th>
                            <th>Video</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($adventures as $adventure)
                        <tr>
                            <td>
                                #{{ $adventure->id }}
                            </td>

                            <td style="min-width: 160px;">
                                @if ($adventure->category)
                                <strong>
                                    {{ $adventure->category->name }}
                                </strong>

                                <div>
                                    <small class="text-muted">
                                        {{ $adventure->category->slug }}
                                    </small>
                                </div>
                                @else
                                <span class="text-danger">
                                    Category missing
                                </span>
                                @endif
                            </td>

                            <td style="min-width: 150px;">
                                <div class="d-flex gap-2">
                                    @if ($adventure->image_one)
                                    <img
                                        src="{{ asset(
                                                    'storage/' .
                                                    $adventure->image_one
                                                ) }}"
                                        alt="{{ $adventure->title }}"
                                        width="62"
                                        height="52"
                                        style="
                                                    object-fit: cover;
                                                    border-radius: 7px;
                                                ">
                                    @endif

                                    @if ($adventure->image_two)
                                    <img
                                        src="{{ asset(
                                                    'storage/' .
                                                    $adventure->image_two
                                                ) }}"
                                        alt="{{ $adventure->title }}"
                                        width="62"
                                        height="52"
                                        style="
                                                    object-fit: cover;
                                                    border-radius: 7px;
                                                ">
                                    @endif
                                </div>

                                @if (
                                !$adventure->image_one &&
                                !$adventure->image_two
                                )
                                <span class="text-muted">
                                    No images
                                </span>
                                @endif
                            </td>

                            <td style="min-width: 220px;">
                                <strong>
                                    {{ $adventure->title }}
                                </strong>
                            </td>

                            <td style="min-width: 260px;">
                                @if ($adventure->description)
                                {{ \Illuminate\Support\Str::limit(
                                            $adventure->description,
                                            100
                                        ) }}
                                @else
                                <span class="text-muted">
                                    No description
                                </span>
                                @endif
                            </td>

                            <td>
                                @php
                                $featureCount = count(
                                $adventure->features ?? []
                                );
                                @endphp

                                @if ($featureCount > 0)
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-list-check me-1"></i>

                                    {{ $featureCount }}

                                    {{ \Illuminate\Support\Str::plural(
                                                'Feature',
                                                $featureCount
                                            ) }}
                                </span>
                                @else
                                <span class="text-muted">
                                    No features
                                </span>
                                @endif
                            </td>

                            <td>
                                @if ($adventure->video_link)
                                <a
                                    href="{{ $adventure->video_link }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn btn-sm btn-outline-dark">
                                    <i class="fas fa-play me-1"></i>
                                    Watch
                                </a>
                                @else
                                <span class="text-muted">
                                    No video
                                </span>
                                @endif
                            </td>

                            <td>
                                @if ($adventure->status === 'active')
                                <span class="ts-status-badge ts-active">
                                    <span></span> Active
                                </span>
                                @else
                                <span class="ts-status-badge ts-inactive">
                                    <span></span> Inactive
                                </span>
                                @endif
                            </td>

                            <td>
                                <div class="ts-actions">
                                    <a
                                        href="{{ route('admin.adventures.edit', $adventure) }}"
                                        class="ts-action-btn ts-edit-btn">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.adventures.destroy', $adventure) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this adventure?');">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="ts-action-btn ts-delete-btn">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="ts-empty-state">
                                    <div class="ts-empty-icon">✦</div>
                                    <h3>No Adventures Found</h3>
                                    <p>Add your first adventure content.</p>
                                    <a href="{{ route('admin.adventures.create') }}" class="ts-primary-btn">
                                        Add Adventure
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

            @if ($adventures->hasPages())
                <div class="ts-pagination">
                    {{ $adventures->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection