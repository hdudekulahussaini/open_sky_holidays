@extends('admin.layouts.app')

@section('title', 'Our Stories')

@section('content')
    <div class="ts-page-wrapper">

        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>

                <h1>Our Stories</h1>

                <p>
                    Manage story sections displayed on the website.
                </p>
            </div>

            <a href="{{ route('admin.our-stories.create') }}" class="ts-primary-btn">
                <span>+</span>
                Add Our Story
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        {{-- List Card --}}
        <div class="ts-list-card">

            <div class="ts-list-card-header">
                <div>
                    <h2>Our Stories</h2>

                    <p>
                        Total records:
                        <strong>{{ $ourStories->total() }}</strong>
                    </p>
                </div>
            </div>

            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Images</th>
                            <th>Content</th>
                            <th>Features</th>
                            <th>Status</th>
                            <th>Created Date</th>

                            <th class="ts-action-column">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($ourStories as $ourStory)
                            <tr>

                                {{-- ID --}}
                                <td>
                                    #{{ $ourStory->id }}
                                </td>

                                {{-- Images --}}
                                <td>
                                    <div class="story-table-images">
                                        @forelse (array_slice($ourStory->images ?? [], 0, 3) as $image)
                                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $ourStory->heading }}"
                                                class="story-table-image">
                                        @empty
                                            <div class="ts-table-image-empty">
                                                ✦
                                            </div>
                                        @endforelse
                                    </div>
                                </td>

                                {{-- Content --}}
                                <td>
                                    <div class="ts-content-cell">
                                        @if ($ourStory->small_heading)
                                            <small class="story-small-heading">
                                                {{ $ourStory->small_heading }}
                                            </small>
                                        @endif

                                        <h3>
                                            {{ $ourStory->heading }}
                                        </h3>

                                        <p>
                                            {{ \Illuminate\Support\Str::limit(strip_tags($ourStory->description), 100) }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Features --}}
                                <td>
                                    @php
                                        $features = $ourStory->features ?? [];
                                    @endphp

                                    @if (count($features))
                                        <ul class="story-feature-list">
                                            @foreach (array_slice($features, 0, 3) as $feature)
                                                <li>
                                                    <strong>
                                                        {{ $feature['heading'] }}
                                                    </strong>

                                                    @if (!empty($feature['sub_heading']))
                                                        <small>
                                                            {{ $feature['sub_heading'] }}
                                                        </small>
                                                    @endif
                                                </li>
                                            @endforeach

                                            @if (count($features) > 3)
                                                <li class="story-feature-more">
                                                    +{{ count($features) - 3 }} more
                                                </li>
                                            @endif
                                        </ul>
                                    @else
                                        —
                                    @endif
                                </td>
                                {{-- Status --}}
                                <td>
                                    @if ($ourStory->status)
                                        <span class="ts-status-badge ts-active">
                                            <span></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="ts-status-badge ts-inactive">
                                            <span></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- Created Date --}}
                                <td>
                                    <span class="ts-date">
                                        {{ $ourStory->created_at->format('d M Y') }}
                                    </span>

                                    <small class="story-created-time">
                                        {{ $ourStory->created_at->format('h:i A') }}
                                    </small>
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="ts-actions">


                                        <a href="{{ route('admin.our-stories.edit', $ourStory) }}"
                                            class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.our-stories.destroy', $ourStory) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this story?')">
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
                                <td colspan="7">
                                    <div class="ts-empty-state">
                                        <div class="ts-empty-icon">
                                            ✦
                                        </div>

                                        <h3>No story records</h3>

                                        <p>
                                            Create your first website story section.
                                        </p>

                                        <a href="{{ route('admin.our-stories.create') }}" class="ts-primary-btn">
                                            Create Our Story
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($ourStories->hasPages())
                <div class="ts-pagination">
                    {{ $ourStories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
