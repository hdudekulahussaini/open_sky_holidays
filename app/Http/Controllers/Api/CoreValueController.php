<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoreValueRequest;
use App\Http\Requests\UpdateCoreValueRequest;
use App\Http\Resources\CoreValueResource;
use App\Models\CoreValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CoreValueController extends Controller
{
    /**
     * Display all active core values.
     */
    public function index(): AnonymousResourceCollection
    {
        $coreValues = CoreValue::query()
            ->where('status', 'active')
            ->latest()
            ->get();

        return CoreValueResource::collection($coreValues);
    }

    /**
     * Store a new core value.
     */
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

    /**
     * Display one core value.
     */
    public function show(
        CoreValue $coreValue
    ): JsonResponse {
        return response()->json([
            'status' => true,
            'message' => 'Core value retrieved successfully.',
            'data' => new CoreValueResource($coreValue),
        ]);
    }

    /**
     * Update the core value.
     */
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

    /**
     * Delete the core value.
     */
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
