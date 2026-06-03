<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} - FYANZ XDEV</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Simple CSS for admin */
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover { background: rgba(255,255,255,0.05); }
        .sidebar-link.active { background: rgba(255,0,85,0.1); border-left: 3px solid #ff0055; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-white font-mono">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#111] border-r border-white/5 p-4 flex flex-col">
            <a href="{{ route('admin.dashboard') }}" class="mb-8 flex items-center gap-2">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-8">
                <span class="text-xs text-neutral-500">ADMIN</span>
            </a>

            <nav class="flex flex-col gap-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link px-4 py-2.5 rounded text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="sidebar-link px-4 py-2.5 rounded text-sm {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    👤 Profile
                </a>
                <a href="{{ route('admin.projects.index') }}" class="sidebar-link px-4 py-2.5 rounded text-sm {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}>
                    🚀 Projects
                </a>
                <a href="{{ route('admin.articles.index') }}" class="sidebar-link px-4 py-2.5 rounded text-sm {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    📝 Articles
                </a>
                <a href="{{ route('admin.certificates.index') }}" class="sidebar-link px-4 py-2.5 rounded text-sm {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                    🏆 Certificates
                </a>
            </nav>

            <div class="mt-auto pt-4 border-t border-white/5 space-y-2">
                <!-- User Info -->
                <div class="px-4 py-2 text-xs text-neutral-500">
                    👤 {{ session('admin_user')['name'] ?? 'Admin' }}
                </div>

                <a href="{{ route('home') }}" class="sidebar-link px-4 py-2.5 rounded text-sm text-neutral-500 flex items-center gap-2">
                    ← View Site
                </a>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full sidebar-link px-4 py-2.5 rounded text-sm text-red-400 hover:text-red-300 flex items-center gap-2">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded text-green-400 text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 rounded text-red-400 text-sm">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 rounded text-red-400 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

</body>
</html>
