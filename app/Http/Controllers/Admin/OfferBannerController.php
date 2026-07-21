<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferBannerRequest;
use App\Models\OfferBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class OfferBannerController extends Controller
{
    public function index(): View
    {
        $offerBanners = OfferBanner::query()
            ->latest()
            ->paginate(10);

        return view(
            'pages.offer-banners.index',
            compact('offerBanners')
        );
    }

    public function create(): View
    {
        return view('pages.offer-banners.create');
    }

    public function store(
        OfferBannerRequest $request
    ): RedirectResponse {
        $data = $request->validated();
        $uploadedImage = null;

        try {
            $uploadedImage = $request
                ->file('image')
                ->store('offer-banners', 'public');

            $data['image'] = $uploadedImage;

            OfferBanner::create($data);

            return redirect()
                ->route('admin.offer-banners.index')
                ->with(
                    'success',
                    'Offer banner created successfully.'
                );
        } catch (Throwable $exception) {
            if ($uploadedImage) {
                Storage::disk('public')->delete($uploadedImage);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create the offer banner. Please try again.'
                );
        }
    }

    public function edit(
        OfferBanner $offerBanner
    ): View {
        return view(
            'pages.offer-banners.edit',
            compact('offerBanner')
        );
    }

    public function update(
        OfferBannerRequest $request,
        OfferBanner $offerBanner
    ): RedirectResponse {
        $data = $request->validated();

        $oldImage = $offerBanner->image;
        $newImage = null;

        try {
            if ($request->hasFile('image')) {
                $newImage = $request
                    ->file('image')
                    ->store('offer-banners', 'public');

                $data['image'] = $newImage;
            } else {
                unset($data['image']);
            }

            $offerBanner->update($data);

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            return redirect()
                ->route('admin.offer-banners.index')
                ->with(
                    'success',
                    'Offer banner updated successfully.'
                );
        } catch (Throwable $exception) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to update the offer banner. Please try again.'
                );
        }
    }

    public function destroy(
        OfferBanner $offerBanner
    ): RedirectResponse {
        try {
            $image = $offerBanner->image;

            $offerBanner->delete();

            if ($image) {
                Storage::disk('public')->delete($image);
            }

            return redirect()
                ->route('admin.offer-banners.index')
                ->with(
                    'success',
                    'Offer banner deleted successfully.'
                );
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'Unable to delete the offer banner.'
            );
        }
    }
}