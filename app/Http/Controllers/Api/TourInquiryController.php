<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourInquiryRequest;
use App\Http\Resources\TourInquiryResource;
use App\Models\TourInquiry;
use Illuminate\Http\JsonResponse;
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
