@extends('admin.layouts.app')

@section('title', 'Adventures')

@section('content')
<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Adventure Management
            </h2>

            <p class="text-muted mb-0">
                Manage adventure content, features, video and images.
            </p>
        </div>

        <a
            href="{{ route('admin.adventures.create') }}"
            class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Add Adventure
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-semibold mb-0">
                    Adventure List
                </h5>

                <span class="badge bg-light text-dark">
                    Total: {{ $adventures->total() }}
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">ID</th>
                            <th>Category</th>
                            <th>Images</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Features</th>
                            <th>Video</th>
                            <th>Status</th>
                            <th class="text-end px-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($adventures as $adventure)
                        <tr>
                            <td class="px-4">
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
                                <span class="badge bg-success">
                                    Active
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    Inactive
                                </span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a
                                        href="{{ route(
                                                'admin.adventures.edit',
                                                $adventure
                                            ) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-pen me-1"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route(
                                                'admin.adventures.destroy',
                                                $adventure
                                            ) }}"
                                        method="POST"
                                        onsubmit="
                                                return confirm(
                                                    'Delete this adventure?'
                                                );
                                            ">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash me-1"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td
                                colspan="9"
                                class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-mountain fa-3x mb-3"></i>

                                    <h5>No Adventures Found</h5>

                                    <p>
                                        Add your first adventure content.
                                    </p>

                                    <a
                                        href="{{ route(
                                                'admin.adventures.create'
                                            ) }}"
                                        class="btn btn-primary">
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
        <div class="card-footer bg-white border-top py-3">
            {{ $adventures->links() }}
        </div>
        @endif
    </div>
</div>
@endsection