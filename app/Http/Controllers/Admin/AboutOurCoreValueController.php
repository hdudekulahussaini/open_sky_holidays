<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutOurCoreValueRequest;
use App\Models\AboutOurCoreValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutOurCoreValueController extends Controller
{
    public function index(): View
    {
        $coreValues = AboutOurCoreValue::query()
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.about_our_core_values.index',
            compact('coreValues')
        );
    }

    public function create(): View
    {
        return view(
            'pages.about_our_core_values.create'
        );
    }

    public function store(
        AboutOurCoreValueRequest $request
    ): RedirectResponse {
        AboutOurCoreValue::create(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.about-our-core-values.index'
            )
            ->with(
                'success',
                'Core value created successfully.'
            );
    }

    public function edit(
        AboutOurCoreValue $aboutOurCoreValue
    ): View {
        return view(
            'pages.about_our_core_values.edit',
            compact('aboutOurCoreValue')
        );
    }

    public function update(
        AboutOurCoreValueRequest $request,
        AboutOurCoreValue $aboutOurCoreValue
    ): RedirectResponse {
        $aboutOurCoreValue->update(
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.about-our-core-values.index'
            )
            ->with(
                'success',
                'Core value updated successfully.'
            );
    }

    public function destroy(
        AboutOurCoreValue $aboutOurCoreValue
    ): RedirectResponse {
        $aboutOurCoreValue->delete();

        return redirect()
            ->route(
                'admin.about-our-core-values.index'
            )
            ->with(
                'success',
                'Core value deleted successfully.'
            );
    }
}