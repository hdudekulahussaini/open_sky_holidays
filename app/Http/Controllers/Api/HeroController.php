<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroRequest;
use App\Http\Resources\HeroResource;
use App\Models\Hero;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class HeroController extends Controller
{
    #[OA\Get(
        path: '/api/heroes',
        summary: 'List homepage hero slides',
        description: 'Retrieves all homepage hero slides in display order.',
        tags: ['Hero Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Hero slides retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Hero slides retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Hero')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $heroes = Hero::query()
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Hero slides retrieved successfully.',
            'data' => HeroResource::collection($heroes),
        ], 200);
    }

    public function store(
        HeroRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;

        /*
         * The API does not upload an image.
         * The image column will remain null.
         */
        $hero = Hero::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hero slide created successfully.',
            'data' => new HeroResource($hero),
        ], 201);
    }

    public function show(Hero $hero): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Hero slide retrieved successfully.',
            'data' => new HeroResource($hero),
        ], 200);
    }

    public function update(
        HeroRequest $request,
        Hero $hero
    ): JsonResponse {
        $validated = $request->validated();

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;

        /*
         * This update does not change the image.
         */
        $hero->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hero slide updated successfully.',
            'data' => new HeroResource($hero->fresh()),
        ], 200);
    }

    public function destroy(Hero $hero): JsonResponse
    {
        /*
         * API deletes only the database record.
         * It does not delete the image file.
         */
        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero slide deleted successfully.',
            'data' => null,
        ], 200);
    }
}
