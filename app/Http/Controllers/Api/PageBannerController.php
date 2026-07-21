<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageBannerRequest;
use App\Http\Resources\PageBannerResource;
use App\Models\PageBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class PageBannerController extends Controller
{
    public function index(): JsonResponse
    {
        $pageBanners = PageBanner::query()
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'message' =>
                'Page banners retrieved successfully.',
            'data' =>
                PageBannerResource::collection($pageBanners),
        ], 200);
    }

    public function store(
        PageBannerRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        /*
         * API image is optional.
         * Raw JSON can be sent without an image.
         * Form-data can be sent with an image.
         */
        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('page-banners', 'public');
        }

        $pageBanner = PageBanner::create($validated);

        return response()->json([
            'success' => true,
            'message' =>
                'Page banner created successfully.',
            'data' =>
                new PageBannerResource($pageBanner),
        ], 201);
    }

    public function show(
        PageBanner $pageBanner
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' =>
                'Page banner retrieved successfully.',
            'data' =>
                new PageBannerResource($pageBanner),
        ], 200);
    }

    public function update(
        PageBannerRequest $request,
        PageBanner $pageBanner
    ): JsonResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage($pageBanner->image);

            $validated['image'] = $request
                ->file('image')
                ->store('page-banners', 'public');
        } else {
            unset($validated['image']);
        }

        $pageBanner->update($validated);

        return response()->json([
            'success' => true,
            'message' =>
                'Page banner updated successfully.',
            'data' =>
                new PageBannerResource(
                    $pageBanner->fresh()
                ),
        ], 200);
    }

    public function destroy(
        PageBanner $pageBanner
    ): JsonResponse {
        $this->deleteImage($pageBanner->image);

        $pageBanner->delete();

        return response()->json([
            'success' => true,
            'message' =>
                'Page banner deleted successfully.',
            'data' => null,
        ], 200);
    }

    public function byPage(
        string $page
    ): JsonResponse {
        $pageBanner = PageBanner::query()
            ->where('page', $page)
            ->where('status', true)
            ->first();

        if (!$pageBanner) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Active page banner not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' =>
                'Page banner retrieved successfully.',
            'data' =>
                new PageBannerResource($pageBanner),
        ], 200);
    }

    private function deleteImage(?string $image): void
    {
        if (
            $image &&
            Storage::disk('public')->exists($image)
        ) {
            Storage::disk('public')->delete($image);
        }
    }
}