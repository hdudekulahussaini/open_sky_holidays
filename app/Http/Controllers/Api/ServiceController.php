<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class ServiceController extends Controller
{
    #[OA\Get(
        path: '/api/services',
        summary: 'List active travel services',
        description: 'Retrieves a list of all active travel services (visa, flight tickets, passport, etc.).',
        tags: ['Services'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Services fetched successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Services fetched successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Service')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $services = Service::query()
            ->where('status', true)
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Services fetched successfully.',
            'data' => ServiceResource::collection($services),
        ]);
    }

    /**
     * Create a new service.
     */
    public function store(Request $request): JsonResponse
    {
        $this->prepareRequestData($request);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:services,slug'],
            'about_title' => ['required', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
            'features' => ['nullable', 'array'],
            'service_items' => ['nullable', 'array'],
            'process_steps' => ['nullable', 'array'],
            'documents' => ['nullable', 'array'],
            'why_choose_items' => ['nullable', 'array'],
            'cta_title' => ['nullable', 'string', 'max:255'],
            'cta_description' => ['nullable', 'string'],
            'cta_background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
            'stats' => ['nullable', 'array'],
            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('about_image')) {
            $validatedData['about_image'] = $request
                ->file('about_image')
                ->store('services/about', 'public');
        }

        if ($request->hasFile('cta_background_image')) {
            $validatedData['cta_background_image'] = $request
                ->file('cta_background_image')
                ->store('services/cta', 'public');
        }

        $service = Service::create($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Service created successfully.',
            'data' => new ServiceResource($service),
        ], 201);
    }

    /**
     * Display one service by slug or ID.
     */
    #[OA\Get(
        path: '/api/services/{slugOrId}',
        summary: 'Get service details by Slug or ID',
        description: 'Retrieves complete details for a specific travel service using its slug (e.g. visa) or numeric ID.',
        tags: ['Services'],
        parameters: [
            new OA\Parameter(
                name: 'slugOrId',
                in: 'path',
                required: true,
                description: 'Slug (e.g. "visa") or numeric ID of the service',
                schema: new OA\Schema(type: 'string', example: 'visa')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Service details fetched successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Service fetched successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Service'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Service not found'),
        ]
    )]
    public function show(string $slugOrId): JsonResponse
    {
        $service = Service::query()
            ->where('slug', $slugOrId)
            ->orWhere('id', $slugOrId)
            ->first();

        if (! $service) {
            return response()->json([
                'status' => false,
                'message' => 'Service not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Service fetched successfully.',
            'data' => new ServiceResource($service),
        ]);
    }

    /**
     * Update an existing service.
     */
    public function update(Request $request, Service $service): JsonResponse
    {
        $this->prepareRequestData($request);

        $validatedData = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('services', 'slug')->ignore($service->id)],
            'about_title' => ['sometimes', 'required', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
            'features' => ['nullable', 'array'],
            'service_items' => ['nullable', 'array'],
            'process_steps' => ['nullable', 'array'],
            'documents' => ['nullable', 'array'],
            'why_choose_items' => ['nullable', 'array'],
            'cta_title' => ['nullable', 'string', 'max:255'],
            'cta_description' => ['nullable', 'string'],
            'cta_background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
            'stats' => ['nullable', 'array'],
            'status' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('about_image')) {
            if ($service->about_image) {
                Storage::disk('public')->delete($service->about_image);
            }

            $validatedData['about_image'] = $request
                ->file('about_image')
                ->store('services/about', 'public');
        }

        if ($request->hasFile('cta_background_image')) {
            if ($service->cta_background_image) {
                Storage::disk('public')->delete($service->cta_background_image);
            }

            $validatedData['cta_background_image'] = $request
                ->file('cta_background_image')
                ->store('services/cta', 'public');
        }

        $service->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Service updated successfully.',
            'data' => new ServiceResource($service->fresh()),
        ]);
    }

    /**
     * Delete a service.
     */
    public function destroy(Service $service): JsonResponse
    {
        if ($service->about_image) {
            Storage::disk('public')->delete($service->about_image);
        }

        if ($service->cta_background_image) {
            Storage::disk('public')->delete($service->cta_background_image);
        }

        $service->delete();

        return response()->json([
            'status' => true,
            'message' => 'Service deleted successfully.',
        ]);
    }

    /**
     * Parse JSON string body if sent via multipart/form-data
     */
    private function prepareRequestData(Request $request): void
    {
        if ($request->filled('slug')) {
            $request->merge([
                'slug' => Str::slug($request->input('slug')),
            ]);
        }

        $jsonFields = [
            'features',
            'service_items',
            'process_steps',
            'documents',
            'why_choose_items',
            'stats',
        ];

        foreach ($jsonFields as $field) {
            $value = $request->input($field);

            if (is_string($value) && ! empty($value)) {
                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $request->merge([$field => $decoded]);
                }
            }
        }
    }
}
