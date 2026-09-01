<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutWhyChooseUsResource;
use App\Models\AboutWhyChooseUs;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AboutWhyChooseUsController extends Controller
{
    #[OA\Get(
        path: '/api/about-why-choose-us',
        summary: 'List active About Why Choose Us sections',
        description: 'Retrieves all active about why choose us section records.',
        tags: ['About Why Choose Us'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'About Why Choose Us retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'About Why Choose Us retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/AboutWhyChooseUs')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $sections = AboutWhyChooseUs::query()
            ->where('status', 'active')
            ->oldest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'About Why Choose Us retrieved successfully.',
            'data' => AboutWhyChooseUsResource::collection($sections),
        ], 200);
    }

    #[OA\Get(
        path: '/api/about-why-choose-us/active',
        summary: 'Get active About Why Choose Us section for website',
        description: 'Retrieves the latest active About Why Choose Us section record for the frontend.',
        tags: ['About Why Choose Us'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active About Why Choose Us retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Active About Why Choose Us retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutWhyChooseUs'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Active About Why Choose Us not found'),
        ]
    )]
    public function active(): JsonResponse
    {
        $section = AboutWhyChooseUs::query()
            ->where('status', 'active')
            ->latest('id')
            ->first();

        if (! $section) {
            return response()->json([
                'success' => false,
                'message' => 'Active About Why Choose Us not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Active About Why Choose Us retrieved successfully.',
            'data' => new AboutWhyChooseUsResource($section),
        ], 200);
    }

    #[OA\Get(
        path: '/api/about-why-choose-us/{aboutWhyChooseUs}',
        summary: 'Get About Why Choose Us details',
        description: 'Retrieves single About Why Choose Us section details by ID.',
        tags: ['About Why Choose Us'],
        parameters: [
            new OA\Parameter(name: 'aboutWhyChooseUs', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'About Why Choose Us retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'About Why Choose Us retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutWhyChooseUs'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Section not found'),
        ]
    )]
    public function show(
        AboutWhyChooseUs $aboutWhyChooseUs
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'About Why Choose Us retrieved successfully.',
            'data' => new AboutWhyChooseUsResource($aboutWhyChooseUs),
        ], 200);
    }
}