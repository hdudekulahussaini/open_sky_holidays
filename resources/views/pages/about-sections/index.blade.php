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
                        <th class="ts-action-column">Actions</th>
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

                                        <a href="{{ route('admin.about-sections.avatars.index', $aboutSection) }}"
                                            class="avatar-add-link">
                                            Manage Images
                                        </a>

                                    </div>
                                </div>
                            </td>

                            <td>
                                <span
                                    class="status-badge {{ $aboutSection->status ? 'status-active' : 'status-inactive' }}">
                                    {{ $aboutSection->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td>
                                <div class="ts-actions">
                                    <a href="{{ route('admin.about-sections.edit', $aboutSection) }}"
                                        class="ts-action-btn ts-edit-btn">
                                        Edit
                                    </a>

                                    <form method="POST"
                                        action="{{ route('admin.about-sections.destroy', $aboutSection) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this About Section?')">
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
