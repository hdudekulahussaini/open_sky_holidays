<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourTypeRequest;
use App\Http\Requests\UpdateTourTypeRequest;
use App\Models\TourType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TourTypeController extends Controller
{
    /**
     * Display all tour types.
     */
    public function index(): View
    {
        $tourTypes = TourType::query()
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.tour-types.index',
            compact('tourTypes')
        );
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('pages.tour-types.create');
    }

    /**
     * Store a new tour type.
     */
    public function store(
        StoreTourTypeRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['slug'] = Str::slug(
            $validated['slug'] ?: $validated['name']
        );

        TourType::create($validated);

        return redirect()
            ->route('admin.tour-types.index')
            ->with(
                'success',
                'Tour type created successfully.'
            );
    }

    /**
     * Show the edit form.
     */
    public function edit(TourType $tourType): View
    {
        return view(
            'pages.tour-types.edit',
            compact('tourType')
        );
    }

    /**
     * Update an existing tour type.
     */
    public function update(
        UpdateTourTypeRequest $request,
        TourType $tourType
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['slug'] = Str::slug(
            $validated['slug'] ?: $validated['name']
        );

        $tourType->update($validated);

        return redirect()
            ->route('admin.tour-types.index')
            ->with(
                'success',
                'Tour type updated successfully.'
            );
    }

    /**
     * Delete a tour type.
     */
    public function destroy(
        TourType $tourType
    ): RedirectResponse {
        $tourType->delete();

        return redirect()
            ->route('admin.tour-types.index')
            ->with(
                'success',
                'Tour type deleted successfully.'
            );
    }
}
