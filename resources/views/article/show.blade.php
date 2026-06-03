@extends('layouts.app') @section('content')
<div class="min-h-screen bg-[#060709] text-white font-mono pb-24 relative overflow-hidden">
    
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.005)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.005)_1px,transparent_1px)] bg-[size:50px_50px] pointer-events-none z-0"></div>
    <div class="absolute inset-0 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.4)_50%)] bg-[length:100%_4px] pointer-events-none z-10"></div>

    <div class="relative w-full min-h-[45vh] md:h-[55vh] flex flex-col md:flex-row bg-[#111] overflow-hidden border-b border-white/5 z-20">
        
        <div class="w-full md:w-[45%] bg-[#e3e3e3] text-[#111] p-8 md:p-16 flex flex-col justify-center relative z-20 clip-skew-left">
            <span class="text-[#FF0000] text-xs font-black tracking-[0.3em] uppercase block mb-3">// DATA_LOG_FOUND</span>
            
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-wider uppercase leading-tight text-black">
                {{ $article['title'] }}
            </h1>
            
            <p class="text-neutral-600 mt-4 text-xs tracking-wide leading-relaxed max-w-sm">
                {{ $article['excerpt'] }}
            </p>

            <div class="grid grid-cols-2 gap-4 mt-8">
                <div class="bg-black/[0.04] border border-black/5 p-4 rounded-sm">
                    <span class="block text-2xl md:text-3xl font-black tracking-tight text-black">INDEX_</span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-neutral-500">
                        {{ sprintf('%03d', rand(1, 99)) }} // SYS
                    </span>
                </div>
                <div class="bg-black/[0.04] border border-black/5 p-4 rounded-sm">
                    <span class="block text-2xl md:text-3xl font-black tracking-tight text-black">REL_</span>
                    <span class="text-[10px] uppercase font-bold tracking-widest text-neutral-500">
                        {{ date('M Y', strtotime($article['date'])) }}
                    </span>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('article') }}" class="inline-block bg-[#FF0000] hover:bg-black text-white font-black text-[10px] tracking-[0.25em] uppercase px-6 py-3 transition-colors hero-btn-clip">
                    <- BACK_TO_ARCHIVE
                </a>
            </div>
        </div>

        <div class="w-full md:w-[58%] h-[300px] md:h-full relative z-0 md:-ml-[3%]">
            <img src="{{ asset($article['cover_image']) }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-[#060709] via-blue-950/40 to-cyan-500/10 opacity-80 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#060709] via-transparent to-transparent md:hidden"></div>
            <div class="absolute top-0 bottom-0 left-0 w-[2px] bg-gradient-to-b from-[#FF0000] via-transparent to-transparent hidden md:block"></div>
        </div>
    </div>

    <main class="max-w-4xl mx-auto px-6 mt-16 relative z-20">
        <div class="w-full border border-white/5 bg-[#0b0c10]/60 p-6 md:p-12 article-body-clip relative">
            <div class="absolute top-0 left-0 bg-[#FF0000] text-white text-[8px] font-bold px-2 py-0.5 tracking-widest uppercase">
                DOC_BODY // RAW
            </div>

            <div class="prose prose-invert prose-red max-w-none font-mono text-xs md:text-sm tracking-wide leading-relaxed filter drop-shadow-[0_0_1px_rgba(255,255,255,0.05)]">
                {!! Parsedown::instance()->text($article['content']) !!}
            </div>

            <div class="mt-16 pt-6 border-t border-white/5 flex items-center justify-between text-[9px] text-neutral-600 tracking-[0.2em] uppercase">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-[#FF0000] rounded-full"></span>
                    <span>EOF // END_OF_FILE_RECORD</span>
                </div>
                <div>
                    <span>HASH_MATCH_OK</span>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    @media (min-width: 768px) {
        .clip-skew-left {
            clip-path: polygon(0 0, 100% 0, 93% 100%, 0% 100%);
        }
    }
    .hero-btn-clip {
        clip-path: polygon(0 0, 90% 0, 100% 30%, 100% 100%, 10% 100%, 0 70%);
    }
    .article-body-clip {
        clip-path: polygon(0 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%);
    }
</style>
@endsection