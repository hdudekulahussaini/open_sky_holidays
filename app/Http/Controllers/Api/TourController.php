<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\TourFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;
use Throwable;

class TourController extends Controller
{
    #[OA\Get(
        path: '/api/tours',
        summary: 'List all tour packages',
        description: 'Retrieves a paginated list of all active and available tour packages.',
        tags: ['Tours'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated list of tours',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Tour')),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $tours = Tour::query()
            ->with(['tourType:id,name,slug', 'detail', 'features', 'gallery'])
            ->latest('id')
            ->paginate(10);

        return TourResource::collection($tours);
    }

    public function store(
        StoreTourRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title']
        );

        if (isset($validated['areas']) && is_array($validated['areas'])) {
            $validated['areas'] = array_values(array_filter($validated['areas'], fn($f) => filled($f)));
        }

        if (isset($validated['features']) && is_array($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features'], fn($f) => filled($f)));
        }

        $thumbnail = null;
        $uploadedFiles = [];

        try {
            DB::beginTransaction();

            $thumbnail = $request
                ->file('thumbnail')
                ->store('tours', 'public');
            $uploadedFiles[] = $thumbnail;

            $validated['thumbnail'] = $thumbnail;

            $tour = Tour::create($validated);

            // Detail
            $tour->detail()->create([
                'heading' => $validated['detail']['heading'],
                'description' => $validated['detail']['description'],
                'status' => $validated['detail']['status'],
            ]);

            // Save gallery images
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store('tour-details/gallery', 'public');
                    $tour->gallery()->create([
                        'image' => $path,
                    ]);
                    $uploadedFiles[] = $path;
                }
            }

            // Save inclusions
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



            // Save places
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

            $tour->load(['tourType:id,name,slug', 'detail', 'features', 'gallery']);

            return response()->json([
                'success' => true,
                'message' => 'Tour created successfully.',
                'data' => new TourResource($tour),
            ], 201);
        } catch (Throwable $exception) {
            DB::rollBack();

            foreach ($uploadedFiles as $file) {
                Storage::disk('public')->delete($file);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create the tour: '.$exception->getMessage(),
            ], 500);
        }
    }

    #[OA\Get(
        path: '/api/tours/{id}',
        summary: 'Get tour details by ID',
        description: 'Retrieves detailed information for a specific tour including itinerary, features, and gallery images.',
        tags: ['Tours'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'ID of the tour', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour details retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Tour'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Tour not found'),
        ]
    )]
    public function show(Tour $tour): JsonResponse
    {
        $tour->load(['tourType:id,name,slug', 'detail', 'features', 'gallery']);

        return response()->json([
            'success' => true,
            'message' => 'Tour retrieved successfully.',
            'data' => new TourResource($tour),
        ]);
    }

    public function update(
        UpdateTourRequest $request,
        Tour $tour
    ): JsonResponse {
        $validated = $request->validated();

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $tour->id
        );

        if (isset($validated['areas']) && is_array($validated['areas'])) {
            $validated['areas'] = array_values(array_filter($validated['areas'], fn($f) => filled($f)));
        }

        if (isset($validated['features']) && is_array($validated['features'])) {
            $validated['features'] = array_values(array_filter($validated['features'], fn($f) => filled($f)));
        }

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

            // Handle TourDetail
            $tour->detail()->updateOrCreate(
                ['tour_id' => $tour->id],
                [
                    'heading' => $validated['detail']['heading'],
                    'description' => $validated['detail']['description'],
                    'status' => $validated['detail']['status'],
                ]
            );

            // Handle Gallery Syncing
            $oldGallery = $tour->gallery;
            $retainedGalleryPaths = $request->input('existing_gallery', []);
            $retainedGalleryPaths = is_array($retainedGalleryPaths) ? $retainedGalleryPaths : [];

            $galleryToDelete = $oldGallery->whereNotIn('image', $retainedGalleryPaths);
            foreach ($galleryToDelete as $tourImage) {
                $deletedFiles[] = $tourImage->image;
                $tourImage->delete();
            }

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $path = $image->store('tour-details/gallery', 'public');
                    $tour->gallery()->create([
                        'image' => $path,
                    ]);
                    $newUploadedFiles[] = $path;
                }
            }

            if ($tour->gallery()->count() > 10) {
                throw new \Exception('The gallery may contain a maximum of 10 images.');
            }

            // Inclusions
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



            // Places
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

            if ($newThumbnail && $oldThumbnail) {
                Storage::disk('public')->delete($oldThumbnail);
            }

            foreach ($deletedFiles as $file) {
                Storage::disk('public')->delete($file);
            }

            $tour->load(['tourType:id,name,slug', 'detail', 'features', 'gallery']);

            return response()->json([
                'success' => true,
                'message' => 'Tour updated successfully.',
                'data' => new TourResource($tour),
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();

            foreach ($newUploadedFiles as $file) {
                Storage::disk('public')->delete($file);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the tour: '.$exception->getMessage(),
            ], 500);
        }
    }

    public function destroy(Tour $tour): JsonResponse
    {
        $filesToDelete = [];

        if ($tour->thumbnail) {
            $filesToDelete[] = $tour->thumbnail;
        }

        $tour->load(['detail', 'placesCovered', 'gallery']);

        foreach ($tour->gallery as $img) {
            $filesToDelete[] = $img->image;
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

            return response()->json([
                'success' => true,
                'message' => 'Tour deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete this tour.',
            ], 500);
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
