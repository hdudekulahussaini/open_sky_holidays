<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounterRequest;
use App\Http\Requests\UpdateCounterRequest;
use App\Models\Counter;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class CounterController extends Controller
{
    #[OA\Get(
        path: '/api/counters',
        summary: 'List all statistic counters',
        description: 'Retrieves all counter statistics for homepage.',
        tags: ['Counters'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Counters retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Counters retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Counter')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $counters = Counter::query()
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Counters retrieved successfully.',
            'data' => $counters,
        ]);
    }

    #[OA\Get(
        path: '/api/counters/active',
        summary: 'Get active statistic counters for website',
        description: 'Retrieves all active statistic counters with icons and values for frontend display.',
        tags: ['Counters'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active counters retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Active counters retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/Counter')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function active(): JsonResponse
    {
        $counters = Counter::query()
            ->where('status', true)
            ->oldest('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Active counters retrieved successfully.',
            'data' => $counters,
        ]);
    }

    #[OA\Post(
        path: '/api/counters',
        summary: 'Store a new counter',
        description: 'Creates a new statistic counter record.',
        tags: ['Counters'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['value', 'name'],
                properties: [
                    new OA\Property(property: 'value', type: 'string', example: '10K+'),
                    new OA\Property(property: 'name', type: 'string', example: 'Happy Travelers'),
                    new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-users', nullable: true),
                    new OA\Property(property: 'status', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Counter created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Counter created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Counter'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error'),
        ]
    )]
    public function store(StoreCounterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $status = $request->boolean('status', true);
        $createdCounters = [];

        if (isset($data['counters']) && is_array($data['counters'])) {
            foreach ($data['counters'] as $counterData) {
                $createdCounters[] = Counter::create([
                    'value' => $counterData['value'],
                    'name' => $counterData['name'],
                    'icon' => $counterData['icon'] ?? 'fa-solid fa-users',
                    'status' => $status,
                ]);
            }
        } elseif (isset($data['value']) && isset($data['name'])) {
            $createdCounters[] = Counter::create([
                'value' => $data['value'],
                'name' => $data['name'],
                'icon' => $data['icon'] ?? 'fa-solid fa-users',
                'status' => $status,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Counters created successfully.',
            'data' => count($createdCounters) === 1 ? $createdCounters[0] : $createdCounters,
        ], 201);
    }

    #[OA\Put(
        path: '/api/counters/{counter}',
        summary: 'Update counter',
        description: 'Updates an existing counter by ID.',
        tags: ['Counters'],
        parameters: [
            new OA\Parameter(name: 'counter', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'value', type: 'string', example: '15K+'),
                    new OA\Property(property: 'name', type: 'string', example: 'Happy Customers'),
                    new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-face-smile', nullable: true),
                    new OA\Property(property: 'status', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Counter updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Counter updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Counter'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Counter not found'),
        ]
    )]
    public function update(
        UpdateCounterRequest $request,
        Counter $counter
    ): JsonResponse {
        $status = $request->boolean('status', $counter->status);

        if ($request->has('counters')) {
            $countersData = $request->input('counters', []);
            foreach ($countersData as $data) {
                if (isset($data['id']) && (int) $data['id'] === $counter->id) {
                    $counter->update([
                        'value' => $data['value'],
                        'name' => $data['name'],
                        'icon' => $data['icon'] ?? $counter->icon ?? 'fa-solid fa-users',
                        'status' => $status,
                    ]);
                }
            }
        } else {
            $counter->update([
                'value' => $request->input('value', $counter->value),
                'name' => $request->input('name', $counter->name),
                'icon' => $request->input('icon', $counter->icon ?? 'fa-solid fa-users'),
                'status' => $status,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Counter updated successfully.',
            'data' => $counter->fresh(),
        ]);
    }

    #[OA\Delete(
        path: '/api/counters/{counter}',
        summary: 'Delete counter',
        description: 'Deletes a counter record by ID.',
        tags: ['Counters'],
        parameters: [
            new OA\Parameter(name: 'counter', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Counter deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Counter deleted successfully.'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Counter not found'),
        ]
    )]
    public function destroy(Counter $counter): JsonResponse
    {
        $counter->delete();

        return response()->json([
            'status' => true,
            'message' => 'Counter deleted successfully.',
        ]);
    }
}
