<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCounterRequest;
use App\Http\Requests\UpdateCounterRequest;
use App\Models\Counter;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CounterController extends Controller
{
    public function index(): View
    {
        $counters = Counter::query()
            ->latest()
            ->paginate(10);

        return view('pages.counters.index', compact('counters'));
    }

    public function create(): View
    {
        return view('pages.counters.create');
    }

    public function store(StoreCounterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['status'] = $request->boolean('status');

        Counter::create($data);

        return redirect()
            ->route('admin.counters.index')
            ->with('success', 'Counter created successfully.');
    }



    public function edit(Counter $counter): View
    {
        return view('pages.counters.edit', compact('counter'));
    }

    public function update(
        UpdateCounterRequest $request,
        Counter $counter
    ): RedirectResponse {
        $data = $request->validated();

        $data['status'] = $request->boolean('status');

        $counter->update($data);

        return redirect()
            ->route('admin.counters.index')
            ->with('success', 'Counter updated successfully.');
    }

    public function destroy(Counter $counter): RedirectResponse
    {
        $counter->delete();

        return redirect()
            ->route('admin.counters.index')
            ->with('success', 'Counter deleted successfully.');
    }
}