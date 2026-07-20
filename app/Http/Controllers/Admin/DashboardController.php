<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalEnquiries = Enquiry::count();

        $newEnquiries = Enquiry::where(
            'status',
            'new'
        )->count();

        $contactedEnquiries = Enquiry::where(
            'status',
            'contacted'
        )->count();

        $closedEnquiries = Enquiry::where(
            'status',
            'closed'
        )->count();

        $recentEnquiries = Enquiry::query()
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEnquiries',
            'newEnquiries',
            'contactedEnquiries',
            'closedEnquiries',
            'recentEnquiries'
        ));
    }
}