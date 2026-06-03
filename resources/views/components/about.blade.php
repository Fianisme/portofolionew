@props(['profile' => []])
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<section id="about" class="bg-[#0b0c10] py-20 border-t border-white/5 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-12 border-b border-white/10 pb-4">
            <h2 class="text-2xl md:text-3xl font-mono font-black text-white tracking-[0.15em] uppercase flex items-center gap-3">
                <span class="w-2 h-6 bg-[#ff0055]"></span> ABOUT_ME //
            </h2>
            <div class="font-mono text-[10px] text-neutral-600 tracking-widest">SYS_ID // 001</div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Kiri: Photo + Basic Info -->
            <div class="lg:col-span-4">
                <div class="relative group">
                    <!-- Glow Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-br from-[#ff0055] to-[#00ffcc] opacity-0 group-hover:opacity-20 blur-lg transition-opacity duration-500"></div>

                    <!-- Photo Card -->
                    <div class="relative bg-[#12141c] border border-white/10 p-4 group-hover:border-[#ff0055]/30 transition-colors duration-300">
                        <!-- Corner Decorations -->
                        <div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-[#ff0055]"></div>
                        <div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-[#00ffcc]"></div>

                        <!-- Photo -->
                        <div class="aspect-square bg-neutral-900 mb-4 overflow-hidden">
                            @if(!empty($profile['photo']))
                                <img src="{{ $profile['photo'] }}" alt="{{ $profile['name'] ?? 'Profile' }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-6xl font-mono font-black text-neutral-800">FX</span>
                                </div>
                            @endif
                        </div>

                        <!-- Name & Status -->
                        <div class="space-y-2">
                            <h3 class="text-white font-mono font-black text-lg tracking-wider uppercase">
                                {{ $profile['name'] ?? 'FYANZ XDEV' }}
                            </h3>
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-green-500 animate-pulse rounded-full"></span>
                                <span class="text-xs font-mono text-green-400 tracking-wider">AVAILABLE FOR WORK</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 gap-3 mt-4">
                    <div class="bg-[#12141c] border border-white/5 p-4 text-center">
                        <div class="text-2xl font-mono font-black text-[#ff0055]">3+</div>
                        <div class="text-[10px] font-mono text-neutral-500 tracking-wider uppercase mt-1">Years Exp</div>
                    </div>
                    <div class="bg-[#12141c] border border-white/5 p-4 text-center">
                        <div class="text-2xl font-mono font-black text-[#00ffcc]">10+</div>
                        <div class="text-[10px] font-mono text-neutral-500 tracking-wider uppercase mt-1">Projects</div>
                    </div>
                </div>
            </div>

            <!-- Kanan: Bio & Skills -->
            <div class="lg:col-span-8 space-y-8">

                <!-- Bio -->
                <div class="bg-[#12141c] border border-white/10 p-6 relative">
                    <div class="absolute top-0 right-0 px-3 py-1 bg-[#ff0055]/10 border-l border-b border-[#ff0055]/20">
                        <span class="text-[9px] font-mono text-[#ff0055] tracking-widest">BIO_DATA</span>
                    </div>

                    <div class="font-mono text-sm text-neutral-300 leading-relaxed space-y-4">
                        <p>
                            <span class="text-[#ff0055]">&gt;</span> {{ $profile['bio'] ?? 'Passionate web developer specializing in modern web architectures. Focused on building high-performance, scalable applications with clean code and exceptional user experiences.' }}
                        </p>
                        <p>
                            <span class="text-[#00ffcc]">&gt;</span> Experienced in full-stack development with expertise in Laravel, React, Vue.js, and various modern frameworks. Committed to writing maintainable code and implementing best practices.
                        </p>
                    </div>
                </div>

                <!-- Tech Stack -->
                <div>
                    <h3 class="text-xs font-mono font-bold text-neutral-500 tracking-widest uppercase mb-4 flex items-center gap-2">
                        <span class="w-1 h-4 bg-[#00ffcc]"></span> TECH_STACK //
                    </h3>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @forelse($profile['skills'] ?? [] as $skill)
                            <div class="bg-[#12141c] border border-white/5 p-3 group hover:border-white/10 transition-colors">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-mono text-white tracking-wider">{{ $skill['name'] }}</span>
                                    <span class="text-[10px] font-mono text-neutral-600">{{ $skill['level'] }}%</span>
                                </div>
                                <div class="w-full h-1 bg-neutral-800 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-1000 group-hover:opacity-100 opacity-60"
                                         style="width: {{ $skill['level'] }}%; background-color: {{ $skill['color'] ?? '#ff0055' }};"></div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-4 text-neutral-600 text-xs font-mono">No skills added yet. Edit in admin panel.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Contact Quick Links -->
                <div class="flex flex-wrap gap-3">
                    @php $social = $profile['social'] ?? []; @endphp

                    <!-- Contact Me -->
                    <a href="#contacts" class="px-4 py-2 bg-[#ff0055] hover:bg-[#cc0044] font-mono text-xs tracking-wider uppercase transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-envelope"></i> Contact Me
                    </a>

                    <!-- Download CV -->
                    @if(!empty($profile['cv_file']))
                        <a href="{{ $profile['cv_file'] }}" target="_blank" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 font-mono text-xs tracking-wider uppercase transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-file-pdf"></i> Download CV
                        </a>
                    @endif

                    <!-- GitHub -->
                    @if(!empty($social['github']))
                        <a href="{{ $social['github'] }}" target="_blank" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 font-mono text-xs tracking-wider uppercase transition-colors flex items-center gap-2">
                            <i class="fa-brands fa-github"></i> GitHub
                        </a>
                    @endif

                    <!-- LinkedIn -->
                    @if(!empty($social['linkedin']))
                        <a href="{{ $social['linkedin'] }}" target="_blank" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 font-mono text-xs tracking-wider uppercase transition-colors flex items-center gap-2">
                            <i class="fa-brands fa-linkedin"></i> LinkedIn
                        </a>
                    @endif

                    <!-- Instagram -->
                    @if(!empty($social['instagram']))
                        <a href="{{ $social['instagram'] }}" target="_blank" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 font-mono text-xs tracking-wider uppercase transition-colors flex items-center gap-2">
                            <i class="fa-brands fa-instagram"></i> Instagram
                        </a>
                    @endif

                    <!-- Email -->
                    @if(!empty($social['email']))
                        <a href="mailto:{{ $social['email'] }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 font-mono text-xs tracking-wider uppercase transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-at"></i> Email
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>
