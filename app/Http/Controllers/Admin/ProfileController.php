<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(ContentService $content)
    {
        return view('admin.profile.edit', [
            'title' => 'Edit Profile',
            'profile' => $content->get('profile'),
        ]);
    }

    public function update(Request $request, ContentService $content)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'required|string|max:500',
            'status' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'photo_url' => 'nullable|string|max:500',
            'cv_file' => 'nullable|file|mimes:pdf|max:5120',
            'cv_url' => 'nullable|string|max:500',
            // Social links
            'social_github' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'social_email' => 'nullable|string|max:255',
            // Skills fields (arrays)
            'skill_name' => 'nullable|array',
            'skill_name.*' => 'nullable|string|max:100',
            'skill_level' => 'nullable|array',
            'skill_level.*' => 'nullable|integer|min:0|max:100',
            'skill_color' => 'nullable|array',
            'skill_color.*' => 'nullable|string|max:20',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('uploads', 'public');
            $validated['photo'] = Storage::url($path);
        } elseif (!empty($validated['photo_url'])) {
            $validated['photo'] = $validated['photo_url'];
        }
        unset($validated['photo_url']);

        // Handle CV upload
        if ($request->hasFile('cv_file')) {
            $path = $request->file('cv_file')->store('uploads', 'public');
            $validated['cv_file'] = Storage::url($path);
        } elseif (!empty($validated['cv_url'])) {
            $validated['cv_file'] = $validated['cv_url'];
        }
        unset($validated['cv_url']);

        // Preserve existing files if not changed
        $existing = $content->get('profile');
        if (empty($validated['photo']) && !empty($existing['photo'])) {
            $validated['photo'] = $existing['photo'];
        }
        if (empty($validated['cv_file']) && !empty($existing['cv_file'])) {
            $validated['cv_file'] = $existing['cv_file'];
        }

        // Process social links
        $validated['social'] = [
            'github' => $validated['social_github'] ?? '',
            'linkedin' => $validated['social_linkedin'] ?? '',
            'instagram' => $validated['social_instagram'] ?? '',
            'twitter' => $validated['social_twitter'] ?? '',
            'email' => $validated['social_email'] ?? '',
        ];
        unset($validated['social_github'], $validated['social_linkedin'], $validated['social_instagram'], $validated['social_twitter'], $validated['social_email']);

        // Process skills
        $skills = [];
        if ($request->has('skill_name')) {
            foreach ($request->skill_name as $index => $name) {
                if (!empty($name)) {
                    $skills[] = [
                        'name' => $name,
                        'level' => (int) ($request->skill_level[$index] ?? 50),
                        'color' => $request->skill_color[$index] ?? '#ff0055',
                    ];
                }
            }
        }
        $validated['skills'] = $skills;

        // Remove raw skill fields from validated data
        unset($validated['skill_name'], $validated['skill_level'], $validated['skill_color']);

        $content->save('profile', $validated);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profile updated successfully!');
    }
}
