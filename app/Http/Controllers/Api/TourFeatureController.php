<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourFeatureResource;
use App\Models\TourFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

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

    #[OA\Get(
        path: '/api/tour-features/{tourFeature}',
        summary: 'Get single tour feature details',
        description: 'Retrieves single tour feature details by ID.',
        tags: ['Tour Features'],
        parameters: [
            new OA\Parameter(name: 'tourFeature', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour feature retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour feature retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TourFeature'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Tour feature not found'),
        ]
    )]
    public function show(TourFeature $tourFeature): JsonResponse
    {
        $tourFeature->load('tour.tourType');

        return response()->json([
            'success' => true,
            'message' => 'Tour feature retrieved successfully.',
            'data' => new TourFeatureResource($tourFeature),
        ]);
    }
}
