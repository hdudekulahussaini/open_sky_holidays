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
use OpenApi\Attributes as OA;
use Throwable;

class TourDetailController extends Controller
{
    #[OA\Get(
        path: '/api/tour-details',
        summary: 'List all tour details',
        description: 'Retrieves a paginated list of all tour details with associated tour packages.',
        tags: ['Tour Details'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated list of tour details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/TourDetail')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index()
    {
        $tourDetails = TourDetail::query()
            ->with('tour')
            ->latest()
            ->paginate(10);

        return TourDetailResource::collection($tourDetails);
    }

    #[OA\Post(
        path: '/api/tour-details',
        summary: 'Create tour details',
        description: 'Creates detailed itinerary, inclusions, exclusions, and gallery images for a tour.',
        tags: ['Tour Details'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['tour_id', 'title'],
                    properties: [
                        new OA\Property(property: 'tour_id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Complete Dubai Desert Safari Itinerary'),
                        new OA\Property(property: 'overview', type: 'string', example: 'Detailed overview of the 5-day tour package.'),
                        new OA\Property(property: 'itinerary', type: 'string', example: '{"Day 1": "Arrival and Dhow Cruise"}'),
                        new OA\Property(
                            property: 'inclusions[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'Hotel Stay')
                        ),
                        new OA\Property(
                            property: 'exclusions[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'Personal Expenses')
                        ),
                        new OA\Property(
                            property: 'gallery[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', format: 'binary')
                        ),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Tour details created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour details created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TourDetail'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 500, description: 'Unable to create tour details'),
        ]
    )]
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

    #[OA\Get(
        path: '/api/tour-details/{tourDetail}',
        summary: 'Get single tour detail',
        description: 'Retrieves single tour detail record with tour information by ID.',
        tags: ['Tour Details'],
        parameters: [
            new OA\Parameter(name: 'tourDetail', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour detail retrieved successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/TourDetail')
            ),
            new OA\Response(response: 404, description: 'Tour detail not found'),
        ]
    )]
    public function show(
        TourDetail $tourDetail
    ): TourDetailResource {
        $tourDetail->load('tour');

        return new TourDetailResource($tourDetail);
    }

    #[OA\Put(
        path: '/api/tour-details/{tourDetail}',
        summary: 'Update tour details',
        description: 'Updates an existing tour detail record by ID.',
        tags: ['Tour Details'],
        parameters: [
            new OA\Parameter(name: 'tourDetail', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'tour_id', type: 'integer', example: 1),
                        new OA\Property(property: 'title', type: 'string', example: 'Updated Tour Details Title'),
                        new OA\Property(property: 'overview', type: 'string', example: 'Updated Overview'),
                        new OA\Property(
                            property: 'gallery[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', format: 'binary')
                        ),
                        new OA\Property(
                            property: 'existing_gallery[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'tour-details/gallery/img1.jpg')
                        ),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour details updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour details updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TourDetail'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Tour detail not found'),
            new OA\Response(response: 500, description: 'Unable to update tour details'),
        ]
    )]
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

    #[OA\Delete(
        path: '/api/tour-details/{tourDetail}',
        summary: 'Delete tour details',
        description: 'Deletes a tour detail record and its gallery images by ID.',
        tags: ['Tour Details'],
        parameters: [
            new OA\Parameter(name: 'tourDetail', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour details deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour details deleted successfully.'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Tour detail not found'),
            new OA\Response(response: 500, description: 'Unable to delete tour details'),
        ]
    )]
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