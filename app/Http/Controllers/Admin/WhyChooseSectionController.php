<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhyChooseSectionRequest;
use App\Http\Requests\UpdateWhyChooseSectionRequest;
use App\Models\WhyChooseSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WhyChooseSectionController extends Controller
{
    public function index(): View
    {
        $whyChooseSections = WhyChooseSection::query()
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(10);

        return view(
            'pages.why-choose-sections.index',
            compact('whyChooseSections')
        );
    }

    public function create(): View
    {
        return view('pages.why-choose-sections.create');
    }

    public function store(
        StoreWhyChooseSectionRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $data['status'] = $request->boolean('status');

        WhyChooseSection::create($data);

        return redirect()
            ->route('admin.why-choose-sections.index')
            ->with('success', 'Why choose section created successfully.');
    }

   
    public function edit(WhyChooseSection $whyChooseSection): View
    {
        return view(
            'pages.why-choose-sections.edit',
            compact('whyChooseSection')
        );
    }

    public function update(
        UpdateWhyChooseSectionRequest $request,
        WhyChooseSection $whyChooseSection
    ): RedirectResponse {
        $data = $request->validated();

        $data['status'] = $request->boolean('status');

        $whyChooseSection->update($data);

        return redirect()
            ->route('admin.why-choose-sections.index')
            ->with('success', 'Why choose section updated successfully.');
    }

    public function destroy(
        WhyChooseSection $whyChooseSection
    ): RedirectResponse {
        $whyChooseSection->delete();

        return redirect()
            ->route('admin.why-choose-sections.index')
            ->with('success', 'Why choose section deleted successfully.');
    }
}