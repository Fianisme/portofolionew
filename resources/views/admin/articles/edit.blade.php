<x-admin-layout>
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.articles.index') }}" class="text-neutral-400 hover:text-white">← Back</a>
        <h1 class="text-2xl font-bold">Edit Article</h1>
    </div>

    <form action="{{ route('admin.articles.update', $article['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-4">
                <div>
                    <label class="block text-sm text-neutral-400 mb-1">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $article['title']) }}" required
                        class="w-full bg-[#111] border border-white/10 rounded px-4 py-3 text-lg font-mono focus:outline-none focus:border-[#ff0055]">
                </div>

                <div>
                    <label class="block text-sm text-neutral-400 mb-1">Excerpt</label>
                    <textarea name="excerpt" rows="2"
                        class="w-full bg-[#111] border border-white/10 rounded px-4 py-2 text-sm focus:outline-none focus:border-[#ff0055]">{{ old('excerpt', $article['excerpt'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm text-neutral-400 mb-1">Content</label>
                    <!-- Toolbar -->
                    <div class="bg-[#111] border border-white/10 border-b-0 rounded-t px-3 py-2 flex gap-2 flex-wrap">
                        <button type="button" onclick="formatText('bold')" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs font-bold" title="Bold">B</button>
                        <button type="button" onclick="formatText('italic')" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs italic" title="Italic">I</button>
                        <button type="button" onclick="formatText('underline')" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs underline" title="Underline">U</button>
                        <span class="w-px bg-white/10"></span>
                        <button type="button" onclick="formatText('formatBlock', 'h2')" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs" title="Heading 2">H2</button>
                        <button type="button" onclick="formatText('formatBlock', 'h3')" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs" title="Heading 3">H3</button>
                        <button type="button" onclick="formatText('formatBlock', 'p')" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs" title="Paragraph">P</button>
                        <span class="w-px bg-white/10"></span>
                        <button type="button" onclick="formatText('insertUnorderedList')" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs" title="Bullet List">• List</button>
                        <button type="button" onclick="formatText('insertOrderedList')" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs" title="Numbered List">1. List</button>
                        <span class="w-px bg-white/10"></span>
                        <button type="button" onclick="insertLink()" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs" title="Insert Link">🔗 Link</button>
                        <button type="button" onclick="insertCode()" class="px-2 py-1 bg-white/5 hover:bg-white/10 rounded text-xs" title="Code Block">{ } Code</button>
                    </div>
                    <!-- Editor -->
                    <div id="editor" contenteditable="true"
                        class="w-full bg-[#0a0a0a] border border-white/10 rounded-b px-4 py-4 text-sm text-neutral-300 focus:outline-none min-h-[400px] prose prose-invert max-w-none"
                        style="line-height: 1.8;">
                        {!! old('content', $article['content'] ?? '') !!}
                    </div>
                    <input type="hidden" name="content" id="content-hidden">
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-4">
                <!-- Publish -->
                <div class="bg-[#111] border border-white/5 rounded-lg p-4">
                    <h3 class="text-sm font-mono font-bold text-[#ff0055] mb-3">// PUBLISH</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="active" id="active" value="1" {{ old('active', $article['active'] ?? true) ? 'checked' : '' }}
                                class="rounded border-white/10 bg-[#0a0a0a]">
                            <label for="active" class="text-sm text-neutral-400">Published</label>
                        </div>
                        <div>
                            <label class="block text-xs text-neutral-500 mb-1">Date</label>
                            <input type="date" name="date" value="{{ old('date', $article['date'] ?? '') }}"
                                class="w-full bg-[#0a0a0a] border border-white/10 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#ff0055]">
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div class="bg-[#111] border border-white/5 rounded-lg p-4">
                    <h3 class="text-sm font-mono font-bold text-[#00ffcc] mb-3">// CATEGORY</h3>
                    <input type="text" name="category" value="{{ old('category', $article['category'] ?? '') }}"
                        class="w-full bg-[#0a0a0a] border border-white/10 rounded px-3 py-2 text-sm focus:outline-none focus:border-[#00ffcc]">
                </div>

                <!-- Image -->
                <div class="bg-[#111] border border-white/5 rounded-lg p-4">
                    <h3 class="text-sm font-mono font-bold text-[#00e5ff] mb-3">// COVER_IMAGE</h3>
                    @if(!empty($article['image']))
                        <div class="mb-3">
                            <img src="{{ $article['image'] }}" alt="" class="w-full h-32 object-cover rounded border border-white/10">
                        </div>
                    @endif
                    <div class="space-y-3">
                        <input type="file" name="image" accept="jpg,jpeg,png,webp"
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-3 py-2 text-sm focus:outline-none file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:bg-white/10 file:text-white">
                        <input type="text" name="image_url" value="{{ old('image_url', $article['image'] ?? '') }}"
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-3 py-2 text-sm focus:outline-none"
                            placeholder="or image URL...">
                    </div>
                </div>

                <!-- Link -->
                <div class="bg-[#111] border border-white/5 rounded-lg p-4">
                    <h3 class="text-sm font-mono font-bold text-[#9d00ff] mb-3">// EXTERNAL_LINK</h3>
                    <input type="text" name="link" value="{{ old('link', $article['link'] ?? '') }}"
                        class="w-full bg-[#0a0a0a] border border-white/10 rounded px-3 py-2 text-sm focus:outline-none"
                        placeholder="https://...">
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button type="submit" onclick="document.getElementById('content-hidden').value = document.getElementById('editor').innerHTML;"
                        class="flex-1 px-4 py-3 bg-[#ff0055] hover:bg-[#cc0044] rounded text-sm font-bold transition">
                        Update Article
                    </button>
                    <a href="{{ route('admin.articles.index') }}" class="px-4 py-3 bg-white/5 hover:bg-white/10 rounded text-sm transition">
                        Cancel
                    </a>
                </div>

                <!-- Preview -->
                @if(!empty($article['content']))
                    <a href="{{ route('admin.articles.show', $article['id']) }}" target="_blank"
                        class="block w-full px-4 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded text-sm text-center transition">
                        👁 Preview Article
                    </a>
                @endif
            </div>

        </div>
    </form>

    <script>
        function formatText(command, value = null) {
            document.execCommand(command, false, value);
            document.getElementById('editor').focus();
        }

        function insertLink() {
            const url = prompt('Enter URL:');
            if (url) {
                document.execCommand('createLink', false, url);
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.appendChild(document.createTextNode(text));
            return div.innerHTML;
        }

        function insertCode() {
            const code = prompt('Enter code:');
            if (code) {
                document.execCommand('insertHTML', false, '<pre><code>' + escapeHtml(code) + '</code></pre><p><br></p>');
            }
        }

        function cleanContent(html) {
            // Remove data-path-to-node and data-index-in-node attributes
            html = html.replace(/\s*data-path-to-node="[^"]*"/g, '');
            html = html.replace(/\s*data-index-in-node="[^"]*"/g, '');
            // Remove empty style attributes
            html = html.replace(/\s*style=""/g, '');
            return html;
        }

        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('content-hidden').value = cleanContent(document.getElementById('editor').innerHTML);
        });
    </script>

    <style>
        #editor h2 { font-size: 1.5rem; font-weight: bold; margin: 1rem 0; color: white; }
        #editor h3 { font-size: 1.25rem; font-weight: bold; margin: 0.75rem 0; color: white; }
        #editor p { margin: 0.5rem 0; }
        #editor ul, #editor ol { margin: 0.5rem 0; padding-left: 1.5rem; }
        #editor li { margin: 0.25rem 0; }
        #editor a { color: #ff0055; text-decoration: underline; }
        #editor pre { background: #1a1a1a; padding: 1rem; border-radius: 0.5rem; margin: 1rem 0; overflow-x: auto; }
        #editor code { font-family: monospace; color: #00ffcc; }
        #editor blockquote { border-left: 3px solid #ff0055; padding-left: 1rem; margin: 1rem 0; color: #888; }
    </style>
</x-admin-layout>
