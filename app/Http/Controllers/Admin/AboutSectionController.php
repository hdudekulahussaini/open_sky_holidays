<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutSectionRequest;
use App\Models\AboutCustomerAvatar;
use App\Models\AboutSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class AboutSectionController extends Controller
{
    public function index(): View
    {
        $aboutSections = AboutSection::with(['customerAvatars'])
            ->withCount([
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
                        'mission_icon',
                        'focus_title',
                        'focus_icon',
                        'description',
                        'customer_count',
                        'destinations_subtitle',
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
                    $request->safe()->only([
                        'main_heading',
                        'mission_title',
                        'mission_icon',
                        'focus_title',
                        'focus_icon',
                        'description',
                        'customer_count',
                        'destinations_subtitle',
                        'status',
                    ])
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
                    if ($avatar->image && Storage::disk('public')->exists($avatar->image)) {
                        Storage::disk('public')->delete($avatar->image);
                    }
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

    public function destroyAvatar(
        AboutSection $aboutSection,
        AboutCustomerAvatar $avatar
    ): RedirectResponse|JsonResponse {
        try {
            if ($avatar->about_section_id !== $aboutSection->id) {
                if (request()->expectsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Avatar does not belong to this section.',
                    ], 403);
                }
                abort(404);
            }

            if ($avatar->image && Storage::disk('public')->exists($avatar->image)) {
                Storage::disk('public')->delete($avatar->image);
            }

            $publicFile = public_path('storage/'.$avatar->image);
            if ($avatar->image && file_exists($publicFile)) {
                @unlink($publicFile);
            }

            $avatar->delete();

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer avatar deleted successfully.',
                    'remaining_count' => $aboutSection->customerAvatars()->count(),
                ]);
            }

            return back()->with('success', 'Customer avatar deleted successfully.');
        } catch (Throwable $exception) {
            report($exception);

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to delete the customer avatar.',
                ], 500);
            }

            return back()->with('error', 'Unable to delete the customer avatar.');
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
        mixed $avatarImages = []
    ): void {
        if (! is_array($avatarImages)) {
            return;
        }

        foreach ($avatarImages as $avatarImage) {
            if (! $avatarImage instanceof \Illuminate\Http\UploadedFile || ! $avatarImage->isValid()) {
                continue;
            }

            $path = $avatarImage->store(
                'about/customer-avatars',
                'public'
            );

            $publicDestination = public_path('storage/'.$path);
            $dir = dirname($publicDestination);
            if (! is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            if (file_exists(storage_path('app/public/'.$path))) {
                @copy(storage_path('app/public/'.$path), $publicDestination);
            }

            $aboutSection->customerAvatars()->create([
                'image' => $path,
            ]);
        }
    }

    private function removeSelectedAvatars(
        AboutSection $aboutSection,
        mixed $avatarIds = []
    ): void {
        if (! is_array($avatarIds) || empty($avatarIds)) {
            return;
        }

        $avatars = $aboutSection
            ->customerAvatars()
            ->whereIn('id', $avatarIds)
            ->get();

        foreach ($avatars as $avatar) {
            if ($avatar->image && Storage::disk('public')->exists($avatar->image)) {
                Storage::disk('public')->delete($avatar->image);
            }

            $publicFile = public_path('storage/'.$avatar->image);
            if ($avatar->image && file_exists($publicFile)) {
                @unlink($publicFile);
            }

            $avatar->delete();
        }
    }
}
