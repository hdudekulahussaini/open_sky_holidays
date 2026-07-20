<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Enquiry::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%")
                    ->orWhere('tour_type', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enquiries = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'pages.Enquiries.index',
            compact('enquiries')
        );
    }

    public function show(Enquiry $enquiry)
    {
        return view(
            'pages.Enquiries.show',
            compact('enquiry')
        );
    }

    public function updateStatus(
        Request $request,
        Enquiry $enquiry
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:new,contacted,closed',
            ],
        ]);

        $enquiry->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Enquiry status updated successfully.'
        );
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()
            ->route('admin.enquiries.index')
            ->with('success', 'Enquiry deleted successfully.');
    }
}