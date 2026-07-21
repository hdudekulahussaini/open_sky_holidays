<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdventureRequest;
use App\Http\Resources\AdventureResource;
use App\Models\Adventure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AdventureController extends Controller
{
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