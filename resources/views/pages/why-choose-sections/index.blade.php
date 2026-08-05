@extends('admin.layouts.app')

@section('title', 'Why Choose Us')
@section('page-title', 'Why Choose Us')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>Why Choose Us</h1>
                <p>Manage the Why Choose Us sections displayed on the website.</p>
            </div>

            <a href="{{ route('admin.why-choose-sections.create') }}" class="ts-primary-btn">
                <span>+</span> Add Section
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Why Choose Us</h2>
                    <p>Total records: <strong>{{ $whyChooseSections->count() }}</strong></p>
                </div>
            </div>

        @if ($whyChooseSections->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($whyChooseSections as $section)
                            <tr>
                                <td>#{{ $section->id }}</td>
                                <td><strong>{{ $section->title }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($section->description, 100) }}</td>
                                <td>{{ $section->sort_order }}</td>
                                <td>
                                    <span class="ts-status-badge {{ $section->status ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
                                        {{ $section->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.why-choose-sections.edit', $section) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.why-choose-sections.destroy', $section) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this section?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ts-action-btn ts-delete-btn">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($whyChooseSections->hasPages())
                <div class="ts-pagination">
                    {{ $whyChooseSections->links() }}
                </div>
            @endif
            </div> {{-- end list card for when there are records --}}
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No sections found.</h3>
                <p>Add your first Why Choose Us section.</p>
                <a href="{{ route('admin.why-choose-sections.create') }}" class="ts-primary-btn">
                    Create Section
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection