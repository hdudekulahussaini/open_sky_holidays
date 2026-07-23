<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutSectionRequest;
use App\Http\Resources\AboutSectionResource;
use App\Models\AboutSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AboutSectionController extends Controller
{
    /**
     * Display all about sections.
     */
    public function index()
    {
        $aboutSections = AboutSection::with([
            'globeLocations',
            'customerAvatars',
        ])
            ->latest()
            ->paginate(10);

        return AboutSectionResource::collection($aboutSections);
    }

    /**
     * Create a new about section.
     */
    public function store(
        AboutSectionRequest $request
    ): JsonResponse {
        try {
            $aboutSection = DB::transaction(
                function () use ($request) {
                    $aboutSection = AboutSection::create(
                        $request->safe()->only([
                            'main_heading',
                            'mission_title',
                            'focus_title',
                            'description',
                            'customer_count',
                            'status',
                        ])
                    );

                    $this->storeLocations(
                        $aboutSection,
                        $request->input('locations', [])
                    );

                    $this->storeAvatars(
                        $aboutSection,
                        $request->file('avatar_images', [])
                    );

                    return $aboutSection->load([
                        'globeLocations',
                        'customerAvatars',
                    ]);
                }
            );

            return response()->json([
                'success' => true,
                'message' => 'About section created successfully.',
                'data' => new AboutSectionResource($aboutSection),
            ], 201);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create the about section.',
                'error' => config('app.debug')
                    ? $exception->getMessage()
                    : null,
            ], 500);
        }
    }

    /**
     * Display one about section.
     */
    public function show(
        AboutSection $aboutSection
    ): JsonResponse {
        $aboutSection->load([
            'globeLocations',
            'customerAvatars',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'About section fetched successfully.',
            'data' => new AboutSectionResource($aboutSection),
        ]);
    }

    /**
     * Update an about section.
     */
    public function update(
        AboutSectionRequest $request,
        AboutSection $aboutSection
    ): JsonResponse {
        try {
            $aboutSection = DB::transaction(
                function () use ($request, $aboutSection) {
                    $aboutSection->update(
                        $request->safe()->only([
                            'main_heading',
                            'mission_title',
                            'focus_title',
                            'description',
                            'customer_count',
                            'status',
                        ])
                    );

                    /*
                     * Replace all old globe locations with the
                     * newly submitted locations.
                     */
                    $aboutSection->globeLocations()->delete();

                    $this->storeLocations(
                        $aboutSection,
                        $request->input('locations', [])
                    );

                    /*
                     * Remove selected old avatar images.
                     */
                    $this->removeSelectedAvatars(
                        $aboutSection,
                        $request->input('remove_avatar_ids', [])
                    );

                    /*
                     * Store newly uploaded avatar images.
                     */
                    $this->storeAvatars(
                        $aboutSection,
                        $request->file('avatar_images', [])
                    );

                    return $aboutSection->fresh()->load([
                        'globeLocations',
                        'customerAvatars',
                    ]);
                }
            );

            return response()->json([
                'success' => true,
                'message' => 'About section updated successfully.',
                'data' => new AboutSectionResource($aboutSection),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the about section.',
                'error' => config('app.debug')
                    ? $exception->getMessage()
                    : null,
            ], 500);
        }
    }

    /**
     * Delete an about section.
     */
    public function destroy(
        AboutSection $aboutSection
    ): JsonResponse {
        try {
            DB::transaction(function () use ($aboutSection) {
                $aboutSection->load('customerAvatars');

                foreach ($aboutSection->customerAvatars as $avatar) {
                    Storage::disk('public')->delete($avatar->image);
                }

                /*
                 * Related globe locations and avatars will be
                 * deleted automatically when cascadeOnDelete()
                 * is used in the migrations.
                 */
                $aboutSection->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'About section deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete the about section.',
                'error' => config('app.debug')
                    ? $exception->getMessage()
                    : null,
            ], 500);
        }
    }

    /**
     * Return the latest active about section for frontend.
     */
    public function active(): JsonResponse
    {
        $aboutSection = AboutSection::with([
            'globeLocations',
            'customerAvatars',
        ])
            ->where('status', true)
            ->latest()
            ->first();

        if (! $aboutSection) {
            return response()->json([
                'success' => false,
                'message' => 'Active about section not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Active about section fetched successfully.',
            'data' => new AboutSectionResource($aboutSection),
        ]);
    }

    /**
     * Store globe locations.
     */
    private function storeLocations(
        AboutSection $aboutSection,
        array $locations
    ): void {
        foreach ($locations as $location) {
            $aboutSection->globeLocations()->create([
                'location_name' => $location['location_name'],
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
            ]);
        }
    }

    /**
     * Store customer avatar images.
     */
    private function storeAvatars(
        AboutSection $aboutSection,
        array $avatarImages
    ): void {
        foreach ($avatarImages as $avatarImage) {
            $path = $avatarImage->store(
                'about/customer-avatars',
                'public'
            );

            $aboutSection->customerAvatars()->create([
                'image' => $path,
            ]);
        }
    }

    /**
     * Remove selected customer avatar images.
     */
    private function removeSelectedAvatars(
        AboutSection $aboutSection,
        array $avatarIds
    ): void {
        if (empty($avatarIds)) {
            return;
        }

        $avatars = $aboutSection
            ->customerAvatars()
            ->whereIn('id', $avatarIds)
            ->get();

        foreach ($avatars as $avatar) {
            Storage::disk('public')->delete($avatar->image);

            $avatar->delete();
        }
    }
}
