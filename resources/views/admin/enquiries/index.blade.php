@extends('admin.layouts.app')

@section('title', 'Enquiries')
@section('page-title', 'Customer Enquiries')

@push('styles')
<style>
    .filters {
        display: grid;
        grid-template-columns: 1fr 220px auto;
        gap: 12px;
        margin-bottom: 22px;
    }

    .inline-form {
        display: flex;
        gap: 7px;
        min-width: 210px;
    }

    .inline-form select {
        min-width: 125px;
    }

    .actions {
        display: flex;
        gap: 6px;
    }

    @media (max-width: 700px) {
        .filters {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <section class="card">
        <form
            method="GET"
            action="{{ route('admin.enquiries.index') }}"
            class="filters"
        >
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Search name, email, phone or destination"
            >

            <select
                name="status"
                class="form-control"
            >
                <option value="">All statuses</option>

                @foreach([
                    'new',
                    'contacted',
                    'processing',
                    'completed',
                    'closed'
                ] as $status)
                    <option
                        value="{{ $status }}"
                        @selected(request('status') === $status)
                    >
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>

            <button
                type="submit"
                class="button button-primary"
            >
                Search
            </button>
        </form>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Destination</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($enquiries as $enquiry)
                        <tr>
                            <td>
                                ENQ-{{ str_pad(
                                    $enquiry->id,
                                    6,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}
                            </td>

                            <td>
                                <strong>{{ $enquiry->name }}</strong>
                                <br>
                                <small>{{ $enquiry->email }}</small>
                            </td>

                            <td>{{ $enquiry->phone }}</td>

                            <td>
                                {{ $enquiry->destination ?? '—' }}
                            </td>

                            <td>
                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.enquiries.status',
                                        $enquiry
                                    ) }}"
                                    class="inline-form"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <select
                                        name="status"
                                        class="form-control"
                                    >
                                        @foreach([
                                            'new',
                                            'contacted',
                                            'processing',
                                            'completed',
                                            'closed'
                                        ] as $status)
                                            <option
                                                value="{{ $status }}"
                                                @selected(
                                                    $enquiry->status === $status
                                                )
                                            >
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button
                                        type="submit"
                                        class="button button-primary"
                                    >
                                        Save
                                    </button>
                                </form>
                            </td>

                            <td>
                                {{ $enquiry->created_at->format(
                                    'd M Y, h:i A'
                                ) }}
                            </td>

                            <td>
                                <div class="actions">
                                    <a
                                        href="{{ route(
                                            'admin.enquiries.show',
                                            $enquiry
                                        ) }}"
                                        class="button button-secondary"
                                    >
                                        View
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.enquiries.destroy',
                                            $enquiry
                                        ) }}"
                                        onsubmit="return confirm(
                                            'Delete this enquiry?'
                                        )"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="button button-danger"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="7"
                                style="text-align: center"
                            >
                                No enquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $enquiries->links() }}
        </div>
    </section>
@endsection