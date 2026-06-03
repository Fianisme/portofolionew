<section id="contacts" class="bg-[#0b0c10] py-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="relative bg-[#12141c] border border-white/10 min-h-[600px] grid grid-cols-1 lg:grid-cols-12 overflow-hidden tech-main-box">
            
            <div class="lg:col-span-5 relative min-h-[300px] lg:min-h-full bg-[#1c1e29] overflow-hidden lg:z-10 z-0 split-clip">
                
                <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:30px_30px]"></div>
                
                <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center select-none">
                    <div class="w-16 h-16 border-2 border-dashed border-neutral-700 flex items-center justify-center text-neutral-600 font-mono text-xl mb-3 animate-pulse">
                        +
                    </div>
                    <span class="font-mono text-xs text-neutral-500 tracking-[0.2em] uppercase">LOCAL_IMAGE_ZONE // CONTACT_VISUAL</span>
                </div>
            </div>

            <div class="lg:col-span-7 bg-[#eceef2] text-neutral-900 p-8 md:p-12 lg:pl-20 flex flex-col justify-center relative z-0">
                
                <div class="flex items-center gap-2 mb-4">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span class="font-mono text-xs font-bold tracking-wider text-emerald-700 uppercase">
                        STATUS: AVAILABLE TO WORK //
                    </span>
                </div>

                <h2 class="text-3xl md:text-4xl font-mono font-black tracking-tight text-neutral-950 uppercase mb-2">
                    LET'S WORK TOGETHER_
                </h2>
                <p class="text-neutral-600 font-mono text-xs md:text-sm mb-8 max-w-xl">
                    Drop a message to forge new digital architectures or just say hi.
                </p>

                <div class="grid grid-cols-2 gap-4 mb-8 max-w-xl">
                    <a href="https://github.com/Fianisme" target="_blank" class="bg-neutral-300/50 hover:bg-neutral-300/80 p-4 flex flex-col justify-between h-[90px] border border-neutral-400/20 transition-all duration-200 group">
                        <span class="text-[10px] font-mono font-bold text-neutral-500 tracking-widest uppercase">// FIND ME ON</span>
                        <span class="text-xl font-mono font-black text-neutral-900 tracking-wide mt-1 group-hover:text-neutral-950">GITHUB &rarr;</span>
                    </a>
                    
                    <a href="https://linkedin.com" target="_blank" class="bg-neutral-300/50 hover:bg-neutral-300/80 p-4 flex flex-col justify-between h-[90px] border border-neutral-400/20 transition-all duration-200 group">
                        <span class="text-[10px] font-mono font-bold text-neutral-500 tracking-widest uppercase">// CONNECT HERE</span>
                        <span class="text-xl font-mono font-black text-neutral-900 tracking-wide mt-1 group-hover:text-neutral-950">LINKEDIN &rarr;</span>
                    </a>
                </div>

                <form action="#" method="POST" class="space-y-4 max-w-xl w-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-mono text-[10px] font-bold text-neutral-500 uppercase mb-1">Your Name_</label>
                            <input type="text" required class="w-full bg-white/80 border border-neutral-300 px-4 py-2.5 font-mono text-sm focus:outline-none focus:border-neutral-800 text-neutral-900 placeholder-neutral-400 transition-colors">
                        </div>
                        <div>
                            <label class="block font-mono text-[10px] font-bold text-neutral-500 uppercase mb-1">Email Address_</label>
                            <input type="email" required class="w-full bg-white/80 border border-neutral-300 px-4 py-2.5 font-mono text-sm focus:outline-none focus:border-neutral-800 text-neutral-900 placeholder-neutral-400 transition-colors">
                        </div>
                    </div>
                    <div>
                        <label class="block font-mono text-[10px] font-bold text-neutral-500 uppercase mb-1">Message Body_</label>
                        <textarea rows="4" required class="w-full bg-white/80 border border-neutral-300 px-4 py-2.5 font-mono text-sm focus:outline-none focus:border-neutral-800 text-neutral-900 placeholder-neutral-400 transition-colors resize-none"></textarea>
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="w-full md:w-auto bg-[#d23232] hover:bg-[#b82626] text-white font-mono font-bold px-8 py-3 text-sm uppercase tracking-widest transition-colors duration-200 shadow-md flex items-center justify-center gap-2 tech-btn-clip">
                            Transmit Message //
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>

<style>
    /* Induk kontainer utama dengan sedikit potongan mekanikal di sudut luar */
    .tech-main-box {
        clip-path: polygon(0 0, 98% 0, 100% 3%, 100% 100%, 2% 100%, 0 97%);
    }

    /* Efek Potongan Pembagi Layar Miring Vertikal (Riot Style)
       Hanya aktif pada tampilan desktop (layar besar)
    */
    @media (min-width: 1024px) {
        .split-clip {
            /* Memotong sisi kanan agar condong masuk ke area putih form */
            clip-path: polygon(0 0, 100% 0, 88% 100%, 0 100%);
        }
    }

    /* Potongan sudut dekoratif ujung tombol kirim pesan */
    .tech-btn-clip {
        clip-path: polygon(0 0, 94% 0, 100% 25%, 100% 100%, 6% 100%, 0 75%);
    }
</style>