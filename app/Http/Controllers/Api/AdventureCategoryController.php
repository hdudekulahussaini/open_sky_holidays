<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdventureCategoryResource;
use App\Models\AdventureCategory;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AdventureCategoryController extends Controller
{
    #[OA\Get(
        path: '/api/adventure-categories',
        summary: 'List active adventure categories',
        description: 'Retrieves all active adventure categories.',
        tags: ['Adventures'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Adventure categories retrieved successfully',
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $categories = AdventureCategory::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Adventure categories retrieved successfully.',
            'data' => AdventureCategoryResource::collection($categories),
        ], 200);
    }

    #[OA\Get(
        path: '/api/adventure-categories/{adventureCategory}',
        summary: 'Get single adventure category',
        description: 'Retrieves single adventure category by ID.',
        tags: ['Adventures'],
        parameters: [
            new OA\Parameter(name: 'adventureCategory', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Adventure category retrieved successfully',
            ),
            new OA\Response(response: 404, description: 'Category not found'),
        ]
    )]
    public function show(
        AdventureCategory $adventureCategory
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'Adventure category retrieved successfully.',
            'data' => new AdventureCategoryResource($adventureCategory),
        ], 200);
    }
}