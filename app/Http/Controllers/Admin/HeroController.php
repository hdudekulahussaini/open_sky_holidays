<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroRequest;
use App\Models\Hero;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroController extends Controller
{
    public function index(): View
    {
        $heroes = Hero::query()
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(10);

        return view('pages.heroes.index', compact('heroes'));
    }

    public function create(): View
    {
        return view('pages.heroes.create');
    }

    public function store(HeroRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['image'] = $request
            ->file('image')
            ->store('heroes', 'public');

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;

        Hero::create($validated);

        return redirect()
            ->route('admin.heroes.index')
            ->with(
                'success',
                'Hero slide created successfully.'
            );
    }

    public function edit(Hero $hero): View
    {
        return view(
            'pages.heroes.edit',
            compact('hero')
        );
    }

    public function update(
        HeroRequest $request,
        Hero $hero
    ): RedirectResponse {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteImage($hero->image);

            $validated['image'] = $request
                ->file('image')
                ->store('heroes', 'public');
        } else {
            unset($validated['image']);
        }

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;

        $hero->update($validated);

        return redirect()
            ->route('admin.heroes.index')
            ->with(
                'success',
                'Hero slide updated successfully.'
            );
    }

    public function destroy(Hero $hero): RedirectResponse
    {
        $this->deleteImage($hero->image);

        $hero->delete();

        return redirect()
            ->route('admin.heroes.index')
            ->with(
                'success',
                'Hero slide deleted successfully.'
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