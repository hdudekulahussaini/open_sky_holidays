<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutWhyChooseUsRequest;
use App\Http\Resources\AboutWhyChooseUsResource;
use App\Models\AboutWhyChooseUs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;
use Throwable;

class AboutWhyChooseUsController extends Controller
{
    #[OA\Get(
        path: '/api/about-why-choose-us',
        summary: 'List active About Why Choose Us sections',
        description: 'Retrieves all active about why choose us section records.',
        tags: ['About Why Choose Us'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'About Why Choose Us retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'About Why Choose Us retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/AboutWhyChooseUs')
                        ),
                    ]
                )
            ),
        ]
    )]
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

    #[OA\Post(
        path: '/api/about-why-choose-us',
        summary: 'Create About Why Choose Us section',
        description: 'Creates a new About Why Choose Us section with image upload.',
        tags: ['About Why Choose Us'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['main_heading', 'main_description', 'features_title'],
                    properties: [
                        new OA\Property(property: 'subtitle', type: 'string', example: 'Why Choose Us'),
                        new OA\Property(property: 'main_heading', type: 'string', example: 'Your Trusted Partner'),
                        new OA\Property(property: 'main_description', type: 'string', example: 'We deliver exceptional travel experiences.'),
                        new OA\Property(property: 'image', type: 'string', format: 'binary'),
                        new OA\Property(
                            property: 'features_title[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'Best Prices')
                        ),
                        new OA\Property(
                            property: 'features_description[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'Competitive rates guaranteed')
                        ),
                        new OA\Property(property: 'status', type: 'string', example: 'active'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'About Why Choose Us created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'About Why Choose Us created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutWhyChooseUs'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 500, description: 'Server Error'),
        ]
    )]
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

    #[OA\Get(
        path: '/api/about-why-choose-us/{aboutWhyChooseUs}',
        summary: 'Get About Why Choose Us details',
        description: 'Retrieves single About Why Choose Us section details by ID.',
        tags: ['About Why Choose Us'],
        parameters: [
            new OA\Parameter(name: 'aboutWhyChooseUs', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'About Why Choose Us retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'About Why Choose Us retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutWhyChooseUs'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Section not found'),
        ]
    )]
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

    #[OA\Put(
        path: '/api/about-why-choose-us/{aboutWhyChooseUs}',
        summary: 'Update About Why Choose Us section',
        description: 'Updates an existing About Why Choose Us section record by ID.',
        tags: ['About Why Choose Us'],
        parameters: [
            new OA\Parameter(name: 'aboutWhyChooseUs', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'subtitle', type: 'string', example: 'Updated Subtitle'),
                        new OA\Property(property: 'main_heading', type: 'string', example: 'Updated Main Heading'),
                        new OA\Property(property: 'main_description', type: 'string', example: 'Updated Main Description'),
                        new OA\Property(property: 'image', type: 'string', format: 'binary', nullable: true),
                        new OA\Property(
                            property: 'features_title[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'Feature Title')
                        ),
                        new OA\Property(
                            property: 'features_description[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'Feature Description')
                        ),
                        new OA\Property(property: 'status', type: 'string', example: 'active'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'About Why Choose Us updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'About Why Choose Us updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/AboutWhyChooseUs'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Section not found'),
            new OA\Response(response: 500, description: 'Server Error'),
        ]
    )]
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

    #[OA\Delete(
        path: '/api/about-why-choose-us/{aboutWhyChooseUs}',
        summary: 'Delete About Why Choose Us section',
        description: 'Deletes an About Why Choose Us section record by ID.',
        tags: ['About Why Choose Us'],
        parameters: [
            new OA\Parameter(name: 'aboutWhyChooseUs', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'About Why Choose Us deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'About Why Choose Us deleted successfully.'),
                        new OA\Property(property: 'data', type: 'string', nullable: true, example: null),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Section not found'),
        ]
    )]
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