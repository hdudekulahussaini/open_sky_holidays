<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhyChooseSectionRequest;
use App\Http\Requests\UpdateWhyChooseSectionRequest;
use App\Http\Resources\WhyChooseSectionResource;
use App\Models\WhyChooseSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WhyChooseSectionController extends Controller
{
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

    public function active(): AnonymousResourceCollection
    {
        $sections = WhyChooseSection::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        return WhyChooseSectionResource::collection($sections);
    }
}