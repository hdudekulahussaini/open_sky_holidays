<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourFeatureRequest;
use App\Http\Requests\UpdateTourFeatureRequest;
use App\Http\Resources\TourFeatureResource;
use App\Models\TourFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TourFeatureController extends Controller
{
    /**
     * Display all tour features.
     */
    public function index(): AnonymousResourceCollection
    {
        $tourFeatures = TourFeature::query()
            ->with('tour.tourType')
            ->orderBy('tour_id')
            ->orderBy('type')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(10);

        return TourFeatureResource::collection($tourFeatures);
    }

    /**
     * Store a new tour feature.
     */
    public function store(
        StoreTourFeatureRequest $request
    ): JsonResponse {
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

            if (
                $validated['type'] ===
                TourFeature::TYPE_PLACE_COVERED
            ) {
                $validated['icon'] = null;
            } else {
                $validated['image'] = null;
            }

            $validated['sort_order'] =
                $validated['sort_order'] ?? 0;

            $tourFeature = DB::transaction(
                fn () => TourFeature::create($validated)
            );

            $tourFeature->load('tour.tourType');

            return response()->json([
                'success' => true,
                'message' => 'Tour feature created successfully.',
                'data' => new TourFeatureResource($tourFeature),
            ], 201);
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create tour feature.',
            ], 500);
        }
    }

    /**
     * Update a tour feature.
     */
    public function update(
        UpdateTourFeatureRequest $request,
        TourFeature $tourFeature
    ): JsonResponse {
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
                    $request->boolean('remove_image')
                    && ! $request->hasFile('image')
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

            $shouldDeleteOldImage =
                $oldImage
                && (
                    $newImage !== null
                    || $validated['type'] !==
                        TourFeature::TYPE_PLACE_COVERED
                    || (
                        array_key_exists('image', $validated)
                        && $validated['image'] === null
                    )
                );

            if ($shouldDeleteOldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            $tourFeature->refresh()
                ->load('tour.tourType');

            return response()->json([
                'success' => true,
                'message' => 'Tour feature updated successfully.',
                'data' => new TourFeatureResource($tourFeature),
            ]);
        } catch (Throwable $exception) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update tour feature.',
            ], 500);
        }
    }

    /**
     * Delete a tour feature.
     */
    public function destroy(
        TourFeature $tourFeature
    ): JsonResponse {
        $image = $tourFeature->image;

        try {
            DB::transaction(function () use ($tourFeature): void {
                $tourFeature->delete();
            });

            if ($image) {
                Storage::disk('public')->delete($image);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tour feature deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete tour feature.',
            ], 500);
        }
    }
}
