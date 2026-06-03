<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(ContentService $content)
    {
        return view('admin.projects.index', [
            'title' => 'Manage Projects',
            'projects' => $content->getAll('projects'),
        ]);
    }

    public function create()
    {
        return view('admin.projects.create', [
            'title' => 'Add Project',
        ]);
    }

    public function store(Request $request, ContentService $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|string|max:500',
            'tech' => 'nullable|string|max:255',
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

        // Convert tech string to array
        $validated['tech'] = array_filter(array_map('trim', explode(',', $validated['tech'] ?? '')));
        $validated['active'] = $request->boolean('active');

        $content->add('projects', $validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project added successfully!');
    }

    public function edit(ContentService $content, int $id)
    {
        $project = $content->find('projects', $id);

        if (!$project) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Project not found!');
        }

        return view('admin.projects.edit', [
            'title' => 'Edit Project',
            'project' => $project,
        ]);
    }

    public function update(Request $request, ContentService $content, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|string|max:500',
            'tech' => 'nullable|string|max:255',
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

        // Convert tech string to array
        $validated['tech'] = array_filter(array_map('trim', explode(',', $validated['tech'] ?? '')));
        $validated['active'] = $request->boolean('active');

        $content->update('projects', $id, $validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(ContentService $content, int $id)
    {
        $content->delete('projects', $id);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully!');
    }
}
