<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdventureRequest;
use App\Models\Adventure;
use App\Models\AdventureCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdventureController extends Controller
{
    public function index(): View
    {
        $adventures = Adventure::query()
            ->with('category')
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.adventures.index',
            compact('adventures')
        );
    }

    public function create(): View
    {
        $categories = AdventureCategory::query()
            ->where('status', 'active')
            ->whereDoesntHave('adventure')
            ->orderBy('name')
            ->get();

        return view(
            'pages.adventures.create',
            compact('categories')
        );
    }

    public function store(
        AdventureRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['features'] = $this->cleanFeatures(
            $request->input('features', [])
        );

        if ($request->hasFile('image_one')) {
            $validated['image_one'] = $request
                ->file('image_one')
                ->store('adventures', 'public');
        }

        if ($request->hasFile('image_two')) {
            $validated['image_two'] = $request
                ->file('image_two')
                ->store('adventures', 'public');
        }

        Adventure::create($validated);

        return redirect()
            ->route('admin.adventures.index')
            ->with(
                'success',
                'Adventure created successfully.'
            );
    }

    public function edit(
        Adventure $adventure
    ): View {
        $adventure->load('category');

        $categories = AdventureCategory::query()
            ->where(function ($query) use ($adventure) {
                $query
                    ->where('status', 'active')
                    ->orWhere(
                        'id',
                        $adventure->adventure_category_id
                    );
            })
            ->where(function ($query) use ($adventure) {
                $query
                    ->whereDoesntHave('adventure')
                    ->orWhere(
                        'id',
                        $adventure->adventure_category_id
                    );
            })
            ->orderBy('name')
            ->get();

        return view(
            'pages.adventures.edit',
            compact('adventure', 'categories')
        );
    }

    public function update(
        AdventureRequest $request,
        Adventure $adventure
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['features'] = $this->cleanFeatures(
            $request->input('features', [])
        );

        if ($request->hasFile('image_one')) {
            $this->deleteImage($adventure->image_one);

            $validated['image_one'] = $request
                ->file('image_one')
                ->store('adventures', 'public');
        } else {
            unset($validated['image_one']);
        }

        if ($request->hasFile('image_two')) {
            $this->deleteImage($adventure->image_two);

            $validated['image_two'] = $request
                ->file('image_two')
                ->store('adventures', 'public');
        } else {
            unset($validated['image_two']);
        }

        $adventure->update($validated);

        return redirect()
            ->route('admin.adventures.index')
            ->with(
                'success',
                'Adventure updated successfully.'
            );
    }

    public function destroy(
        Adventure $adventure
    ): RedirectResponse {
        $this->deleteImage($adventure->image_one);
        $this->deleteImage($adventure->image_two);

        $adventure->delete();

        return redirect()
            ->route('admin.adventures.index')
            ->with(
                'success',
                'Adventure deleted successfully.'
            );
    }

    private function cleanFeatures(array $features): array
    {
        return array_values(
            array_filter(
                array_map(
                    fn ($feature) => is_string($feature)
                        ? trim($feature)
                        : '',
                    $features
                ),
                fn ($feature) => $feature !== ''
            )
        );
    }

    private function deleteImage(?string $path): void
    {
        if (
            $path &&
            Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}