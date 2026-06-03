<x-layouts.app>
    <section class="bg-[#0b0c10] py-20 min-h-screen">
        <div class="max-w-4xl mx-auto px-6">

            <!-- Back Link -->
            <a href="/#article" class="inline-flex items-center gap-2 text-neutral-400 hover:text-white font-mono text-xs tracking-wider mb-8 transition-colors">
                ← BACK TO ARTICLES
            </a>

            <!-- Article Header -->
            <div class="mb-10">
                @if(!empty($article['category']))
                    <span class="px-3 py-1 bg-[#ff0055]/10 border border-[#ff0055]/20 text-[#ff0055] text-xs font-mono tracking-wider rounded mb-4 inline-block">
                        {{ $article['category'] }}
                    </span>
                @endif

                <h1 class="text-3xl md:text-5xl font-mono font-black text-white tracking-wide leading-tight mt-4">
                    {{ $article['title'] }}
                </h1>

                @if(!empty($article['excerpt']))
                    <p class="text-neutral-400 text-lg mt-6 leading-relaxed max-w-2xl">
                        {{ $article['excerpt'] }}
                    </p>
                @endif

                <div class="flex items-center gap-6 mt-8 text-sm text-neutral-500 font-mono border-t border-white/10 pt-6">
                    @if(!empty($article['date']))
                        <span class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-[#ff0055]"></span>
                            {{ date('F d, Y', strtotime($article['date'])) }}
                        </span>
                    @endif
                    <span class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-[#00ffcc]"></span>
                        FYANZ XDEV
                    </span>
                </div>
            </div>

            <!-- Cover Image -->
            @if(!empty($article['image']))
                <div class="mb-12 rounded-lg overflow-hidden border border-white/10 relative">
                    <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-[#ff0055] z-10"></div>
                    <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-[#00ffcc] z-10"></div>
                    <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-auto object-cover">
                </div>
            @endif

            <!-- Article Content -->
            @if(!empty($article['content']))
                <div class="prose prose-invert max-w-none font-mono text-base leading-relaxed text-neutral-300
                            prose-headings:text-white prose-headings:font-bold prose-headings:tracking-wider
                            prose-h2:text-2xl prose-h2:mt-12 prose-h2:mb-4 prose-h2:border-b prose-h2:border-white/10 prose-h2:pb-3
                            prose-h3:text-xl prose-h3:mt-8 prose-h3:mb-3
                            prose-p:mb-4 prose-p:leading-relaxed
                            prose-a:text-[#ff0055] prose-a:no-underline hover:prose-a:underline
                            prose-strong:text-white prose-strong:font-bold
                            prose-em:text-neutral-200
                            prose-code:text-[#00ffcc] prose-code:bg-[#1a1a1a] prose-code:px-2 prose-code:py-0.5 prose-code:rounded prose-code:text-sm
                            prose-pre:bg-[#1a1a1a] prose-pre:border prose-pre:border-white/10 prose-pre:rounded-lg prose-pre:p-4
                            prose-blockquote:border-l-[#ff0055] prose-blockquote:bg-[#1a1a1a] prose-blockquote:px-6 prose-blockquote:py-4 prose-blockquote:rounded-r-lg prose-blockquote:my-6
                            prose-ul:list-disc prose-ol:list-decimal
                            prose-li:mb-2
                            prose-img:rounded-lg prose-img:border prose-img:border-white/10">
                    {!! $article['content'] !!}
                </div>
            @else
                <div class="text-center py-16 text-neutral-500">
                    <p class="text-lg font-mono">Article content not available.</p>
                </div>
            @endif

            <!-- External Link -->
            @if(!empty($article['link']))
                <div class="mt-12 pt-8 border-t border-white/10">
                    <a href="{{ $article['link'] }}" target="_blank"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-[#ff0055] hover:bg-[#cc0044] rounded font-mono text-sm tracking-wider transition-colors">
                        🔗 READ FULL ARTICLE
                        <span class="text-xs opacity-60">→</span>
                    </a>
                </div>
            @endif

            <!-- Related Articles -->
            @if(count($articles) > 1)
                <div class="mt-16 pt-8 border-t border-white/10">
                    <h3 class="text-xs font-mono font-bold text-neutral-500 tracking-widest uppercase mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 bg-[#00ffcc]"></span> MORE_ARTICLES //
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach(array_slice(array_filter($articles, fn($a) => ($a['id'] ?? 0) !== ($article['id'] ?? -1)), 0, 3) as $related)
                            <a href="{{ route('article.show', $related['id']) }}" class="group bg-[#12141c] border border-white/5 hover:border-[#ff0055]/30 rounded-lg overflow-hidden transition-colors">
                                @if(!empty($related['image']))
                                    <div class="h-32 overflow-hidden">
                                        <img src="{{ $related['image'] }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h4 class="font-mono font-bold text-sm text-white group-hover:text-[#ff0055] transition-colors line-clamp-2">
                                        {{ $related['title'] }}
                                    </h4>
                                    @if(!empty($related['date']))
                                        <span class="text-[10px] font-mono text-neutral-600 mt-2 block">{{ $related['date'] }}</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
</x-layouts.app>
