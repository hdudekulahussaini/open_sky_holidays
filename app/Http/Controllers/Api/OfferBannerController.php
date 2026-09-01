<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferBannerResource;
use App\Models\OfferBanner;
use Illuminate\Http\JsonResponse;
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

    #[OA\Get(
        path: '/api/offer-banners/{offerBanner}',
        summary: 'Get single offer banner details',
        description: 'Retrieves single offer banner details by ID.',
        tags: ['Offer Banners'],
        parameters: [
            new OA\Parameter(name: 'offerBanner', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Offer banner retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Offer banner retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/OfferBanner'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Offer banner not found'),
        ]
    )]
    public function show(
        OfferBanner $offerBanner
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'Offer banner retrieved successfully.',
            'data' => new OfferBannerResource($offerBanner),
        ]);
    }
}