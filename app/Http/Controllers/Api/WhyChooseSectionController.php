<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhyChooseSectionRequest;
use App\Http\Requests\UpdateWhyChooseSectionRequest;
use App\Http\Resources\WhyChooseSectionResource;
use App\Models\WhyChooseSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class WhyChooseSectionController extends Controller
{
    #[OA\Get(
        path: '/api/why-choose-sections',
        summary: 'List all Why Choose Us home sections',
        description: 'Retrieves all Why Choose Us section items.',
        tags: ['Why Choose Us'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Why choose sections retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/WhyChooseSection')),
                    ]
                )
            ),
        ]
    )]
    public function index(): AnonymousResourceCollection
    {
        $sections = WhyChooseSection::query()
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(10);

        return WhyChooseSectionResource::collection($sections);
    }

    public function store(
        StoreWhyChooseSectionRequest $request
    ): JsonResponse {
        $section = WhyChooseSection::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Why choose section created successfully.',
            'data' => new WhyChooseSectionResource($section),
        ], 201);
    }

    // public function show(
    //     WhyChooseSection $whyChooseSection
    // ): JsonResponse {
    //     return response()->json([
    //         'success' => true,
    //         'data' => new WhyChooseSectionResource($whyChooseSection),
    //     ]);
    // }

    public function update(
        UpdateWhyChooseSectionRequest $request,
        WhyChooseSection $whyChooseSection
    ): JsonResponse {
        $whyChooseSection->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Why choose section updated successfully.',
            'data' => new WhyChooseSectionResource(
                $whyChooseSection->fresh()
            ),
        ]);
    }

    public function destroy(
        WhyChooseSection $whyChooseSection
    ): JsonResponse {
        $whyChooseSection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Why choose section deleted successfully.',
        ]);
    }

    #[OA\Get(
        path: '/api/why-choose-sections/active',
        summary: 'Get active Why Choose Us sections for website',
        description: 'Retrieves active Why Choose Us cards in display order.',
        tags: ['Why Choose Us'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active Why choose sections retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/WhyChooseSection')),
                    ]
                )
            ),
        ]
    )]
    public function active(): AnonymousResourceCollection
    {
        $sections = WhyChooseSection::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        return WhyChooseSectionResource::collection($sections);
    }
}