<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
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

        return response()->json([
            'status' => true,
            'message' => 'Your enquiry has been submitted successfully.',
            'data' => $enquiry,
        ], 201);
    }
}