<header id="navbar-header" class="relative w-full bg-black border-b border-neutral-900 sticky top-0 z-50 px-6 py-4 transition-all duration-300 ease-in-out text-white">
    <div class="w-full px-6 md:px-10 flex items-center justify-between">

        <div class="flex items-center gap-8">
            <button id="logo-trigger" class="flex items-center gap-3 cursor-pointer select-none group focus:outline-none">
                <img src="{{ asset('images/Logo.png') }}" id="logo-default" alt="FYANZ XDEV" class="h-8 w-auto object-contain block group-hover:hidden">
                <img src="{{ asset('images/logoextended.png') }}" id="logo-extended" alt="FYANZ XDEV" class="h-8 w-auto object-contain hidden group-hover:block">
            </button>

            <nav id="nav-links" class="hidden md:flex items-center gap-2 font-mono text-xs tracking-widest">
                <a href="#home" data-nav="home" class="nav-link px-4 py-2 text-neutral-400 hover:text-white transition-colors duration-200">HOME</a>
                <a href="#about" data-nav="about" class="nav-link px-4 py-2 text-neutral-400 hover:text-white transition-colors duration-200">ABOUT</a>
                <a href="#article" data-nav="article" class="nav-link px-4 py-2 text-neutral-400 hover:text-white transition-colors duration-200">ARTICLE</a>
                <a href="#apps" data-nav="apps" class="nav-link px-4 py-2 text-neutral-400 hover:text-white transition-colors duration-200">APPS</a>
                <a href="#contacts" data-nav="contacts" class="nav-link px-4 py-2 text-neutral-400 hover:text-white transition-colors duration-200">CONTACTS</a>
            </nav>
        </div>

        <div class="flex items-center gap-4">
            <button id="globe-btn" class="text-neutral-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                </svg>
            </button>

            <div id="search-box" class="relative hidden sm:block">
                <input type="text" placeholder="SEARCH .." class="bg-neutral-900 text-xs border border-neutral-800 rounded-sm py-1.5 pl-4 pr-10 focus:outline-none focus:border-neutral-700 text-white font-mono w-40 transition-colors">
                <span class="absolute right-3 top-2 text-neutral-500 text-xs">🔍</span>
            </div>

            <button id="hover-search-btn" class="hidden text-neutral-500 hover:text-[#ff0055] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>

        <!-- ================= MEGA MENU ================= -->
        <div id="dropdown-menu" class="absolute left-0 top-full w-full bg-[#111111] text-white border-t border-white/5 shadow-2xl z-50 hidden">
            <div class="max-w-7xl mx-auto px-12 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">

                <!-- ARTICLES -->
                <div class="flex flex-col">
                    <span class="text-[#ff0055] text-xs font-mono font-black tracking-[0.2em] mb-4 border-b border-white/5 pb-2 uppercase">
                        // ARTICLE
                    </span>
                    <ul class="flex flex-col gap-3">
                        @forelse($navArticles ?? [] as $article)
                            <li>
                                <a href="{{ $article['link'] ?? '#article' }}" class="mega-item text-neutral-400 hover:text-white hover:translate-x-1 transition-all font-mono text-xs tracking-wider uppercase flex items-center gap-2"
                                   data-image="{{ $article['image'] ?? '' }}">
                                    <span>&middot;</span> {{ Str::limit($article['title'], 30) }}
                                </a>
                            </li>
                        @empty
                            <li><span class="text-neutral-600 text-xs font-mono">No articles yet</span></li>
                        @endforelse
                    </ul>
                </div>

                <!-- PROJECTS -->
                <div class="flex flex-col">
                    <span class="text-[#ff0055] text-xs font-mono font-black tracking-[0.2em] mb-4 border-b border-white/5 pb-2 uppercase">
                        // APPS & PROJECTS
                    </span>
                    <ul class="flex flex-col gap-3">
                        @forelse($navProjects ?? [] as $project)
                            <li>
                                <a href="{{ $project['link'] ?? '#apps' }}" class="mega-item text-neutral-400 hover:text-white hover:translate-x-1 transition-all font-mono text-xs tracking-wider uppercase flex items-center gap-2"
                                   data-image="{{ $project['image'] ?? '' }}">
                                    <span>&middot;</span> {{ Str::limit($project['title'], 30) }}
                                </a>
                            </li>
                        @empty
                            <li><span class="text-neutral-600 text-xs font-mono">No projects yet</span></li>
                        @endforelse
                    </ul>
                </div>

                <!-- CERTIFICATES -->
                <div class="flex flex-col">
                    <span class="text-[#ff0055] text-xs font-mono font-black tracking-[0.2em] mb-4 border-b border-white/5 pb-2 uppercase">
                        // CREDENTIALS
                    </span>
                    <ul class="flex flex-col gap-3">
                        @forelse($navCertificates ?? [] as $cert)
                            <li>
                                <a href="#certificates" class="mega-item text-neutral-400 hover:text-white hover:translate-x-1 transition-all font-mono text-xs tracking-wider uppercase flex items-center gap-2"
                                   data-image="{{ $cert['image'] ?? '' }}">
                                    <span>&middot;</span> {{ Str::limit($cert['title'], 30) }}
                                </a>
                            </li>
                        @empty
                            <li><span class="text-neutral-600 text-xs font-mono">No certificates yet</span></li>
                        @endforelse
                    </ul>
                </div>

                <!-- PREVIEW PANEL (Kanan) -->
                <div class="bg-neutral-900/50 border border-white/5 p-6 flex flex-col justify-between min-h-[200px] tech-nav-clip overflow-hidden relative">
                    <div class="font-mono text-[10px] text-neutral-600 uppercase tracking-widest relative z-10">// PREVIEW_SYSTEM</div>

                    <!-- Default State -->
                    <div id="mega-preview-default" class="text-center py-6 relative z-10">
                        <span class="text-[10px] font-mono text-neutral-500 tracking-wider uppercase block">Hover items</span>
                        <span class="text-[9px] font-mono text-[#ff0055] uppercase block mt-1">To preview_</span>
                    </div>

                    <!-- Preview Image (Hidden by default) -->
                    <div id="mega-preview-image" class="absolute inset-0 opacity-0 transition-opacity duration-300">
                        <img src="" alt="Preview" class="w-full h-full object-cover opacity-40">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#111111] via-transparent to-transparent"></div>
                    </div>

                    <div class="w-full h-1 bg-neutral-800 relative overflow-hidden mt-auto z-10">
                        <div class="absolute inset-y-0 left-0 w-1/3 bg-[#ff0055]"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</header>

<style>
    @keyframes dropdownOpen {
        from { opacity: 0; transform: scaleY(0.95) translateY(-10px); }
        to   { opacity: 1; transform: scaleY(1) translateY(0); }
    }
    @keyframes dropdownClose {
        from { opacity: 1; transform: scaleY(1) translateY(0); }
        to   { opacity: 0; transform: scaleY(0.95) translateY(-10px); }
    }
    .dropdown-open {
        animation: dropdownOpen 0.25s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        transform-origin: top;
    }
    .dropdown-close {
        animation: dropdownClose 0.2s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        transform-origin: top;
    }

    .tech-nav-clip {
        clip-path: polygon(0 0, 92% 0, 100% 10%, 100% 100%, 0 100%);
    }

    .header-active-state {
        background-color: #1a1a1a !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoTrigger = document.getElementById('logo-trigger');
        const header = document.getElementById('navbar-header');
        const globeBtn = document.getElementById('globe-btn');
        const searchBox = document.getElementById('search-box');
        const hoverSearchBtn = document.getElementById('hover-search-btn');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const logoDefault = document.getElementById('logo-default');
        const logoExtended = document.getElementById('logo-extended');
        const previewDefault = document.getElementById('mega-preview-default');
        const previewImage = document.getElementById('mega-preview-image');
        const previewImg = previewImage.querySelector('img');

        // Logo click toggle
        logoTrigger.addEventListener('click', function (e) {
            e.preventDefault();
            const isOpen = !dropdownMenu.classList.contains('hidden');

            if (isOpen) {
                dropdownMenu.classList.remove('dropdown-open');
                dropdownMenu.classList.add('dropdown-close');
                setTimeout(function () {
                    dropdownMenu.classList.add('hidden');
                    dropdownMenu.classList.remove('dropdown-close');
                }, 200);
                header.classList.remove('header-active-state');
                logoDefault.classList.remove('!hidden');
                logoExtended.classList.remove('!block');
                globeBtn.classList.remove('hidden');
                searchBox.classList.remove('hidden');
                hoverSearchBtn.classList.add('hidden');
            } else {
                dropdownMenu.classList.remove('hidden');
                dropdownMenu.classList.remove('dropdown-close');
                dropdownMenu.classList.add('dropdown-open');
                header.classList.add('header-active-state');
                logoDefault.classList.add('!hidden');
                logoExtended.classList.add('!block');
                globeBtn.classList.add('hidden');
                searchBox.classList.add('hidden');
                hoverSearchBtn.classList.remove('hidden');
            }
        });

        // Hover preview for mega menu items
        document.querySelectorAll('.mega-item').forEach(function(item) {
            item.addEventListener('mouseenter', function() {
                const imageUrl = this.getAttribute('data-image');
                if (imageUrl) {
                    previewImg.src = imageUrl;
                    previewDefault.style.display = 'none';
                    previewImage.style.opacity = '1';
                }
            });

            item.addEventListener('mouseleave', function() {
                previewImage.style.opacity = '0';
                previewDefault.style.display = 'block';
            });
        });

        // Smooth scroll for nav links
        document.querySelectorAll('.nav-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var targetId = this.getAttribute('href').substring(1);
                var target = document.getElementById(targetId);
                if (target) {
                    var offset = header.offsetHeight + 16;
                    var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });

                    // Close dropdown if open
                    if (!dropdownMenu.classList.contains('hidden')) {
                        dropdownMenu.classList.remove('dropdown-open');
                        dropdownMenu.classList.add('dropdown-close');
                        setTimeout(function () {
                            dropdownMenu.classList.add('hidden');
                            dropdownMenu.classList.remove('dropdown-close');
                        }, 200);
                        header.classList.remove('header-active-state');
                        logoDefault.classList.remove('!hidden');
                        logoExtended.classList.remove('!block');
                        globeBtn.classList.remove('hidden');
                        searchBox.classList.remove('hidden');
                        hoverSearchBtn.classList.add('hidden');
                    }
                }
            });
        });

        // Active state on scroll
        var sections = ['home', 'about', 'article', 'apps', 'certificates', 'contacts'];
        var navLinks = document.querySelectorAll('.nav-link');

        function updateActiveNav() {
            var scrollPos = window.scrollY + header.offsetHeight + 100;
            sections.forEach(function(id) {
                var section = document.getElementById(id);
                if (!section) return;
                var top = section.offsetTop;
                var bottom = top + section.offsetHeight;
                navLinks.forEach(function(link) {
                    if (link.getAttribute('data-nav') === id) {
                        if (scrollPos >= top && scrollPos < bottom) {
                            link.classList.add('text-white', 'font-bold', 'border-b-2', 'border-[#ff0055]');
                            link.classList.remove('text-neutral-400');
                        } else {
                            link.classList.remove('text-white', 'font-bold', 'border-b-2', 'border-[#ff0055]');
                            link.classList.add('text-neutral-400');
                        }
                    }
                });
            });
        }

        window.addEventListener('scroll', updateActiveNav);
        updateActiveNav();
    });
</script>
