<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourDetailResource;
use App\Models\TourDetail;
use OpenApi\Attributes as OA;

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
}