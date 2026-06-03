<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index(ContentService $content)
    {
        return view('admin.certificates.index', [
            'title' => 'Manage Certificates',
            'certificates' => $content->getAll('certificates'),
        ]);
    }

    public function create()
    {
        return view('admin.certificates.create', [
            'title' => 'Add Certificate',
        ]);
    }

    public function store(Request $request, ContentService $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'nullable|string|max:255',
            'date' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:500',
            'active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $validated['image'] = Storage::url($path);
        } elseif (!empty($validated['image_url'])) {
            $validated['image'] = $validated['image_url'];
        }
        unset($validated['image_url']);

        $validated['active'] = $request->boolean('active');

        $content->add('certificates', $validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate added successfully!');
    }

    public function edit(ContentService $content, int $id)
    {
        $certificate = $content->find('certificates', $id);

        if (!$certificate) {
            return redirect()->route('admin.certificates.index')
                ->with('error', 'Certificate not found!');
        }

        return view('admin.certificates.edit', [
            'title' => 'Edit Certificate',
            'certificate' => $certificate,
        ]);
    }

    public function update(Request $request, ContentService $content, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'nullable|string|max:255',
            'date' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|string|max:500',
            'link' => 'nullable|string|max:500',
            'active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $validated['image'] = Storage::url($path);
        } elseif (!empty($validated['image_url'])) {
            $validated['image'] = $validated['image_url'];
        }
        unset($validated['image_url']);

        $validated['active'] = $request->boolean('active');

        $content->update('certificates', $id, $validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate updated successfully!');
    }

    public function destroy(ContentService $content, int $id)
    {
        $content->delete('certificates', $id);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully!');
    }
}
