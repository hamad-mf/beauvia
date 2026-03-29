<x-layouts.app title="Freelancers">
    <section class="pt-28 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="section-title">Find <span class="gradient-text">Freelancers</span></h1>
                <p class="section-subtitle">Expert beauty & wellness professionals who come to you</p>
            </div>

            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('freelancers.index') }}" class="badge {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-white/5 text-dark-300 hover:bg-white/10' }} border border-white/10 !text-sm !px-4 !py-2 transition-colors">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('freelancers.index', ['category' => $cat->slug]) }}"
                       class="badge {{ request('category') === $cat->slug ? 'bg-primary-600 text-white' : 'bg-white/5 text-dark-300 hover:bg-white/10' }} border border-white/10 !text-sm !px-4 !py-2 transition-colors">
                        {{ $cat->icon }} {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div class="flex items-center justify-between mb-6">
                <p class="text-dark-400 text-sm">{{ $freelancers->total() }} freelancers found</p>
                <div class="flex items-center gap-2">
                    <span class="text-dark-400 text-sm">Sort by:</span>
                    <select onchange="window.location.href=this.value" class="bg-white/5 border border-white/10 rounded-lg px-3 py-1.5 text-sm text-white focus:border-primary-500 focus:outline-none">
                        @foreach(['recommended' => 'Recommended', 'rating' => 'Top Rated', 'experience' => 'Most Experienced', 'price_low' => 'Price: Low', 'price_high' => 'Price: High'] as $val => $label)
                            <option value="{{ route('freelancers.index', array_merge(request()->query(), ['sort' => $val])) }}" {{ request('sort', 'recommended') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($freelancers as $fl)
                    <a href="{{ route('freelancers.show', $fl->id) }}" class="glass-card-hover p-6 group">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="relative">
                                <img src="{{ $fl->user->avatar_url }}" class="w-16 h-16 rounded-full border-2 border-primary-500/50" alt="">
                                @if($fl->is_available)
                                    <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-2 border-dark-950 flex items-center justify-center">
                                        <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-display font-semibold text-white group-hover:text-primary-300 transition-colors">{{ $fl->user->name }}</h3>
                                <p class="text-primary-400 text-sm">{{ $fl->title }}</p>
                                <p class="text-dark-400 text-xs">{{ $fl->category->name }}</p>
                            </div>
                        </div>
                        <p class="text-dark-400 text-sm line-clamp-2 mb-4">{{ $fl->bio }}</p>
                        <div class="flex items-center gap-4 text-sm mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span class="text-white font-semibold">{{ number_format($fl->rating_avg, 1) }}</span>
                                <span class="text-dark-400">({{ $fl->rating_count }})</span>
                            </div>
                            <span class="text-dark-600">•</span>
                            <span class="text-dark-400">{{ $fl->experience_years }}yr exp</span>
                            @if($fl->is_mobile)
                                <span class="text-dark-600">•</span>
                                <span class="text-blue-400">🏠 Mobile</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between pt-4 border-t border-white/5">
                            <span class="text-dark-300 text-sm font-semibold">${{ number_format($fl->hourly_rate, 0) }}/hr</span>
                            <span class="text-primary-400 text-xs font-medium group-hover:underline">View Profile →</span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="text-5xl mb-4">🔍</div>
                        <h3 class="font-display text-xl text-white mb-2">No freelancers found</h3>
                        <p class="text-dark-400">Try adjusting your filters</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">{{ $freelancers->withQueryString()->links() }}</div>
        </div>
    </section>
</x-layouts.app>
