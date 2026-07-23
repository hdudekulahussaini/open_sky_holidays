@extends('admin.layouts.app')

@section('title', 'About Why Choose Us')

@section('content')
<div class="container-fluid">

    <div
        class="d-flex flex-wrap
               justify-content-between
               align-items-center gap-3 mb-4"
    >
        <div>
            <h2 class="fw-bold mb-1">
                About Why Choose Us
            </h2>

            <p class="text-muted mb-0">
                Manage title, description, image,
                features and status.
            </p>
        </div>

        <a
            href="{{ route(
                'admin.about-why-choose-us.create'
            ) }}"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-plus me-2"></i>
            Add Section
        </a>
    </div>

    @if (session('success'))
        <div
            class="alert alert-success
                   alert-dismissible fade show"
        >
            <i
                class="fa-solid
                       fa-circle-check me-2"
            ></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div
            class="card-header bg-white
                   border-bottom py-3 px-4"
        >
            <div
                class="d-flex justify-content-between
                       align-items-center"
            >
                <h5 class="fw-semibold mb-0">
                    Section List
                </h5>

                <span class="badge bg-light text-dark">
                    Total: {{ $sections->total() }}
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table
                    class="table table-hover
                           align-middle mb-0"
                >
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Feature Titles</th>
                            <th>Feature Descriptions</th>
                            <th>Status</th>
                            <th class="text-end px-4">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($sections as $section)
                            <tr>
                                <td class="px-4">
                                    #{{ $section->id }}
                                </td>

                                <td>
                                    @if ($section->image)
                                        <img
                                            src="{{ asset(
                                                'storage/' .
                                                $section->image
                                            ) }}"
                                            alt="{{ $section->title }}"
                                            width="115"
                                            height="78"
                                            class="section-table-image"
                                        >
                                    @else
                                        <span class="text-muted">
                                            No image
                                        </span>
                                    @endif
                                </td>

                                <td style="min-width: 220px;">
                                    <strong>
                                        {{ $section->title }}
                                    </strong>
                                </td>

                                <td style="min-width: 270px;">
                                    @if ($section->description)
                                        {{ \Illuminate\Support\Str::limit(
                                            $section->description,
                                            100
                                        ) }}
                                    @else
                                        <span class="text-muted">
                                            No description
                                        </span>
                                    @endif
                                </td>

                                <td style="min-width: 240px;">
                                    @forelse (
                                        $section->features_title
                                        ?? [] as $featureTitle
                                    )
                                        <span
                                            class="badge
                                                   bg-light text-dark
                                                   border me-1 mb-1"
                                        >
                                            {{ $featureTitle }}
                                        </span>
                                    @empty
                                        <span class="text-muted">
                                            No feature titles
                                        </span>
                                    @endforelse
                                </td>

                                <td style="min-width: 300px;">
                                    @php
                                        $descriptions =
                                            $section
                                                ->features_description
                                            ?? [];
                                    @endphp

                                    @if (count($descriptions))
                                        {{ \Illuminate\Support\Str::limit(
                                            implode(
                                                ' | ',
                                                array_filter(
                                                    $descriptions
                                                )
                                            ),
                                            150
                                        ) }}
                                    @else
                                        <span class="text-muted">
                                            No feature descriptions
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if (
                                        $section->status
                                        === 'active'
                                    )
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
                                    <div
                                        class="d-flex
                                               justify-content-end
                                               gap-2"
                                    >
                                        <a
                                            href="{{ route(
                                                'admin.about-why-choose-us.edit',
                                                $section
                                            ) }}"
                                            class="btn btn-sm
                                                   btn-outline-primary"
                                        >
                                            <i
                                                class="fa-solid
                                                       fa-pen me-1"
                                            ></i>

                                            Edit
                                        </a>

                                        <form
                                            action="{{ route(
                                                'admin.about-why-choose-us.destroy',
                                                $section
                                            ) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="
                                                return confirm(
                                                    'Delete this section?'
                                                );
                                            "
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm
                                                       btn-outline-danger"
                                            >
                                                <i
                                                    class="fa-solid
                                                           fa-trash me-1"
                                                ></i>

                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="8"
                                    class="text-center py-5"
                                >
                                    <div class="text-muted">
                                        <i
                                            class="fa-solid
                                                   fa-circle-check
                                                   fa-3x mb-3"
                                        ></i>

                                        <h5>
                                            No Sections Found
                                        </h5>

                                        <p>
                                            Add your first About Why
                                            Choose Us section.
                                        </p>

                                        <a
                                            href="{{ route(
                                                'admin.about-why-choose-us.create'
                                            ) }}"
                                            class="btn btn-primary"
                                        >
                                            Add Section
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($sections->hasPages())
            <div class="card-footer bg-white">
                {{ $sections->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .section-table-image {
        object-fit: cover;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }
</style>
@endsection