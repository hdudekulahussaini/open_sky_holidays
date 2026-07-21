<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display all blogs.
     */
    public function index(): View
    {
        $blogs = Blog::query()
            ->with([
                'category:id,name',
                'author:id,name',
            ])
            ->latest()
            ->paginate(10);

        return view(
            'pages.blogs.index',
            compact('blogs')
        );
    }

    /**
     * Show the create blog form.
     */
    public function create(): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $authors = Author::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'pages.blogs.create',
            compact('categories', 'authors')
        );
    }

    /**
     * Store a new blog.
     */
    public function store(
        StoreBlogRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Generate unique slug
        |--------------------------------------------------------------------------
        */

        $slugValue = $request->filled('slug')
            ? $request->input('slug')
            : $request->input('title');

        $validated['slug'] = $this->generateUniqueSlug(
            $slugValue
        );

        /*
        |--------------------------------------------------------------------------
        | Clean Table of Contents
        |--------------------------------------------------------------------------
        */

        $validated['table_of_contents'] =
            $this->prepareTableOfContents(
                $validated['table_of_contents'] ?? []
            );

        /*
        |--------------------------------------------------------------------------
        | Upload featured image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store(
                    'blogs/featured-images',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Published status and date
        |--------------------------------------------------------------------------
        */

        if ((bool) $validated['status']) {
            $validated['published_at'] =
                $validated['published_at'] ?? now();
        } else {
            $validated['published_at'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Create blog
        |--------------------------------------------------------------------------
        */

        Blog::create($validated);

        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog created successfully.'
            );
    }

    /**
     * Show the edit blog form.
     */
    public function edit(Blog $blog): View
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        /*
         * Show all active authors.
         * Also show the currently selected author,
         * even when that author is inactive.
         */
        $authors = Author::query()
            ->where(function ($query) use ($blog) {
                $query->where('status', true);

                if ($blog->author_id) {
                    $query->orWhere(
                        'id',
                        $blog->author_id
                    );
                }
            })
            ->orderBy('name')
            ->get();

        return view(
            'pages.blogs.edit',
            compact(
                'blog',
                'categories',
                'authors'
            )
        );
    }

    /**
     * Update an existing blog.
     */
    public function update(
        UpdateBlogRequest $request,
        Blog $blog
    ): RedirectResponse {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Generate unique slug
        |--------------------------------------------------------------------------
        */

        $slugValue = $request->filled('slug')
            ? $request->input('slug')
            : $request->input('title');

        $validated['slug'] = $this->generateUniqueSlug(
            $slugValue,
            $blog->id
        );

        /*
        |--------------------------------------------------------------------------
        | Clean Table of Contents
        |--------------------------------------------------------------------------
        */

        $validated['table_of_contents'] =
            $this->prepareTableOfContents(
                $validated['table_of_contents'] ?? []
            );

        /*
        |--------------------------------------------------------------------------
        | Update featured image
        |--------------------------------------------------------------------------
        |
        | Keep the existing image when no new image is selected.
        |
        */

        unset($validated['featured_image']);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete(
                    $blog->featured_image
                );
            }

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store(
                    'blogs/featured-images',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Published status and date
        |--------------------------------------------------------------------------
        */

        if ((bool) $validated['status']) {
            $validated['published_at'] =
                $validated['published_at']
                ?? $blog->published_at
                ?? now();
        } else {
            $validated['published_at'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Update blog
        |--------------------------------------------------------------------------
        */

        $blog->update($validated);

        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog updated successfully.'
            );
    }

    /**
     * Delete a blog.
     */
    public function destroy(
        Blog $blog
    ): RedirectResponse {
        if ($blog->featured_image) {
            Storage::disk('public')->delete(
                $blog->featured_image
            );
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog deleted successfully.'
            );
    }

    private function prepareTableOfContents(
        array $items
    ): array {
        return collect($items)
            ->map(
                fn ($item) => trim((string) $item)
            )
            ->filter(
                fn ($item) => $item !== ''
            )
            ->values()
            ->all();
    }

    /**
     * Generate a unique blog slug.
     */
    private function generateUniqueSlug(
        string $value,
        ?int $ignoreBlogId = null
    ): string {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'blog';
        }

        $slug = $baseSlug;
        $number = 1;

        while (
            Blog::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreBlogId,
                    fn ($query) => $query->where(
                        'id',
                        '!=',
                        $ignoreBlogId
                    )
                )
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $number;
            $number++;
        }

        return $slug;
    }
}