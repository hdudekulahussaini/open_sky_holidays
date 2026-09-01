<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoreValueResource;
use App\Models\CoreValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class CoreValueController extends Controller
{
    #[OA\Get(
        path: '/api/core-values',
        summary: 'Display all active core values',
        description: 'Retrieves all active core values.',
        tags: ['Core Values'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core values retrieved successfully',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/CoreValue')
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $coreValues = CoreValue::query()
            ->where('status', 'active')
            ->latest()
            ->get();

        return CoreValueResource::collection($coreValues);
    }

    #[OA\Get(
        path: '/api/core-values/{coreValue}',
        summary: 'Display single core value',
        description: 'Retrieves details for a single core value by ID.',
        tags: ['Core Values'],
        parameters: [
            new OA\Parameter(name: 'coreValue', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core value retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/CoreValue'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Core value not found'),
        ]
    )]
    public function show(
        CoreValue $coreValue
    ): JsonResponse {
        return response()->json([
            'status' => true,
            'message' => 'Core value retrieved successfully.',
            'data' => new CoreValueResource($coreValue),
        ]);
    }
}
