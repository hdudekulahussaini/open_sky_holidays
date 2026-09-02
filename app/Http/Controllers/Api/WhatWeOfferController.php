<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WhatWeOfferResource;
use App\Models\WhatWeOffer;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class WhatWeOfferController extends Controller
{
    #[OA\Get(
        path: '/api/what-we-offers',
        summary: 'List all active what we offer items',
        description: 'Retrieves all active what we offer items ordered by oldest ID.',
        tags: ['What We Offer'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'What We Offer items retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'What We Offer items retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/WhatWeOffer')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $whatWeOffers = WhatWeOffer::query()
            ->where('status', 'active')
            ->oldest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'What We Offer items retrieved successfully.',
            'data' => WhatWeOfferResource::collection($whatWeOffers),
        ], 200);
    }

    #[OA\Get(
        path: '/api/what-we-offers/{whatWeOffer}',
        summary: 'Get single what we offer item details',
        description: 'Retrieves single what we offer item record by ID.',
        tags: ['What We Offer'],
        parameters: [
            new OA\Parameter(name: 'whatWeOffer', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'What We Offer item retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'What We Offer item retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/WhatWeOffer'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'What We Offer item not found'),
        ]
    )]
    public function show(WhatWeOffer $whatWeOffer): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'What We Offer item retrieved successfully.',
            'data' => new WhatWeOfferResource($whatWeOffer),
        ], 200);
    }
}