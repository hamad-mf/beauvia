<x-layouts.app title="Home">
    {{-- HERO SECTION --}}
    <section class="relative min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-hero-gradient"></div>
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-600/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-coral-500/15 rounded-full blur-3xl animate-float" style="animation-delay: -3s"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-primary-400/10 rounded-full blur-3xl animate-float" style="animation-delay: -1.5s"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 glass-card px-4 py-2 mb-8 animate-fade-in">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-dark-300 text-sm">{{ $shopCount + $freelancerCount }}+ professionals available now</span>
                </div>

                <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold leading-tight mb-6 animate-slide-up">
                    Book Beauty &<br>
                    <span class="gradient-text">Wellness Services</span>
                </h1>

                <p class="text-dark-300 text-lg sm:text-xl max-w-2xl mx-auto mb-10 animate-slide-up" style="animation-delay: 0.1s">
                    Discover top-rated salons, spas, and freelance professionals. Book instantly with real-time availability.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up" style="animation-delay: 0.2s">
                    <a href="{{ route('shops.index') }}" class="btn-primary text-lg !px-8 !py-4 gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Book a Shop
                    </a>
                    <a href="{{ route('freelancers.index') }}" class="btn-coral text-lg !px-8 !py-4 gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Book a Freelancer
                    </a>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-dark-950 to-transparent"></div>
    </section>

    {{-- CATEGORIES --}}
    <section class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 animate-on-scroll">
                <h2 class="section-title">Explore <span class="gradient-text">Categories</span></h2>
                <p class="section-subtitle">Find the perfect service for your needs</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
                @foreach($categories as $i => $category)
                    <a href="{{ route('shops.index', ['category' => $category->slug]) }}"
                       class="glass-card-hover p-4 text-center group animate-on-scroll" style="animation-delay: {{ $i * 0.05 }}s">
                        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">{{ $category->icon }}</div>
                        <span class="text-xs sm:text-sm text-dark-300 group-hover:text-white transition-colors">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FEATURED SHOPS --}}
    <section class="py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12 animate-on-scroll">
                <div>
                    <h2 class="section-title">Featured <span class="gradient-text">Shops</span></h2>
                    <p class="section-subtitle">Top-rated salons and spas near you</p>
                </div>
                <a href="{{ route('shops.index') }}" class="hidden sm:inline-flex btn-secondary text-sm !px-4 !py-2">
                    View All →
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredShops as $i => $shop)
                    <a href="{{ route('shops.show', $shop->slug) }}" class="glass-card-hover overflow-hidden group animate-on-scroll" style="animation-delay: {{ $i * 0.1 }}s">
                        <div class="h-48 bg-gradient-to-br from-primary-900/50 to-dark-800 relative overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center text-6xl opacity-20">{{ $shop->category->icon ?? '✨' }}</div>
                            @if($shop->is_featured)
                                <div class="absolute top-3 left-3 badge bg-primary-500/20 text-primary-300 border border-primary-500/30">⭐ Featured</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-display font-semibold text-lg text-white group-hover:text-primary-300 transition-colors">{{ $shop->name }}</h3>
                                <div class="flex items-center gap-1 text-sm">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-white font-semibold">{{ number_format($shop->rating_avg, 1) }}</span>
                                    <span class="text-dark-400">({{ $shop->rating_count }})</span>
                                </div>
                            </div>
                            <p class="text-dark-400 text-sm mb-3">{{ $shop->category->name ?? '' }}</p>
                            <div class="flex items-center gap-2 text-dark-400 text-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ Str::limit($shop->address, 40) }}
                            </div>
                            <div class="mt-4 pt-3 border-t border-white/5 flex items-center justify-between">
                                <span class="text-dark-400 text-xs">From ${{ number_format($shop->services->min('price'), 0) }}</span>
                                <span class="text-primary-400 text-xs font-medium">{{ $shop->services->count() }} services</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TOP FREELANCERS --}}
    <section class="py-20 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary-950/10 to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12 animate-on-scroll">
                <div>
                    <h2 class="section-title">Top <span class="gradient-text">Freelancers</span></h2>
                    <p class="section-subtitle">Expert professionals who come to you</p>
                </div>
                <a href="{{ route('freelancers.index') }}" class="hidden sm:inline-flex btn-secondary text-sm !px-4 !py-2">View All →</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($topFreelancers as $i => $fl)
                    <a href="{{ route('freelancers.show', $fl->id) }}" class="glass-card-hover p-6 group animate-on-scroll" style="animation-delay: {{ $i * 0.1 }}s">
                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ $fl->user->avatar_url }}" class="w-14 h-14 rounded-full border-2 border-primary-500/50 group-hover:border-primary-400 transition-colors" alt="{{ $fl->user->name }}">
                            <div>
                                <h3 class="font-display font-semibold text-white group-hover:text-primary-300 transition-colors">{{ $fl->user->name }}</h3>
                                <p class="text-primary-400 text-sm">{{ $fl->title }}</p>
                            </div>
                        </div>
                        <p class="text-dark-400 text-sm mb-4 line-clamp-2">{{ $fl->bio }}</p>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-white text-sm font-semibold">{{ number_format($fl->rating_avg, 1) }}</span>
                                <span class="text-dark-400 text-sm">({{ $fl->rating_count }})</span>
                            </div>
                            <span class="text-dark-600">•</span>
                            <span class="text-dark-400 text-sm">{{ $fl->experience_years }}yr exp</span>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-white/5">
                            <div class="flex items-center gap-2">
                                @if($fl->is_available)
                                    <span class="badge bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5 animate-pulse"></span>Available Now
                                    </span>
                                @endif
                                @if($fl->is_mobile)
                                    <span class="badge bg-blue-500/20 text-blue-400 border border-blue-500/30">🏠 Home Service</span>
                                @endif
                            </div>
                            <span class="text-dark-300 text-sm font-semibold">${{ number_format($fl->hourly_rate, 0) }}/hr</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-on-scroll">
                <h2 class="section-title">How It <span class="gradient-text">Works</span></h2>
                <p class="section-subtitle">Book your appointment in 3 simple steps</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach([
                    ['icon' => '🔍', 'title' => 'Discover', 'desc' => 'Browse top-rated shops and freelancers. Filter by category, location, and reviews.'],
                    ['icon' => '📅', 'title' => 'Book Instantly', 'desc' => 'Choose your services, pick a date and time, and confirm your appointment in seconds.'],
                    ['icon' => '✨', 'title' => 'Enjoy', 'desc' => 'Visit the shop or welcome the freelancer to your door. Leave a review after your experience.'],
                ] as $i => $step)
                    <div class="text-center animate-on-scroll" style="animation-delay: {{ $i * 0.15 }}s">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-600/20 to-primary-800/20 border border-primary-500/20 flex items-center justify-center text-4xl">
                            {{ $step['icon'] }}
                        </div>
                        <div class="text-primary-400 text-sm font-semibold mb-2">Step {{ $i + 1 }}</div>
                        <h3 class="font-display font-semibold text-xl text-white mb-3">{{ $step['title'] }}</h3>
                        <p class="text-dark-400">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <section class="py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-8 md:p-12 animate-on-scroll">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    @foreach([
                        ['value' => $shopCount, 'label' => 'Shops', 'suffix' => '+'],
                        ['value' => $freelancerCount, 'label' => 'Freelancers', 'suffix' => '+'],
                        ['value' => $reviewCount, 'label' => 'Reviews', 'suffix' => '+'],
                        ['value' => '4.8', 'label' => 'Avg Rating', 'suffix' => '⭐'],
                    ] as $stat)
                        <div class="text-center">
                            <div class="font-display text-3xl md:text-4xl font-bold gradient-text">{{ $stat['value'] }}{{ $stat['suffix'] }}</div>
                            <div class="text-dark-400 text-sm mt-1">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-on-scroll">
            <h2 class="section-title mb-4">Ready to Get <span class="gradient-text">Started</span>?</h2>
            <p class="text-dark-400 text-lg mb-8">Join thousands of professionals and customers on Beauvia</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary text-lg !px-8 !py-4">Create Free Account</a>
                <a href="{{ route('shops.index') }}" class="btn-secondary text-lg !px-8 !py-4">Explore Services</a>
            </div>
        </div>
    </section>
</x-layouts.app>
