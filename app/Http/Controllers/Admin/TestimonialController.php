<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::latest()
            ->paginate(10);

        return view(
            'pages.testimonials.index',
            compact('testimonials')
        );
    }

    public function create(): View
    {
        return view('pages.testimonials.create');
    }

    public function store(
        StoreTestimonialRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        if ($request->hasFile('customer_image')) {
            $data['customer_image'] = $request
                ->file('customer_image')
                ->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with(
                'success',
                'Testimonial created successfully.'
            );
    }

    public function show(Testimonial $testimonial): View
    {
        return view(
            'pages.testimonials.show',
            compact('testimonial')
        );
    }

    public function edit(Testimonial $testimonial): View
    {
        return view(
            'pages.testimonials.edit',
            compact('testimonial')
        );
    }

    public function update(
        UpdateTestimonialRequest $request,
        Testimonial $testimonial
    ): RedirectResponse {
        $data = $request->validated();

        if ($request->hasFile('customer_image')) {
            if (
                $testimonial->customer_image &&
                Storage::disk('public')->exists(
                    $testimonial->customer_image
                )
            ) {
                Storage::disk('public')->delete(
                    $testimonial->customer_image
                );
            }

            $data['customer_image'] = $request
                ->file('customer_image')
                ->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with(
                'success',
                'Testimonial updated successfully.'
            );
    }

    public function destroy(
        Testimonial $testimonial
    ): RedirectResponse {
        if (
            $testimonial->customer_image &&
            Storage::disk('public')->exists(
                $testimonial->customer_image
            )
        ) {
            Storage::disk('public')->delete(
                $testimonial->customer_image
            );
        }

        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with(
                'success',
                'Testimonial deleted successfully.'
            );
    }
}