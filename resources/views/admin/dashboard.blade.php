<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="bg-[#111] border border-white/5 rounded-lg p-6">
            <div class="text-3xl font-bold text-[#ff0055]">{{ count($projects) }}</div>
            <div class="text-sm text-neutral-500 mt-1">Projects</div>
            <a href="{{ route('admin.projects.index') }}" class="text-xs text-neutral-400 hover:text-white mt-3 inline-block">Manage →</a>
        </div>

        <div class="bg-[#111] border border-white/5 rounded-lg p-6">
            <div class="text-3xl font-bold text-[#ff0055]">{{ count($articles) }}</div>
            <div class="text-sm text-neutral-500 mt-1">Articles</div>
            <a href="{{ route('admin.articles.index') }}" class="text-xs text-neutral-400 hover:text-white mt-3 inline-block">Manage →</a>
        </div>

        <div class="bg-[#111] border border-white/5 rounded-lg p-6">
            <div class="text-3xl font-bold text-[#ff0055]">{{ count($certificates) }}</div>
            <div class="text-sm text-neutral-500 mt-1">Certificates</div>
            <a href="{{ route('admin.certificates.index') }}" class="text-xs text-neutral-400 hover:text-white mt-3 inline-block">Manage →</a>
        </div>
    </div>

    <!-- Quick Actions -->
    <h2 class="text-lg font-bold mb-4">Quick Actions</h2>
    <div class="flex gap-4">
        <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 bg-[#ff0055] hover:bg-[#cc0044] rounded text-sm transition">
            + Add Project
        </a>
        <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded text-sm transition">
            + Add Article
        </a>
        <a href="{{ route('admin.certificates.create') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded text-sm transition">
            + Add Certificate
        </a>
    </div>

    <!-- Content Storage Info -->
    <div class="mt-8 p-4 bg-[#111] border border-white/5 rounded-lg">
        <h3 class="text-sm font-bold mb-2">📁 Storage Info</h3>
        <p class="text-xs text-neutral-500">Content stored in: <code class="text-[#ff0055]">storage/app/content/</code></p>
        <p class="text-xs text-neutral-500 mt-1">Format: JSON files (no database required)</p>
    </div>
</x-admin-layout>
