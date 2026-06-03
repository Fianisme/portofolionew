@props(['projects' => []])

<section id="apps" class="bg-[#0b0c10] py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-2xl md:text-3xl font-mono font-black text-white tracking-[0.15em] uppercase flex items-center gap-3">
            <span class="w-2 h-6 bg-[#ff0055]"></span> APPS & PROJECTS //
        </h2>

        <div class="embla relative">
            <div class="embla__container flex gap-2 overflow-x-auto pb-12 snap-x snap-mandatory scrollbar-hide select-none">

                @php
                    $colors = ['#00ffcc', '#ff0055', '#00e5ff', '#9d00ff'];
                @endphp

                @forelse($projects as $index => $project)
                    @php
                        $color = $colors[$index % count($colors)];
                    @endphp
                    <div class="embla__slide flex-shrink-0 snap-center w-[220px] md:w-[280px] lg:w-[320px] transition-all duration-500 ease-[cubic-bezier(0.25,1,0.5,1)] hover:w-[350px] md:hover:w-[420px] group">
                        <div class="trapezoid-card relative cursor-pointer h-[450px] md:h-[550px]">
                            <div class="absolute inset-0 trapezoid-clip opacity-40 group-hover:opacity-100 group-hover:blur-[2px] transition-all duration-500" style="background-color: {{ $color }}"></div>
                            <div class="trapezoid-card__inner absolute inset-[2px] bg-[#12141c] trapezoid-clip flex flex-col justify-between p-6 transition-all duration-500 overflow-hidden">
                                <!-- Background Image -->
                                @if(!empty($project['image']))
                                    <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}"
                                        class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-50 group-hover:scale-110 transition-all duration-700">
                                @endif

                                <div class="relative z-10 flex justify-between items-center opacity-40 group-hover:opacity-100 transition-opacity">
                                    <span class="font-mono text-[10px] text-white tracking-widest">SYS_SRC // {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <div class="w-2 h-2 animate-pulse" style="background-color: {{ $color }}"></div>
                                </div>
                                <div class="relative z-10">
                                    <h3 class="text-white font-mono font-black text-xl md:text-2xl tracking-wider mb-4" style="text-shadow: 0 2px 10px rgba(0,0,0,0.8)">
                                        {{ $project['title'] }}
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(($project['tech'] ?? []) as $tech)
                                            <span class="px-2 py-1 bg-black/50 backdrop-blur-sm border border-white/10 rounded-sm text-[10px] font-mono text-white/70 uppercase tracking-wider">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                    @if(!empty($project['description']))
                                        <p class="text-neutral-400 text-xs font-mono mt-3 line-clamp-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            {{ $project['description'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-neutral-500 text-sm py-10">No projects yet. Add some from the admin panel.</div>
                @endforelse

            </div>
        </div>
    </div>
</section>

<style>
    .trapezoid-clip {
        clip-path: polygon(12% 0%, 100% 0%, 88% 100%, 0% 100%);
        transition: clip-path 0.5s cubic-bezier(0.25, 1, 0.5, 1);
    }

    .group:hover .trapezoid-clip {
        clip-path: polygon(4% 0%, 100% 0%, 96% 100%, 0% 100%);
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
