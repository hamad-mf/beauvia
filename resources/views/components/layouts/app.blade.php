<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Beauvia' }} — Premium Beauty & Wellness Booking</title>
    <meta name="description" content="{{ $description ?? 'Book beauty & wellness appointments at top salons, spas, and with freelance professionals.' }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen flex flex-col">
    {{-- NAVIGATION --}}
    <nav class="fixed top-0 w-full z-50 transition-all duration-300" x-data="{ scrolled: false, mobileOpen: false }"
         x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
         :class="scrolled ? 'bg-white/80 backdrop-blur-xl border-b border-gray-200 shadow-sm' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-display font-bold text-lg shadow-lg shadow-primary-600/30 group-hover:shadow-primary-600/50 transition-shadow">B</div>
                    <span class="font-display font-bold text-xl text-gray-900">Beauvia</span>
                </a>
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('shops.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors text-sm font-medium">Shops</a>
                    <a href="{{ route('freelancers.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors text-sm font-medium">Freelancers</a>
                </div>
                <div class="hidden lg:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('shops.index') }}" method="GET" class="w-full relative">
                        <input type="text" name="search" placeholder="Search salons, spas, freelancers..." class="w-full bg-gray-50 border border-gray-300 rounded-full px-5 py-2.5 pl-11 text-sm text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </form>
                </div>
                <div class="hidden lg:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition-colors text-sm font-medium">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm !px-5 !py-2.5">Get Started</a>
                    @else
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm">
                                <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-full border-2 border-primary-500/50" alt="">
                                <span class="text-gray-600">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-2xl py-2 shadow-lg">
                                @if(auth()->user()->isCustomer())
                                    <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">Dashboard</a>
                                    <a href="{{ route('customer.bookings') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">My Bookings</a>
                                @elseif(auth()->user()->isShopOwner())
                                    <a href="{{ route('shop.dashboard') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">Shop Dashboard</a>
                                @elseif(auth()->user()->isFreelancer())
                                    <a href="{{ route('freelancer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">Dashboard</a>
                                @endif
                                <hr class="my-1 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">Sign Out</button></form>
                            </div>
                        </div>
                    @endguest
                </div>
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
            <div x-show="mobileOpen" x-transition class="lg:hidden pb-4 border-t border-gray-200 mt-2 pt-4">
                <a href="{{ route('shops.index') }}" class="block py-2 text-gray-600 hover:text-gray-900">Shops</a>
                <a href="{{ route('freelancers.index') }}" class="block py-2 text-gray-600 hover:text-gray-900">Freelancers</a>
                @guest
                    <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-gray-900">Sign In</a>
                    <a href="{{ route('register') }}" class="block py-2 text-primary-600 font-semibold">Get Started</a>
                @else
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="block py-2 text-gray-600 hover:text-gray-900">Sign Out</button></form>
                @endguest
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="fixed top-20 right-4 z-50 bg-white border border-gray-200 shadow-lg rounded-2xl px-6 py-3 border-l-4 border-l-emerald-500 text-emerald-600 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition class="fixed top-20 right-4 z-50 bg-white border border-gray-200 shadow-lg rounded-2xl px-6 py-3 border-l-4 border-l-red-500 text-red-600 text-sm">{{ session('error') }}</div>
    @endif

    <main class="flex-grow">{{ $slot }}</main>

    <footer class="border-t border-gray-100 mt-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-display font-bold text-lg">B</div>
                        <span class="font-display font-bold text-xl text-gray-900">Beauvia</span>
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed">Premium beauty & wellness booking platform. Discover top salons, spas, and freelance professionals.</p>
                </div>
                <div>
                    <h4 class="font-display font-semibold text-gray-900 mb-4">Discover</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('shops.index') }}" class="hover:text-gray-900 transition-colors">Browse Shops</a></li>
                        <li><a href="{{ route('freelancers.index') }}" class="hover:text-gray-900 transition-colors">Find Freelancers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-display font-semibold text-gray-900 mb-4">For Business</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('register') }}" class="hover:text-gray-900 transition-colors">List Your Shop</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-gray-900 transition-colors">Join as Freelancer</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-display font-semibold text-gray-900 mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-gray-900 transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-12 pt-8 text-center">
                <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Beauvia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    const observer = new IntersectionObserver((entries) => { entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); }); }, { threshold: 0.1 });
    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    </script>
</body>
</html>
