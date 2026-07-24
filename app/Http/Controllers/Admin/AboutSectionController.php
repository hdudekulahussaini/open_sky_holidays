<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutSectionRequest;
use App\Models\AboutSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class AboutSectionController extends Controller
{
    public function index(): View
    {
        $aboutSections = AboutSection::withCount([
            'globeLocations',
            'customerAvatars',
        ])->latest()->paginate(10);

        return view(
            'pages.about-sections.index',
            compact('aboutSections')
        );
    }

    public function create(): View
    {
        return view('pages.about-sections.create');
    }

    public function store(
        AboutSectionRequest $request
    ): RedirectResponse {
        try {
            DB::transaction(function () use ($request) {
                $aboutSection = AboutSection::create(
                    $request->safe()->only([
                        'main_heading',
                        'mission_title',
                        'focus_title',
                        'description',
                        'customer_count',
                        'status',
                    ])
                );

                $this->storeLocations(
                    $aboutSection,
                    $request->input('locations', [])
                );

                $this->storeAvatars(
                    $aboutSection,
                    $request->file('avatar_images', [])
                );
            });

            return redirect()
                ->route('admin.about-sections.index')
                ->with('success', 'About section created successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Unable to create the about section.');
        }
    }

    public function show(AboutSection $aboutSection): View
    {
        $aboutSection->load([
            'globeLocations',
            'customerAvatars',
        ]);

        return view(
            'pages.about-sections.show',
            compact('aboutSection')
        );
    }

    public function edit(AboutSection $aboutSection): View
    {
        $aboutSection->load([
            'globeLocations',
            'customerAvatars',
        ]);

        return view(
            'pages.about-sections.edit',
            compact('aboutSection')
        );
    }

    public function update(
        AboutSectionRequest $request,
        AboutSection $aboutSection
    ): RedirectResponse {
        try {
            DB::transaction(function () use ($request, $aboutSection) {
                $aboutSection->update(
                    $request->safe()->only(['main_heading', 'mission_title', 'focus_title', 'description', 'customer_count', 'status'])
                );

                // Replace old locations with submitted locations.
                $aboutSection->globeLocations()->delete();

                $this->storeLocations(
                    $aboutSection,
                    $request->input('locations', [])
                );

                $this->removeSelectedAvatars(
                    $aboutSection,
                    $request->input('remove_avatar_ids', [])
                );

                $this->storeAvatars(
                    $aboutSection,
                    $request->file('avatar_images', [])
                );
            });

            return redirect()
                ->route('admin.about-sections.index')
                ->with('success', 'About section updated successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Unable to update the about section.');
        }
    }

    public function destroy(
        AboutSection $aboutSection
    ): RedirectResponse {
        try {
            DB::transaction(function () use ($aboutSection) {
                $aboutSection->load('customerAvatars');

                foreach ($aboutSection->customerAvatars as $avatar) {
                    Storage::disk('public')->delete($avatar->image);
                }

                $aboutSection->delete();
            });

            return redirect()
                ->route('admin.about-sections.index')
                ->with('success', 'About section deleted successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()->with(
                'error',
                'Unable to delete the about section.'
            );
        }
    }

    private function storeLocations(
        AboutSection $aboutSection,
        array $locations
    ): void {
        foreach ($locations as $location) {
            $aboutSection->globeLocations()->create([
                'location_name' => $location['location_name'],
            ]);
        }
    }

    private function storeAvatars(
        AboutSection $aboutSection,
        array $avatarImages
    ): void {
        foreach ($avatarImages as $avatarImage) {
            $path = $avatarImage->store(
                'about/customer-avatars',
                'public'
            );

            $aboutSection->customerAvatars()->create([
                'image' => $path,
            ]);
        }
    }

    private function removeSelectedAvatars(
        AboutSection $aboutSection,
        array $avatarIds
    ): void {
        $avatars = $aboutSection
            ->customerAvatars()
            ->whereIn('id', $avatarIds)
            ->get();

        foreach ($avatars as $avatar) {
            Storage::disk('public')->delete($avatar->image);
            $avatar->delete();
        }
    }
}
