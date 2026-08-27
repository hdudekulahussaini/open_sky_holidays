@extends('admin.layouts.app')

@section('title', 'Contact Section')
@section('page-title', 'Contact Section')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">Website Content</span>
                <h1>Contact Section</h1>
                <p>Manage contact info cards, phone, email, WhatsApp, address, and office map.</p>
            </div>

            <a href="{{ route('admin.contact-sections.create') }}" class="ts-primary-btn">
                <span>+</span> Add Contact Section
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>Contact Sections</h2>
                    <p>Total records: <strong>{{ $contactSections->total() }}</strong></p>
                </div>
            </div>

            @if ($contactSections->count() > 0)
                <div class="ts-table-wrapper">
                    <table class="ts-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Call / Phone</th>
                                <th>Email</th>
                                <th>WhatsApp</th>
                                <th>Location &amp; Office</th>
                                <th>Status</th>
                                <th class="ts-action-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contactSections as $index => $section)
                                <tr>
                                    <td>
                                        <strong>#{{ $section->id }}</strong>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-phone text-primary me-1"></i> {{ $section->phone ?: '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-envelope text-warning me-1"></i> {{ $section->email ?: '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem;">
                                            <i class="fa-brands fa-whatsapp text-success me-1"></i> {{ $section->whatsapp_number ?: '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.85rem; max-width: 260px;">
                                            <i class="fa-solid fa-location-dot text-danger me-1"></i>
                                            {{ \Illuminate\Support\Str::limit($section->address, 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="ts-status-badge {{ $section->status ? 'ts-active' : 'ts-inactive' }}">
                                            <span></span>
                                            {{ $section->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="ts-actions">
                                            <a href="{{ route('admin.contact-sections.edit', $section) }}" class="ts-action-btn ts-edit-btn">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.contact-sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact section?')">
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

                @if ($contactSections->hasPages())
                    <div class="ts-pagination">
                        {{ $contactSections->links() }}
                    </div>
                @endif
            @else
                <div class="ts-empty-state">
                    <div class="ts-empty-icon">✦</div>
                    <h3>No contact sections found.</h3>
                    <p>Add your first Contact Section record.</p>
                    <a href="{{ route('admin.contact-sections.create') }}" class="ts-primary-btn">
                        Create Section
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
