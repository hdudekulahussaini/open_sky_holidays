<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdventureCategoryRequest;
use App\Models\AdventureCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdventureCategoryController extends Controller
{
    public function index(): View
    {
        $categories = AdventureCategory::query()
            ->with('adventure')
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.adventure-categories.index',
            compact('categories')
        );
    }

    public function create(): View
    {
        return view(
            'pages.adventure-categories.create'
        );
    }

    public function store(
        AdventureCategoryRequest $request
    ): RedirectResponse {
        AdventureCategory::create(
            $request->validated()
        );

        return redirect()
            ->route('admin.adventure-categories.index')
            ->with(
                'success',
                'Adventure category created successfully.'
            );
    }

    public function edit(
        AdventureCategory $adventureCategory
    ): View {
        return view(
            'pages.adventure-categories.edit',
            compact('adventureCategory')
        );
    }

    public function update(
        AdventureCategoryRequest $request,
        AdventureCategory $adventureCategory
    ): RedirectResponse {
        $adventureCategory->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.adventure-categories.index')
            ->with(
                'success',
                'Adventure category updated successfully.'
            );
    }

    public function destroy(
        AdventureCategory $adventureCategory
    ): RedirectResponse {
        $adventureCategory->delete();

        return redirect()
            ->route('admin.adventure-categories.index')
            ->with(
                'success',
                'Adventure category deleted successfully.'
            );
    }
}