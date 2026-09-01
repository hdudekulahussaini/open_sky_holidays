<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopHeaderResource;
use App\Models\TopHeader;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class TopHeaderController extends Controller
{
    #[OA\Get(
        path: '/api/top-header/active',
        summary: 'Get active top header bar data',
        description: 'Retrieves the active top header bar details including email, announcement tagline, button text/link, and social icons.',
        tags: ['Top Header'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active top header bar retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Active top header bar retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TopHeader'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'No active top header bar found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'No active top header bar found.'),
                    ]
                )
            ),
        ]
    )]
    public function active(): JsonResponse
    {
        $topHeader = TopHeader::where('status', true)->latest()->first();

        if (! $topHeader) {
            return response()->json([
                'success' => false,
                'message' => 'No active top header bar found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Active top header bar retrieved successfully.',
            'data' => new TopHeaderResource($topHeader),
        ]);
    }

    #[OA\Get(
        path: '/api/top-headers',
        summary: 'List all top header bar configurations',
        description: 'Retrieves all top header bar records.',
        tags: ['Top Header'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Top header bars retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Top header bars retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/TopHeader')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $topHeaders = TopHeader::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Top header bars retrieved successfully.',
            'data' => TopHeaderResource::collection($topHeaders),
        ]);
    }

    #[OA\Get(
        path: '/api/top-headers/{id}',
        summary: 'Get a specific top header bar',
        description: 'Retrieves a single top header bar by its ID.',
        tags: ['Top Header'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID of the top header bar',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Top header bar retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Top header bar retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TopHeader'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Top header bar not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Top header bar not found.'),
                    ]
                )
            ),
        ]
    )]
    public function show(TopHeader $topHeader): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Top header bar retrieved successfully.',
            'data' => new TopHeaderResource($topHeader),
        ]);
    }
}
