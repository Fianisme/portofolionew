<x-admin-layout>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.articles.index') }}" class="text-neutral-400 hover:text-white">← Back</a>
            <h1 class="text-2xl font-bold">Preview Article</h1>
        </div>
        <a href="{{ route('admin.articles.edit', $article['id']) }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 rounded text-sm transition">
            ✏️ Edit
        </a>
    </div>

    <article class="max-w-3xl">
        <!-- Header -->
        <div class="mb-8">
            @if(!empty($article['category']))
                <span class="px-3 py-1 bg-[#ff0055]/10 text-[#ff0055] text-xs font-mono rounded mb-3 inline-block">
                    {{ $article['category'] }}
                </span>
            @endif

            <h1 class="text-3xl md:text-4xl font-mono font-black text-white tracking-wide leading-tight mt-3">
                {{ $article['title'] }}
            </h1>

            @if(!empty($article['excerpt']))
                <p class="text-neutral-400 text-lg mt-4 leading-relaxed">
                    {{ $article['excerpt'] }}
                </p>
            @endif

            <div class="flex items-center gap-4 mt-6 text-sm text-neutral-500 font-mono">
                @if(!empty($article['date']))
                    <span>📅 {{ date('M d, Y', strtotime($article['date'])) }}</span>
                @endif
                <span class="px-2 py-0.5 rounded text-xs {{ ($article['active'] ?? true) ? 'bg-green-500/10 text-green-400' : 'bg-neutral-500/10 text-neutral-400' }}">
                    {{ ($article['active'] ?? true) ? 'Published' : 'Draft' }}
                </span>
            </div>
        </div>

        <!-- Cover Image -->
        @if(!empty($article['image']))
            <div class="mb-8 rounded-lg overflow-hidden border border-white/10">
                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-auto object-cover">
            </div>
        @endif

        <!-- Content -->
        @if(!empty($article['content']))
            <div class="prose prose-invert max-w-none font-mono text-sm leading-relaxed text-neutral-300
                        prose-headings:text-white prose-headings:font-bold
                        prose-a:text-[#ff0055] prose-a:no-underline hover:prose-a:underline
                        prose-code:text-[#00ffcc] prose-code:bg-[#1a1a1a] prose-code:px-1 prose-code:rounded
                        prose-pre:bg-[#1a1a1a] prose-pre:border prose-pre:border-white/10
                        prose-blockquote:border-l-[#ff0055] prose-blockquote:text-neutral-400
                        prose-strong:text-white prose-em:text-neutral-200">
                {!! $article['content'] !!}
            </div>
        @else
            <div class="text-center py-12 text-neutral-500">
                <p class="text-lg">No content yet.</p>
                <a href="{{ route('admin.articles.edit', $article['id']) }}" class="text-[#ff0055] hover:underline mt-2 inline-block">
                    Write content →
                </a>
            </div>
        @endif

        <!-- External Link -->
        @if(!empty($article['link']))
            <div class="mt-8 pt-6 border-t border-white/10">
                <a href="{{ $article['link'] }}" target="_blank"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#ff0055] hover:bg-[#cc0044] rounded text-sm font-mono transition">
                    🔗 Read Full Article
                </a>
            </div>
        @endif
    </article>
</x-admin-layout>
