<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutSectionResource;
use App\Models\AboutSection;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AboutSectionController extends Controller
{
    #[OA\Get(
        path: '/api/about-sections',
        summary: 'List all about sections',
        description: 'Retrieves all about section records with globe locations and customer avatars.',
        tags: ['About Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'About sections retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/AboutSection')),
                    ]
                )
            ),
        ]
    )]
    public function index()
    {
        $aboutSections = AboutSection::with([
            'globeLocations',
            'customerAvatars',
        ])
            ->latest()
            ->paginate(10);

        return AboutSectionResource::collection($aboutSections);
    }

    #[OA\Get(
        path: '/api/about-sections/{aboutSection}',
        summary: 'Get single about section details',
        description: 'Retrieves single about section record by ID.',
        tags: ['About Section'],
        parameters: [
            new OA\Parameter(name: 'aboutSection', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'About section fetched successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'About section fetched successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutSection'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'About section not found'),
        ]
    )]
    public function show(
        AboutSection $aboutSection
    ): JsonResponse {
        $aboutSection->load([
            'globeLocations',
            'customerAvatars',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'About section fetched successfully.',
            'data' => new AboutSectionResource($aboutSection),
        ]);
    }

    /**
     * Return the latest active about section for frontend.
     */
    #[OA\Get(
        path: '/api/about-section/active',
        summary: 'Get active about section for website',
        description: 'Retrieves the latest active About section content with globe locations and customer avatar images for the website.',
        tags: ['About Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active about section fetched successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutSection'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Active about section not found'),
        ]
    )]
    public function active(): JsonResponse
    {
        $aboutSection = AboutSection::with([
            'globeLocations',
            'customerAvatars',
        ])
            ->where('status', true)
            ->latest()
            ->first();

        if (! $aboutSection) {
            return response()->json([
                'success' => false,
                'message' => 'Active about section not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Active about section fetched successfully.',
            'data' => new AboutSectionResource($aboutSection),
        ]);
    }
}
