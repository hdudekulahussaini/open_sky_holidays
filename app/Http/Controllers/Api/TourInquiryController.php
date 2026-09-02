<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourInquiryRequest;
use App\Http\Resources\TourInquiryResource;
use App\Mail\TourInquiryConfirmationCustomerMail;
use App\Mail\TourInquiryReceivedAdminMail;
use App\Models\TourInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use OpenApi\Attributes as OA;
use Throwable;

class TourInquiryController extends Controller
{
    #[OA\Post(
        path: '/api/tour-inquiries',
        summary: 'Submit a specific tour booking inquiry',
        description: 'Submits a booking inquiry for a specific tour package and sends confirmation emails.',
        tags: ['Tour Inquiries'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TourInquiryInput')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Booking inquiry submitted successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Tour booking inquiry submitted successfully.'),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TourInquiryInput'),
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
    public function store(StoreTourInquiryRequest $request): JsonResponse
    {
        try {
            $inquiry = TourInquiry::create($request->validated());

            try {
                $adminEmail = config('mail.admin_email') ?: config('mail.from.address');
                Mail::to($adminEmail)->send(new TourInquiryReceivedAdminMail($inquiry));

                if ($inquiry->email) {
                    Mail::to($inquiry->email)->send(new TourInquiryConfirmationCustomerMail($inquiry));
                }
            } catch (Throwable $mailException) {
                Log::error('Failed to send tour inquiry notification emails: '.$mailException->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Tour booking inquiry submitted successfully.',
                'data' => new TourInquiryResource($inquiry),
            ], 201);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'Unable to submit booking inquiry at this time.',
                'data' => null,
            ], 500);
        }
    }
}
