<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Models\Tour;
use App\Models\TourFeature;
use App\Models\TourType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class TourController extends Controller
{
    public function index(): View
    {
        $tours = Tour::query()
            ->with(['tourType:id,name,slug', 'detail'])
            ->withCount(['packageInclusions', 'placesCovered', 'tourHighlights'])
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.tours.index',
            compact('tours')
        );
    }

    public function create(): View
    {
        $tourTypes = TourType::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return view(
            'pages.tours.create',
            compact('tourTypes')
        );
    }

    public function store(
        StoreTourRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title']
        );

        $uploadedFiles = [];

        try {
            DB::beginTransaction();

            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('tours', 'public');
            $uploadedFiles[] = $validated['thumbnail'];

            $tour = Tour::create($validated);

            // Create detail heading/description & gallery
            $galleryPaths = [];
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store('tour-details/gallery', 'public');
                    $galleryPaths[] = $path;
                    $uploadedFiles[] = $path;
                }
            }

            $tour->detail()->create([
                'heading' => $validated['detail']['heading'],
                'description' => $validated['detail']['description'],
                'gallery' => $galleryPaths,
                'status' => $validated['detail']['status'],
            ]);

            // Save package inclusions
            if (! empty($validated['package_inclusions'])) {
                foreach ($validated['package_inclusions'] as $item) {
                    $tour->features()->create([
                        'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'status' => 'active',
                    ]);
                }
            }

            // Save highlights
            if (! empty($validated['tour_highlights'])) {
                foreach ($validated['tour_highlights'] as $item) {
                    $tour->features()->create([
                        'type' => TourFeature::TYPE_TOUR_HIGHLIGHT,
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'status' => 'active',
                    ]);
                }
            }

            // Save places covered with image uploads
            if (! empty($validated['places_covered'])) {
                foreach ($validated['places_covered'] as $index => $item) {
                    $placeImage = null;
                    if ($request->hasFile("places_covered.$index.image")) {
                        $placeImage = $request->file("places_covered.$index.image")->store('tour-features', 'public');
                        $uploadedFiles[] = $placeImage;
                    }

                    $tour->features()->create([
                        'type' => TourFeature::TYPE_PLACE_COVERED,
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'image' => $placeImage,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.tours.index')
                ->with(
                    'success',
                    'Tour created successfully.'
                );
        } catch (Throwable $exception) {
            DB::rollBack();

            foreach ($uploadedFiles as $file) {
                Storage::disk('public')->delete($file);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create the tour: '.$exception->getMessage()
                );
        }
    }

    public function edit(Tour $tour): View
    {
        $tour->load(['detail', 'features']);

        $tourTypes = TourType::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return view(
            'pages.tours.edit',
            compact(
                'tour',
                'tourTypes'
            )
        );
    }

    public function update(
        UpdateTourRequest $request,
        Tour $tour
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $tour->id
        );

        $oldThumbnail = $tour->thumbnail;
        $newThumbnail = null;

        $newUploadedFiles = [];
        $deletedFiles = [];

        try {
            DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                $newThumbnail = $request
                    ->file('thumbnail')
                    ->store('tours', 'public');
                $validated['thumbnail'] = $newThumbnail;
                $newUploadedFiles[] = $newThumbnail;
            } else {
                unset($validated['thumbnail']);
            }

            $tour->update($validated);

            // Handle TourDetail & Gallery
            $tourDetail = $tour->detail;
            $oldGallery = $tourDetail && is_array($tourDetail->gallery) ? $tourDetail->gallery : [];
            $retainedGallery = $request->input('existing_gallery', []);
            $retainedGallery = is_array($retainedGallery) ? $retainedGallery : [];
            $existingGallery = array_values(array_intersect($oldGallery, $retainedGallery));

            $newGalleryPaths = [];
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store('tour-details/gallery', 'public');
                    $newGalleryPaths[] = $path;
                    $newUploadedFiles[] = $path;
                }
            }

            $finalGallery = array_merge($existingGallery, $newGalleryPaths);

            if (count($finalGallery) > 10) {
                // Rollback and clean up new files
                throw new \Exception('The gallery may contain a maximum of 10 images.');
            }

            $removedGalleryImages = array_diff($oldGallery, $existingGallery);

            $tour->detail()->updateOrCreate(
                ['tour_id' => $tour->id],
                [
                    'heading' => $validated['detail']['heading'],
                    'description' => $validated['detail']['description'],
                    'gallery' => $finalGallery,
                    'status' => $validated['detail']['status'],
                ]
            );

            // Handle Features Syncing: Inclusions
            $submittedInclusions = $validated['package_inclusions'] ?? [];
            $submittedInclusionsIds = collect($submittedInclusions)->pluck('id')->filter()->all();

            $inclusionsToDelete = $tour->packageInclusions()->whereNotIn('id', $submittedInclusionsIds)->get();
            foreach ($inclusionsToDelete as $item) {
                $item->delete();
            }

            foreach ($submittedInclusions as $item) {
                if (! empty($item['id'])) {
                    $tour->packageInclusions()->where('id', $item['id'])->update([
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                    ]);
                } else {
                    $tour->packageInclusions()->create([
                        'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'status' => 'active',
                    ]);
                }
            }

            // Handle Features Syncing: Highlights
            $submittedHighlights = $validated['tour_highlights'] ?? [];
            $submittedHighlightsIds = collect($submittedHighlights)->pluck('id')->filter()->all();

            $highlightsToDelete = $tour->tourHighlights()->whereNotIn('id', $submittedHighlightsIds)->get();
            foreach ($highlightsToDelete as $item) {
                $item->delete();
            }

            foreach ($submittedHighlights as $item) {
                if (! empty($item['id'])) {
                    $tour->tourHighlights()->where('id', $item['id'])->update([
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                    ]);
                } else {
                    $tour->tourHighlights()->create([
                        'type' => TourFeature::TYPE_TOUR_HIGHLIGHT,
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'status' => 'active',
                    ]);
                }
            }

            // Handle Features Syncing: Places Covered
            $submittedPlaces = $validated['places_covered'] ?? [];
            $submittedPlacesIds = collect($submittedPlaces)->pluck('id')->filter()->all();

            $placesToDelete = $tour->placesCovered()->whereNotIn('id', $submittedPlacesIds)->get();
            foreach ($placesToDelete as $item) {
                if ($item->image) {
                    $deletedFiles[] = $item->image;
                }
                $item->delete();
            }

            foreach ($submittedPlaces as $index => $item) {
                $placeImage = null;
                $hasNewImage = $request->hasFile("places_covered.$index.image");

                if ($hasNewImage) {
                    $placeImage = $request->file("places_covered.$index.image")->store('tour-features', 'public');
                    $newUploadedFiles[] = $placeImage;
                }

                if (! empty($item['id'])) {
                    $existingPlace = $tour->placesCovered()->findOrFail($item['id']);
                    $placeUpdate = [
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                    ];

                    if ($hasNewImage) {
                        $placeUpdate['image'] = $placeImage;
                        if ($existingPlace->image) {
                            $deletedFiles[] = $existingPlace->image;
                        }
                    }

                    $existingPlace->update($placeUpdate);
                } else {
                    $tour->placesCovered()->create([
                        'type' => TourFeature::TYPE_PLACE_COVERED,
                        'title' => $item['title'],
                        'description' => $item['description'] ?? null,
                        'image' => $placeImage,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            // Clear removed gallery and place images
            foreach ($removedGalleryImages as $img) {
                Storage::disk('public')->delete($img);
            }

            if ($newThumbnail && $oldThumbnail) {
                Storage::disk('public')->delete($oldThumbnail);
            }

            foreach ($deletedFiles as $file) {
                Storage::disk('public')->delete($file);
            }

            return redirect()
                ->route('admin.tours.index')
                ->with(
                    'success',
                    'Tour updated successfully.'
                );
        } catch (Throwable $exception) {
            DB::rollBack();

            foreach ($newUploadedFiles as $file) {
                Storage::disk('public')->delete($file);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to update the tour: '.$exception->getMessage()
                );
        }
    }

    public function destroy(
        Tour $tour
    ): RedirectResponse {
        $filesToDelete = [];

        if ($tour->thumbnail) {
            $filesToDelete[] = $tour->thumbnail;
        }

        $tour->load(['detail', 'placesCovered']);
        if ($tour->detail && is_array($tour->detail->gallery)) {
            $filesToDelete = array_merge($filesToDelete, $tour->detail->gallery);
        }

        foreach ($tour->placesCovered as $place) {
            if ($place->image) {
                $filesToDelete[] = $place->image;
            }
        }

        try {
            DB::beginTransaction();

            $tour->delete();

            DB::commit();

            foreach ($filesToDelete as $file) {
                Storage::disk('public')->delete($file);
            }

            return redirect()
                ->route('admin.tours.index')
                ->with(
                    'success',
                    'Tour deleted successfully.'
                );
        } catch (Throwable $exception) {
            DB::rollBack();

            report($exception);

            return back()->with(
                'error',
                'Unable to delete this tour. Please try again.'
            );
        }
    }

    private function generateUniqueSlug(
        ?string $requestedSlug,
        string $title,
        ?int $ignoreTourId = null
    ): string {
        $baseSlug = Str::slug(
            $requestedSlug ?: $title
        );

        if ($baseSlug === '') {
            $baseSlug = 'tour';
        }

        $slug = $baseSlug;
        $number = 1;

        while (
            Tour::query()
                ->when(
                    $ignoreTourId,
                    fn ($query) => $query->where(
                        'id',
                        '!=',
                        $ignoreTourId
                    )
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$number;
            $number++;
        }

        return $slug;
    }
}
