<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactSectionResource;
use App\Models\ContactSection;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ContactSectionController extends Controller
{
    #[OA\Get(
        path: '/api/contact-section/active',
        summary: 'Get active contact section data',
        description: 'Retrieves the active contact information section for the website contact page.',
        tags: ['Contact Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Active contact section retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Active contact section retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/ContactSection'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'No active contact section found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'No active contact section found.'),
                    ]
                )
            ),
        ]
    )]
    public function active(): JsonResponse
    {
        $contactSection = ContactSection::where('status', true)->latest()->first();

        if (! $contactSection) {
            return response()->json([
                'success' => false,
                'message' => 'No active contact section found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Active contact section retrieved successfully.',
            'data' => new ContactSectionResource($contactSection),
        ]);
    }

    #[OA\Get(
        path: '/api/contact-sections',
        summary: 'List all contact sections',
        description: 'Retrieves all contact section records.',
        tags: ['Contact Section'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Contact sections retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Contact sections retrieved successfully.'),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/ContactSection')),
                    ]
                )
            ),
        ]
    )]
    public function index(): JsonResponse
    {
        $contactSections = ContactSection::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Contact sections retrieved successfully.',
            'data' => ContactSectionResource::collection($contactSections),
        ]);
    }

    #[OA\Get(
        path: '/api/contact-sections/{contactSection}',
        summary: 'Get a specific contact section',
        description: 'Retrieves a single contact section by its ID.',
        tags: ['Contact Section'],
        parameters: [
            new OA\Parameter(
                name: 'contactSection',
                in: 'path',
                required: true,
                description: 'ID of the contact section',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Contact section retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Contact section retrieved successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/ContactSection'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Contact section not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Contact section not found.'),
                    ]
                )
            ),
        ]
    )]
    public function show(ContactSection $contactSection): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Contact section retrieved successfully.',
            'data' => new ContactSectionResource($contactSection),
        ]);
    }
}
