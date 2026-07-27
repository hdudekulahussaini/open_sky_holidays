<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageBannerRequest;
use App\Models\PageBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageBannerController extends Controller
{
    public function index(): View
    {
        $pageBanners = PageBanner::query()
            ->latest('id')
            ->paginate(10);

        $usedPages = PageBanner::pluck('page')
            ->map(fn ($page) => Str::slug($page))
            ->toArray();

        $allPages = PageBanner::getPageOptions();

        $availablePages = array_filter(
            $allPages,
            fn ($key) => ! in_array(Str::slug($key), $usedPages),
            ARRAY_FILTER_USE_KEY
        );

        $hasAvailablePages = count($availablePages) > 0;

        return view(
            'pages.page-banners.index',
            compact('pageBanners', 'hasAvailablePages')
        );
    }

    public function create(): View
    {
        $usedPages = PageBanner::pluck('page')
            ->map(fn ($page) => Str::slug($page))
            ->toArray();

        $allPages = PageBanner::getPageOptions();

        $availablePages = array_filter(
            $allPages,
            fn ($key) => ! in_array(Str::slug($key), $usedPages),
            ARRAY_FILTER_USE_KEY
        );

        return view('pages.page-banners.create', compact('availablePages'));
    }

    public function store(PageBannerRequest $request): RedirectResponse
    {
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

    public function edit(PageBanner $pageBanner): View
    {
        $usedPages = PageBanner::where('id', '!=', $pageBanner->id)
            ->pluck('page')
            ->map(fn ($page) => Str::slug($page))
            ->toArray();

        $allPages = PageBanner::getPageOptions();

        $currentSlug = Str::slug($pageBanner->page);
        if (! isset($allPages[$currentSlug]) && ! isset($allPages[$pageBanner->page])) {
            $allPages[$pageBanner->page] = ucfirst($pageBanner->page);
        }

        $availablePages = array_filter(
            $allPages,
            fn ($key) => ! in_array(Str::slug($key), $usedPages),
            ARRAY_FILTER_USE_KEY
        );

        return view(
            'pages.page-banners.edit',
            compact('pageBanner', 'availablePages')
        );
    }

    public function update(PageBannerRequest $request, PageBanner $pageBanner): RedirectResponse
    {
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

    public function destroy(PageBanner $pageBanner): RedirectResponse
    {
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
        if ($image && Storage::disk('public')->exists($image)) {
            Storage::disk('public')->delete($image);
        }
    }
}