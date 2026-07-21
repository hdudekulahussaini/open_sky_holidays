<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTravelSupportSectionRequest;
use App\Http\Requests\UpdateTravelSupportSectionRequest;
use App\Http\Resources\TravelSupportSectionResource;
use App\Models\TravelSupportSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Throwable;

class TravelSupportSectionController extends Controller
{
    public function index(): JsonResponse
    {
        $travelSupportSections = TravelSupportSection::latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Travel support sections retrieved successfully.',
            'data' => TravelSupportSectionResource::collection(
                $travelSupportSections
            ),
        ]);
    }

    public function store(
        StoreTravelSupportSectionRequest $request
    ): JsonResponse {
        try {
            $validated = $request->validated();

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')
                    ->store('travel-support', 'public');
            }

            $validated['features'] = array_values(
                array_filter(
                    $validated['features'],
                    fn ($feature) => trim($feature) !== ''
                )
            );

            $validated['status'] = $request->boolean('status');

            $travelSupportSection = TravelSupportSection::create(
                $validated
            );

            return response()->json([
                'success' => true,
                'message' => 'Travel support section created successfully.',
                'data' => new TravelSupportSectionResource(
                    $travelSupportSection
                ),
            ], 201);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create travel support section.',
            ], 500);
        }
    }

    // public function show(
    //     TravelSupportSection $travelSupport
    // ): JsonResponse {
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Travel support section retrieved successfully.',
    //         'data' => new TravelSupportSectionResource(
    //             $travelSupport
    //         ),
    //     ]);
    // }

    public function update(
        UpdateTravelSupportSectionRequest $request,
        TravelSupportSection $travelSupport
    ): JsonResponse {
        try {
            $validated = $request->validated();

            if ($request->boolean('remove_image')) {
                $this->deleteImage($travelSupport->image);
                $validated['image'] = null;
            }

            if ($request->hasFile('image')) {
                $this->deleteImage($travelSupport->image);

                $validated['image'] = $request->file('image')
                    ->store('travel-support', 'public');
            } else {
                unset($validated['image']);
            }

            unset($validated['remove_image']);

            $validated['features'] = array_values(
                array_filter(
                    $validated['features'],
                    fn ($feature) => trim($feature) !== ''
                )
            );

            $validated['status'] = $request->boolean('status');

            $travelSupport->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Travel support section updated successfully.',
                'data' => new TravelSupportSectionResource(
                    $travelSupport->fresh()
                ),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update travel support section.',
            ], 500);
        }
    }

    public function destroy(
        TravelSupportSection $travelSupport
    ): JsonResponse {
        try {
            $this->deleteImage($travelSupport->image);

            $travelSupport->delete();

            return response()->json([
                'success' => true,
                'message' => 'Travel support section deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete travel support section.',
            ], 500);
        }
    }

    public function active(): JsonResponse
    {
        $travelSupportSections = TravelSupportSection::query()
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Active travel support sections retrieved successfully.',
            'data' => TravelSupportSectionResource::collection(
                $travelSupportSections
            ),
        ]);
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