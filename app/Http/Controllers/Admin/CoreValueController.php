<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoreValueRequest;
use App\Http\Requests\UpdateCoreValueRequest;
use App\Models\CoreValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CoreValueController extends Controller
{
    /**
     * Display all core values.
     */
    public function index(): View
    {
        $coreValues = CoreValue::query()
            ->latest()
            ->paginate(10);

        return view('pages.core-values.index', compact('coreValues'));
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('pages.core-values.create');
    }

    /**
     * Store a new core value.
     */
    public function store(
        StoreCoreValueRequest $request
    ): RedirectResponse {
        CoreValue::create($request->validated());

        return redirect()
            ->route('admin.core-values.index')
            ->with('success', 'Core value created successfully.');
    }

    /**
     * Show the edit form.
     */
    public function edit(CoreValue $coreValue): View
    {
        return view(
            'pages.core-values.edit',
            compact('coreValue')
        );
    }

    /**
     * Update the core value.
     */
    public function update(
        UpdateCoreValueRequest $request,
        CoreValue $coreValue
    ): RedirectResponse {
        $coreValue->update($request->validated());

        return redirect()
            ->route('admin.core-values.index')
            ->with('success', 'Core value updated successfully.');
    }

    /**
     * Delete the core value.
     */
    public function destroy(
        CoreValue $coreValue
    ): RedirectResponse {
        $coreValue->delete();

        return redirect()
            ->route('admin.core-values.index')
            ->with('success', 'Core value deleted successfully.');
    }
}
