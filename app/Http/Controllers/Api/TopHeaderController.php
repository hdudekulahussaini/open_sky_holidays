<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopHeaderRequest;
use App\Http\Requests\UpdateTopHeaderRequest;
use App\Http\Resources\TopHeaderResource;
use App\Models\TopHeader;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Throwable;

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

    #[OA\Post(
        path: '/api/top-headers',
        summary: 'Create a new top header bar',
        description: 'Stores a new top header bar record.',
        tags: ['Top Header'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TopHeaderInput')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Top header bar created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Top header bar created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TopHeader'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse')
            ),
        ]
    )]
    public function store(StoreTopHeaderRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $validated['status'] = $request->boolean('status', true);

            if (isset($validated['social_links']) && is_array($validated['social_links'])) {
                $validated['social_links'] = array_values(array_filter($validated['social_links'], function ($link) {
                    return ! empty($link['url']);
                }));
            }

            $topHeader = TopHeader::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Top header bar created successfully.',
                'data' => new TopHeaderResource($topHeader),
            ], 201);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create top header bar.',
            ], 500);
        }
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

    #[OA\Put(
        path: '/api/top-headers/{id}',
        summary: 'Update an existing top header bar',
        description: 'Updates a top header bar by its ID.',
        tags: ['Top Header'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID of the top header bar to update',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TopHeaderInput')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Top header bar updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Top header bar updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TopHeader'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse')
            ),
        ]
    )]
    public function update(UpdateTopHeaderRequest $request, TopHeader $topHeader): JsonResponse
    {
        try {
            $validated = $request->validated();
            $validated['status'] = $request->boolean('status');

            if (isset($validated['social_links']) && is_array($validated['social_links'])) {
                $validated['social_links'] = array_values(array_filter($validated['social_links'], function ($link) {
                    return ! empty($link['url']);
                }));
            } elseif ($request->has('social_links')) {
                $validated['social_links'] = [];
            }

            $topHeader->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Top header bar updated successfully.',
                'data' => new TopHeaderResource($topHeader->fresh()),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update top header bar.',
            ], 500);
        }
    }

    #[OA\Delete(
        path: '/api/top-headers/{id}',
        summary: 'Delete a top header bar',
        description: 'Deletes a top header bar by its ID.',
        tags: ['Top Header'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID of the top header bar to delete',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Top header bar deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Top header bar deleted successfully.'),
                    ]
                )
            ),
        ]
    )]
    public function destroy(TopHeader $topHeader): JsonResponse
    {
        try {
            $topHeader->delete();

            return response()->json([
                'success' => true,
                'message' => 'Top header bar deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete top header bar.',
            ], 500);
        }
    }
}
