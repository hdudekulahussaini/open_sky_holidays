<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AuthorController extends Controller
{
    /**
     * Display all authors.
     */
    public function index(): View
    {
        $authors = Author::query()
            ->withCount('blogs')
            ->latest()
            ->paginate(10);

        return view(
            'pages.authors.index',
            compact('authors')
        );
    }

    /**
     * Show author create form.
     */
    public function create(): View
    {
        return view('pages.authors.create');
    }

    /**
     * Store a new author.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'twitter_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'facebook_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'linkedin_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('authors', 'public');
        }

        Author::create($validated);

        return redirect()
            ->route('admin.authors.index')
            ->with(
                'success',
                'Author created successfully.'
            );
    }

    /**
     * Show author edit form.
     */
    public function edit(Author $author): View
    {
        return view(
            'pages.authors.edit',
            compact('author')
        );
    }

    /**
     * Update author.
     */
    public function update(
        Request $request,
        Author $author
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
            ],

            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'twitter_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'facebook_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'linkedin_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        /*
         * Keep the old image when no new image is selected.
         */
        unset($validated['image']);

        if ($request->hasFile('image')) {
            if ($author->image) {
                Storage::disk('public')->delete(
                    $author->image
                );
            }

            $validated['image'] = $request
                ->file('image')
                ->store('authors', 'public');
        }

        $author->update($validated);

        return redirect()
            ->route('admin.authors.index')
            ->with(
                'success',
                'Author updated successfully.'
            );
    }

    /**
     * Delete author.
     */
    public function destroy(
        Author $author
    ): RedirectResponse {
        if ($author->image) {
            Storage::disk('public')->delete(
                $author->image
            );
        }

        /*
         * Blogs will keep working because author_id
         * is nullable and uses nullOnDelete().
         */
        $author->delete();

        return redirect()
            ->route('admin.authors.index')
            ->with(
                'success',
                'Author deleted successfully.'
            );
    }
}
