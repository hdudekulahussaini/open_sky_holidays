<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOurProcessRequest;
use App\Http\Requests\UpdateOurProcessRequest;
use App\Models\OurProcess;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OurProcessController extends Controller
{
    public function index(): View
    {
        $ourProcesses = OurProcess::query()
            ->latest()
            ->paginate(10);

        return view(
            'pages.our-processes.index',
            compact('ourProcesses')
        );
    }

    public function create(): View
    {
        return view('pages.our-processes.create');
    }

    public function store(
        StoreOurProcessRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $data['promises'] = $this->preparePromises(
            $data['promises'] ?? []
        );

        OurProcess::create($data);

        return redirect()
            ->route('admin.our-processes.index')
            ->with(
                'success',
                'Our process created successfully.'
            );
    }



    public function edit(OurProcess $ourProcess): View
    {
        return view(
            'pages.our-processes.edit',
            compact('ourProcess')
        );
    }

    public function update(
        UpdateOurProcessRequest $request,
        OurProcess $ourProcess
    ): RedirectResponse {
        $data = $request->validated();

        $data['promises'] = $this->preparePromises(
            $data['promises'] ?? []
        );

        $ourProcess->update($data);

        return redirect()
            ->route('admin.our-processes.index')
            ->with(
                'success',
                'Our process updated successfully.'
            );
    }

    public function destroy(
        OurProcess $ourProcess
    ): RedirectResponse {
        $ourProcess->delete();

        return redirect()
            ->route('admin.our-processes.index')
            ->with(
                'success',
                'Our process deleted successfully.'
            );
    }

    private function preparePromises(array $promises): array
    {
        return collect($promises)
            ->filter(function (array $promise): bool {
                return filled($promise['text'] ?? null);
            })
            ->map(function (array $promise): array {
                return [
                    'text' => trim($promise['text']),
                ];
            })
            ->values()
            ->all();
    }
}