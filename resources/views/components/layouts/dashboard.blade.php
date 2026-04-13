{{-- resources/views/layouts/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — Beauvia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
    <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        {{-- Sidebar --}}
        <aside class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 transform transition-transform lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="p-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-8">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-display font-bold">B</div>
                    <span class="font-display font-bold text-lg text-gray-900">Beauvia</span>
                </a>
                <nav class="space-y-1">
                    {{ $sidebar }}
                </nav>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
                <div class="flex items-center gap-3 mb-3">
                    <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-full" alt="">
                    <div>
                        <p class="text-gray-900 text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500 text-xs capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-gray-900 text-sm transition-colors">Sign Out →</button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-gray-200 shadow-sm px-4 lg:px-8 h-16 flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h2 class="font-display font-semibold text-lg text-gray-900">{{ $title ?? 'Dashboard' }}</h2>
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 text-sm">← Back to site</a>
            </header>

            @if(session('success'))
                <div class="px-4 lg:px-8 mt-4">
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="bg-white shadow-lg border border-gray-200 rounded-2xl px-4 py-3 border-l-4 border-emerald-500 text-emerald-600 text-sm">{{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div class="px-4 lg:px-8 mt-4">
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="bg-white shadow-lg border border-gray-200 rounded-2xl px-4 py-3 border-l-4 border-red-500 text-red-600 text-sm">{{ session('error') }}</div>
                </div>
            @endif

            <main class="flex-1 p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Overlay for mobile --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/20 z-30 lg:hidden"></div>
</body>
</html>