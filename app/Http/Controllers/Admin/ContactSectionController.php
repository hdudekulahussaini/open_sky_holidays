<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactSectionRequest;
use App\Http\Requests\UpdateContactSectionRequest;
use App\Models\ContactSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactSectionController extends Controller
{
    public function index(): View
    {
        $contactSections = ContactSection::latest()->paginate(10);

        return view('pages.contact-sections.index', compact('contactSections'));
    }

    public function create(): View
    {
        return view('pages.contact-sections.create');
    }

    public function store(StoreContactSectionRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = $request->boolean('status');

        ContactSection::create($validated);

        return redirect()
            ->route('admin.contact-sections.index')
            ->with('success', 'Contact section created successfully.');
    }

    public function edit(ContactSection $contactSection): View
    {
        return view('pages.contact-sections.edit', compact('contactSection'));
    }

    public function update(UpdateContactSectionRequest $request, ContactSection $contactSection): RedirectResponse
    {
        $validated = $request->validated();
        $validated['status'] = $request->boolean('status');

        $contactSection->update($validated);

        return redirect()
            ->route('admin.contact-sections.index')
            ->with('success', 'Contact section updated successfully.');
    }

    public function destroy(ContactSection $contactSection): RedirectResponse
    {
        $contactSection->delete();

        return redirect()
            ->route('admin.contact-sections.index')
            ->with('success', 'Contact section deleted successfully.');
    }
}
