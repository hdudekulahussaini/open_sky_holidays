<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WhyChooseSectionResource;
use App\Models\WhyChooseSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class WhyChooseSectionController extends Controller
{
    #[OA\Get(
        path: '/api/why-choose-sections/active',
        summary: 'Get active Why Choose Us sections for website',
        description: 'Retrieves active Why Choose Us cards ordered by sort_order for frontend display.',
        tags: ['Why Choose Us'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active Why Choose sections retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/WhyChooseSection')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function active(): AnonymousResourceCollection
    {
        $sections = WhyChooseSection::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        return WhyChooseSectionResource::collection($sections);
    }

    #[OA\Get(
        path: '/api/why-choose-sections',
        summary: 'List all Why Choose Us sections',
        description: 'Retrieves all Why Choose Us section items with pagination.',
        tags: ['Why Choose Us'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Why choose sections retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/WhyChooseSection')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $sections = WhyChooseSection::query()
            ->orderBy('sort_order')
            ->paginate(10);

        return WhyChooseSectionResource::collection($sections);
    }

    #[OA\Get(
        path: '/api/why-choose-sections/{whyChooseSection}',
        summary: 'Get single Why Choose Us section details',
        description: 'Retrieves single Why Choose Us card details by ID.',
        tags: ['Why Choose Us'],
        parameters: [
            new OA\Parameter(
                name: 'whyChooseSection',
                in: 'path',
                required: true,
                description: 'Why Choose Section ID',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Why choose section details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/WhyChooseSection'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Record not found'
            ),
        ]
    )]
    public function show(
        WhyChooseSection $whyChooseSection
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'data' => new WhyChooseSectionResource($whyChooseSection),
        ]);
    }
}