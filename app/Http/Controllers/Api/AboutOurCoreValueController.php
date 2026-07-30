<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutOurCoreValueRequest;
use App\Http\Resources\AboutOurCoreValueResource;
use App\Models\AboutOurCoreValue;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AboutOurCoreValueController extends Controller
{
    #[OA\Get(
        path: '/api/about-our-core-values',
        summary: 'List all about section core values',
        description: 'Retrieves all about section core values ordered by oldest ID.',
        tags: ['About Core Values'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core values retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core values retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/AboutOurCoreValue')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $coreValues = AboutOurCoreValue::query()
            ->oldest('id')
            ->get();

        return response()->json([
            'success' => true,

            'message' =>
                'Core values retrieved successfully.',

            'data' =>
                AboutOurCoreValueResource::collection(
                    $coreValues
                ),
        ], 200);
    }

    #[OA\Post(
        path: '/api/about-our-core-values',
        summary: 'Create a new about core value',
        description: 'Stores a new about section core value record.',
        tags: ['About Core Values'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'description'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Customer First'),
                    new OA\Property(property: 'description', type: 'string', example: 'We prioritize customer satisfaction.'),
                    new OA\Property(property: 'icon', type: 'string', example: 'fas fa-heart', nullable: true),
                    new OA\Property(property: 'status', type: 'string', example: 'active'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Core value created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutOurCoreValue'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error'),
        ]
    )]
    public function store(
        AboutOurCoreValueRequest $request
    ): JsonResponse {
        $coreValue = AboutOurCoreValue::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,

            'message' =>
                'Core value created successfully.',

            'data' =>
                new AboutOurCoreValueResource(
                    $coreValue
                ),
        ], 201);
    }

    #[OA\Get(
        path: '/api/about-our-core-values/{aboutOurCoreValue}',
        summary: 'Get single about core value details',
        description: 'Retrieves single about core value record by ID.',
        tags: ['About Core Values'],
        parameters: [
            new OA\Parameter(name: 'aboutOurCoreValue', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core value retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutOurCoreValue'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Core value not found'),
        ]
    )]
    public function show(
        AboutOurCoreValue $aboutOurCoreValue
    ): JsonResponse {
        return response()->json([
            'success' => true,

            'message' =>
                'Core value retrieved successfully.',

            'data' =>
                new AboutOurCoreValueResource(
                    $aboutOurCoreValue
                ),
        ], 200);
    }

    #[OA\Put(
        path: '/api/about-our-core-values/{aboutOurCoreValue}',
        summary: 'Update an about core value',
        description: 'Updates an existing about core value by ID.',
        tags: ['About Core Values'],
        parameters: [
            new OA\Parameter(name: 'aboutOurCoreValue', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Updated Core Value Title'),
                    new OA\Property(property: 'description', type: 'string', example: 'Updated core value description.'),
                    new OA\Property(property: 'icon', type: 'string', example: 'fas fa-star', nullable: true),
                    new OA\Property(property: 'status', type: 'string', example: 'active'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core value updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutOurCoreValue'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Core value not found'),
        ]
    )]
    public function update(
        AboutOurCoreValueRequest $request,
        AboutOurCoreValue $aboutOurCoreValue
    ): JsonResponse {
        $aboutOurCoreValue->update(
            $request->validated()
        );

        return response()->json([
            'success' => true,

            'message' =>
                'Core value updated successfully.',

            'data' =>
                new AboutOurCoreValueResource(
                    $aboutOurCoreValue->fresh()
                ),
        ], 200);
    }

    #[OA\Delete(
        path: '/api/about-our-core-values/{aboutOurCoreValue}',
        summary: 'Delete an about core value',
        description: 'Deletes an about core value record by ID.',
        tags: ['About Core Values'],
        parameters: [
            new OA\Parameter(name: 'aboutOurCoreValue', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core value deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value deleted successfully.'),
                        new OA\Property(property: 'data', type: 'string', nullable: true, example: null),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Core value not found'),
        ]
    )]
    public function destroy(
        AboutOurCoreValue $aboutOurCoreValue
    ): JsonResponse {
        $aboutOurCoreValue->delete();

        return response()->json([
            'success' => true,

            'message' =>
                'Core value deleted successfully.',

            'data' => null,
        ], 200);
    }
}