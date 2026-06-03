@props(['articles' => []])

<section id="article" class="bg-[#0b0c10] py-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex items-center justify-between mb-10 border-b border-white/10 pb-4">
            <h2 class="text-2xl md:text-3xl font-mono font-black text-white tracking-[0.15em] uppercase flex items-center gap-3">
                <span class="w-2 h-6 bg-[#ff0055]"></span> WHAT'S HAPPENING //
            </h2>
            <a href="#" class="text-xs font-mono font-bold text-neutral-400 hover:text-[#ff0055] tracking-widest uppercase transition-colors border border-neutral-700 px-4 py-2 bg-neutral-900/50">
                See More_
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @if(count($articles) > 0)
                @php $featured = $articles[0]; @endphp
                <a href="{{ route('article.show', $featured['id']) }}" class="lg:col-span-7 group cursor-pointer relative block">
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#ff0055] to-[#00ffcc] opacity-0 group-hover:opacity-20 blur-md transition-opacity duration-300 pointer-events-none"></div>

                    <div class="relative aspect-[16/10] bg-[#12141c] border border-white/10 tech-clip p-3 transition-colors duration-300 group-hover:border-[#ff0055]/50">
                        <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-[#ff0055] pointer-events-none z-20"></div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-[#00ffcc] pointer-events-none z-20"></div>

                        <div class="w-full h-full bg-gradient-to-br from-[#1c1e29] to-[#12141c] flex flex-col justify-between p-6 relative overflow-hidden tech-clip-inner">
                            @if(!empty($featured['image']))
                                <img src="{{ $featured['image'] }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30">
                            @endif
                            <div class="relative z-10 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-[#ff0055]"></span>
                                <span class="text-[10px] font-mono font-bold tracking-widest text-[#ff0055] uppercase">FEATURED // {{ $featured['category'] ?? 'ARTICLE' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 px-1">
                        <h3 class="text-white text-xl md:text-3xl font-mono font-black tracking-wide leading-tight group-hover:text-[#ff0055] transition-colors duration-300 uppercase">
                            {{ $featured['title'] }}
                        </h3>
                    </div>
                </a>
            @endif

            <div class="lg:col-span-5 flex flex-col gap-4">
                @forelse(array_slice($articles, 1, 3) as $index => $article)
                    <a href="{{ route('article.show', $article['id']) }}" class="group cursor-pointer flex items-center justify-between bg-[#12141c]/60 hover:bg-[#1c1e29] border-b border-white/5 hover:border-[#00ffcc]/30 p-4 h-[120px] transition-all duration-300 relative block">
                        <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-[#00ffcc] scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-center"></div>

                        <div class="flex flex-col justify-between h-full pr-4 flex-1">
                            <div>
                                <span class="text-[9px] font-mono font-bold tracking-widest text-neutral-500 group-hover:text-[#00ffcc] transition-colors uppercase">
                                    // {{ $article['category'] ?? 'NEWS' }}
                                </span>
                                <h4 class="text-white text-sm md:text-base font-mono font-bold tracking-wide line-clamp-2 mt-1 uppercase group-hover:text-neutral-200">
                                    {{ $article['title'] }}
                                </h4>
                            </div>
                            <span class="text-[9px] font-mono text-neutral-600">SYS_LOG // {{ str_pad($index + 2, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div class="w-[120px] md:w-[150px] h-full bg-[#1c1e29] border border-white/10 tech-clip-sm p-1.5 flex-shrink-0 transition-colors group-hover:border-[#00ffcc]/40 overflow-hidden">
                            @if(!empty($article['image']))
                                <img src="{{ $article['image'] }}" alt="" class="w-full h-full object-cover tech-clip-inner-sm">
                            @else
                                <div class="w-full h-full bg-gradient-to-bl from-[#252836] to-[#12141c] flex items-center justify-center tech-clip-inner-sm">
                                    <span class="text-[9px] font-mono font-bold text-neutral-600 uppercase tracking-wider">THUMB_IMG</span>
                                </div>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="text-neutral-500 text-sm py-10">No articles yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<style>
    .tech-clip {
        clip-path: polygon(0 0, 93% 0, 100% 10%, 100% 100%, 7% 100%, 0 90%);
    }
    .tech-clip-inner {
        clip-path: polygon(0 0, 93% 0, 100% 10%, 100% 100%, 7% 100%, 0 90%);
    }
    .tech-clip-sm {
        clip-path: polygon(0 0, 88% 0, 100% 15%, 100% 100%, 12% 100%, 0 85%);
    }
    .tech-clip-inner-sm {
        clip-path: polygon(0 0, 88% 0, 100% 15%, 100% 100%, 12% 100%, 0 85%);
    }
</style>
