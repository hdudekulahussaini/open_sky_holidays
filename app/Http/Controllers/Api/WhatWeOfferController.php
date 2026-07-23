<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatWeOfferRequest;
use App\Http\Resources\WhatWeOfferResource;
use App\Models\WhatWeOffer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class WhatWeOfferController extends Controller
{
    public function index(): JsonResponse
    {
        $whatWeOffers = WhatWeOffer::query()
            ->where('status', 'active')
            ->oldest('id')
            ->get();

        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer items retrieved successfully.',

            'data' =>
                WhatWeOfferResource::collection(
                    $whatWeOffers
                ),
        ], 200);
    }

    public function store(
        WhatWeOfferRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $validated['image'] = $request
            ->file('image')
            ->store(
                'what-we-offers',
                'public'
            );

        $whatWeOffer = WhatWeOffer::create(
            $validated
        );

        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer item created successfully.',

            'data' =>
                new WhatWeOfferResource(
                    $whatWeOffer
                ),
        ], 201);
    }

    public function show(
        WhatWeOffer $whatWeOffer
    ): JsonResponse {
        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer item retrieved successfully.',

            'data' =>
                new WhatWeOfferResource(
                    $whatWeOffer
                ),
        ], 200);
    }

    public function update(
        WhatWeOfferRequest $request,
        WhatWeOffer $whatWeOffer
    ): JsonResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage(
                $whatWeOffer->image
            );

            $validated['image'] = $request
                ->file('image')
                ->store(
                    'what-we-offers',
                    'public'
                );
        } else {
            unset($validated['image']);
        }

        $whatWeOffer->update($validated);

        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer item updated successfully.',

            'data' =>
                new WhatWeOfferResource(
                    $whatWeOffer->fresh()
                ),
        ], 200);
    }

    public function destroy(
        WhatWeOffer $whatWeOffer
    ): JsonResponse {
        $this->deleteImage(
            $whatWeOffer->image
        );

        $whatWeOffer->delete();

        return response()->json([
            'success' => true,

            'message' =>
                'What We Offer item deleted successfully.',

            'data' => null,
        ], 200);
    }

    private function deleteImage(
        ?string $path
    ): void {
        if (
            filled($path) &&
            Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}