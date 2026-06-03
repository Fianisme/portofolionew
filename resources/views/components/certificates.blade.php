@props(['certificates' => []])

<section id="certificates" class="bg-[#14151a] py-16 border-t border-white/5 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-end mb-8">
            <h2 class="text-2xl md:text-3xl font-mono font-black text-white tracking-wider uppercase">
                CERTIFICATES
            </h2>
        </div>

        <div class="flex gap-3 overflow-x-auto pb-8 pt-2 snap-x snap-mandatory scrollbar-hide">
            @forelse($certificates as $index => $cert)
                @if(!empty($cert['link']))
                    <a href="{{ $cert['link'] }}" target="_blank" class="flex-shrink-0 snap-start w-64 md:w-72 group cursor-pointer">
                @else
                    <div class="flex-shrink-0 snap-start w-64 md:w-72 group cursor-pointer">
                @endif
                    <div class="relative h-[180px] md:h-[200px] w-full">
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 blur-[2px] skew-clip transition-all duration-300"></div>
                        <div class="absolute inset-[1px] bg-[#1c1e24] group-hover:bg-[#252830] skew-clip flex flex-col justify-between p-6 transition-colors duration-300 overflow-hidden">
                            @if(!empty($cert['image']))
                                <img src="{{ $cert['image'] }}" alt="{{ $cert['title'] }}"
                                    class="absolute inset-0 w-full h-full object-cover opacity-20 group-hover:opacity-30 transition-opacity">
                            @endif

                            <div class="relative z-10 flex justify-between items-start opacity-40 group-hover:opacity-80 transition-opacity">
                                <span class="font-mono text-[9px] text-white tracking-widest">CERT_ID // {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="font-mono text-[9px] text-[#00ffcc]">VERIFIED</span>
                            </div>

                            <div class="relative z-10 unskew-text mt-auto">
                                <h3 class="text-white font-mono font-bold text-base md:text-lg tracking-wide leading-tight uppercase group-hover:text-[#00ffcc] transition-colors">
                                    {{ $cert['title'] }}
                                </h3>
                                <p class="text-neutral-500 font-mono text-[10px] mt-1 tracking-wider uppercase">
                                    {{ $cert['issuer'] ?? 'Unknown' }} • {{ $cert['date'] ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @if(!empty($cert['link']))
                    </a>
                @else
                    </div>
                @endif
            @empty
                <div class="text-neutral-500 text-sm py-10">No certificates yet.</div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .skew-clip {
        clip-path: polygon(8% 0%, 100% 0%, 92% 100%, 0% 100%);
    }
    .unskew-text {
        transform: skewX(-4deg);
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
