<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatWeOfferRequest;
use App\Http\Resources\WhatWeOfferResource;
use App\Models\WhatWeOffer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class WhatWeOfferController extends Controller
{
    #[OA\Get(
        path: '/api/what-we-offers',
        summary: 'List all active what we offer items',
        description: 'Retrieves all active what we offer items ordered by oldest ID.',
        tags: ['What We Offer'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'What We Offer items retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'What We Offer items retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/WhatWeOffer')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $whatWeOffers = WhatWeOffer::query()
            ->where('status', 'active')
            ->oldest('id')
            ->get();

        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer items retrieved successfully.',

            'data' =>
                WhatWeOfferResource::collection(
                    $whatWeOffers
                ),
        ], 200);
    }

    #[OA\Post(
        path: '/api/what-we-offers',
        summary: 'Create a new what we offer item',
        description: 'Stores a new what we offer item record.',
        tags: ['What We Offer'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['title', 'image', 'status'],
                    properties: [
                        new OA\Property(property: 'title', type: 'string', example: 'Customized Holiday Packages'),
                        new OA\Property(property: 'subtitle', type: 'string', example: 'Tailored for your dream vacation', nullable: true),
                        new OA\Property(property: 'description', type: 'string', example: 'We offer personalized itineraries for individuals, families, and groups.', nullable: true),
                        new OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Image upload. Supported formats: JPG, JPEG, PNG, WEBP, AVIF. Maximum size: 5MB.'),
                        new OA\Property(property: 'status', type: 'string', example: 'active', enum: ['active', 'inactive']),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'What We Offer item created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'What We Offer item created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/WhatWeOffer'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error'),
        ]
    )]
    public function store(
        WhatWeOfferRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store(
                    'what-we-offers',
                    'public'
                );
        }

        $whatWeOffer = WhatWeOffer::create(
            $validated
        );

        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer item created successfully.',

            'data' =>
                new WhatWeOfferResource(
                    $whatWeOffer
                ),
        ], 201);
    }

    #[OA\Get(
        path: '/api/what-we-offers/{whatWeOffer}',
        summary: 'Get single what we offer item details',
        description: 'Retrieves single what we offer item record by ID.',
        tags: ['What We Offer'],
        parameters: [
            new OA\Parameter(name: 'whatWeOffer', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'What We Offer item retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'What We Offer item retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/WhatWeOffer'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'What We Offer item not found'),
        ]
    )]
    public function show(
        WhatWeOffer $whatWeOffer
    ): JsonResponse {
        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer item retrieved successfully.',

            'data' =>
                new WhatWeOfferResource(
                    $whatWeOffer
                ),
        ], 200);
    }

    #[OA\Put(
        path: '/api/what-we-offers/{whatWeOffer}',
        summary: 'Update a what we offer item',
        description: 'Updates an existing what we offer item by ID.',
        tags: ['What We Offer'],
        parameters: [
            new OA\Parameter(name: 'whatWeOffer', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['title', 'status'],
                    properties: [
                        new OA\Property(property: 'title', type: 'string', example: 'Updated Package Title'),
                        new OA\Property(property: 'subtitle', type: 'string', example: 'Updated subtitle', nullable: true),
                        new OA\Property(property: 'description', type: 'string', example: 'Updated description.', nullable: true),
                        new OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Image upload. Supported formats: JPG, JPEG, PNG, WEBP, AVIF. Maximum size: 5MB.', nullable: true),
                        new OA\Property(property: 'status', type: 'string', example: 'active', enum: ['active', 'inactive']),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'What We Offer item updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'What We Offer item updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/WhatWeOffer'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'What We Offer item not found'),
            new OA\Response(response: 422, description: 'Validation Error'),
        ]
    )]
    public function update(
        WhatWeOfferRequest $request,
        WhatWeOffer $whatWeOffer
    ): JsonResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage(
                $whatWeOffer->image
            );

            $validated['image'] = $request
                ->file('image')
                ->store(
                    'what-we-offers',
                    'public'
                );
        } else {
            unset($validated['image']);
        }

        $whatWeOffer->update($validated);

        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer item updated successfully.',

            'data' =>
                new WhatWeOfferResource(
                    $whatWeOffer->fresh()
                ),
        ], 200);
    }

    #[OA\Delete(
        path: '/api/what-we-offers/{whatWeOffer}',
        summary: 'Delete a what we offer item',
        description: 'Deletes a what we offer item record by ID.',
        tags: ['What We Offer'],
        parameters: [
            new OA\Parameter(name: 'whatWeOffer', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'What We Offer item deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'What We Offer item deleted successfully.'),
                        new OA\Property(property: 'data', type: 'string', nullable: true, example: null),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'What We Offer item not found'),
        ]
    )]
    public function destroy(
        WhatWeOffer $whatWeOffer
    ): JsonResponse {
        $this->deleteImage(
            $whatWeOffer->image
        );

        $whatWeOffer->delete();

        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer item deleted successfully.',

            'data' => null,
        ], 200);
    }

    private function deleteImage(
        ?string $path
    ): void {
        if (
            filled($path) &&
            Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}