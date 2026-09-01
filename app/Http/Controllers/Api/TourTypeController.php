<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourTypeResource;
use App\Models\TourType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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

    #[OA\Get(
        path: '/api/tour-types/{tourType}',
        summary: 'Get single tour type details',
        description: 'Retrieves single tour category/type record by ID.',
        tags: ['Tour Types'],
        parameters: [
            new OA\Parameter(name: 'tourType', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Tour type retrieved successfully',
                content: new OA\JsonContent(ref: '#/components/schemas/TourType')
            ),
            new OA\Response(response: 404, description: 'Tour type not found'),
        ]
    )]
    public function show(TourType $tourType): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new TourTypeResource($tourType),
        ]);
    }
}