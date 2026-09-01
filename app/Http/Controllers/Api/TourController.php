<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

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
}
