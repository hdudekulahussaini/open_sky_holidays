<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdventureCategoryRequest;
use App\Http\Resources\AdventureCategoryResource;
use App\Models\AdventureCategory;
use Illuminate\Http\JsonResponse;

class AdventureCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = AdventureCategory::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure categories retrieved successfully.',
            'data' =>
                AdventureCategoryResource::collection(
                    $categories
                ),
        ], 200);
    }

    public function store(
        AdventureCategoryRequest $request
    ): JsonResponse {
        $category = AdventureCategory::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure category created successfully.',
            'data' =>
                new AdventureCategoryResource($category),
        ], 201);
    }

    public function show(
        AdventureCategory $adventureCategory
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' =>
                'Adventure category retrieved successfully.',
            'data' =>
                new AdventureCategoryResource(
                    $adventureCategory
                ),
        ], 200);
    }

    public function update(
        AdventureCategoryRequest $request,
        AdventureCategory $adventureCategory
    ): JsonResponse {
        $adventureCategory->update(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure category updated successfully.',
            'data' =>
                new AdventureCategoryResource(
                    $adventureCategory->fresh()
                ),
        ], 200);
    }

    public function destroy(
        AdventureCategory $adventureCategory
    ): JsonResponse {
        $adventureCategory->delete();

        return response()->json([
            'success' => true,
            'message' =>
                'Adventure category deleted successfully.',
            'data' => null,
        ], 200);
    }
}