<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTravelSupportSectionRequest;
use App\Http\Requests\UpdateTravelSupportSectionRequest;
use App\Models\TravelSupportSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TravelSupportSectionController extends Controller
{
    public function index(): View
    {
        $travelSupports = TravelSupportSection::latest()
            ->paginate(10);

        return view(
            'pages.travel-support.index',
            compact('travelSupports')
        );
    }

    public function create(): View
    {
        return view('pages.travel-support.create');
    }

    public function store(
        StoreTravelSupportSectionRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('travel-support', 'public');
        }

        $validated['features'] = array_values(
            array_filter(
                $validated['features'],
                fn ($feature) => trim($feature) !== ''
            )
        );

        $validated['status'] = $request->boolean('status');

        TravelSupportSection::create($validated);

        return redirect()
            ->route('admin.travel-support.index')
            ->with(
                'success',
                'Travel support section created successfully.'
            );
    }

    public function edit(
        TravelSupportSection $travelSupport
    ): View {
        return view(
            'pages.travel-support.edit',
            compact('travelSupport')
        );
    }

    public function update(
        UpdateTravelSupportSectionRequest $request,
        TravelSupportSection $travelSupport
    ): RedirectResponse {
        $validated = $request->validated();

        if ($request->boolean('remove_image')) {
            $this->deleteImage($travelSupport->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($travelSupport->image);

            $validated['image'] = $request->file('image')
                ->store('travel-support', 'public');
        } else {
            unset($validated['image']);
        }

        unset($validated['remove_image']);

        $validated['features'] = array_values(
            array_filter(
                $validated['features'],
                fn ($feature) => trim($feature) !== ''
            )
        );

        $validated['status'] = $request->boolean('status');

        $travelSupport->update($validated);

        return redirect()
            ->route('admin.travel-support.index')
            ->with(
                'success',
                'Travel support section updated successfully.'
            );
    }

    public function destroy(
        TravelSupportSection $travelSupport
    ): RedirectResponse {
        $this->deleteImage($travelSupport->image);

        $travelSupport->delete();

        return redirect()
            ->route('admin.travel-support.index')
            ->with(
                'success',
                'Travel support section deleted successfully.'
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
