<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutOurCoreValueResource;
use App\Models\AboutOurCoreValue;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AboutOurCoreValueController extends Controller
{
    #[OA\Get(
        path: '/api/about-our-core-values',
        summary: 'List all about section core values',
        description: 'Retrieves all about section core values ordered by oldest ID.',
        tags: ['About Core Values'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core values retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core values retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/AboutOurCoreValue')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $coreValues = AboutOurCoreValue::query()
            ->oldest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Core values retrieved successfully.',
            'data' => AboutOurCoreValueResource::collection($coreValues),
        ], 200);
    }

    #[OA\Get(
        path: '/api/about-our-core-values/{aboutOurCoreValue}',
        summary: 'Get single about core value details',
        description: 'Retrieves single about core value record by ID.',
        tags: ['About Core Values'],
        parameters: [
            new OA\Parameter(name: 'aboutOurCoreValue', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core value retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutOurCoreValue'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Core value not found'),
        ]
    )]
    public function show(
        AboutOurCoreValue $aboutOurCoreValue
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'Core value retrieved successfully.',
            'data' => new AboutOurCoreValueResource($aboutOurCoreValue),
        ], 200);
    }
}