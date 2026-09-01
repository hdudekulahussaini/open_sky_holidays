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
use OpenApi\Attributes as OA;
use Throwable;

class TourFeatureController extends Controller
{
    #[OA\Get(
        path: '/api/tour-features',
        summary: 'List all tour features',
        description: 'Retrieves a paginated list of tour features ordered by tour ID, type, and sort order.',
        tags: ['Tour Features'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated list of tour features',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/TourFeature')
                        ),
                    ]
                )
            ),
        ]
    )]
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

    #[OA\Post(
        path: '/api/tour-features',
        summary: 'Store a new tour feature',
        description: 'Creates a new feature item (inclusion or covered place) for a tour package.',
        tags: ['Tour Features'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['tour_id', 'title', 'type'],
                    properties: [
                        new OA\Property(property: 'tour_id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Deluxe Hotel Stay'),
                        new OA\Property(property: 'type', type: 'string', example: 'package_inclusion'),
                        new OA\Property(property: 'icon', type: 'string', example: 'fas fa-building', nullable: true),
                        new OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Image upload. Supported formats: JPG, JPEG, PNG, WEBP, AVIF. Maximum size: 5MB.', nullable: true),
                        new OA\Property(property: 'sort_order', type: 'integer', example: 1),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Tour feature created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour feature created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TourFeature'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 500, description: 'Unable to create tour feature'),
        ]
    )]
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

    #[OA\Put(
        path: '/api/tour-features/{tourFeature}',
        summary: 'Update tour feature',
        description: 'Updates an existing tour feature record by ID.',
        tags: ['Tour Features'],
        parameters: [
            new OA\Parameter(name: 'tourFeature', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'tour_id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Updated Feature Title'),
                        new OA\Property(property: 'type', type: 'string', example: 'package_inclusion'),
                        new OA\Property(property: 'icon', type: 'string', example: 'fas fa-star', nullable: true),
                        new OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Image upload. Supported formats: JPG, JPEG, PNG, WEBP, AVIF. Maximum size: 5MB.', nullable: true),
                        new OA\Property(property: 'remove_image', type: 'boolean', example: false),
                        new OA\Property(property: 'sort_order', type: 'integer', example: 1),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour feature updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour feature updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TourFeature'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Tour feature not found'),
            new OA\Response(response: 500, description: 'Unable to update tour feature'),
        ]
    )]
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

    #[OA\Delete(
        path: '/api/tour-features/{tourFeature}',
        summary: 'Delete tour feature',
        description: 'Deletes a tour feature record by ID.',
        tags: ['Tour Features'],
        parameters: [
            new OA\Parameter(name: 'tourFeature', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour feature deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour feature deleted successfully.'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Tour feature not found'),
            new OA\Response(response: 500, description: 'Unable to delete tour feature'),
        ]
    )]
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
