<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOurProcessRequest;
use App\Http\Requests\UpdateOurProcessRequest;
use App\Http\Resources\OurProcessResource;
use App\Models\OurProcess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OurProcessController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $ourProcesses = OurProcess::query()
            ->latest()
            ->paginate(10);

        return OurProcessResource::collection(
            $ourProcesses
        );
    }

    public function store(
        StoreOurProcessRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $data['promises'] = $this->preparePromises(
            $data['promises'] ?? []
        );

        $ourProcess = OurProcess::create($data);

        return response()->json([
            'success' => true,

            'message' => 'Our process created successfully.',

            'data' => new OurProcessResource(
                $ourProcess
            ),
        ], 201);
    }
    public function update(
        UpdateOurProcessRequest $request,
        OurProcess $ourProcess
    ): JsonResponse {
        $data = $request->validated();

        $data['promises'] = $this->preparePromises(
            $data['promises'] ?? []
        );

        $ourProcess->update($data);

        return response()->json([
            'success' => true,

            'message' => 'Our process updated successfully.',

            'data' => new OurProcessResource(
                $ourProcess->fresh()
            ),
        ]);
    }

    public function destroy(
        OurProcess $ourProcess
    ): JsonResponse {
        $ourProcess->delete();

        return response()->json([
            'success' => true,

            'message' => 'Our process deleted successfully.',
        ]);
    }

    public function active(): AnonymousResourceCollection
    {
        $ourProcesses = OurProcess::query()
            ->where('status', 'active')
            ->latest()
            ->get();

        return OurProcessResource::collection(
            $ourProcesses
        );
    }

    private function preparePromises(array $promises): array
    {
        return collect($promises)
            ->filter(function (array $promise): bool {
                return filled($promise['text'] ?? null);
            })
            ->map(function (array $promise): array {
                return [
                    'text' => trim($promise['text']),
                ];
            })
            ->values()
            ->all();
    }
}