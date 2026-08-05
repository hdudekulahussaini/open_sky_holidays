@extends('admin.layouts.app')

@section('title', 'Hero Slides')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Hero Slides</h1>
                <p>Manage hero slides displayed on the website.</p>
            </div>

            <a href="{{ route('admin.heroes.create') }}" class="ts-primary-btn">
                <span>+</span> Add Hero
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Hero Slides</h2>
                    <p>Total records: <strong>{{ $heroes->total() }}</strong></p>
                </div>
            </div>
        @if ($heroes->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
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
                                <span class="ts-status-badge ts-active">
                                    <span></span> Active
                                </span>
                                @else
                                <span class="ts-status-badge ts-inactive">
                                    <span></span> Inactive
                                </span>
                                @endif
                            </td>

                            <td>{{ $hero->sort_order }}</td>

                            <td>
                                <div class="ts-actions">
                                    <a href="{{ route('admin.heroes.edit', $hero) }}" class="ts-action-btn ts-edit-btn">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.heroes.destroy', $hero) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this hero?')">
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
                            <td colspan="8">
                                <div class="ts-empty-state">
                                    <div class="ts-empty-icon">✦</div>
                                    <h3>No hero slides found.</h3>
                                    <p>Create your first hero slide.</p>
                                    <a href="{{ route('admin.heroes.create') }}" class="ts-primary-btn">
                                        Add Hero
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($heroes->hasPages())
                <div class="ts-pagination">
                    {{ $heroes->links() }}
                </div>
            @endif
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No hero slides found.</h3>
                <p>Create your first hero slide.</p>
                <a href="{{ route('admin.heroes.create') }}" class="ts-primary-btn">
                    Add Hero
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection
