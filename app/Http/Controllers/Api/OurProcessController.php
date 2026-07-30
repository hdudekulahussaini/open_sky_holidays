<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOurProcessRequest;
use App\Http\Requests\UpdateOurProcessRequest;
use App\Http\Resources\OurProcessResource;
use App\Models\OurProcess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class OurProcessController extends Controller
{
    #[OA\Get(
        path: '/api/our-processes',
        summary: 'List all process section items',
        description: 'Retrieves all process section records.',
        tags: ['About Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Our process items retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/OurProcess')),
                    ]
                )
            ),
        ]
    )]
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

    #[OA\Get(
        path: '/api/our-processes/active',
        summary: 'Get active process section items',
        description: 'Retrieves active company process steps.',
        tags: ['About Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active process section items retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/OurProcess')),
                    ]
                )
            ),
        ]
    )]
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