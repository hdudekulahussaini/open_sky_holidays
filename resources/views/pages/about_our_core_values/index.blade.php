@extends('admin.layouts.app')

@section('title', 'About Our Core Values')
@section('page-title', 'About Our Core Values')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    About Management
                </span>

                <h1>About Our Core Values</h1>

                <p>
                    Manage the core value titles and descriptions.
                </p>
            </div>

            <a href="{{ route('admin.about-our-core-values.create') }}"
                class="ts-primary-btn">
                <span>+</span>
                Add Core Value
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>About Our Core Values List</h2>

                    <p>
                        Total records:
                        <strong>{{ $coreValues->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coreValues as $coreValue)
                            <tr>
                                <td>#{{ $coreValue->id }}</td>
                                <td><strong>{{ $coreValue->title }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($coreValue->description, 120) }}</td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.about-our-core-values.edit', $coreValue) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.about-our-core-values.destroy', $coreValue) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this core value?')">
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
                                <td colspan="4">
                                    <div class="ts-empty-state">
                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No core values found</h3>

                                        <p>
                                            Add your first About Our Core Value.
                                        </p>

                                        <a href="{{ route('admin.about-our-core-values.create') }}" class="ts-primary-btn">
                                            Create Core Value
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($coreValues->hasPages())
                <div class="ts-pagination">
                    {{ $coreValues->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection