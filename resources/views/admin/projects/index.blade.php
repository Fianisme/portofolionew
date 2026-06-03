<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 bg-[#ff0055] hover:bg-[#cc0044] rounded text-sm transition">
            + Add Project
        </a>
    </div>

    @if(count($projects) === 0)
        <div class="text-center py-12 text-neutral-500">
            <p>No projects yet.</p>
            <a href="{{ route('admin.projects.create') }}" class="text-[#ff0055] hover:underline mt-2 inline-block">Add your first project →</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($projects as $project)
                <div class="bg-[#111] border border-white/5 rounded-lg p-4 flex items-center gap-4">
                    <!-- Image Preview -->
                    <div class="w-20 h-14 bg-neutral-800 rounded overflow-hidden flex-shrink-0">
                        @if(!empty($project['image']))
                            <img src="{{ $project['image'] }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs text-neutral-600">No Image</div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-sm truncate">{{ $project['title'] }}</h3>
                        <p class="text-xs text-neutral-500 truncate">{{ $project['description'] ?? '-' }}</p>
                        <div class="flex gap-1 mt-1">
                            @foreach(($project['tech'] ?? []) as $tech)
                                <span class="px-1.5 py-0.5 bg-white/5 rounded text-[10px] text-neutral-400">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="flex-shrink-0">
                        @if($project['active'] ?? true)
                            <span class="px-2 py-1 bg-green-500/10 text-green-400 rounded text-xs">Active</span>
                        @else
                            <span class="px-2 py-1 bg-neutral-500/10 text-neutral-400 rounded text-xs">Inactive</span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 flex-shrink-0">
                        <a href="{{ route('admin.projects.edit', $project['id']) }}" class="px-3 py-1.5 bg-white/5 hover:bg-white/10 rounded text-xs transition">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project['id']) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded text-xs transition">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-admin-layout>
