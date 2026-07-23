<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class TourController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $tours = Tour::query()
            ->with('tourType:id,name,slug')
            ->latest('id')
            ->paginate(10);

        return TourResource::collection($tours);
    }

    public function store(
        StoreTourRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title']
        );

        $thumbnail = null;

        try {
            DB::beginTransaction();

            $thumbnail = $request
                ->file('thumbnail')
                ->store('tours', 'public');

            $validated['thumbnail'] = $thumbnail;

            $tour = Tour::create($validated);

            DB::commit();

            $tour->load('tourType:id,name,slug');

            return response()->json([
                'success' => true,
                'message' => 'Tour created successfully.',
                'data' => new TourResource($tour),
            ], 201);
        } catch (Throwable $exception) {
            DB::rollBack();

            if ($thumbnail) {
                Storage::disk('public')
                    ->delete($thumbnail);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create the tour.',
            ], 500);
        }
    }

    public function show(Tour $tour): JsonResponse
    {
        $tour->load('tourType:id,name,slug');

        return response()->json([
            'success' => true,
            'message' => 'Tour retrieved successfully.',
            'data' => new TourResource($tour),
        ]);
    }

    public function update(
        UpdateTourRequest $request,
        Tour $tour
    ): JsonResponse {
        $validated = $request->validated();

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $tour->id
        );

        $oldThumbnail = $tour->thumbnail;
        $newThumbnail = null;

        try {
            DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                $newThumbnail = $request
                    ->file('thumbnail')
                    ->store('tours', 'public');

                $validated['thumbnail'] = $newThumbnail;
            } else {
                unset($validated['thumbnail']);
            }

            $tour->update($validated);

            DB::commit();

            if (
                $newThumbnail &&
                $oldThumbnail &&
                $oldThumbnail !== $newThumbnail
            ) {
                Storage::disk('public')
                    ->delete($oldThumbnail);
            }

            $tour->load('tourType:id,name,slug');

            return response()->json([
                'success' => true,
                'message' => 'Tour updated successfully.',
                'data' => new TourResource($tour),
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();

            if ($newThumbnail) {
                Storage::disk('public')
                    ->delete($newThumbnail);
            }

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the tour.',
            ], 500);
        }
    }

    public function destroy(Tour $tour): JsonResponse
    {
        $thumbnail = $tour->thumbnail;

        try {
            DB::beginTransaction();

            $tour->delete();

            DB::commit();

            if ($thumbnail) {
                Storage::disk('public')
                    ->delete($thumbnail);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tour deleted successfully.',
            ]);
        } catch (Throwable $exception) {
            DB::rollBack();

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete this tour because related records may exist.',
            ], 409);
        }
    }

    private function generateUniqueSlug(
        ?string $requestedSlug,
        string $title,
        ?int $ignoreTourId = null
    ): string {
        $baseSlug = Str::slug(
            $requestedSlug ?: $title
        );

        if ($baseSlug === '') {
            $baseSlug = 'tour';
        }

        $slug = $baseSlug;
        $number = 1;

        while (
            Tour::query()
                ->when(
                    $ignoreTourId,
                    fn ($query) => $query->where(
                        'id',
                        '!=',
                        $ignoreTourId
                    )
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$number;
            $number++;
        }

        return $slug;
    }
}
