<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0a0a0a] text-white font-mono min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md px-6">
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/Logo.png') }}" alt="FYANZ XDEV" class="h-10 mx-auto mb-4">
            <h1 class="text-xl font-bold tracking-wider">ADMIN PANEL</h1>
            <p class="text-xs text-neutral-500 mt-2">Login to manage your portfolio</p>
        </div>

        <!-- Flash Messages -->
        @if(session('error'))
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 rounded text-red-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/20 rounded text-green-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 rounded text-red-400 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Login Form -->
        <div class="bg-[#111] border border-white/10 rounded-lg p-8">
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm text-neutral-400 mb-2">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required autofocus
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-3 text-sm focus:outline-none focus:border-[#ff0055] transition-colors"
                            placeholder="Enter username">
                    </div>

                    <div>
                        <label class="block text-sm text-neutral-400 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-[#0a0a0a] border border-white/10 rounded px-4 py-3 text-sm focus:outline-none focus:border-[#ff0055] transition-colors"
                            placeholder="Enter password">
                    </div>
                </div>

                <button type="submit"
                    class="w-full mt-6 px-6 py-3 bg-[#ff0055] hover:bg-[#cc0044] rounded text-sm font-bold tracking-wider transition-colors">
                    LOGIN →
                </button>
            </form>
        </div>

        <!-- Back to site -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-xs text-neutral-500 hover:text-white transition-colors">
                ← Back to site
            </a>
        </div>

        <!-- Default credentials hint (remove in production!) -->
        <div class="mt-8 p-4 bg-yellow-500/5 border border-yellow-500/20 rounded-lg">
            <p class="text-xs text-yellow-500/70 text-center">
                ⚠️ Default: <span class="font-bold">admin</span> / <span class="font-bold">password</span>
            </p>
            <p class="text-[10px] text-yellow-500/50 text-center mt-1">Change password after first login!</p>
        </div>
    </div>

</body>
</html>
