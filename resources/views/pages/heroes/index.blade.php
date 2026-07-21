@extends('admin.layouts.app')

@section('title', 'Hero Slides')

@section('content')
<div class="container-fluid">
    <div
        class="d-flex justify-content-between
                   align-items-center mb-4">
        <h2>Hero Slides</h2>

        <a
            href="{{ route('admin.heroes.create') }}"
            class="btn btn-primary">
            Add Hero
        </a>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Slider Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($heroes as $hero)
                        <tr>
                            <td>{{ $hero->id }}</td>

                            <td>
                                @if ($hero->image)
                                <img
                                    src="{{ asset('storage/' . $hero->image) }}"
                                    alt="{{ $hero->title }}"
                                    width="120"
                                    height="70"
                                    style="object-fit: cover; border-radius: 8px;">
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>{{ $hero->title }}</td>

                            <td style="max-width:300px;">
                                {{ Str::limit($hero->description, 80) }}
                            </td>

                            <td>
                                @if ($hero->status)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>

                            <td>{{ $hero->sort_order }}</td>

                            <td>
                                <a href="{{ route('admin.heroes.edit', $hero) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.heroes.destroy', $hero) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Delete this hero?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No hero slides found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $heroes->links() }}
        </div>
    </div>
</div>
@endsection