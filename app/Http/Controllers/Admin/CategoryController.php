<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index(): View
    {
        $categories = Category::query()
            ->withCount('blogs')
            ->latest()
            ->paginate(10);

        return view(
            'pages.categories.index',
            compact('categories')
        );
    }

    /**
     * Show category create form.
     */
    public function create(): View
    {
        return view('pages.categories.create');
    }

    /**
     * Store a new category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:categories,slug',
            ],
        ]);

        $slugValue = $request->filled('slug')
            ? $request->input('slug')
            : $request->input('name');

        $validated['slug'] = $this->generateUniqueSlug(
            $slugValue
        );

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category created successfully.'
            );
    }

    /**
     * Show category edit form.
     */
    public function edit(Category $category): View
    {
        return view(
            'pages.categories.edit',
            compact('category')
        );
    }

    /**
     * Update category.
     */
    public function update(
        Request $request,
        Category $category
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',

                Rule::unique('categories', 'slug')
                    ->ignore($category->id),
            ],
        ]);

        $slugValue = $request->filled('slug')
            ? $request->input('slug')
            : $request->input('name');

        $validated['slug'] = $this->generateUniqueSlug(
            $slugValue,
            $category->id
        );

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }

    /**
     * Delete category.
     */
    public function destroy(
        Category $category
    ): RedirectResponse {
        if ($category->blogs()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with(
                    'error',
                    'This category cannot be deleted because blogs are using it.'
                );
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }

    /**
     * Generate unique slug.
     */
    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value);

        if ($baseSlug === '') {
            $baseSlug = 'category';
        }

        $slug = $baseSlug;
        $number = 1;

        while (
            Category::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where(
                        'id',
                        '!=',
                        $ignoreId
                    )
                )
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$number;
            $number++;
        }

        return $slug;
    }
}
