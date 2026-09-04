@extends('admin.layouts.app')

@section('title', 'About Sections')
@section('page-title', 'About Section Management')

@section('content')

    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>

                <h1>About Section</h1>

                <p>
                    View and manage the About Section content,
                    globe locations and customer avatars.
                </p>
            </div>

            @if ($aboutSections->total() === 0)
                <a href="{{ route('admin.about-sections.create') }}"
                    class="ts-primary-btn">
                    <span>+</span>
                    Add About Section
                </a>
            @endif
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>About Section</h2>

                    <p>
                        Total records:
                        <strong>{{ $aboutSections->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">

                <table class="ts-table">

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
                                @if ($aboutSection->mission_title)
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <i class="{{ $aboutSection->mission_icon ?: 'fa-solid fa-bullseye' }} text-danger"></i>
                                        <span>{{ $aboutSection->mission_title }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </td>

                            <td>
                                @if ($aboutSection->focus_title)
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <i class="{{ $aboutSection->focus_icon ?: 'fa-solid fa-crosshairs' }} text-success"></i>
                                        <span>{{ $aboutSection->focus_title }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
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

                                        @forelse ($aboutSection->customerAvatars as $avatar)
                                            <img src="{{ $avatar->image_url }}" alt="Customer avatar"
                                                class="table-avatar-image" loading="lazy"
                                                onclick="openAvatarPreview(this.src)"
                                                onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\' viewBox=\'0 0 24 24\' fill=\'%2394a3b8\'><path d=\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\'/></svg>'">

                                        @empty

                                            <span class="no-avatar-text">
                                                No images
                                            </span>
                                        @endforelse

                                        <a href="{{ route('admin.about-sections.edit', $aboutSection) }}#customer-avatars"
                                            class="avatar-add-link">
                                            Manage Images
                                        </a>

                                    </div>
                                </div>
                            </td>

                            <td>
                                <span
                                    class="ts-status-badge {{ $aboutSection->status ? 'ts-active' : 'ts-inactive' }}">
                                    <span></span>
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
                            <td colspan="9">
                                <div class="ts-empty-state">
                                    <div class="ts-empty-icon">
                                        ✦
                                    </div>

                                    <h3>No About Section found.</h3>

                                    <p>
                                        Create an About Section to manage
                                        your website content.
                                    </p>

                                    <a href="{{ route('admin.about-sections.create') }}" class="ts-primary-btn">
                                        Add About Section
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($aboutSections->hasPages())
            <div class="ts-pagination">
                {{ $aboutSections->links() }}
            </div>
        @endif
        </div>
    </div>

    {{-- Avatar Full Preview Modal --}}
    <div id="avatarPreviewModal" class="avatar-preview-modal" onclick="closeAvatarPreview()">
        <button type="button" class="avatar-preview-close" onclick="closeAvatarPreview()">&times;</button>
        <img id="avatarPreviewModalImage" class="avatar-preview-modal-image" src="" alt="Customer avatar preview" onclick="event.stopPropagation()">
    </div>

@endsection

@push('scripts')
<script>
    function openAvatarPreview(src) {
        const modal = document.getElementById('avatarPreviewModal');
        const image = document.getElementById('avatarPreviewModalImage');
        if (!modal || !image) return;
        image.src = src;
        modal.classList.add('show');
    }

    function closeAvatarPreview() {
        const modal = document.getElementById('avatarPreviewModal');
        if (modal) {
            modal.classList.remove('show');
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAvatarPreview();
        }
    });
</script>
@endpush
