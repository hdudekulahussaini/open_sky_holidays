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
                                        class="delete-form"
                                        onsubmit="return confirm(
                                            'Are you sure you want to delete this About Section?'
                                        )">
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

@endsection
