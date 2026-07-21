<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferBannerRequest;
use App\Http\Resources\OfferBannerResource;
use App\Models\OfferBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Throwable;

class OfferBannerController extends Controller
{
    public function index(): JsonResponse
    {
        $offerBanners = OfferBanner::query()
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Offer banners retrieved successfully.',
            'data' => OfferBannerResource::collection($offerBanners),
        ]);
    }

    public function store(
        OfferBannerRequest $request
    ): JsonResponse {
        $data = $request->validated();
        $uploadedImage = null;

        try {
            if ($request->hasFile('image')) {
                $uploadedImage = $request
                    ->file('image')
                    ->store('offer-banners', 'public');

                $data['image'] = $uploadedImage;
            }

            $offerBanner = OfferBanner::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Offer banner created successfully.',
                'data' => new OfferBannerResource($offerBanner),
            ], 201);
        } catch (Throwable $exception) {
            if ($uploadedImage) {
                Storage::disk('public')->delete($uploadedImage);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create the offer banner.',
            ], 500);
        }
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
        OfferBannerRequest $request,
        OfferBanner $offerBanner
    ): JsonResponse {
        $data = $request->validated();

        $oldImage = $offerBanner->image;
        $newImage = null;

        try {
            if ($request->hasFile('image')) {
                $newImage = $request
                    ->file('image')
                    ->store('offer-banners', 'public');

                $data['image'] = $newImage;
            } else {
                unset($data['image']);
            }

            $offerBanner->update($data);

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            return response()->json([
                'success' => true,
                'message' => 'Offer banner updated successfully.',
                'data' => new OfferBannerResource(
                    $offerBanner->fresh()
                ),
            ]);
        } catch (Throwable $exception) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the offer banner.',
            ], 500);
        }
    }

    public function destroy(
        OfferBanner $offerBanner
    ): JsonResponse {
        try {
            $image = $offerBanner->image;

            $offerBanner->delete();

            if ($image) {
                Storage::disk('public')->delete($image);
            }

            return response()->json([
                'success' => true,
                'message' => 'Offer banner deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete the offer banner.',
            ], 500);
        }
    }
}