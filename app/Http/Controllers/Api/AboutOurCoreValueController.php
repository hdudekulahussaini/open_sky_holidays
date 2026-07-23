<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutOurCoreValueRequest;
use App\Http\Resources\AboutOurCoreValueResource;
use App\Models\AboutOurCoreValue;
use Illuminate\Http\JsonResponse;

class AboutOurCoreValueController extends Controller
{
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