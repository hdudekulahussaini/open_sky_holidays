<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdventureRequest;
use App\Http\Resources\AdventureResource;
use App\Models\Adventure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class AdventureController extends Controller
{
    #[OA\Get(
        path: '/api/adventures',
        summary: 'List active adventure activities',
        description: 'Retrieves all active adventure activities.',
        tags: ['Adventures'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Adventures retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Adventures retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Adventure')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $adventures = Adventure::query()
            ->with('category')
            ->where('status', 'active')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' =>
                'Adventures retrieved successfully.',
            'data' =>
                AdventureResource::collection($adventures),
        ], 200);
    }

    public function store(
        AdventureRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $validated['features'] = $this->cleanFeatures(
            $request->input('features', [])
        );

        if ($request->hasFile('image_one')) {
            $validated['image_one'] = $request
                ->file('image_one')
                ->store('adventures', 'public');
        }

        if ($request->hasFile('image_two')) {
            $validated['image_two'] = $request
                ->file('image_two')
                ->store('adventures', 'public');
        }

        $adventure = Adventure::create($validated);

        $adventure->load('category');

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure created successfully.',
            'data' =>
                new AdventureResource($adventure),
        ], 201);
    }

    public function show(
        Adventure $adventure
    ): JsonResponse {
        $adventure->load('category');

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure retrieved successfully.',
            'data' =>
                new AdventureResource($adventure),
        ], 200);
    }

    public function update(
        AdventureRequest $request,
        Adventure $adventure
    ): JsonResponse {
        $validated = $request->validated();

        $validated['features'] = $this->cleanFeatures(
            $request->input('features', [])
        );

        if ($request->hasFile('image_one')) {
            $this->deleteImage($adventure->image_one);

            $validated['image_one'] = $request
                ->file('image_one')
                ->store('adventures', 'public');
        } else {
            unset($validated['image_one']);
        }

        if ($request->hasFile('image_two')) {
            $this->deleteImage($adventure->image_two);

            $validated['image_two'] = $request
                ->file('image_two')
                ->store('adventures', 'public');
        } else {
            unset($validated['image_two']);
        }

        $adventure->update($validated);

        $adventure->load('category');

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure updated successfully.',
            'data' =>
                new AdventureResource(
                    $adventure->fresh()->load('category')
                ),
        ], 200);
    }

    public function destroy(
        Adventure $adventure
    ): JsonResponse {
        $this->deleteImage($adventure->image_one);
        $this->deleteImage($adventure->image_two);

        $adventure->delete();

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure deleted successfully.',
            'data' => null,
        ], 200);
    }

    #[OA\Get(
        path: '/api/adventures/category/{slug}',
        summary: 'Get adventure by category slug',
        description: 'Retrieves an active adventure details by category slug.',
        tags: ['Adventures'],
        parameters: [
            new OA\Parameter(name: 'slug', in: 'path', required: true, description: 'Adventure category slug', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Adventure retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Adventure retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Adventure'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Active adventure not found'),
        ]
    )]
    public function byCategorySlug(
        string $slug
    ): JsonResponse {
        $adventure = Adventure::query()
            ->with('category')
            ->where('status', 'active')
            ->whereHas(
                'category',
                function ($query) use ($slug) {
                    $query
                        ->where('slug', $slug)
                        ->where('status', 'active');
                }
            )
            ->first();

        if (!$adventure) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Active adventure not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure retrieved successfully.',
            'data' =>
                new AdventureResource($adventure),
        ], 200);
    }

    private function cleanFeatures(array $features): array
    {
        return array_values(
            array_filter(
                array_map(
                    fn ($feature) => is_string($feature)
                        ? trim($feature)
                        : '',
                    $features
                ),
                fn ($feature) => $feature !== ''
            )
        );
    }

    private function deleteImage(?string $path): void
    {
        if (
            $path &&
            Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}