<x-admin-layout>
    <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <!-- Basic Info -->
            <div class="bg-[#111] border border-white/5 rounded-lg p-6">
                <h2 class="text-sm font-mono font-bold text-[#ff0055] mb-4 tracking-wider">// BASIC_INFO</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-neutral-400 mb-1">Name *</label>
                        <input type="text" name="name" value="{{ old('name', $profile['name'] ?? '') }}" required
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]">
                    </div>

                    <div>
                        <label class="block text-sm text-neutral-400 mb-1">Tagline *</label>
                        <textarea name="tagline" rows="2" required
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]">{{ old('tagline', $profile['tagline'] ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm text-neutral-400 mb-1">Bio</label>
                        <textarea name="bio" rows="4"
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]">{{ old('bio', $profile['bio'] ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-neutral-400 mb-1">Status</label>
                            <input type="text" name="status" value="{{ old('status', $profile['status'] ?? '') }}"
                                class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]">
                        </div>
                        <div>
                            <label class="block text-sm text-neutral-400 mb-1">Location</label>
                            <input type="text" name="location" value="{{ old('location', $profile['location'] ?? '') }}"
                                class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo -->
            <div class="bg-[#111] border border-white/5 rounded-lg p-6">
                <h2 class="text-sm font-mono font-bold text-[#ff0055] mb-4 tracking-wider">// PHOTO</h2>

                @if(!empty($profile['photo']))
                    <div class="mb-4">
                        <img src="{{ $profile['photo'] }}" alt="Current photo" class="w-24 h-24 object-cover rounded border border-white/10">
                        <p class="text-xs text-neutral-500 mt-1">Current photo</p>
                    </div>
                @endif

                <div class="space-y-3">
                    <input type="file" name="photo" accept="jpg,jpeg,png,webp"
                        class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055] file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-white/10 file:text-white">
                    <div class="text-xs text-neutral-500">atau masukkan URL foto:</div>
                    <input type="text" name="photo_url" value="{{ old('photo_url', $profile['photo'] ?? '') }}"
                        class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]"
                        placeholder="https://...">
                </div>
            </div>

            <!-- CV / Resume -->
            <div class="bg-[#111] border border-white/5 rounded-lg p-6">
                <h2 class="text-sm font-mono font-bold text-[#9d00ff] mb-4 tracking-wider">// CV_RESUME</h2>

                @if(!empty($profile['cv_file']))
                    <div class="mb-4 flex items-center gap-3">
                        <span class="text-2xl">📄</span>
                        <div>
                            <p class="text-sm text-neutral-300">CV uploaded</p>
                            <a href="{{ $profile['cv_file'] }}" target="_blank" class="text-xs text-[#ff0055] hover:underline">View current CV →</a>
                        </div>
                    </div>
                @endif

                <div class="space-y-3">
                    <input type="file" name="cv_file" accept="pdf"
                        class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#9d00ff] file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-white/10 file:text-white">
                    <div class="text-xs text-neutral-500">PDF, max 5MB. Atau masukkan URL:</div>
                    <input type="text" name="cv_url" value="{{ old('cv_url', $profile['cv_file'] ?? '') }}"
                        class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#9d00ff]"
                        placeholder="https://...">
                </div>
            </div>

            <!-- Social Links -->
            <div class="bg-[#111] border border-white/5 rounded-lg p-6">
                <h2 class="text-sm font-mono font-bold text-[#00ffcc] mb-4 tracking-wider">// SOCIAL_LINKS</h2>

                @php $social = $profile['social'] ?? []; @endphp

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-neutral-400 mb-1">
                            <span class="text-neutral-500">🔗</span> GitHub
                        </label>
                        <input type="text" name="social_github" value="{{ old('social_github', $social['github'] ?? '') }}"
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#00ffcc]"
                            placeholder="https://github.com/username">
                    </div>

                    <div>
                        <label class="block text-sm text-neutral-400 mb-1">
                            <span class="text-neutral-500">💼</span> LinkedIn
                        </label>
                        <input type="text" name="social_linkedin" value="{{ old('social_linkedin', $social['linkedin'] ?? '') }}"
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#00ffcc]"
                            placeholder="https://linkedin.com/in/username">
                    </div>

                    <div>
                        <label class="block text-sm text-neutral-400 mb-1">
                            <span class="text-neutral-500">📸</span> Instagram
                        </label>
                        <input type="text" name="social_instagram" value="{{ old('social_instagram', $social['instagram'] ?? '') }}"
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#00ffcc]"
                            placeholder="https://instagram.com/username">
                    </div>

                    <div>
                        <label class="block text-sm text-neutral-400 mb-1">
                            <span class="text-neutral-500">🐦</span> Twitter / X
                        </label>
                        <input type="text" name="social_twitter" value="{{ old('social_twitter', $social['twitter'] ?? '') }}"
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#00ffcc]"
                            placeholder="https://twitter.com/username">
                    </div>

                    <div>
                        <label class="block text-sm text-neutral-400 mb-1">
                            <span class="text-neutral-500">📧</span> Email
                        </label>
                        <input type="email" name="social_email" value="{{ old('social_email', $social['email'] ?? '') }}"
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#00ffcc]"
                            placeholder="hello@example.com">
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="bg-[#111] border border-white/5 rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-sm font-mono font-bold text-[#00e5ff] tracking-wider">// TECH_STACK</h2>
                    <button type="button" onclick="addSkill()" class="px-3 py-1 bg-[#00e5ff]/10 hover:bg-[#00e5ff]/20 text-[#00e5ff] text-xs rounded transition">
                        + Add Skill
                    </button>
                </div>

                <div id="skills-container" class="space-y-3">
                    @php $skills = $profile['skills'] ?? []; @endphp
                    @forelse($skills as $index => $skill)
                        <div class="skill-row flex gap-3 items-center bg-[#0a0a0a] border border-white/5 rounded p-3">
                            <input type="text" name="skill_name[]" value="{{ $skill['name'] }}" placeholder="Skill name"
                                class="flex-1 bg-transparent border border-white/10 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-[#00e5ff]">
                            <input type="number" name="skill_level[]" value="{{ $skill['level'] }}" min="0" max="100" placeholder="Level"
                                class="w-20 bg-transparent border border-white/10 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-[#00e5ff]">
                            <input type="color" name="skill_color[]" value="{{ $skill['color'] ?? '#ff0055' }}"
                                class="w-10 h-8 bg-transparent border border-white/10 rounded cursor-pointer">
                            <button type="button" onclick="this.closest('.skill-row').remove()" class="text-red-400 hover:text-red-300 text-sm px-2">✕</button>
                        </div>
                    @empty
                        <div class="skill-row flex gap-3 items-center bg-[#0a0a0a] border border-white/5 rounded p-3">
                            <input type="text" name="skill_name[]" placeholder="Skill name"
                                class="flex-1 bg-transparent border border-white/10 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-[#00e5ff]">
                            <input type="number" name="skill_level[]" value="50" min="0" max="100" placeholder="Level"
                                class="w-20 bg-transparent border border-white/10 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-[#00e5ff]">
                            <input type="color" name="skill_color[]" value="#ff0055"
                                class="w-10 h-8 bg-transparent border border-white/10 rounded cursor-pointer">
                            <button type="button" onclick="this.closest('.skill-row').remove()" class="text-red-400 hover:text-red-300 text-sm px-2">✕</button>
                        </div>
                    @endforelse
                </div>

                <p class="text-xs text-neutral-600 mt-3">Level: 0-100%. Color: warna bar skill.</p>
            </div>

        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-6 py-2 bg-[#ff0055] hover:bg-[#cc0044] rounded text-sm transition">
                Save Profile
            </button>
        </div>
    </form>

    <script>
        function addSkill() {
            const container = document.getElementById('skills-container');
            const row = document.createElement('div');
            row.className = 'skill-row flex gap-3 items-center bg-[#0a0a0a] border border-white/5 rounded p-3';
            row.innerHTML = `
                <input type="text" name="skill_name[]" placeholder="Skill name"
                    class="flex-1 bg-transparent border border-white/10 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-[#00e5ff]">
                <input type="number" name="skill_level[]" value="50" min="0" max="100" placeholder="Level"
                    class="w-20 bg-transparent border border-white/10 rounded px-3 py-1.5 text-sm focus:outline-none focus:border-[#00e5ff]">
                <input type="color" name="skill_color[]" value="#ff0055"
                    class="w-10 h-8 bg-transparent border border-white/10 rounded cursor-pointer">
                <button type="button" onclick="this.closest('.skill-row').remove()" class="text-red-400 hover:text-red-300 text-sm px-2">✕</button>
            `;
            container.appendChild(row);
        }
    </script>
</x-admin-layout>
