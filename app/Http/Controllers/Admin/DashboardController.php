<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Enquiry;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Enquiry Statistics
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Blog Statistics
        |--------------------------------------------------------------------------
        */

        $totalCategories = Category::count();

        $totalAuthors = Author::count();

        $totalBlogs = Blog::count();

        $publishedBlogs = Blog::where(
            'status',
            true
        )->count();

        $draftBlogs = Blog::where(
            'status',
            false
        )->count();

        $recentBlogs = Blog::query()
            ->with([
                'category:id,name',
                'author:id,name',
            ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'totalEnquiries',
                'newEnquiries',
                'contactedEnquiries',
                'closedEnquiries',
                'recentEnquiries',

                'totalCategories',
                'totalAuthors',
                'totalBlogs',
                'publishedBlogs',
                'draftBlogs',
                'recentBlogs'
            )
        );
    }
}
