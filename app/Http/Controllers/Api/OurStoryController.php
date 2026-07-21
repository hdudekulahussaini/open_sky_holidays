<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOurStoryRequest;
use App\Http\Requests\UpdateOurStoryRequest;
use App\Http\Resources\OurStoryResource;
use App\Models\OurStory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class OurStoryController extends Controller
{
    public function index(
        Request $request
    ): AnonymousResourceCollection {
        $ourStories = OurStory::query()
            ->when(
                $request->has('status'),
                fn ($query) => $query->where(
                    'status',
                    $request->boolean('status')
                )
            )
            ->latest()
            ->paginate(
                $request->integer('per_page', 10)
            );

        return OurStoryResource::collection($ourStories);
    }

    public function store(
        StoreOurStoryRequest $request
    ): JsonResponse {
        $uploadedImages = [];

        try {
            DB::beginTransaction();

            foreach ($request->file('images', []) as $image) {
                $uploadedImages[] = $image->store(
                    'our-stories',
                    'public'
                );
            }

            $ourStory = OurStory::create([
                'small_heading' => $request->input('small_heading'),
                'heading' => $request->input('heading'),
                'description' => $request->input('description'),
                'images' => $uploadedImages,
                'features' => $request->input('features', []),
                'status' => $request->boolean('status'),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Our Story created successfully.',
                'data' => new OurStoryResource($ourStory),
            ], 201);
        } catch (Throwable $exception) {
            DB::rollBack();

            foreach ($uploadedImages as $image) {
                Storage::disk('public')->delete($image);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create Our Story.',
            ], 500);
        }
    }

    public function update(
        UpdateOurStoryRequest $request,
        OurStory $ourStory
    ): JsonResponse {
        $newlyUploadedImages = [];
        $deletedImages = [];

        try {
            DB::beginTransaction();

            $currentImages = $ourStory->images ?? [];

            $requestedRemovedImages = array_filter(
                $request->input('removed_images', [])
            );

            $deletedImages = array_values(
                array_intersect(
                    $currentImages,
                    $requestedRemovedImages
                )
            );

            $remainingImages = array_values(
                array_diff($currentImages, $deletedImages)
            );

            foreach ($request->file('images', []) as $image) {
                $path = $image->store('our-stories', 'public');

                $newlyUploadedImages[] = $path;
                $remainingImages[] = $path;
            }

            if (count($remainingImages) > 3) {
                throw new \RuntimeException(
                    'Maximum 3 images are allowed.'
                );
            }

            $ourStory->update([
                'heading' => $request->input('heading'),
                'description' => $request->input('description'),
                'images' => $remainingImages,
                'features' => $request->input('features', []),
                'status' => $request->boolean('status'),
            ]);

            DB::commit();

            foreach ($deletedImages as $image) {
                Storage::disk('public')->delete($image);
            }

            return response()->json([
                'success' => true,
                'message' => 'Our Story updated successfully.',
                'data' => new OurStoryResource($ourStory->fresh()),
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();

            foreach ($newlyUploadedImages as $image) {
                Storage::disk('public')->delete($image);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update Our Story.',
            ], 500);
        }
    }

    public function destroy(
        OurStory $ourStory
    ): JsonResponse {
        try {
            DB::beginTransaction();

            $images = $ourStory->images ?? [];

            $ourStory->delete();

            DB::commit();

            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }

            return response()->json([
                'success' => true,
                'message' => 'Our Story deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete Our Story.',
            ], 500);
        }
    }
}
