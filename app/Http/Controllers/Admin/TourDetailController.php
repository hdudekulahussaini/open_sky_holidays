<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourDetailRequest;
use App\Http\Requests\UpdateTourDetailRequest;
use App\Models\Tour;
use App\Models\TourDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class TourDetailController extends Controller
{
    /**
     * Display all tour details.
     */
    public function index(): View
    {
        $tourDetails = TourDetail::query()
            ->with('tour.tourType')
            ->latest()
            ->paginate(10);

        return view(
            'pages.tour-details.index',
            compact('tourDetails')
        );
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        $tours = Tour::query()
            ->with('tourType')
            ->whereDoesntHave('detail')
            ->orderBy('title')
            ->get();

        return view(
            'pages.tour-details.create',
            compact('tours')
        );
    }

    /**
     * Store new tour details.
     */
    public function store(
        StoreTourDetailRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $galleryPaths = [];

        try {
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $galleryPaths[] = $image->store(
                        'tour-details/gallery',
                        'public'
                    );
                }
            }

            DB::transaction(function () use (
                $validated,
                $galleryPaths
            ): void {
                $validated['gallery'] = $galleryPaths;

                TourDetail::create($validated);
            });

            return redirect()
                ->route('admin.tour-details.index')
                ->with(
                    'success',
                    'Tour details created successfully.'
                );
        } catch (Throwable $exception) {
            foreach ($galleryPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create tour details. Please try again.'
                );
        }
    }

    /**
     * Show the edit form.
     */
    public function edit(TourDetail $tourDetail): View
    {
        $tours = Tour::query()
            ->with('tourType')
            ->where(function ($query) use ($tourDetail) {
                $query
                    ->whereDoesntHave('detail')
                    ->orWhere('id', $tourDetail->tour_id);
            })
            ->orderBy('title')
            ->get();

        return view(
            'pages.tour-details.edit',
            compact('tourDetail', 'tours')
        );
    }

    /**
     * Update tour details.
     */
    public function update(
        UpdateTourDetailRequest $request,
        TourDetail $tourDetail
    ): RedirectResponse {
        $validated = $request->validated();

        $oldGallery = is_array($tourDetail->gallery)
            ? $tourDetail->gallery
            : [];

        /*
         * Keep only genuine existing image paths.
         * This prevents invalid hidden-input values.
         */
        $requestedExistingGallery = $request->input(
            'existing_gallery',
            []
        );

        $requestedExistingGallery = is_array(
            $requestedExistingGallery
        )
            ? $requestedExistingGallery
            : [];

        $existingGallery = array_values(
            array_intersect(
                $oldGallery,
                $requestedExistingGallery
            )
        );

        $newGallery = [];

        try {
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $newGallery[] = $image->store(
                        'tour-details/gallery',
                        'public'
                    );
                }
            }

            $finalGallery = array_values(
                array_merge(
                    $existingGallery,
                    $newGallery
                )
            );

            if (count($finalGallery) > 10) {
                foreach ($newGallery as $path) {
                    Storage::disk('public')->delete($path);
                }

                return back()
                    ->withInput()
                    ->withErrors([
                        'gallery' => 'The gallery may contain a maximum of 10 images.',
                    ]);
            }

            $removedImages = array_diff(
                $oldGallery,
                $existingGallery
            );

            DB::transaction(function () use (
                $tourDetail,
                $validated,
                $finalGallery
            ): void {
                unset($validated['existing_gallery']);

                $validated['gallery'] = $finalGallery;

                $tourDetail->update($validated);
            });

            foreach ($removedImages as $removedImage) {
                Storage::disk('public')->delete($removedImage);
            }

            return redirect()
                ->route('admin.tour-details.index')
                ->with(
                    'success',
                    'Tour details updated successfully.'
                );
        } catch (Throwable $exception) {
            /*
             * Remove only newly uploaded files.
             * Existing images must remain untouched after failure.
             */
            foreach ($newGallery as $path) {
                Storage::disk('public')->delete($path);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to update tour details. Please try again.'
                );
        }
    }

    /**
     * Delete tour details.
     */
    public function destroy(
        TourDetail $tourDetail
    ): RedirectResponse {
        $gallery = is_array($tourDetail->gallery)
            ? $tourDetail->gallery
            : [];

        try {
            DB::transaction(function () use ($tourDetail): void {
                $tourDetail->delete();
            });

            foreach ($gallery as $image) {
                Storage::disk('public')->delete($image);
            }

            return redirect()
                ->route('admin.tour-details.index')
                ->with(
                    'success',
                    'Tour details deleted successfully.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'Unable to delete tour details. Please try again.'
            );
        }
    }
}
