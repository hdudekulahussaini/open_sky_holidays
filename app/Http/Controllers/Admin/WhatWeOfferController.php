<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhatWeOfferRequest;
use App\Models\WhatWeOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WhatWeOfferController extends Controller
{
    public function index(): View
    {
        $whatWeOffers = WhatWeOffer::query()
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.what-we-offers.index',
            compact('whatWeOffers')
        );
    }

    public function create(): View
    {
        return view(
            'pages.what-we-offers.create'
        );
    }

    public function store(
        WhatWeOfferRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['image'] = $request
            ->file('image')
            ->store('what-we-offers', 'public');

        WhatWeOffer::create($validated);

        return redirect()
            ->route('admin.what-we-offers.index')
            ->with(
                'success',
                'What We Offer item created successfully.'
            );
    }

    public function edit(
        WhatWeOffer $whatWeOffer
    ): View {
        return view(
            'pages.what-we-offers.edit',
            compact('whatWeOffer')
        );
    }

    public function update(
        WhatWeOfferRequest $request,
        WhatWeOffer $whatWeOffer
    ): RedirectResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage(
                $whatWeOffer->image
            );

            $validated['image'] = $request
                ->file('image')
                ->store(
                    'what-we-offers',
                    'public'
                );
        } else {
            unset($validated['image']);
        }

        $whatWeOffer->update($validated);

        return redirect()
            ->route('admin.what-we-offers.index')
            ->with(
                'success',
                'What We Offer item updated successfully.'
            );
    }

    public function destroy(
        WhatWeOffer $whatWeOffer
    ): RedirectResponse {
        $this->deleteImage(
            $whatWeOffer->image
        );

        $whatWeOffer->delete();

        return redirect()
            ->route('admin.what-we-offers.index')
            ->with(
                'success',
                'What We Offer item deleted successfully.'
            );
    }

    private function deleteImage(
        ?string $path
    ): void {
        if (
            filled($path) &&
            Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}