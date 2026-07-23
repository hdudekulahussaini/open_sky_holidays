<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Models\Tour;
use App\Models\TourType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class TourController extends Controller
{
    public function index(): View
    {
        $tours = Tour::query()
            ->with('tourType:id,name,slug')
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.tours.index',
            compact('tours')
        );
    }

    public function create(): View
    {
        $tourTypes = TourType::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return view(
            'pages.tours.create',
            compact('tourTypes')
        );
    }

    public function store(
        StoreTourRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title']
        );

        try {
            DB::beginTransaction();

            $validated['thumbnail'] = $request
                ->file('thumbnail')
                ->store('tours', 'public');

            Tour::create($validated);

            DB::commit();

            return redirect()
                ->route('admin.tours.index')
                ->with(
                    'success',
                    'Tour created successfully.'
                );
        } catch (Throwable $exception) {
            DB::rollBack();

            if (! empty($validated['thumbnail'])) {
                Storage::disk('public')
                    ->delete($validated['thumbnail']);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to create the tour. Please try again.'
                );
        }
    }

    public function edit(Tour $tour): View
    {
        $tourTypes = TourType::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return view(
            'pages.tours.edit',
            compact(
                'tour',
                'tourTypes'
            )
        );
    }

    public function update(
        UpdateTourRequest $request,
        Tour $tour
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['slug'] ?? null,
            $validated['title'],
            $tour->id
        );

        $oldThumbnail = $tour->thumbnail;
        $newThumbnail = null;

        try {
            DB::beginTransaction();

            if ($request->hasFile('thumbnail')) {
                $newThumbnail = $request
                    ->file('thumbnail')
                    ->store('tours', 'public');

                $validated['thumbnail'] = $newThumbnail;
            } else {
                unset($validated['thumbnail']);
            }

            $tour->update($validated);

            DB::commit();

            if (
                $newThumbnail &&
                $oldThumbnail &&
                $oldThumbnail !== $newThumbnail
            ) {
                Storage::disk('public')
                    ->delete($oldThumbnail);
            }

            return redirect()
                ->route('admin.tours.index')
                ->with(
                    'success',
                    'Tour updated successfully.'
                );
        } catch (Throwable $exception) {
            DB::rollBack();

            if ($newThumbnail) {
                Storage::disk('public')
                    ->delete($newThumbnail);
            }

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Unable to update the tour. Please try again.'
                );
        }
    }

    public function destroy(
        Tour $tour
    ): RedirectResponse {
        $thumbnail = $tour->thumbnail;

        try {
            DB::beginTransaction();

            $tour->delete();

            DB::commit();

            if ($thumbnail) {
                Storage::disk('public')
                    ->delete($thumbnail);
            }

            return redirect()
                ->route('admin.tours.index')
                ->with(
                    'success',
                    'Tour deleted successfully.'
                );
        } catch (Throwable $exception) {
            DB::rollBack();

            report($exception);

            return back()->with(
                'error',
                'Unable to delete this tour. It may contain related tour details.'
            );
        }
    }

    private function generateUniqueSlug(
        ?string $requestedSlug,
        string $title,
        ?int $ignoreTourId = null
    ): string {
        $baseSlug = Str::slug(
            $requestedSlug ?: $title
        );

        if ($baseSlug === '') {
            $baseSlug = 'tour';
        }

        $slug = $baseSlug;
        $number = 1;

        while (
            Tour::query()
                ->when(
                    $ignoreTourId,
                    fn ($query) => $query->where(
                        'id',
                        '!=',
                        $ignoreTourId
                    )
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$number;
            $number++;
        }

        return $slug;
    }
}