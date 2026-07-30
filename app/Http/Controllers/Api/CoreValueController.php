<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoreValueRequest;
use App\Http\Requests\UpdateCoreValueRequest;
use App\Http\Resources\CoreValueResource;
use App\Models\CoreValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class CoreValueController extends Controller
{
    #[OA\Get(
        path: '/api/core-values',
        summary: 'Display all active core values',
        description: 'Retrieves all active core values.',
        tags: ['Core Values'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core values retrieved successfully',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/CoreValue')
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $coreValues = CoreValue::query()
            ->where('status', 'active')
            ->latest()
            ->get();

        return CoreValueResource::collection($coreValues);
    }

    #[OA\Post(
        path: '/api/core-values',
        summary: 'Store a new core value',
        description: 'Creates a new core value record.',
        tags: ['Core Values'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'description'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Integrity & Trust'),
                    new OA\Property(property: 'description', type: 'string', example: 'Transparent pricing and honest travel guidance.'),
                    new OA\Property(property: 'icon', type: 'string', example: 'fas fa-shield-alt', nullable: true),
                    new OA\Property(property: 'sort_order', type: 'integer', example: 1),
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
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/CoreValue'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error'),
        ]
    )]
    public function store(
        StoreCoreValueRequest $request
    ): JsonResponse {
        $coreValue = CoreValue::create(
            $request->validated()
        );

        return response()->json([
            'status' => true,
            'message' => 'Core value created successfully.',
            'data' => new CoreValueResource($coreValue),
        ], 201);
    }

    #[OA\Get(
        path: '/api/core-values/{coreValue}',
        summary: 'Display single core value',
        description: 'Retrieves details for a single core value by ID.',
        tags: ['Core Values'],
        parameters: [
            new OA\Parameter(name: 'coreValue', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core value retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/CoreValue'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Core value not found'),
        ]
    )]
    public function show(
        CoreValue $coreValue
    ): JsonResponse {
        return response()->json([
            'status' => true,
            'message' => 'Core value retrieved successfully.',
            'data' => new CoreValueResource($coreValue),
        ]);
    }

    #[OA\Put(
        path: '/api/core-values/{coreValue}',
        summary: 'Update core value',
        description: 'Updates an existing core value by ID.',
        tags: ['Core Values'],
        parameters: [
            new OA\Parameter(name: 'coreValue', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'Updated Core Value'),
                    new OA\Property(property: 'description', type: 'string', example: 'Updated description.'),
                    new OA\Property(property: 'icon', type: 'string', example: 'fas fa-star', nullable: true),
                    new OA\Property(property: 'sort_order', type: 'integer', example: 1),
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
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/CoreValue'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Core value not found'),
        ]
    )]
    public function update(
        UpdateCoreValueRequest $request,
        CoreValue $coreValue
    ): JsonResponse {
        $coreValue->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Core value updated successfully.',
            'data' => new CoreValueResource(
                $coreValue->fresh()
            ),
        ]);
    }

    #[OA\Delete(
        path: '/api/core-values/{coreValue}',
        summary: 'Delete core value',
        description: 'Deletes a core value record by ID.',
        tags: ['Core Values'],
        parameters: [
            new OA\Parameter(name: 'coreValue', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Core value deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Core value deleted successfully.'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Core value not found'),
        ]
    )]
    public function destroy(
        CoreValue $coreValue
    ): JsonResponse {
        $coreValue->delete();

        return response()->json([
            'status' => true,
            'message' => 'Core value deleted successfully.',
        ]);
    }
}
