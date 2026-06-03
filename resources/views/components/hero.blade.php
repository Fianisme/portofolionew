@props(['profile' => []])

<section id="home" class="relative w-full h-[85vh] md:h-screen bg-[#060709] overflow-hidden flex flex-col items-center justify-center border-b border-white/5">
    
<div class="absolute bottom-0 left-0 w-full h-[35vh] md:h-[45vh] flex items-end justify-between px-0 opacity-25 pointer-events-none z-0 mix-blend-screen overflow-hidden">
    @for ($i = 0; $i < 120; $i++)
        <div class="cava-bar flex-1 min-w-[2px] max-w-[6px] h-full bg-gradient-to-t from-[#FF0000] via-[#FF0000]/60 to-transparent rounded-t-[1px]" 
             style="animation-duration: {{ rand(700, 1500) }}ms; animation-delay: -{{ rand(0, 1000) }}ms;">
        </div>
    @endfor
</div>

    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,transparent_20%,#060709_90%)] pointer-events-none z-10"></div>


    <div class="absolute inset-0 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.4)_50%)] bg-[length:100%_4px] pointer-events-none z-10"></div>
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.01)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.01)_1px,transparent_1px)] bg-[size:50px_50px] pointer-events-none z-0"></div>


    <div class="absolute inset-4 md:inset-8 border border-white/[0.02] pointer-events-none z-20 flex flex-col justify-between p-4">
        <div class="flex justify-between w-full">
            <div class="w-4 h-4 border-t border-l border-[#FF0000]/30"></div>
            <div class="font-mono text-[8px] text-neutral-700 tracking-widest">// CORE_WAVE_SIGNAL_STABLE</div>
            <div class="w-4 h-4 border-t border-r border-white/10"></div>
        </div>
        <div class="flex justify-between w-full items-end">
            <div class="w-4 h-4 border-b border-l border-white/10"></div>
            <div class="w-4 h-4 border-b border-r border-[#FF0000]/20"></div>
        </div>
    </div>


    <div class="relative z-20 text-center px-6 flex flex-col items-center justify-center max-w-2xl">
        
        <div class="mb-5 flex items-center gap-2 px-3 py-1 bg-neutral-900/60 border border-white/5 rounded-sm font-mono text-[9px] tracking-[0.2em] text-[#FF0000] uppercase select-none">
            <span class="w-1.5 h-1.5 rounded-full bg-[#FF0000] animate-ping"></span> {{ $profile['status'] ?? 'LOG_STREAM: CONNECTED' }} //
        </div>

        <div class="relative group cursor-pointer select-none my-3">
            <img src="{{ asset('images/clearimage.png') }}" 
                 alt="Glitch Red" 
                 class="h-20 sm:h-24 md:h-32 w-auto object-contain absolute top-[3px] left-[3px] opacity-60 mix-blend-screen filter drop-shadow-[0_0_15px_#FF0000] animate-pulse" 
                 style="animation-duration: 0.15s">
            
            <img src="{{ asset('images/clearimage.png') }}" 
                 alt="Glitch Cyan" 
                 class="h-20 sm:h-24 md:h-32 w-auto object-contain absolute -top-[3px] -left-[3px] opacity-40 mix-blend-screen filter drop-shadow-[0_0_20px_#00e5ff] animate-ping" 
                 style="animation-duration: 3s">
            
            <img src="{{ asset('images/clearimage.png') }}" 
                 alt="FYANZ XDEV LOGO" 
                 class="h-20 sm:h-24 md:h-32 w-auto object-contain relative z-10 filter drop-shadow-[0_0_25px_rgba(255,255,255,0.1)] group-hover:scale-105 transition-transform duration-300">
        </div>

        <h2 class="text-white font-mono font-black text-xl md:text-2xl tracking-[0.3em] uppercase mt-4">
            {{ $profile['name'] ?? 'FYANZ XDEV' }}_
        </h2>

        <p class="text-neutral-500 font-mono mt-3 text-[10px] md:text-xs tracking-[0.2em] uppercase max-w-md leading-relaxed">
            {{ $profile['tagline'] ?? 'Forging high-performance web architectures & edgy digital solutions.' }}
        </p>

        <div class="mt-10 relative group/btn">
            <div class="absolute inset-0 bg-[#FF0000] opacity-20 blur-sm group-hover/btn:opacity-40 transition-opacity pointer-events-none hero-btn-clip"></div>
            <a href="#explore" class="relative inline-block bg-[#FF0000] hover:bg-[#cc0000] text-white font-mono font-black text-xs tracking-[0.25em] uppercase px-10 py-4 transition-colors hero-btn-clip">
                EXPLORE PROJECTS //
            </a>
        </div>
    </div>


    <div class="absolute bottom-8 left-10 right-10 z-20 flex justify-between items-center font-mono text-[9px] text-neutral-600 tracking-[0.3em] uppercase select-none hidden sm:flex border-t border-white/5 pt-4">
        <div class="flex items-center gap-3">
            <span class="inline-block w-1.5 h-1.5 bg-[#FF0000] animate-pulse"></span>
            <span>SYSTEM_LOG // ACCESS_GRANTED</span>
        </div>
        <div class="flex items-center gap-6">
            <span>NET_STATUS // SECURE</span>
            <span>LOC_IDX // {{ $profile['location'] ?? '2026_MNG' }}</span>
        </div>
    </div>
</section>

<style>
    /* Animasi Naik Turun Acak ala Cava Hyprland */
    @keyframes cavaWave {
        0%, 100% { transform: scaleY(0.03); }
        50%      { transform: scaleY(1); }
    }

    .cava-bar {
        animation-name: cavaWave;
        animation-iteration-count: infinite;
        animation-timing-function: cubic-bezier(0.2, 0.8, 0.2, 1);
        transform-origin: bottom;
    }

    .hero-btn-clip {
        clip-path: polygon(0 0, 85% 0, 100% 35%, 100% 100%, 15% 100%, 0 65%);
    }
</style>