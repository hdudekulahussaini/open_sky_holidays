<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OurProcessResource;
use App\Models\OurProcess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class OurProcessController extends Controller
{
    #[OA\Get(
        path: '/api/our-processes',
        summary: 'List all process section items',
        description: 'Retrieves all process section records.',
        tags: ['About Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Our process items retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/OurProcess')),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $ourProcesses = OurProcess::query()
            ->latest()
            ->paginate(10);

        return OurProcessResource::collection($ourProcesses);
    }

    #[OA\Get(
        path: '/api/our-processes/active',
        summary: 'Get active process section items',
        description: 'Retrieves active company process steps.',
        tags: ['About Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active process section items retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/OurProcess')),
                    ]
                )
            ),
        ]
    )]
    public function active(): AnonymousResourceCollection
    {
        $ourProcesses = OurProcess::query()
            ->where('status', 'active')
            ->latest()
            ->get();

        return OurProcessResource::collection($ourProcesses);
    }

    #[OA\Get(
        path: '/api/our-processes/{ourProcess}',
        summary: 'Get single process item details',
        description: 'Retrieves single process item details by ID.',
        tags: ['About Section'],
        parameters: [
            new OA\Parameter(name: 'ourProcess', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Process item retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/OurProcess'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Process item not found'),
        ]
    )]
    public function show(OurProcess $ourProcess): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Our process retrieved successfully.',
            'data' => new OurProcessResource($ourProcess),
        ]);
    }
}