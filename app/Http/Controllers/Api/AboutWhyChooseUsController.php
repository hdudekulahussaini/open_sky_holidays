<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutWhyChooseUsRequest;
use App\Http\Resources\AboutWhyChooseUsResource;
use App\Models\AboutWhyChooseUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Throwable;

class AboutWhyChooseUsController extends Controller
{
    public function index(): JsonResponse
    {
        $sections = AboutWhyChooseUs::query()
            ->where('status', 'active')
            ->oldest('id')
            ->get();

        return response()->json([
            'success' => true,

            'message' =>
                'About Why Choose Us retrieved successfully.',

            'data' =>
                AboutWhyChooseUsResource::collection(
                    $sections
                ),
        ], 200);
    }

    public function store(
        AboutWhyChooseUsRequest $request
    ): JsonResponse {
        $validated = $request->validated();

        $uploadedImage = null;

        try {
            $uploadedImage = $request
                ->file('image')
                ->store(
                    'about_why_choose_us',
                    'public'
                );

            $validated['image'] = $uploadedImage;

            [
                $validated['features_title'],
                $validated['features_description'],
            ] = $this->prepareFeatures(
                $validated['features_title'],
                $validated['features_description'] ?? []
            );

            $section = AboutWhyChooseUs::create(
                $validated
            );

            return response()->json([
                'success' => true,

                'message' =>
                    'About Why Choose Us created successfully.',

                'data' =>
                    new AboutWhyChooseUsResource(
                        $section
                    ),
            ], 201);
        } catch (Throwable $exception) {
            $this->deleteImage($uploadedImage);

            report($exception);

            return response()->json([
                'success' => false,
                'message' =>
                    'Unable to create About Why Choose Us.',
                'data' => null,
            ], 500);
        }
    }

    public function show(
        AboutWhyChooseUs $aboutWhyChooseUs
    ): JsonResponse {
        return response()->json([
            'success' => true,

            'message' =>
                'About Why Choose Us retrieved successfully.',

            'data' =>
                new AboutWhyChooseUsResource(
                    $aboutWhyChooseUs
                ),
        ], 200);
    }

    public function update(
        AboutWhyChooseUsRequest $request,
        AboutWhyChooseUs $aboutWhyChooseUs
    ): JsonResponse {
        $validated = $request->validated();

        $oldImage = $aboutWhyChooseUs->image;
        $newImage = null;

        try {
            if ($request->hasFile('image')) {
                $newImage = $request
                    ->file('image')
                    ->store(
                        'about_why_choose_us',
                        'public'
                    );

                $validated['image'] = $newImage;
            } else {
                unset($validated['image']);
            }

            [
                $validated['features_title'],
                $validated['features_description'],
            ] = $this->prepareFeatures(
                $validated['features_title'],
                $validated['features_description'] ?? []
            );

            $aboutWhyChooseUs->update(
                $validated
            );

            if ($newImage) {
                $this->deleteImage($oldImage);
            }

            return response()->json([
                'success' => true,

                'message' =>
                    'About Why Choose Us updated successfully.',

                'data' =>
                    new AboutWhyChooseUsResource(
                        $aboutWhyChooseUs->fresh()
                    ),
            ], 200);
        } catch (Throwable $exception) {
            $this->deleteImage($newImage);

            report($exception);

            return response()->json([
                'success' => false,
                'message' =>
                    'Unable to update About Why Choose Us.',
                'data' => null,
            ], 500);
        }
    }

    public function destroy(
        AboutWhyChooseUs $aboutWhyChooseUs
    ): JsonResponse {
        $image = $aboutWhyChooseUs->image;

        $aboutWhyChooseUs->delete();

        $this->deleteImage($image);

        return response()->json([
            'success' => true,

            'message' =>
                'About Why Choose Us deleted successfully.',

            'data' => null,
        ], 200);
    }

    private function prepareFeatures(
        array $titles,
        array $descriptions
    ): array {
        $preparedTitles = [];
        $preparedDescriptions = [];

        foreach ($titles as $index => $title) {
            if (blank($title)) {
                continue;
            }

            $preparedTitles[] = trim($title);

            $description =
                $descriptions[$index] ?? null;

            $preparedDescriptions[] =
                filled($description)
                    ? trim($description)
                    : null;
        }

        return [
            $preparedTitles,
            $preparedDescriptions,
        ];
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