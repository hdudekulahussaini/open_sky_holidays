<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTopHeaderRequest;
use App\Http\Requests\UpdateTopHeaderRequest;
use App\Models\TopHeader;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TopHeaderController extends Controller
{
    public function index(): View
    {
        $topHeaders = TopHeader::latest()->paginate(10);

        return view('pages.top-headers.index', compact('topHeaders'));
    }

    public function create(): View
    {
        return view('pages.top-headers.create');
    }

    public function store(StoreTopHeaderRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = $request->boolean('status');

        if (isset($validated['social_links']) && is_array($validated['social_links'])) {
            $validated['social_links'] = array_values(array_filter($validated['social_links'], function ($link) {
                return ! empty($link['url']);
            }));
        }

        TopHeader::create($validated);

        return redirect()
            ->route('admin.top-headers.index')
            ->with('success', 'Top header bar created successfully.');
    }

    public function edit(TopHeader $topHeader): View
    {
        return view('pages.top-headers.edit', compact('topHeader'));
    }

    public function update(UpdateTopHeaderRequest $request, TopHeader $topHeader): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = $request->boolean('status');

        if (isset($validated['social_links']) && is_array($validated['social_links'])) {
            $validated['social_links'] = array_values(array_filter($validated['social_links'], function ($link) {
                return ! empty($link['url']);
            }));
        } else {
            $validated['social_links'] = [];
        }

        $topHeader->update($validated);

        return redirect()
            ->route('admin.top-headers.index')
            ->with('success', 'Top header bar updated successfully.');
    }

    public function destroy(TopHeader $topHeader): RedirectResponse
    {
        $topHeader->delete();

        return redirect()
            ->route('admin.top-headers.index')
            ->with('success', 'Top header bar deleted successfully.');
    }
}
