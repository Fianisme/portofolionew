<x-admin-layout>
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.projects.index') }}" class="text-neutral-400 hover:text-white">← Back</a>
        <h1 class="text-2xl font-bold">Add Project</h1>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
        @csrf

        <div class="space-y-4">
            <div>
                <label class="block text-sm text-neutral-400 mb-1">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full bg-[#111] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]">
            </div>

            <div>
                <label class="block text-sm text-neutral-400 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full bg-[#111] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm text-neutral-400 mb-1">Image</label>
                <div class="space-y-2">
                    <input type="file" name="image" accept="jpg,jpeg,png,webp"
                        class="w-full bg-[#111] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055] file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-white/10 file:text-white">
                    <div class="text-xs text-neutral-500">atau masukkan URL gambar:</div>
                    <input type="text" name="image_url" value="{{ old('image_url') }}"
                        class="w-full bg-[#111] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]"
                        placeholder="https://...">
                </div>
            </div>

            <div>
                <label class="block text-sm text-neutral-400 mb-1">Tech Stack (comma separated)</label>
                <input type="text" name="tech" value="{{ old('tech') }}"
                    class="w-full bg-[#111] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]"
                    placeholder="Laravel, React, MySQL">
            </div>

            <div>
                <label class="block text-sm text-neutral-400 mb-1">Link</label>
                <input type="text" name="link" value="{{ old('link') }}"
                    class="w-full bg-[#111] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]"
                    placeholder="https://...">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="active" id="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                    class="rounded border-white/10 bg-[#111]">
                <label for="active" class="text-sm text-neutral-400">Active (visible on site)</label>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-6 py-2 bg-[#ff0055] hover:bg-[#cc0044] rounded text-sm transition">Save Project</button>
            <a href="{{ route('admin.projects.index') }}" class="px-6 py-2 bg-white/5 hover:bg-white/10 rounded text-sm transition">Cancel</a>
        </div>
    </form>
</x-admin-layout>
