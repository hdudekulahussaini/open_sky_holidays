<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourTypeRequest;
use App\Http\Requests\UpdateTourTypeRequest;
use App\Http\Resources\TourTypeResource;
use App\Models\TourType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

class TourTypeController extends Controller
{
    #[OA\Get(
        path: '/api/tour-types',
        summary: 'List all tour categories/types',
        description: 'Retrieves a paginated list of tour categories and types.',
        tags: ['Tour Types'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour types retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/TourType')),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $tourTypes = TourType::query()
            ->latest('id')
            ->paginate(10);

        return TourTypeResource::collection($tourTypes);
    }

    /**
     * Store a new tour type.
     */
    public function store(
        StoreTourTypeRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $validated['slug'] = Str::slug(
            $validated['slug'] ?: $validated['name']
        );

        $tourType = TourType::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tour type created successfully.',
            'data' => new TourTypeResource($tourType),
        ], 201);
    }
    /**
     * Update a tour type.
     */
    public function update(
        UpdateTourTypeRequest $request,
        TourType $tourType
    ): JsonResponse {
        $validated = $request->validated();

        $validated['slug'] = Str::slug(
            $validated['slug'] ?: $validated['name']
        );

        $tourType->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tour type updated successfully.',
            'data' => new TourTypeResource(
                $tourType->fresh()
            ),
        ]);
    }

    /**
     * Delete a tour type.
     */
    public function destroy(
        TourType $tourType
    ): JsonResponse {
        $tourType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tour type deleted successfully.',
        ]);
    }
}