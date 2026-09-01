<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelSupportSectionResource;
use App\Models\TravelSupportSection;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class TravelSupportSectionController extends Controller
{
    #[OA\Get(
        path: '/api/travel-support',
        summary: 'List all travel support sections',
        description: 'Retrieves all travel support sections.',
        tags: ['Travel Support'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Travel support sections retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Travel support sections retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/TravelSupportSection')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $travelSupportSections = TravelSupportSection::latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Travel support sections retrieved successfully.',
            'data' => TravelSupportSectionResource::collection(
                $travelSupportSections
            ),
        ]);
    }

    #[OA\Get(
        path: '/api/travel-support/{travelSupport}',
        summary: 'Get single travel support section details',
        description: 'Retrieves details for a single travel support section by ID.',
        tags: ['Travel Support'],
        parameters: [
            new OA\Parameter(name: 'travelSupport', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Travel support section retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Travel support section retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TravelSupportSection'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Travel support section not found'),
        ]
    )]
    public function show(
        TravelSupportSection $travelSupport
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'Travel support section retrieved successfully.',
            'data' => new TravelSupportSectionResource(
                $travelSupport
            ),
        ]);
    }

    #[OA\Get(
        path: '/api/travel-support/active',
        summary: 'Get active travel support sections',
        description: 'Retrieves all active travel support sections for website display.',
        tags: ['Travel Support'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active travel support sections retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Active travel support sections retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/TravelSupportSection')),
                    ]
                )
            ),
        ]
    )]
    public function active(): JsonResponse
    {
        $travelSupportSections = TravelSupportSection::query()
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Active travel support sections retrieved successfully.',
            'data' => TravelSupportSectionResource::collection(
                $travelSupportSections
            ),
        ]);
    }
}