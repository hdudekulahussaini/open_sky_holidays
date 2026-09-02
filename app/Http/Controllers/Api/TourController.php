<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\TourFeature;
use App\Models\TourImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TourController extends Controller
{
    /**
     * List all tour packages with optional tour type filtering.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Tour::query()
            ->with(['tourType:id,name,slug', 'detail', 'tourFeatures', 'gallery']);

        if ($type = $request->query('type')) {
            $query->whereHas('tourType', function ($q) use ($type) {
                $q->where('slug', $type)->orWhere('name', $type);
            });
        }

        $tours = $query->latest('id')->paginate(10);

        return TourResource::collection($tours);
    }

    /**
     * Get tour details by numeric ID or slug.
     */
    public function show(string $idOrSlug): JsonResponse
    {
        $tour = is_numeric($idOrSlug)
            ? Tour::where('id', $idOrSlug)->firstOrFail()
            : Tour::where('slug', $idOrSlug)->firstOrFail();

        $tour->load(['tourType:id,name,slug', 'detail', 'tourFeatures', 'gallery']);

        return response()->json([
            'success' => true,
            'message' => 'Tour retrieved successfully.',
            'data' => new TourResource($tour),
        ]);
    }

    /**
     * Create a new tour package via API.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tour_type_id' => 'required|exists:tour_types,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'thumbnail' => 'required',
            'areas' => 'nullable|array',
            'features' => 'nullable|array',
            'status' => 'required',
            'detail.heading' => 'required|string|max:255',
            'detail.description' => 'required|string',
            'detail.status' => 'nullable|string',
            'gallery' => 'nullable|array',
            'package_inclusions' => 'nullable|array',
            'places_covered' => 'nullable|array',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('tours', 'public');
            } elseif (is_string($validated['thumbnail'])) {
                $thumbnailPath = $validated['thumbnail'];
            }

            $tour = Tour::create([
                'tour_type_id' => $validated['tour_type_id'],
                'title' => $validated['title'],
                'slug' => $validated['slug'] ?? Str::slug($validated['title']),
                'country' => $validated['country'],
                'state' => $validated['state'],
                'duration' => $validated['duration'],
                'thumbnail' => $thumbnailPath,
                'areas' => $validated['areas'] ?? [],
                'features' => $validated['features'] ?? [],
                'status' => (bool) $validated['status'],
            ]);

            // Tour Detail
            if (isset($validated['detail'])) {
                $tour->detail()->create([
                    'heading' => $validated['detail']['heading'],
                    'description' => $validated['detail']['description'],
                    'status' => $validated['detail']['status'] ?? 'active',
                ]);
            }

            // Gallery
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store('tour-details/gallery', 'public');
                    $tour->gallery()->create(['image' => $path]);
                }
            }

            // Package Inclusions
            if (! empty($validated['package_inclusions'])) {
                foreach ($validated['package_inclusions'] as $inclusion) {
                    $tour->tourFeatures()->create([
                        'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
                        'title' => $inclusion['title'],
                        'sort_order' => $inclusion['sort_order'] ?? 1,
                        'status' => 'active',
                    ]);
                }
            }

            // Places Covered
            if (! empty($validated['places_covered'])) {
                foreach ($validated['places_covered'] as $index => $place) {
                    $placeImage = null;
                    if ($request->hasFile("places_covered.{$index}.image")) {
                        $placeImage = $request->file("places_covered.{$index}.image")->store('tour-features/places', 'public');
                    }

                    $tour->tourFeatures()->create([
                        'type' => TourFeature::TYPE_PLACE_COVERED,
                        'title' => $place['title'],
                        'description' => $place['description'] ?? null,
                        'image' => $placeImage,
                        'sort_order' => $place['sort_order'] ?? 1,
                        'status' => 'active',
                    ]);
                }
            }

            $tour->load(['tourType:id,name,slug', 'detail', 'tourFeatures', 'gallery']);

            return response()->json([
                'success' => true,
                'message' => 'Tour created successfully.',
                'data' => new TourResource($tour),
            ], 201);
        });
    }

    /**
     * Update an existing tour package via API.
     */
    public function update(Request $request, Tour $tour): JsonResponse
    {
        $validated = $request->validate([
            'tour_type_id' => 'sometimes|required|exists:tour_types,id',
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required',
            'detail.heading' => 'nullable|string|max:255',
            'detail.description' => 'nullable|string',
            'existing_gallery' => 'nullable|array',
            'gallery' => 'nullable|array',
            'package_inclusions' => 'nullable|array',
        ]);

        return DB::transaction(function () use ($request, $validated, $tour) {
            $tour->update([
                'tour_type_id' => $validated['tour_type_id'] ?? $tour->tour_type_id,
                'title' => $validated['title'] ?? $tour->title,
                'slug' => $validated['slug'] ?? $tour->slug,
                'country' => $validated['country'] ?? $tour->country,
                'duration' => $validated['duration'] ?? $tour->duration,
                'status' => isset($validated['status']) ? (bool) $validated['status'] : $tour->status,
            ]);

            // Detail
            if (isset($validated['detail'])) {
                $tour->detail()->updateOrCreate(
                    ['tour_id' => $tour->id],
                    [
                        'heading' => $validated['detail']['heading'] ?? '',
                        'description' => $validated['detail']['description'] ?? '',
                    ]
                );
            }

            // Sync existing gallery (delete removed ones)
            $existingImages = $validated['existing_gallery'] ?? [];
            $imagesToDelete = $tour->gallery()->whereNotIn('image', $existingImages)->get();
            foreach ($imagesToDelete as $delImage) {
                if (Storage::disk('public')->exists($delImage->image)) {
                    Storage::disk('public')->delete($delImage->image);
                }
                $delImage->delete();
            }

            // Add new gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store('tour-details/gallery', 'public');
                    $tour->gallery()->create(['image' => $path]);
                }
            }

            // Sync package inclusions
            if (isset($validated['package_inclusions'])) {
                $keptIds = [];
                foreach ($validated['package_inclusions'] as $inc) {
                    if (isset($inc['id']) && $inc['id']) {
                        $tour->tourFeatures()->where('id', $inc['id'])->update([
                            'title' => $inc['title'],
                            'sort_order' => $inc['sort_order'] ?? 1,
                        ]);
                        $keptIds[] = $inc['id'];
                    } else {
                        $newInc = $tour->tourFeatures()->create([
                            'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
                            'title' => $inc['title'],
                            'sort_order' => $inc['sort_order'] ?? 1,
                            'status' => 'active',
                        ]);
                        $keptIds[] = $newInc->id;
                    }
                }
            }

            $tour->load(['tourType:id,name,slug', 'detail', 'tourFeatures', 'gallery']);

            return response()->json([
                'success' => true,
                'message' => 'Tour updated successfully.',
                'data' => new TourResource($tour),
            ], 200);
        });
    }

    /**
     * Delete a tour package via API.
     */
    public function destroy(Tour $tour): JsonResponse
    {
        $tour->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tour deleted successfully.',
        ], 200);
    }
}
