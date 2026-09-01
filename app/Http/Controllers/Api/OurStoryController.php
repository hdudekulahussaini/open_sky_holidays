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
use OpenApi\Attributes as OA;
use Throwable;

class OurStoryController extends Controller
{
    #[OA\Get(
        path: '/api/our-stories',
        summary: 'List company stories',
        description: 'Retrieves a paginated list of company story records with optional status filter.',
        tags: ['Our Story'],
        parameters: [
            new OA\Parameter(name: 'status', in: 'query', description: 'Filter by status (true/false)', required: false, schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'per_page', in: 'query', description: 'Items per page (default 10)', required: false, schema: new OA\Schema(type: 'integer', default: 10)),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated list of our stories',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/OurStory')
                        ),
                    ]
                )
            ),
        ]
    )]
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

    #[OA\Post(
        path: '/api/our-stories',
        summary: 'Store a new company story',
        description: 'Creates a new company story with image uploads (max 3 images).',
        tags: ['Our Story'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['heading', 'description'],
                    properties: [
                        new OA\Property(property: 'heading', type: 'string', example: 'Our Journey Since 2015'),
                        new OA\Property(property: 'description', type: 'string', example: 'Started with a vision to make international travel accessible.'),
                        new OA\Property(
                            property: 'images[]',
                            type: 'array',
                            description: 'Story images to upload (Max 3). Supported formats: JPG, JPEG, PNG, WEBP, AVIF. Maximum size: 5MB per file.',
                            items: new OA\Items(type: 'string', format: 'binary')
                        ),
                        new OA\Property(
                            property: 'features[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'Certified Travel Agents')
                        ),
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Our Story created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Our Story created successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/OurStory'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Validation Error'),
            new OA\Response(response: 500, description: 'Unable to create Our Story'),
        ]
    )]
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

    #[OA\Put(
        path: '/api/our-stories/{ourStory}',
        summary: 'Update company story',
        description: 'Updates an existing company story record by ID.',
        tags: ['Our Story'],
        parameters: [
            new OA\Parameter(name: 'ourStory', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'heading', type: 'string', example: 'Updated Story Heading'),
                        new OA\Property(property: 'description', type: 'string', example: 'Updated description content.'),
                        new OA\Property(
                            property: 'images[]',
                            type: 'array',
                            description: 'New story images to upload. Supported formats: JPG, JPEG, PNG, WEBP, AVIF. Maximum size: 5MB per file.',
                            items: new OA\Items(type: 'string', format: 'binary')
                        ),
                        new OA\Property(
                            property: 'removed_images[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'our-stories/old_image.jpg')
                        ),
                        new OA\Property(
                            property: 'features[]',
                            type: 'array',
                            items: new OA\Items(type: 'string', example: 'Feature Name')
                        ),
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Our Story updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Our Story updated successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/OurStory'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Story not found'),
            new OA\Response(response: 500, description: 'Unable to update Our Story'),
        ]
    )]
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

    #[OA\Delete(
        path: '/api/our-stories/{ourStory}',
        summary: 'Delete company story',
        description: 'Deletes a company story record by ID.',
        tags: ['Our Story'],
        parameters: [
            new OA\Parameter(name: 'ourStory', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Our Story deleted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Our Story deleted successfully.'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Story not found'),
            new OA\Response(response: 500, description: 'Unable to delete Our Story'),
        ]
    )]
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
