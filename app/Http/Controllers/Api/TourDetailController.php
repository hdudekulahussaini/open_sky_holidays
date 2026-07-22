<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourDetailRequest;
use App\Http\Requests\UpdateTourDetailRequest;
use App\Http\Resources\TourDetailResource;
use App\Models\TourDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TourDetailController extends Controller
{
    /**
     * Display all tour details.
     */
    public function index()
    {
        $tourDetails = TourDetail::query()
            ->with('tour')
            ->latest()
            ->paginate(10);

        return TourDetailResource::collection($tourDetails);
    }

    /**
     * Store a new tour detail.
     */
    public function store(
        StoreTourDetailRequest $request
    ): JsonResponse {
        try {
            $tourDetail = DB::transaction(
                function () use ($request): TourDetail {
                    $validated = $request->validated();

                    $galleryPaths = [];

                    if ($request->hasFile('gallery')) {
                        foreach ($request->file('gallery') as $image) {
                            $galleryPaths[] = $image->store(
                                'tour-details/gallery',
                                'public'
                            );
                        }
                    }

                    $validated['gallery'] = $galleryPaths;

                    return TourDetail::create($validated);
                }
            );

            $tourDetail->load('tour');

            return response()->json([
                'success' => true,
                'message' => 'Tour details created successfully.',
                'data' => new TourDetailResource($tourDetail),
            ], 201);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to create tour details.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Display one tour detail.
     */
    public function show(
        TourDetail $tourDetail
    ): TourDetailResource {
        $tourDetail->load('tour');

        return new TourDetailResource($tourDetail);
    }

    /**
     * Update tour details.
     */
    public function update(
        UpdateTourDetailRequest $request,
        TourDetail $tourDetail
    ): JsonResponse {
        try {
            DB::transaction(
                function () use (
                    $request,
                    $tourDetail
                ): void {
                    $validated = $request->validated();

                    $existingGallery = $request->input(
                        'existing_gallery',
                        []
                    );

                    $oldGallery = $tourDetail->gallery ?? [];

                    $newGallery = [];

                    if ($request->hasFile('gallery')) {
                        foreach ($request->file('gallery') as $image) {
                            $newGallery[] = $image->store(
                                'tour-details/gallery',
                                'public'
                            );
                        }
                    }

                    $removedImages = array_diff(
                        $oldGallery,
                        $existingGallery
                    );

                    foreach ($removedImages as $image) {
                        Storage::disk('public')->delete($image);
                    }

                    $validated['gallery'] = array_values(
                        array_merge(
                            $existingGallery,
                            $newGallery
                        )
                    );

                    unset($validated['existing_gallery']);

                    $tourDetail->update($validated);
                }
            );

            $tourDetail->refresh()->load('tour');

            return response()->json([
                'success' => true,
                'message' => 'Tour details updated successfully.',
                'data' => new TourDetailResource($tourDetail),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to update tour details.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete tour details.
     */
    public function destroy(
        TourDetail $tourDetail
    ): JsonResponse {
        try {
            DB::transaction(
                function () use ($tourDetail): void {
                    foreach ($tourDetail->gallery ?? [] as $image) {
                        Storage::disk('public')->delete($image);
                    }

                    $tourDetail->delete();
                }
            );

            return response()->json([
                'success' => true,
                'message' => 'Tour details deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete tour details.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}