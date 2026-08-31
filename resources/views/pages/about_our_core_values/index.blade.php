@extends('admin.layouts.app')

@section('title', 'About Our Core Values')
@section('page-title', 'About Our Core Values')

@section('content')
    <div class="ts-page-wrapper">
        {{-- Page Header --}}
        <div class="ts-page-header">
            <div>
                <span class="ts-page-eyebrow">
                    Website Content
                </span>
                <h1>About Our Core Values</h1>
                <p>Manage the core value titles and descriptions.</p>
            </div>

            <a href="{{ route('admin.about-our-core-values.create') }}"
                class="ts-primary-btn">
                <span>+</span> Add Core Value
            </a>
        </div>

        {{-- List Card --}}
        <div class="ts-list-card">
            <div class="ts-list-card-header">
                <div>
                    <h2>About Our Core Values</h2>
                    <p>
                        Total records: <strong>{{ $coreValues->count() }}</strong>
                    </p>
                </div>
            </div>

        @if ($coreValues->count() > 0)
            <div class="ts-table-wrapper">
                <table class="ts-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th class="ts-action-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $colorPalettes = [
                                'handshake' => ['bg' => '#ffedd5', 'color' => '#ea580c', 'border' => '#fed7aa'], // 🤝 Integrity (Warm Orange)
                                'star'      => ['bg' => '#fef3c7', 'color' => '#d97706', 'border' => '#fde68a'], // ⭐ Excellence (Amber/Gold)
                                'lightbulb' => ['bg' => '#fef9c3', 'color' => '#ca8a04', 'border' => '#fef08a'], // 💡 Innovation (Yellow)
                                'heart'     => ['bg' => '#ffe4e6', 'color' => '#e11d48', 'border' => '#fecdd3'], // ❤️ Care (Rose Red)
                                'gem'       => ['bg' => '#ede9fe', 'color' => '#7c3aed', 'border' => '#ddd6fe'], // 💎 Gem (Purple)
                                'shield'    => ['bg' => '#fee2e2', 'color' => '#dc2626', 'border' => '#fecaca'], // 🛡️ Safety (Red)
                                'award'     => ['bg' => '#ecfdf5', 'color' => '#059669', 'border' => '#a7f3d0'], // 🏆 Award (Emerald)
                                'compass'   => ['bg' => '#e0f2fe', 'color' => '#0284c7', 'border' => '#bae6fd'], // 🧭 Compass (Sky Blue)
                                'earth'     => ['bg' => '#f0fdf4', 'color' => '#16a34a', 'border' => '#bbf7d0'], // 🌍 Earth (Green)
                                'users'     => ['bg' => '#f3e8ff', 'color' => '#9333ea', 'border' => '#e9d5ff'], // 👥 Users (Purple)
                            ];

                            $fallbackColors = [
                                ['bg' => '#ffedd5', 'color' => '#ea580c', 'border' => '#fed7aa'],
                                ['bg' => '#fef3c7', 'color' => '#d97706', 'border' => '#fde68a'],
                                ['bg' => '#fef9c3', 'color' => '#ca8a04', 'border' => '#fef08a'],
                                ['bg' => '#ffe4e6', 'color' => '#e11d48', 'border' => '#fecdd3'],
                                ['bg' => '#e0f2fe', 'color' => '#0284c7', 'border' => '#bae6fd'],
                            ];
                        @endphp
                        @foreach ($coreValues as $coreValue)
                            @php
                                $iconClass = $coreValue->icon ?: 'fa-solid fa-heart';
                                $palette = $fallbackColors[$loop->index % count($fallbackColors)];
                                foreach ($colorPalettes as $key => $colors) {
                                    if (str_contains($iconClass, $key) || str_contains(strtolower($coreValue->title ?? ''), $key)) {
                                        $palette = $colors;
                                        break;
                                    }
                                }
                            @endphp
                            <tr>
                                <td>#{{ $coreValue->id }}</td>
                                <td>
                                    <div style="width: 40px; height: 40px; border-radius: 8px; background: {{ $palette['bg'] }}; color: {{ $palette['color'] }}; border: 1px solid {{ $palette['border'] }}; display: inline-flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                                        <i class="{{ $iconClass }}"></i>
                                    </div>
                                </td>
                                <td><strong>{{ $coreValue->title }}</strong></td>
                                <td>{{ \Illuminate\Support\Str::limit($coreValue->description, 120) }}</td>
                                <td>
                                    <div class="ts-actions">
                                        <a href="{{ route('admin.about-our-core-values.edit', $coreValue) }}" class="ts-action-btn ts-edit-btn">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.about-our-core-values.destroy', $coreValue) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this core value?')">
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

            @if ($coreValues->hasPages())
                <div class="ts-pagination">
                    {{ $coreValues->links() }}
                </div>
            @endif
        @else
            <div class="ts-empty-state">
                <div class="ts-empty-icon">✦</div>
                <h3>No core values found.</h3>
                <p>Add your first About Our Core Value.</p>
                <a href="{{ route('admin.about-our-core-values.create') }}" class="ts-primary-btn">
                    Create Core Value
                </a>
            </div>
        @endif
        </div>
    </div>
@endsection