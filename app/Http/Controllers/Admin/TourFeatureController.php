<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourFeatureRequest;
use App\Http\Requests\UpdateTourFeatureRequest;
use App\Models\Tour;
use App\Models\TourFeature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class TourFeatureController extends Controller
{
    /**
     * Display all tour features.
     */
    public function index(Request $request): View
    {
        $tourFeatures = TourFeature::query()
            ->with('tour.tourType')
            ->when(
                $request->filled('tour_id'),
                fn ($query) => $query->where(
                    'tour_id',
                    $request->integer('tour_id')
                )
            )
            ->when(
                $request->filled('type'),
                fn ($query) => $query->where(
                    'type',
                    $request->string('type')->toString()
                )
            )
            ->orderBy('tour_id')
            ->orderBy('type')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        $tours = Tour::query()
            ->with('tourType')
            ->orderBy('title')
            ->get();

        $featureTypes = TourFeature::types();

        return view(
            'pages.tour-features.index',
            compact(
                'tourFeatures',
                'tours',
                'featureTypes'
            )
        );
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        $tours = Tour::query()
            ->with('tourType')
            ->orderBy('title')
            ->get();

        $featureTypes = TourFeature::types();

        return view(
            'pages.tour-features.create',
            compact('tours', 'featureTypes')
        );
    }

    /**
     * Store a new tour feature.
     */
    public function store(
        StoreTourFeatureRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $imagePath = null;

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store(
                    'tour-features',
                    'public'
                );

                $validated['image'] = $imagePath;
            }

            /*
             * Places use an image and do not use an icon.
             */
            if (
                $validated['type'] ===
                TourFeature::TYPE_PLACE_COVERED
            ) {
                $validated['icon'] = null;
            } else {
                /*
                 * Inclusions and highlights use icons,
                 * so no image should be stored.
                 */
                $validated['image'] = null;
            }

            $validated['sort_order'] =
                $validated['sort_order'] ?? 0;

            DB::transaction(function () use ($validated): void {
                TourFeature::create($validated);
            });

            return redirect()
                ->route('admin.tour-features.index')
                ->with(
                    'success',
                    'Tour feature created successfully.'
                );
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create tour feature. Please try again.'
                );
        }
    }

    /**
     * Show the edit form.
     */
    public function edit(
        TourFeature $tourFeature
    ): View {
        $tourFeature->load('tour.tourType');

        $tours = Tour::query()
            ->with('tourType')
            ->orderBy('title')
            ->get();

        $featureTypes = TourFeature::types();

        return view(
            'pages.tour-features.edit',
            compact(
                'tourFeature',
                'tours',
                'featureTypes'
            )
        );
    }

    /**
     * Update the tour feature.
     */
    public function update(
        UpdateTourFeatureRequest $request,
        TourFeature $tourFeature
    ): RedirectResponse {
        $validated = $request->validated();

        $oldImage = $tourFeature->image;

        $newImage = null;

        try {
            if ($request->hasFile('image')) {
                $newImage = $request->file('image')->store(
                    'tour-features',
                    'public'
                );

                $validated['image'] = $newImage;
            }

            if (
                $validated['type'] ===
                TourFeature::TYPE_PLACE_COVERED
            ) {
                $validated['icon'] = null;

                if (
                    $request->boolean('remove_image') &&
                    ! $request->hasFile('image')
                ) {
                    $validated['image'] = null;
                }
            } else {
                $validated['image'] = null;
            }

            $validated['sort_order'] =
                $validated['sort_order'] ?? 0;

            unset($validated['remove_image']);

            DB::transaction(function () use (
                $tourFeature,
                $validated
            ): void {
                $tourFeature->update($validated);
            });

            $imageWasReplaced =
                $newImage !== null &&
                $oldImage !== null;

            $imageWasRemoved =
                $validated['type'] !==
                    TourFeature::TYPE_PLACE_COVERED ||
                (
                    array_key_exists('image', $validated) &&
                    $validated['image'] === null
                );

            if (
                $oldImage &&
                ($imageWasReplaced || $imageWasRemoved)
            ) {
                Storage::disk('public')->delete($oldImage);
            }

            return redirect()
                ->route('admin.tour-features.index')
                ->with(
                    'success',
                    'Tour feature updated successfully.'
                );
        } catch (Throwable $exception) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to update tour feature. Please try again.'
                );
        }
    }

    /**
     * Delete the tour feature.
     */
    public function destroy(
        TourFeature $tourFeature
    ): RedirectResponse {
        $image = $tourFeature->image;

        try {
            DB::transaction(function () use ($tourFeature): void {
                $tourFeature->delete();
            });

            if ($image) {
                Storage::disk('public')->delete($image);
            }

            return redirect()
                ->route('admin.tour-features.index')
                ->with(
                    'success',
                    'Tour feature deleted successfully.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'Unable to delete tour feature. Please try again.'
            );
        }
    }
}
