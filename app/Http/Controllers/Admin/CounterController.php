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
        $status = $request->boolean('status');
        $counters = $request->input('counters', []);

        foreach ($counters as $counterData) {
            Counter::create([
                'value' => $counterData['value'],
                'name' => $counterData['name'],
                'status' => $status,
            ]);
        }

        return redirect()
            ->route('admin.counters.index')
            ->with('success', 'Counters created successfully.');
    }

    public function edit(Counter $counter): View
    {
        return view('pages.counters.edit', compact('counter'));
    }

    public function update(
        UpdateCounterRequest $request,
        Counter $counter
    ): RedirectResponse {
        $status = $request->boolean('status');
        $countersData = $request->input('counters', []);

        $submittedIds = [];
        $currentCounterUpdated = false;

        foreach ($countersData as $data) {
            if (isset($data['id'])) {
                $existing = Counter::find($data['id']);
                if ($existing) {
                    $existing->update([
                        'value' => $data['value'],
                        'name' => $data['name'],
                        'status' => $status,
                    ]);
                    $submittedIds[] = $existing->id;
                    if ($existing->id === $counter->id) {
                        $currentCounterUpdated = true;
                    }
                }
            } else {
                $newCounter = Counter::create([
                    'value' => $data['value'],
                    'name' => $data['name'],
                    'status' => $status,
                ]);
                $submittedIds[] = $newCounter->id;
            }
        }

        if (! $currentCounterUpdated) {
            $counter->delete();
        }

        return redirect()
            ->route('admin.counters.index')
            ->with('success', 'Counters updated successfully.');
    }

    public function destroy(Counter $counter): RedirectResponse
    {
        $counter->delete();

        return redirect()
            ->route('admin.counters.index')
            ->with('success', 'Counter deleted successfully.');
    }
}
