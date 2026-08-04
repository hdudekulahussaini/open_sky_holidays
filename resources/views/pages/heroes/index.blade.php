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
                                    <th>Button Text & Link</th>
                                    <th>Status</th>
                                    <th>Slider Order</th>
                                    <th class="ts-action-column">Actions</th>
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
                                <strong>{{ $hero->button_text ?: 'Explore More' }}</strong>
                                <br>
                                <small class="text-muted">{{ $hero->button_link ?: '/tours' }}</small>
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
                                <div class="ts-actions">
                                    <a href="{{ route('admin.heroes.edit', $hero) }}"
                                        class="ts-action-btn ts-edit-btn">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.heroes.destroy', $hero) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this hero?')">
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
                            <td colspan="8" class="text-center">
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