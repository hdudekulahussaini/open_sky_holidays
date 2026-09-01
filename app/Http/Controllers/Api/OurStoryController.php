<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OurStoryResource;
use App\Models\OurStory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class OurStoryController extends Controller
{
    #[OA\Get(
        path: '/api/our-stories',
        summary: 'List company stories',
        description: 'Retrieves a paginated list of company story records with optional status filter.',
        tags: ['Our Story'],
        parameters: [
            new OA\Parameter(name: 'status', in: 'query', description: 'Filter by status (true/false)', required: false, schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'per_page', in: 'query', description: 'Items per page (default 10)', required: false, schema: new OA\Schema(type: 'integer', default: 10)),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated list of our stories',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/OurStory')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(
        Request $request
    ): AnonymousResourceCollection {
        $ourStories = OurStory::query()
            ->when(
                $request->has('status'),
                fn ($query) => $query->where(
                    'status',
                    $request->boolean('status')
                )
            )
            ->latest()
            ->paginate(
                $request->integer('per_page', 10)
            );

        return OurStoryResource::collection($ourStories);
    }

    #[OA\Get(
        path: '/api/our-stories/{ourStory}',
        summary: 'Get single story details',
        description: 'Retrieves details for a single company story by ID.',
        tags: ['Our Story'],
        parameters: [
            new OA\Parameter(name: 'ourStory', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Story details retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/OurStory'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Story not found'),
        ]
    )]
    public function show(OurStory $ourStory): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new OurStoryResource($ourStory),
        ], 200);
    }
}
