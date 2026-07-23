<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutWhyChooseUsRequest;
use App\Models\AboutWhyChooseUs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class AboutWhyChooseUsController extends Controller
{
    public function index(): View
    {
        $sections = AboutWhyChooseUs::query()
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.about_why_choose_us.index',
            compact('sections')
        );
    }

    public function create(): View
    {
        return view(
            'pages.about_why_choose_us.create'
        );
    }

    public function store(
        AboutWhyChooseUsRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $uploadedImage = null;

        try {
            $uploadedImage = $request
                ->file('image')
                ->store(
                    'about_why_choose_us',
                    'public'
                );

            $validated['image'] = $uploadedImage;

            [
                $validated['features_title'],
                $validated['features_description'],
            ] = $this->prepareFeatures(
                $validated['features_title'],
                $validated['features_description'] ?? []
            );

            AboutWhyChooseUs::create($validated);

            return redirect()
                ->route(
                    'admin.about-why-choose-us.index'
                )
                ->with(
                    'success',
                    'About Why Choose Us created successfully.'
                );
        } catch (Throwable $exception) {
            $this->deleteImage($uploadedImage);

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create the section. Please try again.'
                );
        }
    }

    public function edit(
        AboutWhyChooseUs $aboutWhyChooseUs
    ): View {
        return view(
            'pages.about_why_choose_us.edit',
            compact('aboutWhyChooseUs')
        );
    }

    public function update(
        AboutWhyChooseUsRequest $request,
        AboutWhyChooseUs $aboutWhyChooseUs
    ): RedirectResponse {
        $validated = $request->validated();

        $oldImage = $aboutWhyChooseUs->image;
        $newImage = null;

        try {
            if ($request->hasFile('image')) {
                $newImage = $request
                    ->file('image')
                    ->store(
                        'about_why_choose_us',
                        'public'
                    );

                $validated['image'] = $newImage;
            } else {
                unset($validated['image']);
            }

            [
                $validated['features_title'],
                $validated['features_description'],
            ] = $this->prepareFeatures(
                $validated['features_title'],
                $validated['features_description'] ?? []
            );

            $aboutWhyChooseUs->update($validated);

            if ($newImage) {
                $this->deleteImage($oldImage);
            }

            return redirect()
                ->route(
                    'admin.about-why-choose-us.index'
                )
                ->with(
                    'success',
                    'About Why Choose Us updated successfully.'
                );
        } catch (Throwable $exception) {
            $this->deleteImage($newImage);

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to update the section. Please try again.'
                );
        }
    }

    public function destroy(
        AboutWhyChooseUs $aboutWhyChooseUs
    ): RedirectResponse {
        $image = $aboutWhyChooseUs->image;

        $aboutWhyChooseUs->delete();

        $this->deleteImage($image);

        return redirect()
            ->route(
                'admin.about-why-choose-us.index'
            )
            ->with(
                'success',
                'About Why Choose Us deleted successfully.'
            );
    }

    private function prepareFeatures(
        array $titles,
        array $descriptions
    ): array {
        $preparedTitles = [];
        $preparedDescriptions = [];

        foreach ($titles as $index => $title) {
            if (blank($title)) {
                continue;
            }

            $preparedTitles[] = trim($title);

            $description =
                $descriptions[$index] ?? null;

            $preparedDescriptions[] =
                filled($description)
                    ? trim($description)
                    : null;
        }

        return [
            $preparedTitles,
            $preparedDescriptions,
        ];
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