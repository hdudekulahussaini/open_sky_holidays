<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageBannerResource;
use App\Models\PageBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;

class PageBannerController extends Controller
{
    #[OA\Get(
        path: '/api/page-banners',
        summary: 'List all page header banners',
        description: 'Retrieves a list of all configured page banners.',
        tags: ['Page Banners'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Page banners retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Page banners retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/PageBanner')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $pageBanners = PageBanner::query()
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Page banners retrieved successfully.',
            'data' => PageBannerResource::collection($pageBanners),
        ], 200);
    }

    #[OA\Get(
        path: '/api/page-banners/{pageBanner}',
        summary: 'Get single page banner details',
        description: 'Retrieves single page banner details by ID.',
        tags: ['Page Banners'],
        parameters: [
            new OA\Parameter(name: 'pageBanner', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Page banner retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Page banner retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/PageBanner'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Page banner not found'),
        ]
    )]
    public function show(PageBanner $pageBanner): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Page banner retrieved successfully.',
            'data' => new PageBannerResource($pageBanner),
        ], 200);
    }

    #[OA\Get(
        path: '/api/page-banners/page/{page}',
        summary: 'Get banner by page name or slug',
        description: 'Retrieves active banner image and titles for a specific page (e.g., tours-international, about-us, contact-us).',
        tags: ['Page Banners'],
        parameters: [
            new OA\Parameter(name: 'page', in: 'path', required: true, description: 'Page key or slug name', schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Page banner retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Page banner retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/PageBanner'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Active page banner not found'),
        ]
    )]
    public function byPage(string $page): JsonResponse
    {
        $slug = Str::slug($page);

        $pageBanner = PageBanner::query()
            ->where(function ($query) use ($page, $slug) {
                $query->where('page', $page)
                    ->orWhere('page', $slug);
            })
            ->where('status', true)
            ->first();

        if (! $pageBanner) {
            return response()->json([
                'success' => false,
                'message' => 'Active page banner not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Page banner retrieved successfully.',
            'data' => new PageBannerResource($pageBanner),
        ], 200);
    }
}