@extends('admin.layouts.app')

@section('title', 'Tour Features')

@section('content')

    {{-- Page Header --}}
    <div class="tf-index-header">

        <div>
            <h1>Tour Features</h1>

            <p>
                View package inclusions, places covered,
                and tour highlights for each tour.
            </p>
        </div>

        <a href="{{ route('admin.tour-features.create') }}" class="tf-create-button">
            <span>+</span>

            Add Tour Features
        </a>

    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="tf-alert tf-alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
        <div class="tf-alert tf-alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tour Filter --}}
    <div class="tf-filter-card">

        <form action="{{ route('admin.tour-features.index') }}" method="GET" class="tf-filter-form">

            <div class="tf-filter-group">

                <label for="tour_id">
                    Select Tour
                </label>

                <select name="tour_id" id="tour_id">
                    <option value="">
                        All Tours
                    </option>

                    @foreach ($filterTours as $tour)
                        <option value="{{ $tour->id }}" @selected((string) request('tour_id') === (string) $tour->id)>
                            {{ $tour->title }}

                            @if ($tour->tourType)
                                — {{ $tour->tourType->name }}
                            @endif
                        </option>
                    @endforeach

                </select>

            </div>

            <div class="tf-filter-actions">

                <button type="submit" class="tf-filter-button">
                    Filter
                </button>

                <a href="{{ route('admin.tour-features.index') }}" class="tf-reset-button">
                    Reset
                </a>

            </div>

        </form>

    </div>

    {{-- Tour Feature Groups --}}
    <div class="tf-tour-list">

        @forelse ($tours as $tour)

            @php
                $packageInclusions = $tour->features
                    ->where('type', \App\Models\TourFeature::TYPE_PACKAGE_INCLUSION)
                    ->values();

                $placesCovered = $tour->features->where('type', \App\Models\TourFeature::TYPE_PLACE_COVERED)->values();

                $tourHighlights = $tour->features
                    ->where('type', \App\Models\TourFeature::TYPE_TOUR_HIGHLIGHT)
                    ->values();

                $activeCount = $tour->features->where('status', 'active')->count();

                $inactiveCount = $tour->features->where('status', 'inactive')->count();
            @endphp

            <div class="tf-tour-card">

                {{-- Tour Header --}}
                <div class="tf-tour-header">

                    <div class="tf-tour-information">

                        @if ($tour->thumbnail)
                            <img src="{{ asset('storage/' . $tour->thumbnail) }}"
                                alt="{{ $tour->title }}" class="tf-tour-thumbnail">
                        @else
                            <div class="tf-tour-thumbnail-empty">
                                {{ strtoupper(substr($tour->title, 0, 1)) }}
                            </div>
                        @endif

                        <div class="tf-tour-title">

                            <h2>
                                {{ $tour->title }}
                            </h2>

                            <div class="tf-tour-meta">

                                @if ($tour->tourType)
                                    <span>
                                        {{ $tour->tourType->name }}
                                    </span>
                                @endif

                                @if ($tour->country)
                                    <span>
                                        {{ $tour->country }}
                                    </span>
                                @endif

                                @if ($tour->duration)
                                    <span>
                                        {{ $tour->duration }}
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                    <div class="tf-tour-header-actions">

                        <div class="tf-tour-counts">

                            <span class="tf-active-count">
                                {{ $activeCount }} Active
                            </span>

                            @if ($inactiveCount > 0)
                                <span class="tf-inactive-count">
                                    {{ $inactiveCount }} Inactive
                                </span>
                            @endif

                        </div>

                        <a href="{{ route('admin.tour-features.create', ['tour_id' => $tour->id]) }}"
                            class="tf-add-more-button">
                            + Add More
                        </a>

                    </div>

                </div>

                {{-- Three Columns --}}
                <div class="tf-feature-columns">

                    {{-- Package Inclusions Column --}}
                    <section class="tf-feature-column">

                        <div class="tf-column-header">

                            <div>
                                <h3>Package Inclusions</h3>

                                <p>
                                    Services included in the package
                                </p>
                            </div>

                            <span class="tf-column-count">
                                {{ $packageInclusions->count() }}
                            </span>

                        </div>

                        <div class="tf-column-list">

                            @forelse ($packageInclusions
                                    as $feature)
                                <article class="tf-feature-item">

                                    <div class="tf-feature-content">

                                        <div class="tf-feature-title-row">

                                            <strong>
                                                {{ $feature->title }}
                                            </strong>

                                            <span
                                                class="tf-status-dot
                                                    {{ $feature->status === 'active' ? 'tf-status-dot-active' : 'tf-status-dot-inactive' }}"
                                                title="{{ ucfirst($feature->status) }}"></span>

                                        </div>

                                        @if ($feature->description)
                                            <p>
                                                {{ \Illuminate\Support\Str::limit($feature->description, 90) }}
                                            </p>
                                        @endif

                                        <div class="tf-feature-bottom">

                                            <span class="tf-sort-order">
                                                Order:
                                                {{ $feature->sort_order }}
                                            </span>

                                            <div class="tf-item-actions">

                                                <a href="{{ route('admin.tour-features.edit', $feature) }}"
                                                    class="tf-item-edit">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.tour-features.destroy', $feature) }}"
                                                    method="POST"
                                                    onsubmit="return confirm(
                                                        'Delete this package inclusion?'
                                                    )">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="tf-item-delete">
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @empty

                                <div class="tf-column-empty">

                                    <strong>
                                        No package inclusions
                                    </strong>

                                    <span>
                                        Add services included in this tour.
                                    </span>

                                </div>
                            @endforelse

                        </div>

                    </section>

                    {{-- Places Covered Column --}}
                    <section class="tf-feature-column">

                        <div class="tf-column-header">

                            <div>
                                <h3>Places Covered</h3>

                                <p>
                                    Destinations included in the tour
                                </p>
                            </div>

                            <span class="tf-column-count">
                                {{ $placesCovered->count() }}
                            </span>

                        </div>

                        <div class="tf-column-list">

                            @forelse ($placesCovered as $feature)
                                <article class="tf-feature-item tf-place-item">

                                    @if ($feature->image)
                                        <img src="{{ asset('storage/' . $feature->image) }}"
                                            alt="{{ $feature->title }}" class="tf-place-image">
                                    @else
                                        <div class="tf-place-image-empty">
                                            No image
                                        </div>
                                    @endif

                                    <div class="tf-feature-content">

                                        <div class="tf-feature-title-row">

                                            <strong>
                                                {{ $feature->title }}
                                            </strong>

                                            <span
                                                class="tf-status-dot
                                                    {{ $feature->status === 'active' ? 'tf-status-dot-active' : 'tf-status-dot-inactive' }}"
                                                title="{{ ucfirst($feature->status) }}"></span>

                                        </div>

                                        @if ($feature->description)
                                            <p>
                                                {{ \Illuminate\Support\Str::limit($feature->description, 90) }}
                                            </p>
                                        @endif

                                        <div class="tf-feature-bottom">

                                            <span class="tf-sort-order">
                                                Order:
                                                {{ $feature->sort_order }}
                                            </span>

                                            <div class="tf-item-actions">

                                                <a href="{{ route('admin.tour-features.edit', $feature) }}"
                                                    class="tf-item-edit">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.tour-features.destroy', $feature) }}"
                                                    method="POST"
                                                    onsubmit="return confirm(
                                                        'Delete this place?'
                                                    )">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="tf-item-delete">
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @empty

                                <div class="tf-column-empty">

                                    <strong>
                                        No places covered
                                    </strong>

                                    <span>
                                        Add destinations for this tour.
                                    </span>

                                </div>
                            @endforelse

                        </div>

                    </section>

                    {{-- Tour Highlights Column --}}
                    <section class="tf-feature-column">

                        <div class="tf-column-header">

                            <div>
                                <h3>Tour Highlights</h3>

                                <p>
                                    Main experiences and attractions
                                </p>
                            </div>

                            <span class="tf-column-count">
                                {{ $tourHighlights->count() }}
                            </span>

                        </div>

                        <div class="tf-column-list">

                            @forelse ($tourHighlights as $feature)
                                <article class="tf-feature-item">

                                    <div class="tf-feature-content">

                                        <div class="tf-feature-title-row">

                                            <strong>
                                                {{ $feature->title }}
                                            </strong>

                                            <span
                                                class="tf-status-dot
                                                    {{ $feature->status === 'active' ? 'tf-status-dot-active' : 'tf-status-dot-inactive' }}"
                                                title="{{ ucfirst($feature->status) }}"></span>

                                        </div>

                                        @if ($feature->description)
                                            <p>
                                                {{ \Illuminate\Support\Str::limit($feature->description, 90) }}
                                            </p>
                                        @endif

                                        <div class="tf-feature-bottom">

                                            <span class="tf-sort-order">
                                                Order:
                                                {{ $feature->sort_order }}
                                            </span>

                                            <div class="tf-item-actions">

                                                <a href="{{ route('admin.tour-features.edit', $feature) }}"
                                                    class="tf-item-edit">
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.tour-features.destroy', $feature) }}"
                                                    method="POST"
                                                    onsubmit="return confirm(
                                                        'Delete this tour highlight?'
                                                    )">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="tf-item-delete">
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </article>

                            @empty

                                <div class="tf-column-empty">

                                    <strong>
                                        No tour highlights
                                    </strong>

                                    <span>
                                        Add important experiences
                                        for this tour.
                                    </span>

                                </div>
                            @endforelse

                        </div>

                    </section>

                </div>

            </div>

        @empty

            <div class="tf-empty-state">

                <div class="tf-empty-mark">
                    +
                </div>

                <h2>
                    No tour features found
                </h2>

                <p>
                    Add package inclusions, places covered,
                    and highlights for your tours.
                </p>

                <a href="{{ route('admin.tour-features.create') }}">
                    Create Tour Features
                </a>

            </div>

        @endforelse

    </div>

    {{-- Pagination --}}
    @if ($tours->hasPages())
        <div class="tf-pagination">
            {{ $tours->links() }}
        </div>
    @endif

@endsection

@push('styles')
    <style>
        .tf-index-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .tf-index-header h1 {
            margin: 0 0 6px;
            color: #172033;
            font-size: 27px;
            font-weight: 750;
        }

        .tf-index-header p {
            margin: 0;
            color: #7b8798;
            font-size: 14px;
        }

        .tf-create-button {
            display: inline-flex;
            min-height: 44px;
            padding: 10px 16px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            background: #2563eb;
            border-radius: 10px;
            box-shadow:
                0 7px 16px rgba(37, 99, 235, 0.2);
        }

        .tf-create-button span {
            font-size: 20px;
            font-weight: 400;
            line-height: 1;
        }

        .tf-alert {
            margin-bottom: 20px;
            padding: 13px 15px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 10px;
        }

        .tf-alert-success {
            color: #166534;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .tf-alert-error {
            color: #b91c1c;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .tf-filter-card {
            margin-bottom: 24px;
            padding: 18px;
            background: #ffffff;
            border: 1px solid #e4eaf1;
            border-radius: 15px;
            box-shadow:
                0 8px 28px rgba(15, 23, 42, 0.05);
        }

        .tf-filter-form {
            display: grid;
            grid-template-columns:
                minmax(250px, 1fr) auto;
            gap: 14px;
            align-items: end;
        }

        .tf-filter-group label {
            display: block;
            margin-bottom: 7px;
            color: #344054;
            font-size: 12px;
            font-weight: 700;
        }

        .tf-filter-group select {
            width: 100%;
            min-height: 43px;
            padding: 9px 12px;
            color: #334155;
            font: inherit;
            font-size: 13px;
            background: #ffffff;
            border: 1px solid #d8e0e9;
            border-radius: 9px;
            outline: none;
        }

        .tf-filter-actions {
            display: flex;
            gap: 9px;
        }

        .tf-filter-button,
        .tf-reset-button {
            display: inline-flex;
            min-height: 43px;
            padding: 9px 15px;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border-radius: 9px;
        }

        .tf-filter-button {
            color: #ffffff;
            background: #2563eb;
            border: 1px solid #2563eb;
        }

        .tf-reset-button {
            color: #475569;
            background: #ffffff;
            border: 1px solid #d7dee7;
        }

        .tf-tour-list {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .tf-tour-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e4eaf1;
            border-radius: 17px;
            box-shadow:
                0 9px 30px rgba(15, 23, 42, 0.055);
        }

        .tf-tour-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 19px 21px;
            background: #ffffff;
            border-bottom: 1px solid #edf1f5;
        }

        .tf-tour-information {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 14px;
        }

        .tf-tour-thumbnail,
        .tf-tour-thumbnail-empty {
            flex: 0 0 64px;
            width: 64px;
            height: 52px;
            border-radius: 10px;
        }

        .tf-tour-thumbnail {
            object-fit: cover;
            border: 1px solid #e2e8f0;
        }

        .tf-tour-thumbnail-empty {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 18px;
            font-weight: 800;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .tf-tour-title {
            min-width: 0;
        }

        .tf-tour-title h2 {
            margin: 0 0 7px;
            overflow: hidden;
            color: #1e293b;
            font-size: 18px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .tf-tour-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
        }

        .tf-tour-meta span {
            display: inline-flex;
            padding: 4px 8px;
            color: #64748b;
            font-size: 10px;
            font-weight: 650;
            background: #f1f5f9;
            border-radius: 999px;
        }

        .tf-tour-header-actions {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .tf-tour-counts {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .tf-active-count,
        .tf-inactive-count {
            display: inline-flex;
            min-height: 27px;
            padding: 5px 9px;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            border-radius: 999px;
        }

        .tf-active-count {
            color: #15803d;
            background: #dcfce7;
        }

        .tf-inactive-count {
            color: #b91c1c;
            background: #fee2e2;
        }

        .tf-add-more-button {
            display: inline-flex;
            min-height: 37px;
            padding: 8px 12px;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
        }

        .tf-feature-columns {
            display: grid;
            grid-template-columns:
                repeat(3, minmax(0, 1fr));
            align-items: start;
        }

        .tf-feature-column {
            min-width: 0;
            padding: 20px;
            border-right: 1px solid #edf1f5;
        }

        .tf-feature-column:last-child {
            border-right: 0;
        }

        .tf-column-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 13px;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px solid #edf1f5;
        }

        .tf-column-header h3 {
            margin: 0 0 4px;
            color: #273247;
            font-size: 15px;
            font-weight: 750;
        }

        .tf-column-header p {
            margin: 0;
            color: #8a95a5;
            font-size: 10px;
            line-height: 1.45;
        }

        .tf-column-count {
            display: inline-flex;
            min-width: 28px;
            height: 28px;
            padding: 4px 8px;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 11px;
            font-weight: 800;
            background: #eff6ff;
            border-radius: 999px;
        }

        .tf-column-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .tf-feature-item {
            overflow: hidden;
            background: #f8fafc;
            border: 1px solid #e7ecf2;
            border-radius: 11px;
        }

        .tf-place-item {
            display: grid;
            grid-template-columns: 92px minmax(0, 1fr);
        }

        .tf-place-image,
        .tf-place-image-empty {
            width: 92px;
            height: 100%;
            min-height: 125px;
        }

        .tf-place-image {
            display: block;
            object-fit: cover;
        }

        .tf-place-image-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 9px;
            text-align: center;
            background: #eef2f6;
        }

        .tf-feature-content {
            min-width: 0;
            padding: 13px;
        }

        .tf-feature-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .tf-feature-title-row strong {
            color: #273247;
            font-size: 12px;
            line-height: 1.45;
        }

        .tf-status-dot {
            flex: 0 0 8px;
            width: 8px;
            height: 8px;
            margin-top: 4px;
            border-radius: 50%;
        }

        .tf-status-dot-active {
            background: #22c55e;
        }

        .tf-status-dot-inactive {
            background: #ef4444;
        }

        .tf-feature-content p {
            margin: 7px 0 12px;
            color: #7b8798;
            font-size: 10px;
            line-height: 1.55;
        }

        .tf-feature-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 11px;
            padding-top: 10px;
            border-top: 1px solid #e5eaf0;
        }

        .tf-sort-order {
            color: #94a3b8;
            font-size: 9px;
            font-weight: 650;
        }

        .tf-item-actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .tf-item-actions form {
            margin: 0;
        }

        .tf-item-edit,
        .tf-item-delete {
            padding: 0;
            font: inherit;
            font-size: 9px;
            font-weight: 750;
            text-decoration: none;
            cursor: pointer;
            background: transparent;
            border: 0;
        }

        .tf-item-edit {
            color: #2563eb;
        }

        .tf-item-delete {
            color: #dc2626;
        }

        .tf-column-empty {
            display: flex;
            min-height: 130px;
            padding: 20px;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #94a3b8;
            text-align: center;
            background: #f8fafc;
            border: 1px dashed #d6dee8;
            border-radius: 11px;
        }

        .tf-column-empty strong {
            margin-bottom: 5px;
            color: #64748b;
            font-size: 12px;
        }

        .tf-column-empty span {
            max-width: 190px;
            font-size: 10px;
            line-height: 1.5;
        }

        .tf-empty-state {
            padding: 65px 25px;
            text-align: center;
            background: #ffffff;
            border: 1px solid #e4eaf1;
            border-radius: 16px;
        }

        .tf-empty-mark {
            display: inline-flex;
            width: 58px;
            height: 58px;
            margin-bottom: 15px;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 28px;
            background: #eff6ff;
            border-radius: 15px;
        }

        .tf-empty-state h2 {
            margin: 0 0 8px;
            color: #273247;
            font-size: 18px;
        }

        .tf-empty-state p {
            margin: 0 0 17px;
            color: #8792a2;
            font-size: 13px;
        }

        .tf-empty-state a {
            color: #2563eb;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .tf-pagination {
            margin-top: 23px;
            padding: 17px;
            background: #ffffff;
            border: 1px solid #e4eaf1;
            border-radius: 13px;
        }

        @media (max-width: 1100px) {
            .tf-feature-columns {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .tf-feature-column:nth-child(2) {
                border-right: 0;
            }

            .tf-feature-column:nth-child(3) {
                grid-column: 1 / -1;
                border-top: 1px solid #edf1f5;
            }
        }

        @media (max-width: 750px) {

            .tf-index-header,
            .tf-tour-header {
                align-items: stretch;
                flex-direction: column;
            }

            .tf-create-button {
                width: 100%;
            }

            .tf-filter-form {
                grid-template-columns: 1fr;
            }

            .tf-filter-actions {
                width: 100%;
            }

            .tf-filter-button,
            .tf-reset-button {
                flex: 1;
            }

            .tf-tour-header-actions {
                justify-content: space-between;
            }

            .tf-feature-columns {
                grid-template-columns: 1fr;
            }

            .tf-feature-column {
                border-right: 0;
                border-bottom: 1px solid #edf1f5;
            }

            .tf-feature-column:nth-child(3) {
                grid-column: auto;
                border-top: 0;
                border-bottom: 0;
            }
        }

        @media (max-width: 480px) {
            .tf-tour-information {
                align-items: flex-start;
            }

            .tf-tour-title h2 {
                white-space: normal;
            }

            .tf-tour-header-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .tf-tour-counts {
                flex-wrap: wrap;
            }

            .tf-add-more-button {
                width: 100%;
            }

            .tf-place-item {
                grid-template-columns: 1fr;
            }

            .tf-place-image,
            .tf-place-image-empty {
                width: 100%;
                height: 160px;
                min-height: 160px;
            }

            .tf-feature-bottom {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush
