<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOurStoryRequest;
use App\Http\Requests\UpdateOurStoryRequest;
use App\Models\OurStory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class OurStoryController extends Controller
{
    public function index(): View
    {
        $ourStories = OurStory::query()
            ->latest()
            ->paginate(10);

        return view('pages.our-stories.index', compact('ourStories'));
    }

    public function create(): View
    {
        return view('pages.our-stories.create');
    }

    public function store(
        StoreOurStoryRequest $request
    ): RedirectResponse {
        $uploadedImages = [];

        try {
            DB::beginTransaction();

            foreach ($request->file('images', []) as $image) {
                $uploadedImages[] = $image->store(
                    'our-stories',
                    'public'
                );
            }

            OurStory::create([
                'small_heading' => $request->input('small_heading'),
                'heading' => $request->input('heading'),
                'description' => $request->input('description'),
                'images' => $uploadedImages,
                'features' => $request->input('features', []),
                'status' => $request->boolean('status'),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.our-stories.index')
                ->with('success', 'Our Story created successfully.');
        } catch (Throwable $exception) {
            DB::rollBack();

            foreach ($uploadedImages as $image) {
                Storage::disk('public')->delete($image);
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Unable to create Our Story.');
        }
    }
    public function edit(OurStory $ourStory): View
    {
        return view(
            'pages.our-stories.edit',
            compact('ourStory')
        );
    }

    public function update(
        UpdateOurStoryRequest $request,
        OurStory $ourStory
    ): RedirectResponse {
        $newlyUploadedImages = [];
        $deletedImages = [];

        try {
            DB::beginTransaction();

            $currentImages = $ourStory->images ?? [];

            $requestedRemovedImages = array_filter(
                $request->input('removed_images', [])
            );

            /*
             * Only remove images that actually belong to this record.
             * This prevents deleting unrelated storage files.
             */
            $deletedImages = array_values(
                array_intersect(
                    $currentImages,
                    $requestedRemovedImages
                )
            );

            $remainingImages = array_values(
                array_diff($currentImages, $deletedImages)
            );

            foreach ($request->file('images', []) as $image) {
                $path = $image->store('our-stories', 'public');

                $newlyUploadedImages[] = $path;
                $remainingImages[] = $path;
            }

            if (count($remainingImages) > 3) {
                throw new \RuntimeException(
                    'Maximum 3 images are allowed.'
                );
            }

            $ourStory->update([
                'heading' => $request->input('heading'),
                'description' => $request->input('description'),
                'images' => $remainingImages,
                'features' => $request->input('features', []),
                'status' => $request->boolean('status'),
            ]);

            DB::commit();

            foreach ($deletedImages as $deletedImage) {
                Storage::disk('public')->delete($deletedImage);
            }

            return redirect()
                ->route('admin.our-stories.index')
                ->with('success', 'Our Story updated successfully.');
        } catch (Throwable $exception) {
            DB::rollBack();

            foreach ($newlyUploadedImages as $image) {
                Storage::disk('public')->delete($image);
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Unable to update Our Story.');
        }
    }

    public function destroy(
        OurStory $ourStory
    ): RedirectResponse {
        try {
            DB::beginTransaction();

            $images = $ourStory->images ?? [];

            $ourStory->delete();

            DB::commit();

            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }

            return redirect()
                ->route('admin.our-stories.index')
                ->with('success', 'Our Story deleted successfully.');
        } catch (Throwable $exception) {
            DB::rollBack();

            report($exception);

            return back()
                ->with('error', 'Unable to delete Our Story.');
        }
    }
}