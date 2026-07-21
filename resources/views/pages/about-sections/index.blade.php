@extends('admin.layouts.app')

@section('title', 'About Sections')
@section('page-title', 'About Section Management')

@section('content')

    <div class="admin-card">

        <div class="admin-card-header">

            <div>
                <h3>About Section</h3>

                <p>
                    View and manage the About Section content,
                    globe locations and customer avatars.
                </p>
            </div>

            <div class="admin-header-actions">

                <div class="enquiry-count">
                    Total: {{ $aboutSections->total() }}
                </div>

                @if ($aboutSections->total() === 0)
                    <a href="{{ route('admin.about-sections.create') }}" class="btn btn-primary">
                        Add About Section
                    </a>
                @endif

            </div>

        </div>
        <div class="table-responsive">

            <table class="admin-table">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Main Heading</th>
                        <th>Mission</th>
                        <th>Focus</th>
                        <th>Customers</th>
                        <th>Locations</th>
                        <th>Avatars</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($aboutSections as $aboutSection)
                        <tr>

                            <td>
                                #{{ $aboutSection->id }}
                            </td>

                            <td>
                                <strong>
                                    {{ $aboutSection->main_heading }}
                                </strong>

                                <small>
                                    {{ \Illuminate\Support\Str::limit(strip_tags($aboutSection->description), 65) }}
                                </small>
                            </td>

                            <td>
                                {{ $aboutSection->mission_title ?: 'Not provided' }}
                            </td>

                            <td>
                                {{ $aboutSection->focus_title ?: 'Not provided' }}
                            </td>

                            <td>
                                {{ number_format($aboutSection->customer_count ?? 0) }}
                            </td>

                            <td>
                                {{ $aboutSection->globe_locations_count ?? 0 }}
                            </td>

                            <td>
                                <div class="table-avatar-wrapper">

                                    <div class="table-avatar-list">

                                        @forelse ($aboutSection->customerAvatars->take(3) as $avatar)
                                            <img src="{{ Storage::url($avatar->image) }}" alt="Customer avatar"
                                                class="table-avatar-image" loading="lazy"
                                                onclick="openAvatarPreview(this.src)">

                                        @empty

                                            <span class="no-avatar-text">
                                                No images
                                            </span>
                                        @endforelse

                                        @if ($aboutSection->customerAvatars->count() > 3)
                                            <span class="table-avatar-more">
                                                +{{ $aboutSection->customerAvatars->count() - 3 }}
                                            </span>
                                        @endif

                                    </div>

                                    <a href="{{ route('admin.about-sections.edit', $aboutSection) }}#customer-avatars"
                                        class="avatar-add-link">
                                        Manage Images
                                    </a>

                                </div>
                            </td>

                            <td>
                                <span
                                    class="status-badge {{ $aboutSection->status ? 'status-active' : 'status-inactive' }}">
                                    {{ $aboutSection->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td>

                                <div class="table-actions">

                                    <a href="{{ route('admin.about-sections.edit', $aboutSection) }}"
                                        class="action-button action-edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 20h9"></path>

                                            <path d="M16.5 3.5a2.12 2.12 0 0 1
                                                        3 3L7 19l-4 1 1-4z"></path>
                                        </svg>

                                        Edit
                                    </a>

                                    <form method="POST"
                                        action="{{ route('admin.about-sections.destroy', $aboutSection) }}"
                                        class="delete-form"
                                        onsubmit="return confirm(
                                            'Are you sure you want to delete this About Section?'
                                        )">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="action-button action-delete">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>

                                                <path d="M19 6l-1 14H6L5 6"></path>

                                                <path d="M10 11v6"></path>

                                                <path d="M14 11v6"></path>

                                                <path d="M9 6V4h6v2"></path>
                                            </svg>

                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="empty-table">

                                <strong>
                                    No About Section found.
                                </strong>

                                <p>
                                    Create an About Section to manage
                                    your website content.
                                </p>

                                <a href="{{ route('admin.about-sections.create') }}" class="btn btn-primary">
                                    Add About Section
                                </a>

                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($aboutSections->hasPages())
            <div class="pagination-wrapper">
                {{ $aboutSections->links() }}
            </div>
        @endif

    </div>

@endsection
