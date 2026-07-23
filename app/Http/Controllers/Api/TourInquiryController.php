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
use Throwable;

class TourInquiryController extends Controller
{
    /**
     * Store a new tour inquiry submission.
     */
    public function store(StoreTourInquiryRequest $request): JsonResponse
    {
        try {
            $inquiry = TourInquiry::create($request->validated());

            try {
                $adminEmail = env('ADMIN_EMAIL', config('mail.from.address')) ?: 'hdudekulahussaini@gmail.com';
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
