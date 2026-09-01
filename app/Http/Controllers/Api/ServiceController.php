<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ServiceController extends Controller
{
    #[OA\Get(
        path: '/api/services',
        summary: 'List active travel services',
        description: 'Retrieves a list of all active travel services (visa, flight tickets, passport, etc.).',
        tags: ['Services'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Services fetched successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Services fetched successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Service')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $services = Service::query()
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Services fetched successfully.',
            'data' => ServiceResource::collection($services),
        ]);
    }

    /**
     * Display one service by slug or ID.
     */
    #[OA\Get(
        path: '/api/services/{slugOrId}',
        summary: 'Get service details by Slug or ID',
        description: 'Retrieves complete details for a specific travel service using its slug (e.g. visa) or numeric ID.',
        tags: ['Services'],
        parameters: [
            new OA\Parameter(
                name: 'slugOrId',
                in: 'path',
                required: true,
                description: 'Slug (e.g. "visa") or numeric ID of the service',
                schema: new OA\Schema(type: 'string', example: 'visa')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Service details fetched successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Service fetched successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Service'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Service not found'),
        ]
    )]
    public function show(string $slugOrId): JsonResponse
    {
        $service = Service::query()
            ->where('slug', $slugOrId)
            ->orWhere('id', $slugOrId)
            ->first();

        if (! $service) {
            return response()->json([
                'status' => false,
                'message' => 'Service not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Service fetched successfully.',
            'data' => new ServiceResource($service),
        ]);
    }
}
