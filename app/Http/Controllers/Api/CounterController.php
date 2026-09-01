<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CounterController extends Controller
{
    #[OA\Get(
        path: '/api/counters',
        summary: 'List all statistic counters',
        description: 'Retrieves all counter statistics for homepage.',
        tags: ['Counters'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Counters retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Counters retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Counter')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $counters = Counter::query()
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Counters retrieved successfully.',
            'data' => $counters,
        ]);
    }

    #[OA\Get(
        path: '/api/counters/active',
        summary: 'Get active statistic counters for website',
        description: 'Retrieves all active statistic counters with icons and values for frontend display.',
        tags: ['Counters'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active counters retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Active counters retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Counter')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function active(): JsonResponse
    {
        $counters = Counter::query()
            ->where('status', true)
            ->oldest('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Active counters retrieved successfully.',
            'data' => $counters,
        ]);
    }

    #[OA\Get(
        path: '/api/counters/{counter}',
        summary: 'Get single statistic counter details',
        description: 'Retrieves single counter details by ID.',
        tags: ['Counters'],
        parameters: [
            new OA\Parameter(name: 'counter', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Counter retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Counter retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Counter'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Counter not found'),
        ]
    )]
    public function show(Counter $counter): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => 'Counter retrieved successfully.',
            'data' => $counter,
        ]);
    }
}
