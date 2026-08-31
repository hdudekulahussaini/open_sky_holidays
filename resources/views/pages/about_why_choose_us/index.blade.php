@extends('admin.layouts.app')

@section('title', 'About Why Choose Us')
@section('page-title', 'About Why Choose Us')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>About Why Choose Us</h1>
                <p>Manage title, description, features list with icons, image, and trust badge.</p>
            </div>

            <a href="{{ route('admin.about-why-choose-us.create') }}"
                class="ts-primary-btn">
                <span>+</span> Add Section
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>About Why Choose Us</h2>
                    <p>
                        Total records: <strong>{{ $sections->count() }}</strong>
                    </p>
                </div>
            </div>

        @if ($sections->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Heading &amp; Subtitle</th>
                            <th>Features &amp; Icons</th>
                            <th>Trust Badge</th>
                            <th>Status</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sections as $section)
                            @php
                                $titles = $section->features_title ?? [];
                                $icons = $section->features_icon ?? [];
                            @endphp
                            <tr>
                                <td>#{{ $section->id }}</td>
                                <td>
                                    @if ($section->image)
                                        <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title }}" class="blog-table-image" style="width: 60px; height: 45px; object-fit: cover; border-radius: 6px;">
                                    @else
                                        <small class="text-muted">No image</small>
                                    @endif
                                </td>
                                <td>
                                    @if ($section->subtitle)
                                        <span class="badge bg-light text-secondary mb-1" style="font-size: 0.72rem;">{{ $section->subtitle }}</span><br>
                                    @endif
                                    <strong>{{ $section->title }}</strong>
                                    <div class="text-muted small mt-1">
                                        {{ \Illuminate\Support\Str::limit($section->description, 70) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @foreach(array_slice($titles, 0, 3) as $idx => $featTitle)
                                            <div class="d-flex align-items-center gap-1 small">
                                                <i class="{{ $icons[$idx] ?? 'fa-solid fa-circle-check' }} text-primary" style="font-size: 0.85rem; width: 16px;"></i>
                                                <span>{{ $featTitle }}</span>
                                            </div>
                                        @endforeach
                                        @if(count($titles) > 3)
                                            <small class="text-muted">+{{ count($titles) - 3 }} more features</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 4px 8px; display: inline-block;">
                                        <div class="fw-bold text-dark" style="font-size: 0.8rem;">
                                            <i class="fa-solid fa-circle-check text-primary me-1"></i> {{ $section->badge_title ?? 'Trusted by 15,000+' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 0.72rem;">
                                            {{ $section->badge_subtitle ?? 'Happy travelers worldwide' }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="ts-status-badge {{ $section->status === 'active' ? 'ts-active' : 'ts-inactive' }}">
                                        <span></span>
                                        {{ ucfirst($section->status ?? 'active') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.about-why-choose-us.edit', $section) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.about-why-choose-us.destroy', $section) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
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

            @if ($sections->hasPages())
                <div class="ts-pagination">
                    {{ $sections->links() }}
                </div>
            @endif
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No sections found.</h3>
                <p>Create your first About Why Choose Us section.</p>
                <a href="{{ route('admin.about-why-choose-us.create') }}" class="ts-primary-btn">
                    Create Section
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection