@extends('admin.layouts.app')

@section('title', 'Top Header Bar')
@section('page-title', 'Top Header Bar')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">Website Header</span>
                <h1>Top Header Bar</h1>
                <p>Manage the top announcement bar, contact email, call-to-action button, and custom social media links.</p>
            </div>

            <a href="{{ route('admin.top-headers.create') }}" class="ts-primary-btn">
                <span>+</span> Add Top Header
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Top Header Configurations</h2>
                    <p>Total records: <strong>{{ $topHeaders->total() }}</strong></p>
                </div>
            </div>

            @if ($topHeaders->count() > 0)
                <div class="ts-table-wrapper">
                    <table class="ts-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Announcement / Tagline</th>
                                <th>Button Action</th>
                                <th>Social Icons</th>
                                <th>Status</th>
                                <th class="ts-action-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topHeaders as $index => $item)
                                @php
                                    $socials = is_array($item->social_links) ? $item->social_links : [];
                                @endphp
                                <tr>
                                    <td>
                                        <strong>#{{ $item->id }}</strong>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-envelope text-warning me-1"></i> {{ $item->email ?: '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem; max-width: 280px;">
                                            <i class="fa-solid fa-bullhorn text-info me-1"></i>
                                            {{ \Illuminate\Support\Str::limit($item->tagline, 60) ?: '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem;">
                                            @if($item->button_text)
                                                <span class="badge bg-primary text-white px-2 py-1">{{ $item->button_text }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 fs-6">
                                            @if(!empty($socials))
                                                @foreach($socials as $s)
                                                    @if(!empty($s['url']))
                                                        <a href="{{ $s['url'] }}" target="_blank" title="{{ ucfirst($s['platform'] ?? 'Link') }}" class="text-decoration-none text-dark">
                                                            <i class="{{ $s['icon'] ?? 'fa-solid fa-link' }}"></i>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="text-muted" style="font-size: 0.85rem;">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="ts-status-badge {{ $item->status ? 'ts-active' : 'ts-inactive' }}">
                                            <span></span>
                                            {{ $item->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="ts-actions">
                                            <a href="{{ route('admin.top-headers.edit', $item) }}" class="ts-action-btn ts-edit-btn">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.top-headers.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this top header bar?')">
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

                @if ($topHeaders->hasPages())
                    <div class="ts-pagination">
                        {{ $topHeaders->links() }}
                    </div>
                @endif
            @else
                <div class="ts-empty-state">
                    <div class="ts-empty-icon">✦</div>
                    <h3>No top header configurations found.</h3>
                    <p>Add your first Top Header Bar record.</p>
                    <a href="{{ route('admin.top-headers.create') }}" class="ts-primary-btn">
                        Create Top Header
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
