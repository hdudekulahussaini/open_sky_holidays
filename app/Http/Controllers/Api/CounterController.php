<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounterRequest;
use App\Http\Requests\UpdateCounterRequest;
use App\Models\Counter;
use Illuminate\Http\JsonResponse;

class CounterController extends Controller
{
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

    public function store(StoreCounterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['status'] = $request->boolean('status', true);

        $counter = Counter::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Counter created successfully.',
            'data' => $counter,
        ], 201);
    }

    public function update(
        UpdateCounterRequest $request,
        Counter $counter
    ): JsonResponse {
        $data = $request->validated();

        if ($request->has('status')) {
            $data['status'] = $request->boolean('status');
        }

        $counter->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Counter updated successfully.',
            'data' => $counter->fresh(),
        ]);
    }

    public function destroy(Counter $counter): JsonResponse
    {
        $counter->delete();

        return response()->json([
            'status' => true,
            'message' => 'Counter deleted successfully.',
        ]);
    }
}
