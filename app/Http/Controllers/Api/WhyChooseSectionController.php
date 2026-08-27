<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhyChooseSectionRequest;
use App\Http\Requests\UpdateWhyChooseSectionRequest;
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
            ->latest('id')
            ->paginate(10);

        return WhyChooseSectionResource::collection($sections);
    }

    #[OA\Post(
        path: '/api/why-choose-sections',
        summary: 'Create a new Why Choose Us section',
        description: 'Stores a new Why Choose Us record including title, description, and FontAwesome icon.',
        tags: ['Why Choose Us'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'description'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Worldwide Coverage', description: 'Section benefit title'),
                    new OA\Property(property: 'description', type: 'string', example: 'Explore domestic and international destinations with complete planning and trusted travel support.', description: 'Section description text'),
                    new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-earth-americas', nullable: true, description: 'FontAwesome 6 icon class (e.g. fa-solid fa-earth-americas, fa-solid fa-bolt-lightning, fa-solid fa-headset)'),
                    new OA\Property(property: 'sort_order', type: 'integer', example: 0, description: 'Display sort order priority'),
                    new OA\Property(property: 'status', type: 'integer', example: 1, description: '1 for Active, 0 for Inactive'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Why choose section created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Why choose section created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/WhyChooseSection'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            ),
        ]
    )]
    public function store(
        StoreWhyChooseSectionRequest $request
    ): JsonResponse {
        $section = WhyChooseSection::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Why choose section created successfully.',
            'data' => new WhyChooseSectionResource($section),
        ], 201);
    }

    #[OA\Get(
        path: '/api/why-choose-sections/{id}',
        summary: 'Get single Why Choose Us section',
        description: 'Retrieves a single Why Choose Us record by ID.',
        tags: ['Why Choose Us'],
        parameters: [
            new OA\Parameter(
                name: 'id',
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

    #[OA\Put(
        path: '/api/why-choose-sections/{id}',
        summary: 'Update Why Choose Us section',
        description: 'Updates an existing Why Choose Us record with new title, description, or icon.',
        tags: ['Why Choose Us'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Why Choose Section ID',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'description'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Fast Booking', description: 'Section benefit title'),
                    new OA\Property(property: 'description', type: 'string', example: 'Seamless and quick reservations with instant confirmation.', description: 'Section description text'),
                    new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-calendar-check', nullable: true, description: 'FontAwesome 6 icon class'),
                    new OA\Property(property: 'sort_order', type: 'integer', example: 2, description: 'Display sort order priority'),
                    new OA\Property(property: 'status', type: 'integer', example: 1, description: '1 for Active, 0 for Inactive'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Why choose section updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Why choose section updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/WhyChooseSection'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            ),
            new OA\Response(
                response: 404,
                description: 'Record not found'
            ),
        ]
    )]
    public function update(
        UpdateWhyChooseSectionRequest $request,
        WhyChooseSection $whyChooseSection
    ): JsonResponse {
        $whyChooseSection->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Why choose section updated successfully.',
            'data' => new WhyChooseSectionResource(
                $whyChooseSection->fresh()
            ),
        ]);
    }

    #[OA\Delete(
        path: '/api/why-choose-sections/{id}',
        summary: 'Delete Why Choose Us section',
        description: 'Permanently removes a Why Choose Us section record by ID.',
        tags: ['Why Choose Us'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Why Choose Section ID',
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Why choose section deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Why choose section deleted successfully.'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Record not found'
            ),
        ]
    )]
    public function destroy(
        WhyChooseSection $whyChooseSection
    ): JsonResponse {
        $whyChooseSection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Why choose section deleted successfully.',
        ]);
    }
}