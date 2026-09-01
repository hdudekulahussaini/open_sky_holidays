<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HeroResource;
use App\Models\Hero;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class HeroController extends Controller
{
    #[OA\Get(
        path: '/api/heroes',
        summary: 'List homepage hero slides',
        description: 'Retrieves all homepage hero slides in display order.',
        tags: ['Hero Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Hero slides retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Hero slides retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Hero')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $heroes = Hero::query()
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Hero slides retrieved successfully.',
            'data' => HeroResource::collection($heroes),
        ], 200);
    }

    #[OA\Get(
        path: '/api/heroes/{hero}',
        summary: 'Get single hero slide details',
        description: 'Retrieves single hero slide details by ID.',
        tags: ['Hero Section'],
        parameters: [
            new OA\Parameter(name: 'hero', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Hero slide retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Hero slide retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Hero'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Hero slide not found'),
        ]
    )]
    public function show(Hero $hero): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Hero slide retrieved successfully.',
            'data' => new HeroResource($hero),
        ], 200);
    }
}
