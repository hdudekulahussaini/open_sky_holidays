<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::latest()->paginate(10);

        return view('pages.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('pages.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->prepareRequestData($request);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'],
            'about_title' => ['required', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'features' => ['nullable', 'array'],
            'service_items' => ['nullable', 'array'],
            'process_steps' => ['nullable', 'array'],
            'documents' => ['nullable', 'array'],
            'why_choose_items' => ['nullable', 'array'],
            'status' => ['nullable', 'boolean'],
        ]);

        if (empty($validatedData['slug'])) {
            $validatedData['slug'] = Str::slug($validatedData['title']);
        }

        $validatedData['status'] = $request->has('status') ? (bool) $request->input('status') : true;

        if ($request->hasFile('about_image')) {
            $validatedData['about_image'] = $request
                ->file('about_image')
                ->store('services/about', 'public');
        }

        Service::create($validatedData);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service): View
    {
        return view('pages.services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        return view('pages.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $this->prepareRequestData($request);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('services', 'slug')->ignore($service->id)],
            'about_title' => ['required', 'string', 'max:255'],
            'about_description' => ['nullable', 'string'],
            'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'features' => ['nullable', 'array'],
            'service_items' => ['nullable', 'array'],
            'process_steps' => ['nullable', 'array'],
            'documents' => ['nullable', 'array'],
            'why_choose_items' => ['nullable', 'array'],
            'status' => ['nullable', 'boolean'],
        ]);

        $validatedData['status'] = $request->has('status') ? (bool) $request->input('status') : false;

        if ($request->hasFile('about_image')) {
            if ($service->about_image) {
                Storage::disk('public')->delete($service->about_image);
            }

            $validatedData['about_image'] = $request
                ->file('about_image')
                ->store('services/about', 'public');
        }

        $service->update($validatedData);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->about_image) {
            Storage::disk('public')->delete($service->about_image);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    private function prepareRequestData(Request $request): void
    {
        if ($request->filled('slug')) {
            $request->merge([
                'slug' => Str::slug($request->input('slug')),
            ]);
        }

        $jsonFields = [
            'features',
            'service_items',
            'process_steps',
            'documents',
            'why_choose_items',
        ];

        foreach ($jsonFields as $field) {
            $value = $request->input($field);

            if (is_string($value) && ! empty($value)) {
                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $request->merge([$field => $decoded]);
                }
            }
        }
    }
}
