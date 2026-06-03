<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(ContentService $content)
    {
        return view('admin.articles.index', [
            'title' => 'Manage Articles',
            'articles' => $content->getAll('articles'),
        ]);
    }

    public function create()
    {
        return view('admin.articles.create', [
            'title' => 'Add Article',
        ]);
    }

    public function store(Request $request, ContentService $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'date' => 'nullable|date',
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

        $content->add('articles', $validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article added successfully!');
    }

    public function show(ContentService $content, int $id)
    {
        $article = $content->find('articles', $id);

        if (!$article) {
            return redirect()->route('admin.articles.index')
                ->with('error', 'Article not found!');
        }

        return view('admin.articles.show', [
            'title' => $article['title'],
            'article' => $article,
        ]);
    }

    public function edit(ContentService $content, int $id)
    {
        $article = $content->find('articles', $id);

        if (!$article) {
            return redirect()->route('admin.articles.index')
                ->with('error', 'Article not found!');
        }

        return view('admin.articles.edit', [
            'title' => 'Edit Article',
            'article' => $article,
        ]);
    }

    public function update(Request $request, ContentService $content, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_url' => 'nullable|string|max:500',
            'category' => 'nullable|string|max:100',
            'date' => 'nullable|date',
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

        $content->update('articles', $id, $validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully!');
    }

    public function destroy(ContentService $content, int $id)
    {
        $content->delete('articles', $id);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}
