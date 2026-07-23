@extends('admin.layouts.app')

@section('title', 'About Our Core Values')

@section('content')
<div class="container-fluid">

    <div
        class="d-flex flex-wrap
               justify-content-between
               align-items-center gap-3 mb-4"
    >
        <div>
            <h2 class="fw-bold mb-1">
                About Our Core Values
            </h2>

            <p class="text-muted mb-0">
                Manage the core value titles
                and descriptions.
            </p>
        </div>

        <a
            href="{{ route(
                'admin.about-our-core-values.create'
            ) }}"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-plus me-2"></i>
            Add Core Value
        </a>
    </div>

    @if (session('success'))
        <div
            class="alert alert-success
                   alert-dismissible fade show
                   border-0 shadow-sm"
            role="alert"
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
                aria-label="Close"
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
                <div>
                    <h5 class="fw-semibold mb-1">
                        Core Values List
                    </h5>

                    <p class="small text-muted mb-0">
                        All About Our Core Values records.
                    </p>
                </div>

                <span
                    class="badge bg-light text-dark
                           border px-3 py-2"
                >
                    Total:
                    {{ $coreValues->total() }}
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
                            <th class="px-4">
                                ID
                            </th>

                            <th>
                                Title
                            </th>

                            <th>
                                Description
                            </th>

                            <th
                                class="text-end px-4"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse (
                            $coreValues as $coreValue
                        )
                            <tr>
                                <td class="px-4">
                                    <span
                                        class="badge
                                               bg-light text-dark
                                               border"
                                    >
                                        #{{ $coreValue->id }}
                                    </span>
                                </td>

                                <td style="min-width: 200px;">
                                    <div
                                        class="d-flex
                                               align-items-center
                                               gap-3"
                                    >
                                        <div
                                            class="core-value-letter"
                                        >
                                            {{ strtoupper(
                                                substr(
                                                    $coreValue->title,
                                                    0,
                                                    1
                                                )
                                            ) }}
                                        </div>

                                        <strong>
                                            {{ $coreValue->title }}
                                        </strong>
                                    </div>
                                </td>

                                <td style="min-width: 420px;">
                                    {{ \Illuminate\Support\Str::limit(
                                        $coreValue->description,
                                        150
                                    ) }}
                                </td>

                                <td class="text-end px-4">
                                    <div
                                        class="d-flex
                                               justify-content-end
                                               align-items-center
                                               gap-2"
                                    >
                                        <a
                                            href="{{ route(
                                                'admin.about-our-core-values.edit',
                                                $coreValue
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
                                                'admin.about-our-core-values.destroy',
                                                $coreValue
                                            ) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="
                                                return confirm(
                                                    'Delete this core value?'
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
                                    colspan="4"
                                    class="text-center py-5"
                                >
                                    <div class="empty-state">
                                        <div
                                            class="empty-state-icon"
                                        >
                                            <i
                                                class="fa-solid
                                                       fa-gem"
                                            ></i>
                                        </div>

                                        <h5 class="fw-bold mt-3">
                                            No Core Values Found
                                        </h5>

                                        <p class="text-muted">
                                            Add your first About Our
                                            Core Value.
                                        </p>

                                        <a
                                            href="{{ route(
                                                'admin.about-our-core-values.create'
                                            ) }}"
                                            class="btn btn-primary"
                                        >
                                            <i
                                                class="fa-solid
                                                       fa-plus me-2"
                                            ></i>

                                            Add Core Value
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($coreValues->hasPages())
            <div
                class="card-footer bg-white
                       border-top py-3"
            >
                {{ $coreValues->links() }}
            </div>
        @endif

    </div>
</div>

<style>
    .core-value-letter {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #0d6efd;
        font-weight: 700;
        background: #eaf3ff;
        border: 1px solid #cfe2ff;
        border-radius: 12px;
    }

    .empty-state-icon {
        width: 72px;
        height: 72px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0d6efd;
        font-size: 28px;
        background: #eaf3ff;
        border-radius: 50%;
    }
</style>
@endsection