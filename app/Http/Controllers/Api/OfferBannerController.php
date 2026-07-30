<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferBannerRequest;
use App\Http\Requests\UpdateOfferBannerRequest;
use App\Http\Resources\OfferBannerResource;
use App\Models\OfferBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class OfferBannerController extends Controller
{
    #[OA\Get(
        path: '/api/offer-banners',
        summary: 'List active offer banners',
        description: 'Retrieves all active promotional offer banners.',
        tags: ['Offer Banners'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Offer banners retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Offer banners retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/OfferBanner')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $offerBanners = OfferBanner::query()
            ->where('status', true)
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Offer banners retrieved successfully.',
            'data' => OfferBannerResource::collection($offerBanners),
        ]);
    }

    public function store(
        StoreOfferBannerRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('offer-banners', 'public');
        }

        $offerBanner = OfferBanner::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Offer banner created successfully.',
            'data' => new OfferBannerResource($offerBanner),
        ], 201);
    }

    public function show(
        OfferBanner $offerBanner
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'Offer banner retrieved successfully.',
            'data' => new OfferBannerResource($offerBanner),
        ]);
    }

    public function update(
        UpdateOfferBannerRequest $request,
        OfferBanner $offerBanner
    ): JsonResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($offerBanner->image && Storage::disk('public')->exists($offerBanner->image)) {
                Storage::disk('public')->delete($offerBanner->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('offer-banners', 'public');
        }

        $offerBanner->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Offer banner updated successfully.',
            'data' => new OfferBannerResource($offerBanner->fresh()),
        ]);
    }

    public function destroy(
        OfferBanner $offerBanner
    ): JsonResponse {
        if ($offerBanner->image && Storage::disk('public')->exists($offerBanner->image)) {
            Storage::disk('public')->delete($offerBanner->image);
        }

        $offerBanner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Offer banner deleted successfully.',
            'data' => null,
        ]);
    }
}