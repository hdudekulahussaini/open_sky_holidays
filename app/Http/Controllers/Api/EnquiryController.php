<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EnquiryConfirmationCustomerMail;
use App\Mail\EnquiryReceivedAdminMail;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use OpenApi\Attributes as OA;
use Throwable;

class EnquiryController extends Controller
{
    #[OA\Post(
        path: '/api/enquiries',
        summary: 'Submit a customer travel enquiry',
        description: 'Submits a new general travel enquiry and sends email notifications to admin and customer.',
        tags: ['Enquiries'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/EnquiryInput')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Enquiry submitted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Your enquiry has been submitted successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Enquiry'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation Error',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse')
            ),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'travel_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'destination' => [
                'required',
                'string',
                'max:150',
            ],

            'travelers' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'tour_type' => [
                'required',
                'string',
                'max:100',
            ],

            'message' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $enquiry = Enquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'travel_date' => $validated['travel_date'],
            'destination' => $validated['destination'],
            'travelers' => $validated['travelers'],
            'tour_type' => $validated['tour_type'],
            'message' => $validated['message'] ?? null,
            'status' => 'new',
        ]);

        try {
            $adminEmail = config('mail.admin_email') ?: config('mail.from.address');
            Mail::to($adminEmail)->send(new EnquiryReceivedAdminMail($enquiry));
            Mail::to($enquiry->email)->send(new EnquiryConfirmationCustomerMail($enquiry));
        } catch (Throwable $e) {
            Log::error('Failed to send enquiry notification emails: '.$e->getMessage());
        }

        return response()->json([
            'status' => true,
            'message' => 'Your enquiry has been submitted successfully.',
            'data' => $enquiry,
        ], 201);
    }
}
