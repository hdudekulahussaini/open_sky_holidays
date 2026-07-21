<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageBannerRequest;
use App\Models\PageBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageBannerController extends Controller
{
    public function index(): View
    {
        $pageBanners = PageBanner::query()
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.page-banners.index',
            compact('pageBanners')
        );
    }

    public function create(): View
    {
        return view('pages.page-banners.create');
    }

    public function store(
        PageBannerRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('page-banners', 'public');
        }

        PageBanner::create($validated);

        return redirect()
            ->route('admin.page-banners.index')
            ->with(
                'success',
                'Page banner created successfully.'
            );
    }

    public function edit(
        PageBanner $pageBanner
    ): View {
        return view(
            'pages.page-banners.edit',
            compact('pageBanner')
        );
    }

    public function update(
        PageBannerRequest $request,
        PageBanner $pageBanner
    ): RedirectResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage($pageBanner->image);

            $validated['image'] = $request
                ->file('image')
                ->store('page-banners', 'public');
        } else {
            unset($validated['image']);
        }

        $pageBanner->update($validated);

        return redirect()
            ->route('admin.page-banners.index')
            ->with(
                'success',
                'Page banner updated successfully.'
            );
    }

    public function destroy(
        PageBanner $pageBanner
    ): RedirectResponse {
        $this->deleteImage($pageBanner->image);

        $pageBanner->delete();

        return redirect()
            ->route('admin.page-banners.index')
            ->with(
                'success',
                'Page banner deleted successfully.'
            );
    }

    private function deleteImage(?string $image): void
    {
        if (
            $image &&
            Storage::disk('public')->exists($image)
        ) {
            Storage::disk('public')->delete($image);
        }
    }
}