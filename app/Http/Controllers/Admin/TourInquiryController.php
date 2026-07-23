<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTourInquiryRequest;
use App\Models\TourInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourInquiryController extends Controller
{
    /**
     * Display a listing of the tour inquiries.
     */
    public function index(Request $request): View
    {
        $query = TourInquiry::query()
            ->with('tour')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('tour', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $inquiries = $query
            ->paginate(10)
            ->withQueryString();

        return view('pages.tour-inquiries.index', compact('inquiries'));
    }

    /**
     * Display the specified tour inquiry.
     */
    public function show(TourInquiry $tourInquiry): View
    {
        $tourInquiry->load('tour');

        return view('pages.tour-inquiries.show', compact('tourInquiry'));
    }

    /**
     * Update the specified tour inquiry in storage.
     */
    public function update(UpdateTourInquiryRequest $request, TourInquiry $tourInquiry): RedirectResponse
    {
        $tourInquiry->update($request->validated());

        return back()->with('success', 'Tour inquiry status updated successfully.');
    }

    /**
     * Remove the specified tour inquiry from storage.
     */
    public function destroy(TourInquiry $tourInquiry): RedirectResponse
    {
        $tourInquiry->delete();

        return redirect()
            ->route('admin.tour-inquiries.index')
            ->with('success', 'Tour inquiry deleted successfully.');
    }
}
