<x-layouts.app title="Home">
    {{-- HERO SECTION --}}
    <section class="relative min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-hero-gradient"></div>
        <div class="absolute inset-0 opacity-40">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-200/50 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-pink-200/40 rounded-full blur-3xl animate-float" style="animation-delay: -3s"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-primary-100/40 rounded-full blur-3xl animate-float" style="animation-delay: -1.5s"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 bg-white border border-gray-200 shadow-sm rounded-2xl px-4 py-2 mb-8 animate-fade-in">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-gray-600 text-sm">{{ $shopCount + $freelancerCount }}+ professionals available now</span>
                </div>

                <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold leading-tight mb-6 animate-slide-up text-gray-900">
                    Book Beauty &<br>
                    <span class="gradient-text">Wellness Services</span>
                </h1>

                <p class="text-gray-500 text-lg sm:text-xl max-w-2xl mx-auto mb-10 animate-slide-up" style="animation-delay: 0.1s">
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

        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white to-transparent"></div>
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
                        <span class="text-xs sm:text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ $category->name }}</span>
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
                        <div class="h-48 bg-gradient-to-br from-primary-50 to-gray-100 relative overflow-hidden">
                            <div class="absolute inset-0 flex items-center justify-center opacity-20"><svg class="w-24 h-24 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg></div>
                            @if($shop->is_featured)
                                <div class="absolute top-3 left-3 badge bg-primary-50 text-primary-700 border border-primary-200"><svg class="w-3.5 h-3.5 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>Featured</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-display font-semibold text-lg text-gray-900 group-hover:text-primary-600 transition-colors">{{ $shop->name }}</h3>
                                <div class="flex items-center gap-1 text-sm">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-gray-900 font-semibold">{{ number_format($shop->rating_avg, 1) }}</span>
                                    <span class="text-gray-400">({{ $shop->rating_count }})</span>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm mb-3">{{ $shop->category->name ?? '' }}</p>
                            <div class="flex items-center gap-2 text-gray-400 text-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ Str::limit($shop->address, 40) }}
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-gray-500 text-xs">From ${{ number_format($shop->services->min('price'), 0) }}</span>
                                <span class="text-primary-600 text-xs font-medium">{{ $shop->services->count() }} services</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TOP FREELANCERS --}}
    <section class="py-20 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary-50/30 to-transparent"></div>
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
                                <h3 class="font-display font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $fl->user->name }}</h3>
                                <p class="text-primary-600 text-sm">{{ $fl->title }}</p>
                            </div>
                        </div>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $fl->bio }}</p>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-gray-900 text-sm font-semibold">{{ number_format($fl->rating_avg, 1) }}</span>
                                <span class="text-gray-400 text-sm">({{ $fl->rating_count }})</span>
                            </div>
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-500 text-sm">{{ $fl->experience_years }}yr exp</span>
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-2">
                                @if($fl->is_available)
                                    <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5 animate-pulse"></span>Available Now
                                    </span>
                                @endif
                                @if($fl->is_mobile)
                                    <span class="badge bg-blue-50 text-blue-700 border border-blue-200"><svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>Home Service</span>
                                @endif
                            </div>
                            <span class="text-gray-700 text-sm font-semibold">${{ number_format($fl->hourly_rate, 0) }}/hr</span>
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
                {{-- Step 1: Discover --}}
                <div class="text-center animate-on-scroll">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 flex items-center justify-center">
                        <svg class="w-9 h-9 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </div>
                    <div class="text-primary-600 text-sm font-semibold mb-2">Step 1</div>
                    <h3 class="font-display font-semibold text-xl text-gray-900 mb-3">Discover</h3>
                    <p class="text-gray-500">Browse top-rated shops and freelancers. Filter by category, location, and reviews.</p>
                </div>
                {{-- Step 2: Book Instantly --}}
                <div class="text-center animate-on-scroll" style="animation-delay: 0.15s">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 flex items-center justify-center">
                        <svg class="w-9 h-9 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>
                    </div>
                    <div class="text-primary-600 text-sm font-semibold mb-2">Step 2</div>
                    <h3 class="font-display font-semibold text-xl text-gray-900 mb-3">Book Instantly</h3>
                    <p class="text-gray-500">Choose your services, pick a date and time, and confirm your appointment in seconds.</p>
                </div>
                {{-- Step 3: Enjoy --}}
                <div class="text-center animate-on-scroll" style="animation-delay: 0.3s">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 flex items-center justify-center">
                        <svg class="w-9 h-9 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg>
                    </div>
                    <div class="text-primary-600 text-sm font-semibold mb-2">Step 3</div>
                    <h3 class="font-display font-semibold text-xl text-gray-900 mb-3">Enjoy</h3>
                    <p class="text-gray-500">Visit the shop or welcome the freelancer to your door. Leave a review after your experience.</p>
                </div>
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
                        ['value' => '4.8', 'label' => 'Avg Rating', 'suffix' => '/5'],
                    ] as $stat)
                        <div class="text-center">
                            <div class="font-display text-3xl md:text-4xl font-bold gradient-text">{{ $stat['value'] }}{{ $stat['suffix'] }}</div>
                            <div class="text-gray-500 text-sm mt-1">{{ $stat['label'] }}</div>
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
            <p class="text-gray-500 text-lg mb-8">Join thousands of professionals and customers on Beauvia</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary text-lg !px-8 !py-4">Create Free Account</a>
                <a href="{{ route('shops.index') }}" class="btn-secondary text-lg !px-8 !py-4">Explore Services</a>
            </div>
        </div>
    </section>

</x-layouts.app>
