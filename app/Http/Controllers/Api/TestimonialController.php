<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use OpenApi\Attributes as OA;

class TestimonialController extends Controller
{
    #[OA\Get(
        path: '/api/testimonials',
        summary: 'List active customer testimonials',
        description: 'Retrieves a list of customer reviews and ratings.',
        tags: ['Testimonials'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Testimonials fetched successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Testimonials fetched successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Testimonial')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::query()
            ->where('status', true)
            ->latest('reviewed_at')
            ->paginate(10);

        $testimonials->getCollection()->transform(
            fn (Testimonial $testimonial) => $this->formatTestimonial($testimonial)
        );

        return response()->json([
            'success' => true,
            'message' => 'Testimonials fetched successfully.',
            'data' => $testimonials,
        ]);
    }

    public function store(
        StoreTestimonialRequest $request
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('customer_image')) {
            $data['customer_image'] = $request
                ->file('customer_image')
                ->store('testimonials', 'public');
        }

        $testimonial = Testimonial::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial created successfully.',
            'data' => $this->formatTestimonial($testimonial),
        ], 201);
    }

    #[OA\Get(
        path: '/api/testimonials/{id}',
        summary: 'Get testimonial by ID',
        description: 'Retrieves details for a single customer review.',
        tags: ['Testimonials'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, description: 'ID of the testimonial', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Testimonial fetched successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Testimonial fetched successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Testimonial'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Testimonial not found'),
        ]
    )]
    public function show(
        Testimonial $testimonial
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'Testimonial fetched successfully.',
            'data' => $this->formatTestimonial($testimonial),
        ]);
    }

    public function update(
        UpdateTestimonialRequest $request,
        Testimonial $testimonial
    ): JsonResponse {
        $data = $request->validated();

        if ($request->hasFile('customer_image')) {
            if (
                $testimonial->customer_image &&
                Storage::disk('public')->exists($testimonial->customer_image)
            ) {
                Storage::disk('public')->delete($testimonial->customer_image);
            }

            $data['customer_image'] = $request
                ->file('customer_image')
                ->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial updated successfully.',
            'data' => $this->formatTestimonial($testimonial->fresh()),
        ]);
    }

    public function destroy(
        Testimonial $testimonial
    ): JsonResponse {
        if (
            $testimonial->customer_image &&
            Storage::disk('public')->exists($testimonial->customer_image)
        ) {
            Storage::disk('public')->delete($testimonial->customer_image);
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully.',
        ]);
    }

    private function formatTestimonial(
        Testimonial $testimonial
    ): array {
        return [
            'id' => $testimonial->id,

            'platform' => $testimonial->platform,

            'customer_name' => $testimonial->customer_name,

            'customer_image' => $testimonial->customer_image,

            'customer_image_url' => $testimonial->customer_image
                ? asset('storage/' . $testimonial->customer_image)
                : null,

            'location' => $testimonial->location,

            'rating' => $testimonial->rating,

            'review' => $testimonial->review,

            'reviewed_at' => $testimonial->reviewed_at?->toISOString(),

            'review_date' => $testimonial->reviewed_at?->format('Y-m-d'),

            'review_time' => $testimonial->reviewed_at?->format('h:i A'),

            'status' => $testimonial->status,

            'created_at' => $testimonial->created_at?->toISOString(),

            'updated_at' => $testimonial->updated_at?->toISOString(),
        ];
    }
}